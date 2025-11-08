<?php
/**
 * Cold Transport Pro - 主题自定义设置
 * Theme Customizer Settings
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 添加主题自定义设置
 */
function cold_transport_customize_register($wp_customize) {
    
    // ===== 主题设置面板 =====
    $wp_customize->add_panel('cold_transport_theme_options', array(
        'title' => __('主题设置 | Theme Options', 'cold-transport'),
        'description' => __('Cold Transport Pro主题自定义设置 | Customize settings for Cold Transport Pro theme', 'cold-transport'),
        'priority' => 10,
    ));
    
    // ===== 头部设置部分 =====
    $wp_customize->add_section('cold_transport_header_settings', array(
        'title' => __('头部设置 | Header Settings', 'cold-transport'),
        'panel' => 'cold_transport_theme_options',
        'priority' => 10,
    ));
    
    // 头部背景颜色
    $wp_customize->add_setting('cold_transport_header_bg_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'cold_transport_header_bg_color', array(
        'label' => __('头部背景颜色 | Header Background Color', 'cold-transport'),
        'section' => 'cold_transport_header_settings',
        'settings' => 'cold_transport_header_bg_color',
    )));
    
    // 头部文字颜色
    $wp_customize->add_setting('cold_transport_header_text_color', array(
        'default' => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'cold_transport_header_text_color', array(
        'label' => __('头部文字颜色 | Header Text Color', 'cold-transport'),
        'section' => 'cold_transport_header_settings',
        'settings' => 'cold_transport_header_text_color',
    )));
    
    // 显示/隐藏搜索框
    $wp_customize->add_setting('cold_transport_show_header_search', array(
        'default' => true,
        'sanitize_callback' => 'cold_transport_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('cold_transport_show_header_search', array(
        'label' => __('显示头部搜索框 | Show Header Search', 'cold-transport'),
        'section' => 'cold_transport_header_settings',
        'type' => 'checkbox',
    ));
    
    // ===== 首页设置部分 =====
    $wp_customize->add_section('cold_transport_homepage_settings', array(
        'title' => __('首页设置 | Homepage Settings', 'cold-transport'),
        'panel' => 'cold_transport_theme_options',
        'priority' => 20,
    ));
    
    // 英雄区域标题
    $wp_customize->add_setting('cold_transport_hero_title', array(
        'default' => __('专业冷链运输解决方案专家 | Professional Cold Chain Transportation Solutions', 'cold-transport'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('cold_transport_hero_title', array(
        'label' => __('英雄区域标题 | Hero Section Title', 'cold-transport'),
        'section' => 'cold_transport_homepage_settings',
        'type' => 'text',
    ));
    
    // 英雄区域描述
    $wp_customize->add_setting('cold_transport_hero_description', array(
        'default' => __('专注于冷藏车、鸡苗运输车的研发与制造，为全球客户提供可靠的运输设备 | Specializing in the R&D and manufacturing of refrigerated trucks and chick transport vehicles, providing reliable transportation equipment for global customers', 'cold-transport'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('cold_transport_hero_description', array(
        'label' => __('英雄区域描述 | Hero Section Description', 'cold-transport'),
        'section' => 'cold_transport_homepage_settings',
        'type' => 'textarea',
    ));
    
    // 英雄区域背景图片
    $wp_customize->add_setting('cold_transport_hero_background', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'cold_transport_hero_background', array(
        'label' => __('英雄区域背景图片 | Hero Section Background Image', 'cold-transport'),
        'section' => 'cold_transport_homepage_settings',
        'settings' => 'cold_transport_hero_background',
    )));
    
    // 显示特色产品
    $wp_customize->add_setting('cold_transport_show_featured_products', array(
        'default' => true,
        'sanitize_callback' => 'cold_transport_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('cold_transport_show_featured_products', array(
        'label' => __('显示特色产品 | Show Featured Products', 'cold-transport'),
        'section' => 'cold_transport_homepage_settings',
        'type' => 'checkbox',
    ));
    
    // 特色产品数量
    $wp_customize->add_setting('cold_transport_featured_products_count', array(
        'default' => 6,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('cold_transport_featured_products_count', array(
        'label' => __('特色产品数量 | Featured Products Count', 'cold-transport'),
        'section' => 'cold_transport_homepage_settings',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 12,
            'step' => 1,
        ),
    ));
    
    // ===== 产品设置部分 =====
    $wp_customize->add_section('cold_transport_product_settings', array(
        'title' => __('产品设置 | Product Settings', 'cold-transport'),
        'panel' => 'cold_transport_theme_options',
        'priority' => 30,
    ));
    
    // 产品每页显示数量
    $wp_customize->add_setting('cold_transport_products_per_page', array(
        'default' => 9,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('cold_transport_products_per_page', array(
        'label' => __('每页产品数量 | Products Per Page', 'cold-transport'),
        'section' => 'cold_transport_product_settings',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 24,
            'step' => 1,
        ),
    ));
    
    // 显示相关产品
    $wp_customize->add_setting('cold_transport_show_related_products', array(
        'default' => true,
        'sanitize_callback' => 'cold_transport_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('cold_transport_show_related_products', array(
        'label' => __('显示相关产品 | Show Related Products', 'cold-transport'),
        'section' => 'cold_transport_product_settings',
        'type' => 'checkbox',
    ));
    
    // 相关产品数量
    $wp_customize->add_setting('cold_transport_related_products_count', array(
        'default' => 4,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('cold_transport_related_products_count', array(
        'label' => __('相关产品数量 | Related Products Count', 'cold-transport'),
        'section' => 'cold_transport_product_settings',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 8,
            'step' => 1,
        ),
    ));
    
    // ===== 页脚设置部分 =====
    $wp_customize->add_section('cold_transport_footer_settings', array(
        'title' => __('页脚设置 | Footer Settings', 'cold-transport'),
        'panel' => 'cold_transport_theme_options',
        'priority' => 40,
    ));
    
    // 页脚版权信息
    $wp_customize->add_setting('cold_transport_footer_copyright', array(
        'default' => '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. ' . __('版权所有 | All rights reserved.', 'cold-transport'),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('cold_transport_footer_copyright', array(
        'label' => __('页脚版权信息 | Footer Copyright Text', 'cold-transport'),
        'section' => 'cold_transport_footer_settings',
        'type' => 'textarea',
    ));
    
    // 公司联系信息
    $wp_customize->add_setting('cold_transport_company_phone', array(
        'default' => '+86 000-0000-0000',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('cold_transport_company_phone', array(
        'label' => __('公司电话 | Company Phone', 'cold-transport'),
        'section' => 'cold_transport_footer_settings',
        'type' => 'text',
    ));
    
    $wp_customize->add_setting('cold_transport_company_email', array(
        'default' => 'info@example.com',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('cold_transport_company_email', array(
        'label' => __('公司邮箱 | Company Email', 'cold-transport'),
        'section' => 'cold_transport_footer_settings',
        'type' => 'email',
    ));
    
    $wp_customize->add_setting('cold_transport_company_address', array(
        'default' => __('中国山东省济宁市泗水县 | Sishui County, Jining City, Shandong Province, China', 'cold-transport'),
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('cold_transport_company_address', array(
        'label' => __('公司地址 | Company Address', 'cold-transport'),
        'section' => 'cold_transport_footer_settings',
        'type' => 'textarea',
    ));
    
    // ===== 颜色设置部分 =====
    $wp_customize->add_section('cold_transport_color_settings', array(
        'title' => __('颜色设置 | Color Settings', 'cold-transport'),
        'panel' => 'cold_transport_theme_options',
        'priority' => 50,
    ));
    
    // 主色调
    $wp_customize->add_setting('cold_transport_primary_color', array(
        'default' => '#2c5aa0',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'cold_transport_primary_color', array(
        'label' => __('主色调 | Primary Color', 'cold-transport'),
        'section' => 'cold_transport_color_settings',
        'settings' => 'cold_transport_primary_color',
    )));
    
    // 辅助色
    $wp_customize->add_setting('cold_transport_secondary_color', array(
        'default' => '#f0a500',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'cold_transport_secondary_color', array(
        'label' => __('辅助色 | Secondary Color', 'cold-transport'),
        'section' => 'cold_transport_color_settings',
        'settings' => 'cold_transport_secondary_color',
    )));
    
    // 背景色
    $wp_customize->add_setting('cold_transport_background_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'cold_transport_background_color', array(
        'label' => __('背景色 | Background Color', 'cold-transport'),
        'section' => 'cold_transport_color_settings',
        'settings' => 'cold_transport_background_color',
    )));
}

add_action('customize_register', 'cold_transport_customize_register');

/**
 * 验证复选框
 */
function cold_transport_sanitize_checkbox($input) {
    return (bool) $input;
}

/**
 * 在头部输出自定义CSS
 */
function cold_transport_customizer_css() {
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo get_theme_mod('cold_transport_primary_color', '#2c5aa0'); ?>;
            --secondary-color: <?php echo get_theme_mod('cold_transport_secondary_color', '#f0a500'); ?>;
        }
        
        .site-header {
            background-color: <?php echo get_theme_mod('cold_transport_header_bg_color', '#ffffff'); ?>;
            color: <?php echo get_theme_mod('cold_transport_header_text_color', '#333333'); ?>;
        }
        
        body {
            background-color: <?php echo get_theme_mod('cold_transport_background_color', '#ffffff'); ?>;
        }
        
        <?php if (get_theme_mod('cold_transport_hero_background')) : ?>
        .hero-section {
            background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('<?php echo get_theme_mod('cold_transport_hero_background'); ?>');
            background-size: cover;
            background-position: center;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'cold_transport_customizer_css');

/**
 * 实时预览JavaScript
 */
function cold_transport_customizer_live_preview() {
    wp_enqueue_script(
        'cold-transport-customizer',
        get_template_directory_uri() . '/assets/js/customizer.js',
        array('jquery', 'customize-preview'),
        COLD_TRANSPORT_VERSION,
        true
    );
}
add_action('customize_preview_init', 'cold_transport_customizer_live_preview');
?>
