import { Modal } from "bootstrap";

export class CustomTableHandler {
  handleBtnEdit() {
    const editButtons = document.querySelectorAll('button[name="edit"]');
    editButtons.forEach((button) => {
      button.addEventListener("click", function (ev) {
        ev.preventDefault();
        const rowId = parseInt(ev.target.dataset.id);
        const urlParams = new URLSearchParams(window.location.search);
        const userId = urlParams.get("id");

        // Générer le contenu du modal en utilisant les données appropriées
        const modalContent = generateModalContent("Edit", rowId, userId);

        // Créer un élément HTML pour le modal
        const modalElement = document.createElement("div");
        modalElement.classList.add("modal");
        modalElement.innerHTML = modalContent;

        // Créer une instance du modal Bootstrap avec l'option backdrop:false
        const modal = new Modal(modalElement, { backdrop: true });

        // Ajouter un écouteur d'événements sur le bouton de fermeture du modal
        const closeButton = modalElement.querySelector(
          '[data-bs-dismiss="modal"]'
        );
        closeButton.addEventListener("click", function () {
          modal.hide();
          modalElement.remove();
        });

        // Afficher le modal
        modal.show();
      });
    });
  }
}

// Fonction pour générer le contenu du modal en fonction des données
function generateModalContent(title, rowId, userId) {
  return `
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">${title}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenu du formulaire d'édition -->
                <form>
                    <label>Test</label>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
    `;
}
