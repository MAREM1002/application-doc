let currentFormToDelete = null;

function showAddPopup() {
    document.getElementById("addPopup").style.display = "flex";
}

function closeAddPopup() {
    document.getElementById("addPopup").style.display = "none";
}

function showDeletePopup(formElement) {
    currentFormToDelete = formElement;
    document.getElementById("deletePopup").style.display = "flex";
}

function closeDeletePopup() {
    document.getElementById("deletePopup").style.display = "none";
    currentFormToDelete = null;
}

function addIcon() {
    const iconName = document.getElementById("iconName").value;
    if (iconName) {
        const li = document.createElement("li");
        li.className = "icon";

        const span = document.createElement("span");
        span.textContent = iconName;

        const deleteButton = document.createElement("button");
        deleteButton.innerHTML = "&times;"; // Utilisation de la croix noire
        deleteButton.onclick = function() {
            // Créez un formulaire de suppression temporaire pour la nouvelle icône
            const form = document.createElement("form");
            form.action = "/icons/delete"; // Mettez ici l'URL de suppression appropriée
            form.method = "POST";
            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
            `;
            document.body.appendChild(form);
            showDeletePopup(form);
        };

        li.appendChild(span);
        li.appendChild(deleteButton);

        const navbar = document.get;}}
