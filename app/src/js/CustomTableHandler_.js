import { Modal, Toast } from "bootstrap";
import { CustomToast } from "./CustomToast";

export class CustomTableHandler {
    constructor() {
        // Ecouter le bouton add
        this.buttonAdd = document.getElementById("table-btn-add");
        this.buttonAdd.addEventListener("click", this.handleClickAdd.bind(this));

        // Ecouter si le bouton edit est cliqué
        this.buttonEdit = document.querySelectorAll('button[name="edit"]');
        this.buttonEdit.forEach((button) => {
            button.addEventListener("click", (ev) => {
                ev.preventDefault();
                this.handleClickEdit();
            });
        });
    }

    handleClickAdd() {
        this.showModal();
    }

    handleClickEdit() {
        console.log("Button edit clicked");
    }

    showModal() {
        const modalElement = document.createElement("div");
        modalElement.classList.add("modal");
        // modalElement.innerHTML = content;
        console.log(modalElement);
    }

}
