import { Modal } from "bootstrap";

export class CustomTableHandler {
  handleBtnEdit() {
    const editButtons = document.querySelectorAll('button[name="edit"]');
    editButtons.forEach((button) => {
      button.addEventListener("click", async (ev) => {
        ev.preventDefault();
        const rowId = parseInt(ev.target.dataset.id);
        const urlParams = new URLSearchParams(window.location.search);
        const currentPort = window.location.port;
        const currentHost = window.location.host;

        let currentBasedUrl;

        if (currentPort) {
          currentBasedUrl = `${currentHost}:${currentPort}`;
        } else {
          currentBasedUrl = currentHost;
        }

        const userId = urlParams.get("id");

        try {
          // Récupérer les données de l'API
          const data = await this.fetchDataFromAPI(userId, currentBasedUrl);

          // Générer le contenu du modal en utilisant les données appropriées
          const modalContent = generateModalContent("Edit", data);

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
        } catch (error) {
          console.error(error);
        }
      });
    });
  }

  // Méthode pour récupérer les données de l'API
  async fetchDataFromAPI(userId, baseUrl) {
    const apiUrl = `/api/user?userId=${userId}`;

    try {
      const response = await fetch(apiUrl);
      if (!response.ok) {
        throw new Error("Unable to fetch data from API.");
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error(error);
      throw error;
    }
  }
}

// Fonction pour générer le contenu du modal en fonction des données
function generateModalContent(title, data) {
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
                        <div class="form-group row">
                            <label for="name" class="col-sm-5 col-form-label">Nom</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control form-control-sm" value=${data["nom"]} name="name" id="name"  required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lastName" class="col-sm-5 col-form-label">Prénoms</label>
                            <div class="col-sm-7">
                                <input type="text" name="lastName" id="lastName" value=${data["prenom"]}  required class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-5 col-form-label">email</label>
                            <div class="col-sm-7">
                                <input type="email" name="email" id="email" value=${data["email"]}  required class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="role" class="col-sm-5 col-form-label">Role</label>
                            <div class="col-sm-7">
                                <select name="role" id="role" class="form-control form-control-sm" required>
                                    <option value="admin" ${data["role"] === "admin" ? 'selected' : ''}>Admin</option>
                                    <option value="operator" ${data["role"] === "operator" ? 'selected' : ''}>Operator</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-5 col-form-label">password</label>
                            <div class="col-sm-7">
                                <input type="password" name="password" id="password" value=${data["password"]} required class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="confirm_password" class="col-sm-5 col-form-label">Confirm password</label>
                            <div class="col-sm-7">
                                <input type="password" name="confirm_password" id="confirm_password" required class="form-control form-control-sm">
                            </div>
                        </div>
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
