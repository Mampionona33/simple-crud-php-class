import { autoloadToast } from "./js/autoloadToast";
import "./styles/style.scss";
import * as bootstrap from "bootstrap";
// import modalHandler from "./js/modalHandler";
import { CustomTableHandler } from "./js/CustomTableHandler";

// modalHandler();
autoloadToast();
console.log("Hello World!!");

// run table handler 
const generateVoterForm =(data)=>{
    return  `
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Nom</label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" name="name" id="name" value=${data["name"]} required>
        </div>
    </div>
    <div class="form-group row">
        <label for="last_name" class="col-sm-3 col-form-label">Prénoms</label>
        <div class="col-sm-9">
            <input type="text" name="last_name" id="last_name" value=${data["last_name"]} required class="form-control form-control-sm">
        </div>
    </div>
    `;
}
const voterTableHandler = new CustomTableHandler();
voterTableHandler.handleBtnEdit("voter?id_voter", generateVoterForm);

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