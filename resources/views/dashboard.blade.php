@extends('layouts.app')

@section('content')
<!-- Include Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Maison de Web/</span> My Documentations</h4>
    <div class="app-academy">
        <div class="card p-0 mb-4">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between p-0 pt-4">
                <div class="app-academy-md-25 card-body py-0">
                    <img src="{{ asset('assets/img/illustrations/bulb-light.png') }}" class="img-fluid app-academy-img-height scaleX-n1-rtl" alt="Bulb in hand" height="90" />
                </div>
                <div class="app-academy-md-50 card-body d-flex align-items-md-center flex-column text-md-center">
                    <h3 class="card-title mb-4 lh-sm px-md-5 lh-lg">
                         Discover essential documentation and training to enhance your skills.
                        <span class="text-primary fw-medium text-nowrap">Available right here on our platform.</span>
                    </h3>
                    <p class="mb-3">
                      Navigate through our vast pool of documents.
                    </p>
                    <div class="d-flex align-items-center justify-content-between app-academy-md-80">
                        <input type="search" placeholder="Find your document" class="form-control me-2" />
                        <button type="submit" class="btn btn-primary btn-icon"><i class="ti ti-search"></i></button>
                    </div>
                </div>
                <div class="app-academy-md-25 d-flex align-items-end justify-content-end">
                    <img src="{{ asset('assets/img/illustrations/pencil-rocket.png') }}" alt="pencil rocket" height="188" class="scaleX-n1-rtl" />
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header d-flex flex-wrap justify-content-between gap-3">
                <div class="card-title mb-0 me-1">
                    <h5 class="mb-1">My Documentations</h5>
                </div>
                <!-- Button for adding a new card -->
                <div class="demo-inline-spacing">
                    <button type="button" class="btn btn-label-primary" data-bs-toggle="modal" data-bs-target="#addCardModal">Add Card</button>
                </div>
            </div>
            <div class="card-body">
                <div id="cardsContainer" class="row gy-4 mb-4">
                    <!-- New cards will be added here dynamically -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for adding a new card -->
<div class="modal fade" id="addCardModal" tabindex="-1" aria-labelledby="addCardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCardModalLabel">Add New Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCardForm" method="POST" action="{{ route('cards.store') }}">
                    <div class="mb-3">
                        <label for="cardTitle" class="form-label">Card Title</label>
                        <input type="text" class="form-control" id="cardTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="cardDescription" class="form-label">Card Description</label>
                        <textarea class="form-control" id="cardDescription" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="cardCategory" class="form-label">Category</label>
                        <select class="form-select" id="cardCategory" required>
                            <option value="Web">Web</option>
                            <option value="Mobile">Mobile</option>
                            <option value="Data">Data</option>
                            <option value="E-Commerce">E-Commerce</option>
                            <!-- Add more categories as needed -->
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Card</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for delete confirmation -->
<div class="modal fade" id="deleteCardModal" tabindex="-1" aria-labelledby="deleteCardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCardModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this card?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    let cardToDelete = null;

    document.getElementById('addCardForm').addEventListener('submit', function (e) {
        e.preventDefault();

        // Get form values
        const title = document.getElementById('cardTitle').value;
        const description = document.getElementById('cardDescription').value;
        const category = document.getElementById('cardCategory').value;

        // Determine the image based on the category
        let imageUrl;
        if (category === 'Web') {
            imageUrl = '{{ asset('assets/img/pages/app-academy-tutor-1.png') }}';
        } else if (category === 'Mobile') {
            imageUrl = '{{ asset('assets/img/pages/app-academy-tutor-2.png') }}';
        } else if (category === 'Data') {
            imageUrl = '{{ asset('assets/img/pages/app-academy-tutor-3.png') }}';
        } else if (category === 'E-Commerce') {
            imageUrl = '{{ asset('assets/img/pages/app-academy-tutor-4.png') }}';
        }

        // Create a new card element with a clickable link around the title
        const newCard = `
            <div class="col-sm-6 col-lg-4">
                <div class="card p-2 h-100 shadow-none border">
                    <div class="rounded-2 text-center mb-3">
                        <img class="img-fluid" src="${imageUrl}" alt="tutor image" />
                    </div>
                    <div class="card-body p-3 pt-2">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-label-primary">${category}</span>
                            <button type="button" class="btn btn-danger btn-sm" onclick="openDeleteModal(this)">Delete</button>
                        </div>
                        <a href="/pgweb" class="h5 text-decoration-none">${title}</a>
                        <p class="mt-2">${description}</p>
                        <div class="progress mb-4" style="height: 8px">
                            <div class="progress-bar w-25" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Add the new card to the container
        document.getElementById('cardsContainer').insertAdjacentHTML('beforeend', newCard);

        // Close the modal
        const addCardModal = bootstrap.Modal.getInstance(document.getElementById('addCardModal'));
        if (addCardModal) {
            addCardModal.hide();
        }
    });

    function openDeleteModal(button) {
        const card = button.closest('.col-sm-6.col-lg-4');
        cardToDelete = card;
        const deleteCardModal = new bootstrap.Modal(document.getElementById('deleteCardModal'));
        deleteCardModal.show();
    }

    document.getElementById('confirmDeleteButton').addEventListener('click', function () {
        if (cardToDelete) {
            cardToDelete.remove();
            cardToDelete = null;
        }
        const deleteCardModal = bootstrap.Modal.getInstance(document.getElementById('deleteCardModal'));
        if (deleteCardModal) {
            deleteCardModal.hide();
        }
    });

    // Clear form fields when the modal is shown
    document.getElementById('addCardModal').addEventListener('shown.bs.modal', function () {
        // Clear the form fields
        document.getElementById('cardTitle').value = '';
        document.getElementById('cardDescription').value = '';
        document.getElementById('cardCategory').value = 'Web'; // Default value, change as needed
    });
</script>

@endsection
