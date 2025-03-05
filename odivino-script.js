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

  let str = title?.innerHTML;
  let new_title = document.createElement("h1");
  new_title.classList.add("odivino-animated-title");
  for (let letter of str) {
    let span = document.createElement("span");
    span.innerHTML = letter;
    new_title.appendChild(span);
  }

  title.parentElement?.appendChild(new_title);
  title.remove();
}
