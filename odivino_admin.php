<?php

    wp_enqueue_script('wp-api');

    function custom_admin_menu()
    {
        add_menu_page(
            'Odivino Admin',              // Page title
            'Odivino Admin',              // Menu title
            'manage_options',             // Capability
            'odivino-admin',              // Menu slug (custom URL)
            'custom_admin_page_callback', // Callback function to render the page
            'dashicons-admin-tools',      // Icon
            2                             // Position
        );
    }
    add_action('admin_menu', 'custom_admin_menu');

    function custom_admin_page_callback()
    {
    ?>
<div class="wrap">
    <h1>Odivino Admin ( Inutile pour l'instant)</h1>
    <p>This page allows you to edit posts using the REST API.</p>
    <div id="custom-app">



    </div>
    <script type="module">
        import { my_function } from '<?php echo get_stylesheet_directory_uri(); ?>/js/admin_module.js';

        my_function();
        function build_plat_container(plat_data){
            const plat_container = document.createElement('div');
            plat_container.className = 'plat-container';
            plat_container.style.opacity = "1.0";
            plat_container.style.transform = "unset";
            plat_container.innerHTML = `<h4>${plat_data.title}</h4><p>${plat_data.content}</p>`;
            plat_container.innerHTML += `<button>Edit plat (${plat_data.id})</button>`;
            return plat_container;
        }
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/wp-json/wp/v2/plats')
                .then(response => response.json())
                .then((posts) => {
                    console.log(posts);
                    for(let post of posts){
                        const plat_container = build_plat_container({id : post.id, title: post.title.rendered, content: post.content.rendered});
                        document.getElementById('custom-app').appendChild(plat_container);
                    }
                });
        });
    </script>
</div>
<?php
}
