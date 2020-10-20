<?php

add_action('wp_enqueue_scripts', 'theodosiou_enqueue_styles');

add_action('wp_logout', 'auto_redirect_after_logout');

function auto_redirect_after_logout()
{
    wp_safe_redirect(home_url());
    exit;
}

add_action('init', 'admin_bar');

add_action('elementor/query/my_photos', function ($query) {

    $user_id = get_current_user_id();
    $member_subscriptions = pms_get_member_subscriptions(array('user_id' => $user_id));

    $member_subscription_ids = [];
    foreach ($member_subscriptions as $member_subscription) {
        $member_subscription_ids[] = $member_subscription->subscription_plan_id;
    }

    $meta_query = [[
        'key' => 'pms-content-restrict-subscription-plan',
        'value' => $member_subscription_ids,
        'compare' => 'in',
    ]];

    $query->set('meta_query', $meta_query);


});

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

    if (is_user_logged_in() && current_user_can('edit_posts')) {
        add_filter('show_admin_bar', '__return_true', 1000);
    }
}

?>
