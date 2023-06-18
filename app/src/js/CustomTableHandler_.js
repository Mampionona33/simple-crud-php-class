import { Modal, Toast } from "bootstrap";
import { CustomToast } from "./CustomToast";

export class CustomTableHandler {
  constructor(formTemplate, concernedRessource, apiEndpoint, idVariableName) {
    // initialise variables
    this.formTemplate = formTemplate;
    this.modalAddTitle = `Créer ${concernedRessource}`;
    this.modalElement = document.createElement("div");
    this.modalElement.classList.add("modal");
    this.modalEditTitle = `Modifier ${concernedRessource}`;
    this.apiEndpoint = apiEndpoint;
    this.idVariableName = idVariableName;

    // Ecouter le bouton add
    this.buttonAdd = document.getElementById("table-btn-add");
    this.buttonAdd.addEventListener("click", this.handleClickAdd.bind(this));

    // Ecouter si le bouton edit est cliqué
    this.buttonEdit = document.querySelectorAll('button[name="edit"]');
    this.buttonEdit.forEach((button) => {
      button.addEventListener("click", (ev) => {
        ev.preventDefault();
        // recuperer l'id de la ligne pour la recuperer dans handleClickEdit
        this.rowId = ev.target.dataset.id;
        this.handleClickEdit.bind(this)();
      });
    });

    // Ecouter le boutton delete
    this.buttonDelete = document.querySelectorAll('button[name="delete"]');
    this.buttonDelete.forEach((buttonDelete) => {
      buttonDelete.addEventListener("click", (ev) => {
        console.log(ev.target);
      });
    });

    // Remove modal if hidden
    this.modalElement.addEventListener(
      "hide.bs.modal",
      this.removeModal.bind(this)
    );
  }

  handleClickAdd() {
    this.showModal(this.modalAddTitle);
  }

  async handleClickEdit() {
    // Créer un modal au click sur un boutton edit
    try {
      const rowData = await this.getRowDataFromApi();
      this.showModal(this.modalEditTitle, rowData[0]);
    } catch (error) {}
  }

  showModal(title, data) {
    const modalForm = this.generateModal(title, data);
    this.modalElement.innerHTML = modalForm;
    document.body.appendChild(this.modalElement);
    this.modal = new Modal(this.modalElement, {
      backdrop: true,
      keyboard: true,
    });

    // Ecouter l'événement de soumission du formulaire
    const form = this.modalElement.querySelector("#form_modal");
    form.addEventListener("submit", this.handleFormSubmit.bind(this));

    this.modal.show();
  }

  generateModal(title = "Title", data = []) {
    const buttonSubmitText =
      Object.keys(data).length === 0 ? "Ajouter" : "Modifier";

    this.buttonSubmitId =
      Object.keys(data).length === 0
        ? "submit_modal_create"
        : "submit_modal_update";

    return `
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">${title}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="form_modal">
            <div class="modal-body">
              <div class="d-flex justify-content-center align-items-center">
                <div class="col-9">${this.formTemplate(data)}</div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" id="${
                this.buttonSubmitId
              }" class="btn btn-primary">${buttonSubmitText}</button>
            </div>
          </form>
        </div>
      </div>
    `;
  }

  removeModal() {
    if (this.modal.hide) {
      this.modalElement.remove();
    }
  }

  handleFormSubmit(ev) {
    ev.preventDefault();
    const form = ev.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    const submitButton = form.querySelector(`#${this.buttonSubmitId}`);
    const isEditModal = submitButton.id === "submit_modal_update";

    if (isEditModal) {
      // Utiliser la méthode "PUT" pour l'édition
      this.putDataToApi(data).then((resp) => {
        // console.log(resp);
        if (resp.status === 200) {
          this.createToaster(resp.data.message);
        }
        if (resp.status === 401) {
          this.createToaster(resp.data.error, "error");
        }
      });
    } else {
      // Utiliser la méthode "POST" pour l'ajout
      this.postDataToApi(data).then((resp) => {
        if (resp.status === 201) {
          this.createToaster(resp.data.message);
        }
        if (resp.status === 401) {
          this.createToaster(resp.data.error, "error");
        }
      });
    }
  }

  async putDataToApi(putData) {
    try {
      const requestData = { ...putData, id_voter: this.rowId };
      const response = await fetch(`/api/${this.apiEndpoint}`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(requestData),
      });
      const data = await response.json();
      return {
        status: response.status,
        data: data,
      };
    } catch (error) {
      throw error;
    }
  }

  createToaster(message, status = "success") {
    this.toastElement = document.createElement("div");
    this.toastElement.classList.add("customToast");
    this.toastContent = new CustomToast(message, status);
    this.toastElement.innerHTML = this.toastContent.renderToast();
    document.body.appendChild(this.toastElement);
    this.liveToast = document.getElementById("liveToast");
    this.toast = new Toast(liveToast);
    this.toast.show();

    setTimeout(() => {
      this.toast.hide();
    }, 2500);

    if (status.match(/success/i)) {
      this.modal.hide();
      if (this.modal.hide) {
        setTimeout(() => {
          window.location.reload();
        }, 2000);
      }
    }

    this.liveToast.addEventListener("hidden.bs.toast", () => {
      this.toastElement.remove();
    });
  }

  async postDataToApi(postData) {
    try {
      const response = await fetch(`/api/${this.apiEndpoint}`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(postData),
      });
      const data = await response.json();
      return {
        status: response.status,
        data: data,
      };
    } catch (error) {
      throw error;
    }
  }

  async getRowDataFromApi() {
    try {
      const response = await fetch(
        `/api/${this.apiEndpoint}?${this.idVariableName}=${this.rowId}`
      );
      if (!response.ok) {
        throw new Error("Unable to fetch data from API.");
      }
      const data = response.json(); // Utilise response.json() pour obtenir les données JSON
      return data;
    } catch (error) {
      console.error(error);
      throw error;
    }
  }

  alertConfirmDelete() {
    return `
    
    `;
  }
}
