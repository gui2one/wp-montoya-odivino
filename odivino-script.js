window.addEventListener("DOMContentLoaded", () => {
  console.log("odivino-script loaded");

  odivino_plats();
  odivino_animated_title();
});

let options = {
  rootMargin: "0px 0px 0px 0px",
  threshold: 0.3,
};
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
  }, options);

  for (let i = 0; i < plats.length; i++) {
    let plat = plats[i];
    obs.observe(plat);
    // plat.classList.add("reverse");
    // if (i % 2 == 0) {
    //   plat.classList.add("reverse");
    // }
  }
}

function odivino_animated_title() {
  let titles = document.querySelectorAll(".odivino-animated-title");
  for (let title of titles) {
    console.log(title);
  }
}
