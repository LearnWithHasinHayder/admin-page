<?php
/**
 * Plugin Name: Admin Page
 * Description: A simple plugin to demonstrate how to create an admin page in WordPress
 * Version: 1.0
 * Author: Hasin Hayder
 */

if (!defined('ABSPATH')) {
    exit;
}


class Admin_Page {
    function __construct() {
        add_action('init', [$this, 'init']);
    }

    function init() {
        $this->save_form();
        add_action('admin_menu', [$this, 'add_admin_menu']);
        //admin_enqueue_script tailwind cdn
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
    }

    function add_admin_menu() {
        add_menu_page(
            'Admin Page',
            'Admin Page',
            'manage_options',
            'admin-page',
            [$this, 'admin_page_content'],
            'dashicons-shield',
            20
        );
        //add three submenu pages 
        add_submenu_page(
            'admin-page',
            'Submenu Page 1',
            'Submenu Page 1',
            'manage_options',
            'submenu-page-1',
            [$this, 'submenu_page_content_1']
        );

        add_submenu_page(
            'admin-page',
            'Submenu Page 2',
            'Submenu Page 2',
            'manage_options',
            'submenu-page-2',
            [$this, 'submenu_page_content_2']
        );

        //add as a submenu page
        // add_submenu_page(
        //     'index.php',
        //     'Admin Page',
        //     'Admin Page',
        //     'manage_options',
        //     'admin-page',
        //     [$this, 'admin_page_content']
        // );
    }

    function admin_page_content() {
        include_once (plugin_dir_path(__FILE__) . 'pages/admin.php');
    }

    function submenu_page_content_1() {
        include_once (plugin_dir_path(__FILE__) . 'pages/submenu1.php');
    }

    function submenu_page_content_2() {
        include_once (plugin_dir_path(__FILE__) . 'pages/submenu2.php');
    }

    function admin_enqueue_scripts($hook) {
        if ($hook == 'toplevel_page_admin-page') {
            wp_enqueue_script('admin-page-tailwind', '//cdn.tailwindcss.com', [], '1.0', [
                'in_footer' => true,
                'strategy' => 'defer'
            ]);
        }
    }

    function save_form(){
        if(isset($_POST['action']) && $_POST['action'] == 'save_name'){
            if(!isset($_POST['save_name_nonce']) || !wp_verify_nonce($_POST['save_name_nonce'], 'save_name')){
                return;
            }
            if(!current_user_can('manage_options')){
                return;
            }
            if(!isset($_POST['user_name']) || empty($_POST['user_name'])){
                return;
            }
            update_option('user_name', sanitize_text_field($_POST['user_name']));
        }
    }

}

new Admin_Page();