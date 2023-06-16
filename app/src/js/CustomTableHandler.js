import { Modal, Toast } from "bootstrap";
import { CustomToast } from "./CustomToast";

export class CustomTableHandler {
  constructor(formGenerator) {
    this.formGenerator = formGenerator;
    this.handleBtnAdd(this.formGenerator);
    this.handleBtnEdit(this.formGenerator);
  }

  handleBtnEdit(formGenerator) {
    const editButtons = document.querySelectorAll('button[name="edit"]');
    // Edit
    editButtons.forEach((button) => {
      button.addEventListener("click", async (ev) => {
        ev.preventDefault();
        const rowId = parseInt(ev.target.dataset.id);
        const apiPath = ev.target.dataset.apiPath;
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
          const data = await this.fetchDataFromAPI(apiPath, rowId);

          // Générer le contenu du modal en utilisant les données appropriées
          const modalContent = generateModalContent(
            "Modifier l'électeur",
            formGenerator(data)
          );

          // Créer un élément HTML pour le modal
          const modalElement = createModalElement(modalContent);

          // Créer une instance du modal Bootstrap avec l'option backdrop:true et keyboard:true
          const modal = new Modal(modalElement, {
            backdrop: true,
            keyboard: true,
          });

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

  handleBtnAdd(formGenerator) {
    const addButton = document.getElementById("table-btnAdd");
    addButton.addEventListener("click", async (ev) => {
      ev.preventDefault();

      const modalContent = generateModalContent(
        "Créer un électeur",
        formGenerator([])
      );

      const modalElement = createModalElement(modalContent);
      document.body.appendChild(modalElement);

      // Créer une instance du modal Bootstrap avec l'option backdrop:true et keyboard:true
      const modal = new Modal(modalElement, { backdrop: true, keyboard: true });

      modal.show();

      const submitButton = modalElement.querySelector("#submit_modal");

      submitButton.addEventListener("click", async function () {
        try {
          const data = await handleSubmit(modalElement);
          if (data && data.status === 201) {
            closeModal(modal, modalElement);
            showSuccessToast(data.message);
          } else if (data && data.status === 401) {
            showErrorToast(data.error);
          }
        } catch (error) {
          console.error(error);
        }
      });
      
      document.addEventListener("submit",async (event)=>{
        event.preventDefault();
        try {
          const data = await handleSubmit(modalElement);
          if (data && data.status === 201) {
            closeModal(modal, modalElement);
            showSuccessToast(data.message);
          } else if (data && data.status === 401) {
            showErrorToast(data.error);
          }
        } catch (error) {
          console.error(error);
        }
      })

      // Ajouter un écouteur d'événements sur le bouton de fermeture du modal
      const closeButton = modalElement.querySelector(
        '[data-bs-dismiss="modal"]'
      );

      closeButton.addEventListener("click", function () {
        closeModal(modal, modalElement);
      });

      // Ajouter un écouteur d'événements sur l'événement "hide" du modal
      modalElement.addEventListener("hide.bs.modal", function () {
        modalElement.remove();
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

  async postDataToApi(apiUrl, postData) {
    try {
      const response = await fetch(`/api/${apiUrl}`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(postData),
      });
      const data = await response.json();
      return data;
    } catch (error) {
      throw error;
    }
  }

}


// End of class start simple functions
async function handleSubmit(modalElement) {
  const form = modalElement.querySelector("form");
  const formData = new FormData(form);
  const postData = {};
  for (const [key, value] of formData.entries()) {
    postData[key] = value;
  }

  try {
    const response = await fetch(`/api/voter`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(postData),
    });
    const data = await response.json();
    data.status = response.status;

    return data;
  } catch (error) {
    throw error;
  }
}

function generateModalContent(title, formContent) {
  return `
    <form class="modal-dialog modal-dialog-centered">
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
                <button type="submit" id="submit_modal" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
    `;
}

function createModalElement(content) {
  const modalElement = document.createElement("div");
  modalElement.classList.add("modal");
  modalElement.innerHTML = content;
  return modalElement;
}

function closeModal(modal, modalElement) {
  modal.hide();
  modalElement.remove();
}

function showSuccessToast(message) {
  const toastElement = document.createElement("div");
  toastElement.classList.add("customToast");
  const toastContent = new CustomToast(message,"success");
  toastElement.innerHTML = toastContent.renderToast();
  document.body.appendChild(toastElement);
  const liveToast = document.getElementById("liveToast");
  const toast = new Toast(liveToast);
  toast.show();
  setTimeout(function () {
    toast.hide();
  }, 1500);
  liveToast.addEventListener("hidden.bs.toast", function () {
    window.location.reload();
  });
}

function showErrorToast(error) {
  const toastElement = document.createElement("div");
  toastElement.classList.add("customToast");
  const toastContent = new CustomToast(error,"error");
  toastElement.innerHTML = toastContent.renderToast();
  document.body.appendChild(toastElement);
  const liveToast = document.getElementById("liveToast");
  const toast = new Toast(liveToast);
  toast.show();
  setTimeout(function () {
    toast.hide();
    removeToast(toastElement);
  }, 2000);
}

function removeToast(toastElement) {
  toastElement.remove();
}
