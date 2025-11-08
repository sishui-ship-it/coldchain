<?php
/**
 * Cold Transport Pro Theme Functions
 * 主题功能文件
 * 
 * @package Cold_Transport_Pro
 */

if (!defined('ABSPATH')) {
    exit; // 直接访问禁止
}

// 主题版本
define('COLD_TRANSPORT_VERSION', '1.0.0');

/**
 * 主题初始化设置
 */
function cold_transport_setup() {
    // 加载翻译文件
    load_theme_textdomain('cold-transport', get_template_directory() . '/languages');
    
    // 支持自动Feed链接
    add_theme_support('automatic-feed-links');
    
    // 支持标题标签
    add_theme_support('title-tag');
    
    // 支持文章特色图像
    add_theme_support('post-thumbnails');
    
    // 支持自定义Logo
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // 支持HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // 注册导航菜单
    register_nav_menus(array(
        'primary' => __('主菜单 | Primary Menu', 'cold-transport'),
        'footer'  => __('底部菜单 | Footer Menu', 'cold-transport'),
        'mobile'  => __('移动菜单 | Mobile Menu', 'cold-transport'),
    ));
    
    // 自定义图像尺寸
    add_image_size('product-thumb', 400, 300, true);
    add_image_size('product-large', 800, 600, true);
    add_image_size('hero-banner', 1200, 600, true);
}
add_action('after_setup_theme', 'cold_transport_setup');

/**
 * 注册样式和脚本
 */
function cold_transport_scripts() {
    // 主样式表
    wp_enqueue_style('cold-transport-style', get_stylesheet_uri(), array(), COLD_TRANSPORT_VERSION);
    wp_enqueue_style('cold-transport-main', get_template_directory_uri() . '/assets/css/main.css', array(), COLD_TRANSPORT_VERSION);
    wp_enqueue_style('cold-transport-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array('cold-transport-main'), COLD_TRANSPORT_VERSION);
    
    // 主JavaScript文件
    wp_enqueue_script('cold-transport-script', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), COLD_TRANSPORT_VERSION, true);
    
    // 为脚本传递PHP变量到JavaScript
    wp_localize_script('cold-transport-script', 'coldTransport', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('cold_transport_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'cold_transport_scripts');

/**
 * 注册产品自定义文章类型
 */
function cold_transport_register_product_post_type() {
    $labels = array(
        'name'                  => _x('产品 | Products', 'post type general name', 'cold-transport'),
        'singular_name'         => _x('产品 | Product', 'post type singular name', 'cold-transport'),
        'menu_name'             => _x('产品 | Products', 'admin menu', 'cold-transport'),
        'name_admin_bar'        => _x('产品 | Product', 'add new on admin bar', 'cold-transport'),
        'add_new'               => _x('添加产品 | Add New', 'product', 'cold-transport'),
        'add_new_item'          => __('添加新产品 | Add New Product', 'cold-transport'),
        'new_item'              => __('新产品 | New Product', 'cold-transport'),
        'edit_item'             => __('编辑产品 | Edit Product', 'cold-transport'),
        'view_item'             => __('查看产品 | View Product', 'cold-transport'),
        'all_items'             => __('所有产品 | All Products', 'cold-transport'),
        'search_items'          => __('搜索产品 | Search Products', 'cold-transport'),
        'not_found'             => __('未找到产品 | No products found.', 'cold-transport'),
        'not_found_in_trash'    => __('回收站中未找到产品 | No products found in Trash.', 'cold-transport'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'products'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-truck',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
        'rest_base'          => 'products',
    );

    register_post_type('product', $args);
}
add_action('init', '_transport_register_product_post_type');

/**
 * 注册产品分类法
 */
function cold_transport_register_product_taxonomy() {
    $labels = array(
        'name'              => _x('产品分类 | Product Categories', 'taxonomy general name', 'cold-transport'),
        'singular_name'     => _x('产品分类 | Product Category', 'taxonomy singular name', 'cold-transport'),
        'search_items'      => __('搜索分类 | Search Categories', 'cold-transport'),
        'all_items'         => __('所有分类 | All Categories', 'cold-transport'),
        'parent_item'       => __('父级分类 | Parent Category', 'cold-transport'),
        'parent_item_colon' => __('父级分类: | Parent Category:', 'cold-transport'),
        'edit_item'         => __('编辑分类 | Edit Category', 'cold-transport'),
        'update_item'       => __('更新分类 | Update Category', 'cold-transport'),
        'add_new_item'      => __('添加新分类 | Add New Category', 'cold-transport'),
        'new_item_name'     => __('新分类名称 | New Category Name', 'cold-transport'),
        'menu_name'         => __('产品分类 | Product Categories', 'cold-transport'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'product-category'),
        'show_in_rest'      => true,
    );

    register_taxonomy('product_category', array('product'), $args);
}
add_action('init', 'cold_transport_register_product_taxonomy');

/**
 * 注册小工具区域
 */
function cold_transport_widgets_init() {
    // 主侧边栏
    register_sidebar(array(
        'name'          => __('主侧边栏 | Main Sidebar', 'cold-transport'),
        'id'            => 'sidebar-1',
        'description'   => __('在主页面显示的侧边栏 | Sidebar that appears on the main pages', 'cold-transport'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // 页脚小工具区域
    register_sidebar(array(
        'name'          => __('页脚区域 1 | Footer Area 1', 'cold-transport'),
        'id'            => 'footer-1',
        'description'   => __('第一个页脚小工具区域 | First footer widget area', 'cold-transport'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar(array(
        'name'          => __('页脚区域 2 | Footer Area 2', 'cold-transport'),
        'id'            => 'footer-2',
        'description'   => __('第二个页脚小工具区域 | Second footer widget area', 'cold-transport'),
        'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'cold_transport_widgets_init');

/**
 * 自定义菜单回退函数
 */
function cold_transport_fallback_menu() {
    echo '<ul id="primary-menu" class="menu">';
    echo '<li><a href="' . home_url() . '">' . __('首页 | Home', 'cold-transport') . '</a></li>';
    echo '<li><a href="/products">' . __('产品中心 | Products', 'cold-transport') . '</a></li>';
    echo '<li><a href="/about">' . __('关于我们 | About', 'cold-transport') . '</a></li>';
    echo '<li><a href="/contact">' . __('联系我们 | Contact', 'cold-transport') . '</a></li>';
    echo '</ul>';
}

/**
 * 自定义摘录长度
 */
function cold_transport_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'cold_transport_excerpt_length');

/**
 * 自定义摘录更多文本
 */
function cold_transport_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'cold_transport_excerpt_more');

// 包含其他功能文件
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/template-functions.php';
?>
