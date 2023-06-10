import { Toast } from "bootstrap";

export const autoloadToast = () => {
  const toastLive = document.getElementById("liveToast");
  const toastBootstrap = Toast.getOrCreateInstance(toastLive);
  if (toastLive) {
    toastBootstrap.show();
  }
};
