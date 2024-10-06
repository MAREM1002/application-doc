@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Styles pour les cartes utilisateurs et le popup -->
<style>
    .user-card {
        box-shadow: 0 4px 8px rgba(115, 103, 240, 0.3), 0 6px 20px rgba(115, 103, 240, 0.3);
        transition: transform 0.3s ease;
    }

    .user-card:hover {
        transform: translateY(-5px);
    }

    .user-name {
        color: #7367f0;
        font-size: 1.2rem;
        font-weight: bold;
    }

    /* Styles pour le bouton "Delete" */
    .delete-button {
        font-size: 0.8rem; /* Small size */
        padding: 5px 10px; /* Smaller padding */
        float: right; /* Align to the right */
    }

    /* Styles pour le bouton "Edit Role" */
    .edit-role-button {
        font-size: 0.8rem; /* Small size */
        padding: 5px 10px; /* Smaller padding */
        float: right; /* Align to the right */
        margin-right: 5px; /* Space between buttons */
    }

    /* Styles pour le popup personnalisé */
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none; /* Initially hidden */
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .popup-content {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        max-width: 400px;
        width: 100%;
        position: relative;
    }

    .popup-content p {
        margin-bottom: 20px;
    }

    .popup-buttons {
        display: flex;
        justify-content: space-between;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Maison de Web/</span> User Management</h4>
    <div class="card p-0 mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between p-0 pt-4">
            <div class="app-academy-md-25 card-body py-0">
                <img src="{{ asset('assets/img/illustrations/rocket.png') }}" class="img-fluid app-academy-img-height scaleX-n1-rtl" alt="Bulb in hand" height="90" />
            </div>
            <div class="app-academy-md-50 card-body d-flex align-items-md-center flex-column text-md-center">
                <h3 class="card-title mb-4 lh-sm px-md-5 lh-lg">
                Manage your users effectively with our powerful search tool.
                <span class="text-primary fw-medium text-nowrap">Here.</span>
                </h3>
                <p class="mb-3">
                Search for users to maintain an organized and secure environment.
                </p>
                <div class="d-flex align-items-center justify-content-between app-academy-md-80">
                    <input type="search" id="userSearch" placeholder="Find your user" class="form-control me-2" />
                    <button type="submit" class="btn btn-primary btn-icon"><i class="ti ti-search"></i></button>
                </div>
            </div>
            <div class="app-academy-md-25 d-flex align-items-end justify-content-end">
                <img src="{{ asset('assets/img/illustrations/wizard-create-deal-confirm.png') }}" alt="pencil rocket" height="188" class="scaleX-n1-rtl" />
            </div>
        </div>
    </div>
    @if($users->isEmpty())
        <p>No users registered at the moment.</p>
    @else
        <div class="row">
            @foreach($users as $user)
                <div class="col-md-4 mb-4">
                    <div class="card user-card">
                        <div class="card-body">
                            <h5 class="card-title user-name">{{ $user->name }}</h5>
                            <p class="card-text">
                                <strong>Email :</strong> {{ $user->email }} <br>
                                <strong>Registration Date :</strong> {{ $user->created_at->format('d/m/Y') }}
                            </p>
                            <!-- Buttons for admin -->
                            @if(auth()->user()->usertype == 'admin')
                                <button type="button" class="btn btn-danger delete-button" onclick="showPopup({{ $user->id }})">Delete</button>
                                <button type="button" class="btn btn-primary edit-role-button" onclick="showRolePopup({{ $user->id }})">Edit Role</button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Popup for user deletion -->
                <div id="popup{{ $user->id }}" class="popup-overlay">
                    <div class="popup-content">
                        <h5>Confirm Deletion</h5>
                        <p>To confirm deletion of user <strong>{{ $user->name }}</strong>, please enter your admin password:</p>
                        <input type="password" id="adminPasswordInput{{ $user->id }}" class="form-control" placeholder="Enter your password">
                        <div class="popup-buttons mt-3">
                            <button class="btn btn-secondary" onclick="closePopup({{ $user->id }})">Cancel</button>
                            <button class="btn btn-danger" onclick="confirmDelete({{ $user->id }})">Delete</button>
                        </div>
                    </div>
                </div>
                <!-- End of deletion popup -->

                <!-- Popup for editing roles -->
                <div id="rolePopup{{ $user->id }}" class="popup-overlay">
                    <div class="popup-content">
                        <h5>Edit Roles for <strong>{{ $user->name }}</strong></h5>
                        <form id="roleForm{{ $user->id }}">
                            <div>
                                <label>
                                    <input type="checkbox" name="roles[]" value="create"> Create
                                    <button type="button" onclick="removeRole(this)">✖</button>
                                </label>
                            </div>
                            <div>
                                <label>
                                    <input type="checkbox" name="roles[]" value="edit"> Edit
                                    <button type="button" onclick="removeRole(this)">✖</button>
                                </label>
                            </div>
                            <div>
                                <label>
                                    <input type="checkbox" name="roles[]" value="delete"> Delete
                                    <button type="button" onclick="removeRole(this)">✖</button>
                                </label>
                            </div>
                        </form>
                        <div class="popup-buttons mt-3">
                            <button class="btn btn-secondary" onclick="closeRolePopup({{ $user->id }})">Cancel</button>
                            <button class="btn btn-primary" onclick="confirmRoles({{ $user->id }})">Save</button>
                        </div>
                    </div>
                </div>
                <!-- End of role editing popup -->
            @endforeach
        </div>
    @endif
</div>

<script>
    // Function to display the deletion popup
    function showPopup(userId) {
        var popup = document.getElementById('popup' + userId);
        popup.style.display = 'flex';
    }

    // Function to close the deletion popup
    function closePopup(userId) {
        var popup = document.getElementById('popup' + userId);
        popup.style.display = 'none';
    }

    // Function to confirm deletion with admin password check
    function confirmDelete(userId) {
        var password = document.getElementById('adminPasswordInput' + userId).value;

        if (password.trim() !== '') {
            fetch('/users/' + userId + '/delete', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ password: password })
            })
            .then(() => {
                location.reload(); 
            })
            .catch(() => {
                location.reload(); 
            });
        } else {
            alert('Please enter your password to confirm.');
        }
    }

    // Function to show the role editing popup
    function showRolePopup(userId) {
        var rolePopup = document.getElementById('rolePopup' + userId);
        rolePopup.style.display = 'flex';
    }

    // Function to close the role editing popup
    function closeRolePopup(userId) {
        var rolePopup = document.getElementById('rolePopup' + userId);
        rolePopup.style.display = 'none';
    }

    // Function to confirm roles and save changes
    function confirmRoles(userId) {
        var roles = Array.from(document.querySelectorAll(`#roleForm${userId} input[type="checkbox"]:checked`))
                        .map(checkbox => checkbox.value);

        // Make an AJAX request to save the roles
        fetch(`/users/${userId}/roles`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ roles: roles })
        })
        .then(() => {
            location.reload(); 
        })
        .catch(() => {
            location.reload(); 
        });
    }

    // Function to remove a role from the list (optional)
    function removeRole(button) {
        button.parentElement.remove();
    }

    // Function to filter user cards based on search input
    document.getElementById('userSearch').addEventListener('input', function() {
        var searchValue = this.value.toLowerCase(); // Get the search value
        var userCards = document.querySelectorAll('.user-card'); // Get all user cards

        userCards.forEach(function(card) {
            var userName = card.querySelector('.user-name').textContent.toLowerCase(); // Get the user name
            
            // Show card if the name includes the search value, otherwise hide it
            if (userName.includes(searchValue)) {
                card.style.display = 'block'; // Show card
            } else {
                card.style.display = 'none'; // Hide card
            }
        });
    });
</script>
@endsection
