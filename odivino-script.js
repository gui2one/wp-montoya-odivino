window.addEventListener("DOMContentLoaded", () => {
  console.log("odivino-script loaded");

  odivino_plats();
});

function odivino_plats() {
  const plats = document.querySelectorAll(".odivino-plat-container");
  plats.forEach((plat) => {
    plat.addEventListener("click", () => {
      console.log(plat);
    });
  });
}
