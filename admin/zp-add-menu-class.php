<?php
/*
 * create admin menu and sub menu
 * example:
    $page_one = new Admin_page_class('zp-donate', 'Zarin Pall Donate', 'page_one_callback', 10);
    $page_one->add_menu_zp_func();
    function page_one_callback() { // }
 */

class Admin_page
{
    public $page_option = 'manage_options';
    public $logo = 'dashicons-image-filter';
    public $page_dir = 'zp-donate';
    public $page_slug;
    public $page_title;
    public $page_callback;
    public $position;
	
    public function __construct($page_slug, $page_title, $page_callback, $position) {
        $this->page_slug = $page_slug;
        $this->page_title = $page_title;
        $this->page_callback = $page_callback;
        $this->position = $position;
    }
    //add menu page
    public function add_menu_zp_func(){
        add_action('admin_menu', array(&$this, 'add_menu_zp'));
    }
    //add sub menu page
    public function add_submenu_zp_func(){
        add_action('admin_menu', array(&$this, 'add_submenu_zp'));
    }

    public function add_menu_zp()
    {
        add_menu_page(
            $this->page_slug,
            $this->page_title,
            $this->page_option,
            $this->page_dir,
            $this->page_callback,
            $this->logo,
            $this->position
        );

    }

    public function add_submenu_zp()
    {
        add_submenu_page(
            $this->page_dir,
            $this->page_title,
            $this->page_title,
            $this->page_option,
            $this->page_slug,
            $this->page_callback,
            $this->position
        );
    }
}