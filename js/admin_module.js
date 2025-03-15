import { LitElement, html /* @ts-ignore */ } from "./libs/lit-all.min.js";

export function my_function() {
  console.log("MY FUNCTION !!!!!!!!!!!!!!!!!!");
}

export class OdivinoAdminTabs extends LitElement {
  constructor() {
    super();
    this.tabs = [];
    this._curTab = 0;
  }

  set curTab(index) {
    this._curTab = index;
    // console.log("curtab", this._curTab);
    let content_div = this.querySelector(".tabcontent");
    if (content_div) {
      content_div.innerHTML = this.tabs[index].content.innerHTML;
    }
  }

  get curTab() {
    return this._curTab;
  }
  // @ts-ignore
  createRenderRoot() {
    return this; // Renders template in light DOM instead of shadow DOM
  }

  // @ts-ignore
  render() {
    return html`
      <div class="tabs">
        ${this.tabs.map(
          (tab, index) =>
            html`<button @click=${() => (this.curTab = index)}>
              ${tab.title}
            </button>`
        )}
      </div>
      <div class="tabcontent">${this.tabs[this.curTab].content}</div>
    `;
  }
}
// @ts-ignore
customElements.define("odivino-admin-tabs", OdivinoAdminTabs);

export class OdivinoAdminTab extends LitElement {
  constructor() {
    super();
    this.title = "no title";
    this.content = document.createElement("div");
    this.content.innerHTML = "no content";
  }

  static get properties() {
    return {
      title: { type: String },
      content: { type: HTMLElement },
    };
  }

  // @ts-ignore
  render() {
    return html` <div class="tabcontent">${this.content}</div> `;
  }
}
// @ts-ignore
customElements.define("odivino-admin-tab", OdivinoAdminTab);
