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
                <div class="d-flex justify-content-center align-items-center"">
                  <div class="col-9">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Nom</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-sm" name="name" id="name" value="$name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lastName" class="col-sm-3 col-form-label">Prénoms</label>
                            <div class="col-sm-9">
                                <input type="text" name="lastName" id="lastName" value="$lastName" required class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="birthday" class="col-sm-3 col-form-label">Date de naissance</label>
                            <div class="col-sm-9">
                                <input type="date" name="birthday" id="birthday" value="$birthday" required class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" id="email" value="$email" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label">Adresse</label>
                            <div class="col-sm-9">
                                <input type="text" name="address" id="address" value="$address" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tel" class="col-sm-3 col-form-label">Tel</label>
                            <div class="col-sm-9">
                                <input type="tel" name="tel" id="tel" value="$tel" class="form-control form-control-sm">
                            </div>
                        </div>
                        <fieldset>
                            <p class="form-label col-form-label">Sélectionnez la civilité</p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="Mr" name="civilite" value="Mr" $civiliteMrChecked>
                                <label class="form-check-label" for="Mr">Mr</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="Mme" name="civilite" value="Mme" $civiliteMmeChecked>
                                <label class="form-check-label" for="Mme">Mme</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="Mlle" name="civilite" value="Mlle" $civiliteMlleChecked>
                                <label class="form-check-label" for="Mlle">Mlle</label>
                            </div>
                        </fieldset>
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
