import { autoloadToast } from "./js/autoloadToast";
import "./styles/style.scss";
import * as bootstrap from "bootstrap";
// import modalHandler from "./js/modalHandler";
import { CustomTableHandler } from "./js/CustomTableHandler";

// modalHandler();
autoloadToast();
console.log("Hello World!!");

// run table handler 
const adminUserList = new CustomTableHandler();
adminUserList.handleBtnEdit();
