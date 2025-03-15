import { my_function } from "./js/admin_module";

// @ts-nocheck
console.log("odivino_admin.js executed");

edit_plat();
// wp.api.loadPromise.done(function () {
//   //   get_plats().then((data) => {
//   //     console.log(data);
//   //   });
// });

// async function get_plats() {
//   let fetched = await fetch("/wp-json/wp/v2/plats/");
//   let result = await fetched.json();

//   return result;
// }

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

my_function();
