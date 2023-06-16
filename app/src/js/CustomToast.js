export class CustomToast {
    #message;
    #type;
  
    constructor(message, type = "info") {
      this.#message = message;
      this.#type = type;
    }
  
    renderToast() {
      let headerClass = "";
      let headerTitle = "";
  
      if (this.#type.match(/error/ig)) {
        headerClass = "bg-danger text-white";
        headerTitle = "Erreur";
      } else if (this.#type === "success") {
        headerClass = "bg-success text-white";
        headerTitle = "Succès";
      } else {
        headerClass = "bg-info text-white";
        headerTitle = "Information";
      }
  
      return `
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header ${headerClass}">
                    <strong class="me-auto">${headerTitle}</strong>
                    <small>Il y a quelques instants</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${this.#message}
                </div>
            </div>
        </div>
      `;
    }
  }
  