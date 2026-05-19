<?php

function remover_menu_posts_padrao()
{
    remove_menu_page('edit.php');
}
add_action('admin_menu', 'remover_menu_posts_padrao');


function remover_atalho_posts_admin_bar($wp_admin_bar)
{
    $wp_admin_bar->remove_node('new-post');
}
add_action('admin_bar_menu', 'remover_atalho_posts_admin_bar', 999);


function bloquear_acesso_direto_posts()
{
    global $pagenow;


    if ($pagenow === 'edit.php' && (!isset($_GET['post_type']) || $_GET['post_type'] === 'post')) {
        wp_redirect(admin_url());
        exit;
    }


    if ($pagenow === 'post-new.php' && (!isset($_GET['post_type']) || $_GET['post_type'] === 'post')) {
        wp_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'bloquear_acesso_direto_posts');