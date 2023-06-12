const modalHandler = () => {
  const modalElement = document.getElementById("modal");
  modalElement.addEventListener("show.bs.modal", function (event) {
    // event.preventDefault();
    const button = event.relatedTarget; // Le bouton qui a déclenché l'ouverture du modal
    const id = button.getAttribute("data-bs-id"); // Récupérer la valeur de data-bs-id

    // Faites quelque chose avec la valeur de l'ID, par exemple affichez-la dans la console
    console.log("ID:", id);
  });
};

export default modalHandler;
