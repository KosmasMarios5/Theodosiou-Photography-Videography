<?php

add_action('wp_enqueue_scripts', 'theodosiou_enqueue_styles');
add_action('init', 'admin_bar');

function theodosiou_enqueue_styles()
{
    $parenthandle = 'parent-style';
    $theme = wp_get_theme();
    wp_enqueue_style($parenthandle, get_template_directory_uri() . '/style.css',
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );

    wp_enqueue_style('child-style', get_stylesheet_uri(),
        array($parenthandle),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}

function admin_bar()
{
    if (is_user_logged_in()) {
        add_filter('show_admin_bar', '__return_true', 1000);
    }
}

?>
