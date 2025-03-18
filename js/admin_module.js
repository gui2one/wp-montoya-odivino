import { LitElement, html /* @ts-ignore */, css } from "./libs/lit-all.min.js";

export function my_function() {
  console.log("MY FUNCTION !!!!!!!!!!!!!!!!!!");
}

export class OdivinoAdminTabs extends LitElement {
  constructor() {
    super();
    this.tabs = [];
    this._curTab = 0;
  }

  properties() {
    return {
      tabs: { type: Array },
      _curTab: { type: Number },
    };
  }

  async fetch_post_type(post_type) {
    let response = await fetch(
      "/wp-json/wp/v2/" + post_type + "?per_page=100&orderby=title&order=asc"
    );
    let json = await response.json();
    return json;
  }
  async build_items_container(tab) {
    let content_div = this.querySelector(".tabcontent");
    if (content_div !== null) {
      console.log("build_items_container !!!!!!!!!!!!!");
      console.log(tab);
      content_div.innerHTML = "";
      console.log(tab.slug);
      content_div.innerHTML = tab.title;
      let data = await this.fetch_post_type(tab.slug);
      console.log(data[0]);
      for (let item of data) {
        console.log(item);
        let plat_container = new OdivinoAdminPlat();
        plat_container.title = decodeHtmlCharCodes(item.title.rendered);
        plat_container.category = item[`${tab.slug}-category`];
        plat_container.content.innerHTML = decodeHtmlCharCodes(
          item.content.rendered
        );
        // plat_container.title = item.title.rendered;

        content_div.appendChild(plat_container);
      }
    }
  }
  set curTab(index) {
    this._curTab = index;
    // console.log("curtab", this._curTab);
    let content_div = this.querySelector(".tabcontent");
    if (content_div) {
      content_div.innerHTML = this.tabs[index].content.innerHTML;
    }
    console.log(index);
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
            html`<button
              @click=${() => {
                this.curTab = index;
                this.build_items_container(tab);
              }}
            >
              ${tab.title}
            </button>`
        )}
      </div>
      <div class="tabcontent"></div>
    `;
  }
}
// @ts-ignore
customElements.define("odivino-admin-tabs", OdivinoAdminTabs);

export class OdivinoAdminTab extends LitElement {
  constructor() {
    super();
    this._title = "no title";
    this._slug = "no slug";
    this.content = document.createElement("div");
    this.content.innerHTML = "no content";
  }

  static get properties() {
    return {
      title: { type: String },
      content: { type: HTMLElement },
      slug: { type: String },
    };
  }

  get title() {
    return this._title;
  }
  set title(value) {
    this._title = value;
  }

  get slug() {
    return this._slug;
  }
  set slug(value) {
    this._slug = value;
  }

  // @ts-ignore
  render() {
    return html` <div class="tabcontent">${this.title}</div> `;
  }
}
// @ts-ignore
customElements.define("odivino-admin-tab", OdivinoAdminTab);

export class OdivinoAdminPlat extends LitElement {
  constructor() {
    super();
    this._title = "no title";
    this._content = document.createElement("div");
    this._category = -1;
  }
  properties() {
    return {
      title: { type: String },
      content: { type: HTMLElement },
    };
  }
  static styles = css`
    :host {
      display: block;
    }
  `;
  set title(value) {
    this._title = value;
  }
  get title() {
    return this._title;
  }

  set content(value) {
    this._content = value;
  }
  get content() {
    return this._content;
  }

  set category(value) {
    this._category = value;
  }
  get category() {
    return this._category;
  }

  edit_post() {
    document.body.appendChild(new OdivinoEditPlat());
    console.log(this.title);
  }
  // @ts-ignore
  render() {
    return html` <div class="plat-container">
      <h2>${this.title}</h2>
      <p>${this.content}</p>
      <p>${this.category}</p>
      <button @click=${this.edit_post}>Edit</button>
    </div>`;
  }
}
customElements.define("odivino-admin-plat", OdivinoAdminPlat);

export class OdivinoEditPlat extends LitElement {
  constructor() {
    super();
    this.plat_id = -1;
  }

  static styles = css`
    :host {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      z-index: 1000000000;
    }

    #edit_plat_container {
      background-color: red;
      display: flex;
      flex-direction: column;
    }
  `;
  cancel() {
    console.log("cancelling");
    this.remove();
  }

  save() {
    console.log("saving");
  }

  // @ts-ignore
  createRenderRoot() {
    return this; // Renders template in light DOM instead of shadow DOM
  }
  // @ts-ignore
  render() {
    return html`
      <div id="edit_plat_container">
        <label for="input_title">Titre </label>
        <input type="text" id="input_title" />
        <label for="input_description">Description </label>
        <input type="text" id="input_description" />
        <label for="input_price">Prix </label>
        <input type="number" id="input_price" />
      </div>
      <div id="edit_plat_buttons">
        <button @click=${this.cancel}>Cancel</button>
        <button @click=${this.save}>Save</button>
      </div>
    `;
  }
}
customElements.define("odivino-edit-plat", OdivinoEditPlat);
// utils functions
export function edit_plat(id) {
  let page = new wp.api.models.Plats({ id: id });

  page.fetch().then(() => {
    console.log("Current Content:", page.get("content").rendered);

    // Update the content properly
    page.set("content", {
      raw: `
            <!-- wp:paragraph -->
<p>Trio de mignardises</p>
<!-- /wp:paragraph -->`,
      block_version: 2,
    });
    // page.content.rendered = "\n<p>sdfsdf</p>";
    console.log(page);

    // // Save the updated post
    // page
    //   .save()
    //   .then(() => console.log("Post updated successfully"))
    //   .catch((err) => console.error("Save failed:", err));
  });
}

function decodeHtmlCharCodes(str) {
  return str.replace(/(&#(\d+);)/g, function (match, capture, charCode) {
    return String.fromCharCode(charCode);
  });
}
