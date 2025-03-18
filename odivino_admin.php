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
        import { OdivinoAdminTabs, OdivinoAdminTab, OdivinoAdminPlat , edit_plat } from '<?php echo get_stylesheet_directory_uri(); ?>/js/admin_module.js';

        const root_div = document.getElementById('custom-app');
        let tabs = document.createElement('odivino-admin-tabs');

        let tab1 = document.createElement('odivino-admin-tab');
        tab1.title = "Plats";
        tab1.slug = "plats";

        let tab2 = document.createElement('odivino-admin-tab');
        tab2.title = "Pizzas";
        tab2.slug = "pizzas";

        let tab3 = document.createElement('odivino-admin-tab');
        tab3.title = "A Emporter";
        tab3.slug = "a_emporter";


        tabs.tabs = [tab1, tab2, tab3];
        root_div.appendChild(tabs);

    </script>
</div>
<?php
}
