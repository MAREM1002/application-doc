@extends('layouts.app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Quill Script -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.6/quill.core.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<style>
    #editor {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        min-height: 300px; /* Ajustez la hauteur selon vos besoins */
    }

    /* Styles pour l'ombre colorée */
    .card.shadow-custom {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 6px 20px rgba(0, 0, 0, 0.1);
    }
    .card.shadow-custom.blue {
        box-shadow: 0 4px 8px rgba(0, 0, 255, 0.3), 0 6px 20px rgba(0, 0, 255, 0.3);
    }
    .card.shadow-custom.red {
        box-shadow: 0 4px 8px rgba(255, 0, 0, 0.3), 0 6px 20px rgba(255, 0, 0, 0.3);
    }
    .card.shadow-custom.green {
        box-shadow: 0 4px 8px rgba(0, 255, 0, 0.3), 0 6px 20px rgba(0, 255, 0, 0.3);
    }

    /* Styles pour les boutons avec des couleurs correspondant à celles des cartes */
    .btn-danger.shadow-blue {
        background-color: rgba(0, 0, 255, 0.6); /* Plus foncé */
        border-color: rgba(0, 0, 255, 0.8); /* Plus foncé */
        color: #fff; /* Texte en blanc pour un meilleur contraste */
    }
    .btn-danger.shadow-red {
        background-color: rgba(255, 0, 0, 0.6); /* Plus foncé */
        border-color: rgba(255, 0, 0, 0.8); /* Plus foncé */
        color: #fff; /* Texte en blanc pour un meilleur contraste */
    }
    .btn-danger.shadow-green {
        background-color: rgba(0, 255, 0, 0.6); /* Plus foncé */
        border-color: rgba(0, 255, 0, 0.8); /* Plus foncé */
        color: #fff; /* Texte en blanc pour un meilleur contraste */
    }

    /* Styles pour l'alignement du texte */
    .ql-align-left {
        text-align: left;
    }
    .ql-align-center {
        text-align: center;
    }
    .ql-align-right {
        text-align: right;
    }

    /* Styles pour le contenu principal */
    #contentArea .ql-align-left {
        text-align: left;
    }
    #contentArea .ql-align-center {
        text-align: center;
    }
    #contentArea .ql-align-right {
        text-align: right;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Maison de Web/</span>  Documentations</h4>
    
    <div class="row">
        <!-- Colonne gauche pour les cartes -->
        <div class="col-md-3">
            <div id="cardStack">
                <!-- Les cartes seront ajoutées dynamiquement ici -->
            </div>
            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addCardModal">
                Add Module
            </button>
        </div>

        <!-- Contenu principal -->
        <div class="col-md-9">
    <div id="mainContent" class="card p-0 mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between p-0 pt-4">
            <div class="app-academy-md-25 card-body py-0">
                <!-- Le contenu ou l'image sera mis à jour dynamiquement -->
                <div id="contentArea">
                    <div class="row g-3">
                        <div class="col-12 d-flex justify-content-center">
                            <img
                                src="../../assets/img/illustrations/wizard-create-deal-girl-with-laptop-light.png"
                                alt="wizard-create-deal"
                                data-app-light-img="illustrations/wizard-create-deal-girl-with-laptop-light.png"
                                width="650"
                                class="img-fluid border-custom" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Modale pour ajouter une nouvelle carte -->
    <div class="modal fade" id="addCardModal" tabindex="-1" aria-labelledby="addCardModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCardForm">
                        <div class="mb-3">
                            <label for="cardName" class="form-label">Documentation Name</label>
                            <input type="text" class="form-control" id="cardName" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale pour ajouter le contenu d'une carte -->
    <div class="modal fade" id="editCardModal" tabindex="-1" aria-labelledby="editCardModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCardModalLabel">Edit Documentation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCardForm">
                        <div class="mb-3">
                            <label for="cardContent" class="form-label">Documentation Content</label>
                            <!-- Utilisation de Quill -->
                            <div id="editor"></div>
                            <input type="hidden" id="cardContent">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Documentation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale de suppression d'une carte -->
    <div class="modal fade" id="deleteCardModal" tabindex="-1" aria-labelledby="deleteCardModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCardModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this card?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteButton" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de gestion des cartes et des modales -->
    <script>
        let cardToDelete = null;
        let colorIndex = 0;
        let currentCardElement = null;
        const colors = ['blue', 'red', 'green'];

        // Initialiser Quill
        let quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        [{ 'header': [1, 2, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link'],
                        ['image'],
                        [{ 'color': [] }, { 'background': [] }], // Ajout du sélecteur de couleur
                        [{ 'align': [] }] // Ajouter les options d'alignement
                    ],
                    handlers: {
                        'image': imageHandler
                    }
                }
            }
        });

        // Fonction pour transformer la première lettre en majuscule
        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        // Gestionnaire d'upload d'image
        function imageHandler() {
            const range = quill.getSelection();
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.style.display = 'none';
            input.addEventListener('change', () => {
                const file = input.files[0];
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100%'; // Ajustez la largeur selon vos besoins
                    quill.insertEmbed(range.index, 'image', img.src);
                };
                reader.readAsDataURL(file);
            });
            input.click();
        }

        // Gestion de l'ajout d'une carte
        document.getElementById('addCardForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const cardName = capitalizeFirstLetter(document.getElementById('cardName').value.trim());
            const cardColor = colors[colorIndex];
            colorIndex = (colorIndex + 1) % colors.length;

            const newCard = `
                <div class="card mb-3 shadow-custom ${cardColor}" onclick="openEditModal(this)">
                    <div class="card-body">
                        <h5 class="card-title">${cardName}</h5>
                        <button type="button" class="btn btn-danger btn-sm shadow-${cardColor}" onclick="openDeleteModal(event, this)">Delete</button>
                    </div>
                </div>
            `;

            document.getElementById('cardStack').insertAdjacentHTML('beforeend', newCard);
            document.getElementById('addCardForm').reset();
            const addCardModal = bootstrap.Modal.getInstance(document.getElementById('addCardModal'));
            addCardModal.hide();
        });

        // Ouverture de la modale d'édition
        function openEditModal(cardElement) {
            currentCardElement = cardElement;
            quill.setContents([]); // Réinitialiser Quill
            const editCardModal = new bootstrap.Modal(document.getElementById('editCardModal'));
            editCardModal.show();
        }

        // Gestion de la soumission du formulaire d'édition
        document.getElementById('editCardForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const cardContent = quill.root.innerHTML; // Récupérer le contenu de Quill

            // Mise à jour du contenu principal
            document.getElementById('contentArea').innerHTML = `
                <div class="p-4">
                    <div class="card shadow-custom ${currentCardElement.classList[2]} border-0 mb-4">
                        <div class="card-body">
                            <h4 class="card-title text-primary">${currentCardElement.querySelector('.card-title').textContent}</h4>
                            <div class="card-text text-secondary">${cardContent}</div>
                        </div>
                    </div>
                </div>
            `;

            const editCardModal = bootstrap.Modal.getInstance(document.getElementById('editCardModal'));
            editCardModal.hide();
        });

        // Ouverture de la modale de suppression
        function openDeleteModal(event, button) {
            event.stopPropagation();
            cardToDelete = button.closest('.card');
            const deleteCardModal = new bootstrap.Modal(document.getElementById('deleteCardModal'));
            deleteCardModal.show();
        }

        // Gestion de la suppression d'une carte
        document.getElementById('confirmDeleteButton').addEventListener('click', function () {
            if (cardToDelete) {
                cardToDelete.remove();
                cardToDelete = null;
            }
            const deleteCardModal = bootstrap.Modal.getInstance(document.getElementById('deleteCardModal'));
            deleteCardModal.hide();
        });
    </script>
</div>
@endsection
