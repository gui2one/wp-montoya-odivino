window.addEventListener("DOMContentLoaded", () => {
  console.log("odivino-script loaded");

  odivino_plats();
});

function odivino_plats() {
  const plats = document.querySelectorAll(".odivino-plat-container");

  let obs = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("show");
        console.log("add show");
        obs.unobserve(entry.target);
      }
    });
  });

  for (let i = 0; i < plats.length; i++) {
    let plat = plats[i];
    obs.observe(plat);
    if (i % 2 == 0) {
      plat.classList.add("reverse");
    }
  }
}
