<?php
/*
 * Fails if this class wasn't loaded by the plugin boot script 
 */
if (!defined('HB_PLUGIN_VERSION')) {
    header( 'HTTP/1.0 403 Forbidden' );
    die;
}

/**
 * A sample plugin class for building Hoverboard things that happen on the 
 * admin side of WordPress
 */
class HB_Generate_Menu
{

    /**
     * Include a default menu with the theme
     * @return string The slug to be used as a body class
     * @since  0.1.0
     *
     * Example configuration:
     *    
     * $menu_config = [
     *     'menu_name'     => 'Main Menu',
     *     'menu_location' => 'primary',
     *     'menu_items'    => [
     *         [ 
     *             'title' => 'About',
     *             'url'   => '/about/',
     *             'class' => 'about'
     *         ],
     *         [ 
     *             'title' => 'Health',
     *             'url'   => '/health/',
     *             'class' => 'health'
     *         ],
     *         [ 
     *             'title' => 'Fitness &amp; Nutrition',
     *             'url'   => '/fitness-nutrition/',
     *             'class' => 'fitness-nutrition'
     *         ],
     *         [ 
     *             'title' => 'Blog',
     *             'url'   => '/blog/',
     *             'class' => 'blog'
     *         ],
     *         [ 
     *             'title' => 'Contact',
     *             'url'   => '/contact/',
     *             'class' => 'contact'
     *         ],
     *         [ 
     *             'title' => 'Facebook',
     *             'url'   => '#',
     *             'class' => 'fa fa-facebook'
     *         ],
     *         [ 
     *             'title' => 'Twitter',
     *             'url'   => '#',
     *             'class' => 'fa fa-twitter'
     *         ],
     *         [ 
     *             'title' => 'Instagram',
     *             'url'   => '#',
     *             'class' => 'fa fa-instagram'
     *         ],
     *         [ 
     *             'title' => 'YouTube',
     *             'url'   => '#',
     *             'class' => 'fa fa-youtube'
     *         ]
     *     ]
     * ];
     * 
     * if (class_exists('HB_Generate_Menu')) {
     *     HB_Generate_Menu::generate_default_menu($menu_config);
     * }
     * 
     */
    static function generate_default_menu( $menu_config ) {
        global $wp_query;

        // Does the menu exist already?
        if( !wp_get_nav_menu_object( $menu_config['menu_name'] )){
            
            // If it doesn't exist, let's create it.
            $menu_id = wp_create_nav_menu($menu_config['menu_name']);

            // Set up default links and add them to the menu.
            foreach ($menu_config['menu_items'] as $item) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' =>  __($item['title']),
                    'menu-item-classes' => $item['class'],
                    'menu-item-url' => home_url( $item['url'] ), 
                    'menu-item-status' => 'publish'));
            }

            // Grab the theme locations and assign our newly-created menu
            // to the primary menu location.
            if( !has_nav_menu( $menu_config['menu_location'] ) ){
                $locations = get_theme_mod('nav_menu_locations');
                $locations[$menu_config['menu_location']] = $menu_id;
                set_theme_mod( 'nav_menu_locations', $locations );
            }
        }
    }

}
