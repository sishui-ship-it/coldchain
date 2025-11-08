<?php
/**
 * The header for our theme
 * 网站头部模板
 *
 * @package Cold_Transport_Pro
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">
    <?php _e('跳过导航 | Skip to content', 'cold-transport'); ?>
</a>

<header id="site-header" class="site-header" role="banner">
    <div class="container">
        <div class="header-inner">
            
            <!-- 网站品牌标识 -->
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <div class="site-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <div class="site-title-wrap">
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                        <?php
                        $description = get_bloginfo('description', 'display');
                        if ($description || is_customize_preview()) :
                        ?>
                            <p class="site-description"><?php echo $description; ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- 主导航 -->
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('主菜单 | Main Menu', 'cold-transport'); ?>">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="hamburger">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </span>
                    <span class="menu-toggle-text">
                        <?php _e('菜单 | Menu', 'cold-transport'); ?>
                    </span>
                </button>
                
                <?php
                wp_nav_menu(array(
                    'theme_location'  => 'primary',
                    'menu_id'         => 'primary-menu',
                    'menu_class'      => 'nav-menu',
                    'container'       => false,
                    'fallback_cb'     => 'cold_transport_fallback_menu',
                    'depth'           => 3,
                ));
                ?>
            </nav>

            <!-- 头部操作区域 -->
            <div class="header-actions">
                
                <!-- 搜索框 -->
                <div class="header-search">
                    <button class="search-toggle" aria-expanded="false">
                        <span class="search-icon">🔍</span>
                        <span class="screen-reader-text">
                            <?php _e('搜索 | Search', 'cold-transport'); ?>
                        </span>
                    </button>
                    <div class="search-form-container">
                        <?php get_search_form(); ?>
                    </div>
                </div>
                
                <!-- 语言切换 -->
                <div class="language-switcher">
                    <button class="language-btn" aria-expanded="false">
                        <span class="current-lang">中文</span>
                        <span class="lang-arrow">▼</span>
                    </button>
                    <div class="language-dropdown">
                        <a href="?lang=zh" class="lang-option" data-lang="zh">中文</a>
                        <a href="?lang=en" class="lang-option" data-lang="en">English</a>
                    </div>
                </div>
                
                <!-- 联系按钮 -->
                <div class="header-contact">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="contact-btn">
                        <?php _e('联系我们 | Contact', 'cold-transport'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- 主内容区域 -->
<div id="page" class="site">
    <div id="main-content" class="site-content">
