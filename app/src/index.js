import { autoloadToast } from "./js/autoloadToast";
import "./styles/style.scss";
import * as bootstrap from "bootstrap";
import { CustomTableHandler } from "./js/CustomTableHandler";

// modalHandler();
autoloadToast();
console.log("Hello World!");

/**
 * Génère un formulaire HTML pour l'enregistrement des informations d'un électeur.
 * A utiliser comme premier argument du classe CustomTableHandler pour créer un objet modal
 * @param {object} data - Les données de l'électeur.
 * @returns {string} - Le code HTML du formulaire généré.
 */
const generateVoterForm = (data) => {
  return `
    <div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label">Nom</label>
    <div class="col-sm-8">
        <input type="text" class="form-control form-control-sm" name="name" id="name" value="${
          data["name"] ? data["name"] : ""
        }" required>
    </div>
    </div>
    <div class="form-group row">
        <label for="last_name" class="col-sm-4 col-form-label">Prénoms</label>
        <div class="col-sm-8">
            <input type="text" name="last_name" id="last_name" value="${
              data["last_name"] ? data["last_name"] : ""
            }" required class="form-control form-control-sm">
        </div>
    </div>
    <div class="form-group row">
        <label for="birthday" class="col-sm-4 col-form-label">Date de naissance</label>
        <div class="col-sm-8">
            <input type="date" name="birthday" id="birthday" value="${
              data["birthday"] ? data["birthday"] : ""
            }" required class="form-control form-control-sm">
        </div>
    </div>
    <div class="form-group row">
        <label for="adresse" class="col-sm-4 col-form-label">Adresse</label>
        <div class="col-sm-8">
            <input type="text" name="adresse" id="adresse" value="${
              data["adresse"] ? data["adresse"] : ""
            }" required class="form-control form-control-sm">
        </div>
    </div>
    <fieldset>
        <p class="form-label col-form-label">Sélectionnez la civilité</p>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="Mr" name="civility" value="Mr" ${
              data["civility"] === "Mr" ? "checked" : "checked"
            }>
            <label class="form-check-label" for="Mr">Mr</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="Mme" name="civility" value="Mme" ${
              data["civility"] === "Mme" ? "checked" : ""
            }>
            <label class="form-check-label" for="Mme">Mme</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="Mlle" name="civility" value="Mlle" ${
              data["civility"] === "Mlle" ? "checked" : ""
            }>
            <label class="form-check-label" for="Mlle">Mlle</label>
        </div>
    </fieldset>

    `;
};

/**
 * Génère un formulaire HTML pour l'enregistrement des informations d'un utilisateur.
 * A utiliser comme premier argument du classe CustomTableHandler pour créer un objet modal
 * @param {object} data - Les données de l'utilisateur.
 * @returns {string} - Le code HTML du formulaire généré.
 */
const generateUserForm = (data) => {
  return `
  <div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label">Nom</label> <!-- Ajustez la classe "col-sm-4" pour agrandir la largeur du label -->
    <div class="col-sm-8">
        <input type="text" class="form-control form-control-sm" name="nom" id="nom" value="${
          data["nom"] ? data["nom"] : ""
        }" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label">Prénom</label>
    <div class="col-sm-8">
        <input type="text" class="form-control form-control-sm" name="prenom" id="prenom" value="${
          data["prenom"] ? data["prenom"] : ""
        }" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label">Date de naissance</label>
    <div class="col-sm-8">
        <input type="date" class="form-control form-control-sm" name="birthday" id="birthday" value="${
          data["birthday"] ? data["birthday"] : ""
        }">
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label">email</label>
    <div class="col-sm-8">
        <input type="email" class="form-control form-control-sm" autocomplete="user@gmail.com" name="email" id="email" value="${
          data["email"] ? data["email"] : ""
        }" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label">Adresse</label>
    <div class="col-sm-8">
        <input type="text" class="form-control form-control-sm" autocomplete="adresse" name="address" id="address" value="${
          data["address"] ? data["address"] : ""
        }">
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label">Tel</label>
    <div class="col-sm-8">
        <input type="tel" class="form-control form-control-sm" autocomplete="tel" name="tel" id="tel" value="${
          data["tel"] ? data["tel"] : ""
        }" >
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label">Mots de passe</label>
    <div class="col-sm-8">
        <input type="password" class="form-control form-control-sm" autocomplete="password" name="password" id="password" value="${
          data["password"] ? data["password"] : ""
        }" >
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label">Confrilm mots de passe</label>
    <div class="col-sm-8">
        <input type="password" class="form-control form-control-sm" autocomplete="confirm-password" name="confirm-password" id="confirm-password">
    </div>
  </div>
  <div class="form-group row">
  <label for="role" class="col-sm-4 col-form-label">Rôle</label>
  <div class="col-sm-8">
    <select class="form-control form-control-sm" name="role" id="role" required>
      <option value="" ${
        !data["role"] ? "selected" : ""
      } disabled hidden></option>
      <option value="admin" ${
        data["role"] === "admin" ? "selected" : ""
      }>Admin</option>
      <option value="operator" ${
        data["role"] === "operator" ? "selected" : ""
      }>Operator</option>
    </select>
  </div>
</div>
  <fieldset>
        <p class="form-label col-form-label">Sélectionnez la civilité</p>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="Mr" name="civilite" value="Mr" ${
              data["civilite"] === "Mr" ? "checked" : "checked"
            }>
            <label class="form-check-label" for="Mr">Mr</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="Mme" name="civilite" value="Mme" ${
              data["civilite"] === "Mme" ? "checked" : ""
            }>
            <label class="form-check-label" for="Mme">Mme</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" id="Mlle" name="civilite" value="Mlle" ${
              data["civilite"] === "Mlle" ? "checked" : ""
            }>
            <label class="form-check-label" for="Mlle">Mlle</label>
        </div>
    </fieldset>
  `;
};

/**
 * ! Gestion de création des modales a la suite d'une click sur
 * ! un tableau génerer par l'instanciation d'un objet CustomTableHandler
 */
window.addEventListener("load", function () {
  const location = window.location;
  const pathName = location.pathname;

  if (
    pathName.match(/operator\/dashboard/i) ||
    pathName.match(/admin\/manage_voters/i)
  ) {
    const voterTableHandler = new CustomTableHandler(
      generateVoterForm,
      "un électeur",
      "voter",
      "id_voter"
    );
  }

  if (pathName.match(/admin\/manage_users/i)) {
    const userTableHandler = new CustomTableHandler(
      generateUserForm,
      "Utilisateur",
      "users",
      "id_user"
    );
  }
});
