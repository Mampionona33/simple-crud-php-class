import { autoloadToast } from "./js/autoloadToast";
import "./styles/style.scss";
import * as bootstrap from "bootstrap";
// import modalHandler from "./js/modalHandler";
import { CustomTableHandler } from "./js/CustomTableHandler_";

// modalHandler();
autoloadToast();
console.log("Hello World!!");

// const generateVoterForm = (data) => {
//   return `
//     <div class="form-group row">
//     <label for="name" class="col-sm-3 col-form-label">Nom</label>
//     <div class="col-sm-9">
//         <input type="text" class="form-control form-control-sm" name="name" id="name" value="${
//           data["name"] ? data["name"] : ""
//         }" required>
//     </div>
//     </div>
//     <div class="form-group row">
//         <label for="last_name" class="col-sm-3 col-form-label">Prénoms</label>
//         <div class="col-sm-9">
//             <input type="text" name="last_name" id="last_name" value="${
//               data["last_name"] ? data["last_name"] : ""
//             }" required class="form-control form-control-sm">
//         </div>
//     </div>
//     <div class="form-group row">
//         <label for="birthday" class="col-sm-3 col-form-label">Date de naissance</label>
//         <div class="col-sm-9">
//             <input type="date" name="birthday" id="birthday" value="${
//               data["birthday"] ? data["birthday"] : ""
//             }" required class="form-control form-control-sm">
//         </div>
//     </div>
//     <div class="form-group row">
//         <label for="adresse" class="col-sm-3 col-form-label">Adresse</label>
//         <div class="col-sm-9">
//             <input type="text" name="adresse" id="adresse" value="${
//               data["adresse"] ? data["adresse"] : ""
//             }" required class="form-control form-control-sm">
//         </div>
//     </div>
//     <fieldset>
//         <p class="form-label col-form-label">Sélectionnez la civilité</p>
//         <div class="form-check">
//             <input class="form-check-input" type="radio" id="Mr" name="civility" value="Mr" ${
//               data["civility"] === "Mr" ? "checked" : "checked"
//             }>
//             <label class="form-check-label" for="Mr">Mr</label>
//         </div>
//         <div class="form-check">
//             <input class="form-check-input" type="radio" id="Mme" name="civility" value="Mme" ${
//               data["civility"] === "Mme" ? "checked" : ""
//             }>
//             <label class="form-check-label" for="Mme">Mme</label>
//         </div>
//         <div class="form-check">
//             <input class="form-check-input" type="radio" id="Mlle" name="civility" value="Mlle" ${
//               data["civility"] === "Mlle" ? "checked" : ""
//             }>
//             <label class="form-check-label" for="Mlle">Mlle</label>
//         </div>
//     </fieldset>

//     `;
// };

const voterTableHandler = new CustomTableHandler();

// const generateUserForm =(data)=>{
//     return  `
//     <div class="form-group row">
//         <label for="name" class="col-sm-3 col-form-label">Nom</label>
//         <div class="col-sm-9">
//             <input type="text" class="form-control form-control-sm" name="name" id="name" value=${data["name"]} required>
//                     </div>
//                 </div>

//                 <div class="d-flex justify-content-center gap-3">
//                     <input type="reset" value="Recommencer" class="btn btn-secondary">
//         <input type="submit" value="$submitButton" class="btn btn-primary">
//     </div>
//     `;
// }

// const userTableHandler = new CustomTableHandler();
// userTableHandler.handleBtnEdit("/api/user", generateUserForm);
