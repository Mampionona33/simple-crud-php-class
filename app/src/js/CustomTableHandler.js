import { Modal } from "bootstrap";

export class CustomTableHandler {
  handleBtnEdit(apiUrl, formGenerator) {
    
    const editButtons = document.querySelectorAll('button[name="edit"]');
    
    editButtons.forEach((button) => {
      button.addEventListener("click", async (ev) => {
        ev.preventDefault();
        const rowId = parseInt(ev.target.dataset.id);
        const currentPort = window.location.port;
        const currentHost = window.location.host;
        let currentBasedUrl;

        if (currentPort) {
          currentBasedUrl = `${currentHost}:${currentPort}`;
        } else {
          currentBasedUrl = currentHost;
        }

        try {
          // Récupérer les données de l'API
          const data = await this.fetchDataFromAPI(apiUrl, rowId);

          // Générer le contenu du modal en utilisant les données appropriées
          const modalContent = generateModalContent("Edit",formGenerator(data));

          // Créer un élément HTML pour le modal
          const modalElement = document.createElement("div");
          modalElement.classList.add("modal");
          modalElement.innerHTML = modalContent;

          // Créer une instance du modal Bootstrap avec l'option backdrop:true et keyboard:true
          const modal = new Modal(modalElement, { backdrop: true, keyboard: true });

          // Ajouter un écouteur d'événements sur le bouton de fermeture du modal
          const closeButton = modalElement.querySelector(
            '[data-bs-dismiss="modal"]'
          );
          closeButton.addEventListener("click", function () {
            modal.hide();
            modalElement.remove();
          });

          // Ajouter un écouteur d'événements au document pour supprimer le modal en cliquant à l'extérieur
          const removeModalOnOutsideClick = function (event) {
            if (!modalElement.contains(event.target)) {
              modal.hide();
              modalElement.remove();
              document.removeEventListener("click", removeModalOnOutsideClick);
            }
          };
          document.addEventListener("click", removeModalOnOutsideClick);

          // Afficher le modal
          modal.show();
        } catch (error) {
          console.error(error);
        }
      });
    });
  }

  // Méthode pour récupérer les données de l'API
  async fetchDataFromAPI(apiUrl, id) {
    try {
      const response = await fetch(`/api/${apiUrl}=${id}`);
      if (!response.ok) {
        throw new Error("Unable to fetch data from API.");
      }
      const data = await response.json();
      return data[0];
    } catch (error) {
      console.error(error);
      throw error;
    }
  }
}

// Fonction pour générer le contenu du modal en fonction des données et du formulaire
function generateModalContent(title, formContent) {
  return `
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">${title}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Contenu du formulaire d'édition -->
                <div class="d-flex justify-content-center align-items-center">
                    <div class="col-9">
                        ${formContent}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
    `;
}
