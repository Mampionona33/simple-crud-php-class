export const autoloadToast = () => {
  const toastLiveExample = document.getElementById("liveToast");
  const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);

  if (toastLiveExample) {
    console.log("live toaster");
    toastBootstrap.show();
  }
};
