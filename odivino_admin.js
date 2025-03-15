// @ts-nocheck
import { my_function } from "./js/admin_module";

// @ts-nocheck
console.log("odivino_admin.js executed");

edit_plat();

function edit_plat() {
  // Fetch the post by slug to get its ID first
  let post = new wp.api.collections.Plats();
  post
    .fetch({ data: { slug: "cafe-gustoso" } })
    .then((posts) => {
      if (posts.length === 0) {
        console.error("Post not found");
        return;
      }

      let page = new wp.api.models.Plats({ id: posts[0].id });

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
    })
    .catch((err) => console.error("Fetch failed:", err));
}
