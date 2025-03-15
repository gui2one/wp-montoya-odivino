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
            0                             // Position
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
        import { OdivinoAdminTabs, OdivinoAdminTab } from '<?php echo get_stylesheet_directory_uri(); ?>/js/admin_module.js';

        const root_div = document.getElementById('custom-app');
        let tabs = document.createElement('odivino-admin-tabs');

        let tab1 = document.createElement('odivino-admin-tab');
        tab1.title = "Plats";

        let tab2 = document.createElement('odivino-admin-tab');
        tab2.title = "Pizzas";

        let tab3 = document.createElement('odivino-admin-tab');
        tab3.title = "A Emporter";


        tabs.tabs = [tab1, tab2, tab3];
        root_div.appendChild(tabs);

        // root_div.appendChild(tabs);
        function build_plat_container(plat_data){
            const plat_container = document.createElement('div');
            plat_container.className = 'plat-container';
            plat_container.innerHTML = `<h4 class"title">${plat_data.title}</h4><p>${plat_data.content}</p>`;
            plat_container.innerHTML += `<button data-post-id="${plat_data.id}">Modifier</button>`;
            plat_container.querySelector('button').addEventListener('click', (ev) => {
                console.log(ev.target.dataset.postId);
            })
            return plat_container;
        }

        async function fetch_post_type(post_type) {
            let response = await fetch('/wp-json/wp/v2/' + post_type + '?per_page=100&orderby=title&order=asc');
            let json = await response.json();
            return json;

        }

        async function init_all(){
            let plats = await fetch_post_type('plats');
            console.log(plats);

            tab1.content.innerHTML = `<h1>Les plats</h1>`;
            let containers = [];
            let plats_container = document.createElement('div');
            plats_container.id = "plats-container";
            for (let i = 0; i < plats.length; i++) {
                const plat_container = build_plat_container({id : plats[i].id, title: plats[i].title.rendered, content: plats[i].content.rendered});
                plats_container.appendChild(plat_container);
            }

            tab1.content.appendChild(plats_container);


            let pizzas = await fetch_post_type('pizzas');
            tab2.content.innerHTML = `<h1>Les pizzas</h1>`;
            let pizzas_container = document.createElement('div');
            pizzas_container.id = "plats-container";
            for (let i = 0; i < pizzas.length; i++) {
                const plat_container = build_plat_container({id : pizzas[i].id, title: pizzas[i].title.rendered, content: pizzas[i].content.rendered});
                pizzas_container.appendChild(plat_container);
            }
            tab2.content.appendChild(pizzas_container);

            let a_emporter = await fetch_post_type('a_emporter');
            tab3.content.innerHTML = `<h1>Les a_emporter</h1>`;
            let a_emporter_container = document.createElement('div');
            a_emporter_container.id = "plats-container";
            for (let i = 0; i < a_emporter.length; i++) {
                const plat_container = build_plat_container({id : a_emporter[i].id, title: a_emporter[i].title.rendered, content: a_emporter[i].content.rendered});
                a_emporter_container.appendChild(plat_container);
            }
            tab3.content.appendChild(a_emporter_container);
        }
        document.addEventListener('DOMContentLoaded',()=> {
           init_all();
        });

    </script>
</div>
<?php
}
