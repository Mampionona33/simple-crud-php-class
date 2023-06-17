import { Modal, Toast } from "bootstrap";
import { CustomToast } from "./CustomToast";

export class CustomTableHandler {
  constructor(formTemplate, modalAddTitle) {
    // initialise variables
    this.formTemplate = formTemplate;
    this.modalAddTitle = modalAddTitle;
    this.modalElement = document.createElement("div");
    this.modalElement.classList.add("modal");

    // Ecouter le bouton add
    this.buttonAdd = document.getElementById("table-btn-add");
    this.buttonAdd.addEventListener("click", this.handleClickAdd.bind(this));

    // Ecouter si le bouton edit est cliqué
    this.buttonEdit = document.querySelectorAll('button[name="edit"]');
    this.buttonEdit.forEach((button) => {
      button.addEventListener("click", (ev) => {
        ev.preventDefault();
        this.handleClickEdit.bind(this)();
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

  handleClickEdit() {
    console.log("Button edit clicked");
  }

  showModal(title) {
    const modalForm = this.generateModal(title);
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
                <div class="col-9">${this.formTemplate([])}</div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" id="submit_modal" class="btn btn-primary">${
                data.length > 0 ? "Modifier" : "Ajouter"
              }</button>
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

    this.postDataToApi(data).then((resp) => {
      if (resp.status === 201) {
        this.createToaster(resp.data.message);
      }
      if (resp.status === 401) {
        this.createToaster(resp.data.error, "error");
      }
    });
  }

  async postDataToApi(postData) {
    const apiUrl = "voter";
    try {
      const response = await fetch(`/api/${apiUrl}`, {
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
        }, 2500);
      }
    }

    this.liveToast.addEventListener("hidden.bs.toast", () => {
      this.toastElement.remove();
    });
  }
}
