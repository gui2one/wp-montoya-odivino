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
  }
}

function odivino_animated_title() {
  let title = /** @type {HTMLElement} */ (
    document.querySelector(".odivino-animated-title")
  );

  if (title) {
    let str = title?.innerHTML;
    title.innerHTML = ""; /* reset content */

    for (let letter of str) {
      let span = document.createElement("span");
      span.innerHTML = letter;
      title.appendChild(span);
    }

    title.addEventListener("mouseover", () => {
      console.log("title hover !!");
    });
  }
}
