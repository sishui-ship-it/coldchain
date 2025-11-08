<?php
/**
 * Cold Transport Pro - 演示数据导入
 * Demo Content Importer
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 创建演示页面
 */
function cold_transport_create_demo_pages() {
    $pages = array(
        'home' => array(
            'title' => __('首页 | Home', 'cold-transport'),
            'content' => '<!-- wp:html -->
<div class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>专业冷链运输解决方案专家</h1>
            <p>专注于冷藏车、鸡苗运输车的研发与制造，为全球客户提供可靠的运输设备</p>
            <div class="hero-actions">
                <a href="/products" class="btn btn-primary">查看产品</a>
                <a href="/contact" class="btn btn-secondary">联系我们</a>
            </div>
        </div>
    </div>
</div>
<!-- /wp:html -->',
            'template' => 'front-page.php'
        ),
        
        'about' => array(
            'title' => __('关于我们 | About Us', 'cold-transport'),
            'content' => '<!-- wp:paragraph -->
<p>我们是一家专业从事冷藏车、鸡苗运输车研发与制造的企业，拥有20年的行业经验。</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2>我们的使命</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>为客户提供高品质、可靠的冷链运输解决方案。</p>
<!-- /wp:paragraph -->'
        ),
        
        'products' => array(
            'title' => __('产品中心 | Products', 'cold-transport'),
            'content' => '<!-- wp:paragraph -->
<p>浏览我们的冷藏车和鸡苗运输车产品系列。</p>
<!-- /wp:paragraph -->'
        ),
        
        'contact' => array(
            'title' => __('联系我们 | Contact', 'cold-transport'),
            'content' => '<!-- wp:html -->
<div class="contact-info">
    <div class="contact-item">
        <h3>电话</h3>
        <p>+86 000-0000-0000</p>
    </div>
    <div class="contact-item">
        <h3>邮箱</h3>
        <p>info@example.com</p>
    </div>
    <div class="contact-item">
        <h3>地址</h3>
        <p>中国山东省济宁市泗水县</p>
    </div>
</div>
<!-- /wp:html -->'
        )
    );
    
    foreach ($pages as $key => $page) {
        $page_id = wp_insert_post(array(
            'post_title' => $page['title'],
            'post_content' => $page['content'],
            'post_status' => 'publish',
            'post_type' => 'page',
            'page_template' => isset($page['template']) ? $page['template'] : ''
        ));
        
        if ($page_id && !is_wp_error($page_id)) {
            update_option('cold_transport_' . $key . '_page_id', $page_id);
        }
    }
}

/**
 * 创建产品分类
 */
function cold_transport_create_product_categories() {
    $categories = array(
        'refrigerated-trucks' => array(
            'name' => __('冷藏运输车 | Refrigerated Trucks', 'cold-transport'),
            'description' => __('专业食品、医药冷链运输车辆 | Professional food and pharmaceutical cold chain transportation vehicles', 'cold-transport'),
            'slug' => 'refrigerated-trucks'
        ),
        'chick-transport' => array(
            'name' => __('鸡苗运输车 | Chick Transport Vehicles', 'cold-transport'),
            'description' => __('专业活禽运输设备 | Professional live poultry transportation equipment', 'cold-transport'),
            'slug' => 'chick-transport'
        ),
        'special-vehicles' => array(
            'name' => __('特种运输车 | Special Transport Vehicles', 'cold-transport'),
            'description' => __('定制化特种运输解决方案 | Customized special transportation solutions', 'cold-transport'),
            'slug' => 'special-vehicles'
        )
    );
    
    $category_ids = array();
    
    foreach ($categories as $key => $category) {
        $term = wp_insert_term(
            $category['name'],
            'product_category',
            array(
                'description' => $category['description'],
                'slug' => $category['slug']
            )
        );
        
        if (!is_wp_error($term)) {
            $category_ids[$key] = $term['term_id'];
        }
    }
    
    return $category_ids;
}

/**
 * 创建演示产品
 */
function cold_transport_create_demo_products($category_ids) {
    $products = array(
        array(
            'title' => __('小型冷藏运输车 | Small Refrigerated Truck', 'cold-transport'),
            'content' => '<!-- wp:paragraph -->
<p>适用于城市配送的小型冷藏车，温度控制精确，节能环保。</p>
<!-- /wp:paragraph -->',
            'excerpt' => __('小型冷藏车，适用于城市冷链配送 | Small refrigerated truck for urban cold chain distribution', 'cold-transport'),
            'category' => 'refrigerated-trucks',
            'features' => array(
                __('温度范围: -20°C 至 +25°C | Temperature range: -20°C to +25°C', 'cold-transport'),
                __('载重量: 2-3吨 | Load capacity: 2-3 tons', 'cold-transport'),
                __('节能设计 | Energy-saving design', 'cold-transport')
            ),
            'specs' => array(
                array('name' => '载重量', 'value' => '2-3', 'unit' => '吨'),
                array('name' => '温度范围', 'value' => '-20°C 至 +25°C', 'unit' => ''),
                array('name' => '车厢尺寸', 'value' => '4.2×2.1×2.1', 'unit' => '米')
            )
        ),
        
        array(
            'title' => __('大型冷藏半挂车 | Large Refrigerated Semi-trailer', 'cold-transport'),
            'content' => '<!-- wp:paragraph -->
<p>适用于长途运输的大型冷藏半挂车，大容量，高效制冷。</p>
<!-- /wp:paragraph -->',
            'excerpt' => __('大型冷藏半挂车，适用于长途冷链运输 | Large refrigerated semi-trailer for long-distance cold chain transportation', 'cold-transport'),
            'category' => 'refrigerated-trucks',
            'features' => array(
                __('温度范围: -25°C 至 +15°C | Temperature range: -25°C to +15°C', 'cold-transport'),
                __('载重量: 20-30吨 | Load capacity: 20-30 tons', 'cold-transport'),
                __('智能温控系统 | Intelligent temperature control system', 'cold-transport')
            ),
            'specs' => array(
                array('name' => '载重量', 'value' => '20-30', 'unit' => '吨'),
                array('name' => '温度范围', 'value' => '-25°C 至 +15°C', 'unit' => ''),
                array('name' => '车厢容积', 'value' => '60', 'unit' => '立方米')
            ),
            'featured' => true
        ),
        
        array(
            'title' => __('标准鸡苗运输车 | Standard Chick Transport Vehicle', 'cold-transport'),
            'content' => '<!-- wp:paragraph -->
<p>专业鸡苗运输车，保证运输过程中鸡苗的健康和安全。</p>
<!-- /wp:paragraph -->',
            'excerpt' => __('专业鸡苗运输车，通风保温系统完善 | Professional chick transport vehicle with complete ventilation and insulation system', 'cold-transport'),
            'category' => 'chick-transport',
            'features' => array(
                __('智能通风系统 | Intelligent ventilation system', 'cold-transport'),
                __('温度湿度控制 | Temperature and humidity control', 'cold-transport'),
                __('安全舒适运输 | Safe and comfortable transportation', 'cold-transport')
            ),
            'specs' => array(
                array('name' => '装载量', 'value' => '10000-15000', 'unit' => '只'),
                array('name' => '温度控制', 'value' => '25-30°C', 'unit' => ''),
                array('name' => '通风系统', 'value' => '自动调节', 'unit' => '')
            )
        ),
        
        array(
            'title' => __('医药冷藏车 | Medical Refrigerated Truck', 'cold-transport'),
            'content' => '<!-- wp:paragraph -->
<p>专业医药冷链运输车，符合GSP标准，温度控制精确。</p>
<!-- /wp:paragraph -->',
            'excerpt' => __('医药专用冷藏车，符合GSP标准 | Medical refrigerated truck compliant with GSP standards', 'cold-transport'),
            'category' => 'special-vehicles',
            'features' => array(
                __('GSP认证 | GSP certified', 'cold-transport'),
                __('温度记录系统 | Temperature recording system', 'cold-transport'),
                __('高精度温控 | High-precision temperature control', 'cold-transport')
            ),
            'specs' => array(
                array('name' => '温度精度', 'value' => '±0.5°C', 'unit' => ''),
                array('name' => '符合标准', 'value' => 'GSP', 'unit' => ''),
                array('name' => '数据记录', 'value' => '支持', 'unit' => '')
            ),
            'featured' => true
        )
    );
    
    foreach ($products as $product_data) {
        $post_id = wp_insert_post(array(
            'post_title' => $product_data['title'],
            'post_content' => $product_data['content'],
            'post_excerpt' => $product_data['excerpt'],
            'post_status' => 'publish',
            'post_type' => 'product',
            'post_author' => 1
        ));
        
        if ($post_id && !is_wp_error($post_id)) {
            // 设置产品分类
            if (isset($category_ids[$product_data['category']])) {
                wp_set_object_terms($post_id, $category_ids[$product_data['category']], 'product_category');
            }
            
            // 设置产品特色图片（使用占位图）
            $image_url = 'https://picsum.photos/800/600?random=' . $post_id;
            cold_transport_set_featured_image_from_url($post_id, $image_url);
            
            // 添加产品元数据
            update_post_meta($post_id, '_product_features', $product_data['features']);
            update_post_meta($post_id, '_technical_specs', $product_data['specs']);
            update_post_meta($post_id, '_product_sku', 'CTP' . str_pad($post_id, 4, '0', STR_PAD_LEFT));
            
            if (isset($product_data['featured']) && $product_data['featured']) {
                update_post_meta($post_id, '_featured_product', 'yes');
            }
        }
    }
}

/**
 * 从URL设置特色图片
 */
function cold_transport_set_featured_image_from_url($post_id, $image_url) {
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    
    if ($image_data) {
        $filename = basename($image_url);
        if (wp_mkdir_p($upload_dir['path'])) {
            $file = $upload_dir['path'] . '/' . $filename;
        } else {
            $file = $upload_dir['basedir'] . '/' . $filename;
        }
        
        file_put_contents($file, $image_data);
        
        $wp_filetype = wp_check_filetype($filename, null);
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        
        $attach_id = wp_insert_attachment($attachment, $file, $post_id);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata($attach_id, $file);
        wp_update_attachment_metadata($attach_id, $attach_data);
        
        set_post_thumbnail($post_id, $attach_id);
    }
}

/**
 * 创建导航菜单
 */
function cold_transport_create_menus() {
    // 创建主菜单
    $menu_name = '主菜单 | Main Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        // 添加菜单项
        $pages = array(
            'home' => __('首页 | Home', 'cold-transport'),
            'about' => __('关于我们 | About', 'cold-transport'),
            'products' => __('产品中心 | Products', 'cold-transport'),
            'contact' => __('联系我们 | Contact', 'cold-transport')
        );
        
        foreach ($pages as $key => $title) {
            $page_id = get_option('cold_transport_' . $key . '_page_id');
            if ($page_id) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $title,
                    'menu-item-object-id' => $page_id,
                    'menu-item-object' => 'page',
                    'menu-item-type' => 'post_type',
                    'menu-item-status' => 'publish'
                ));
            }
        }
        
        // 设置菜单位置
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

/**
 * 设置主题选项
 */
function cold_transport_set_theme_options() {
    // 设置首页为静态页面
    $home_page_id = get_option('cold_transport_home_page_id');
    $blog_page_id = get_option('page_for_posts');
    
    if ($home_page_id) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $home_page_id);
    }
    
    // 设置站点标题和描述
    update_option('blogname', __('冷运专业 | Cold Transport Pro', 'cold-transport'));
    update_option('blogdescription', __('专业冷藏车、鸡苗运输车制造商 | Professional Refrigerated Truck and Chick Transport Vehicle Manufacturer', 'cold-transport'));
}

/**
 * 导入演示数据
 */
function cold_transport_import_demo_content() {
    // 检查是否已经导入过
    if (get_option('cold_transport_demo_imported')) {
        return;
    }
    
    // 创建页面
    cold_transport_create_demo_pages();
    
    // 创建产品分类
    $category_ids = cold_transport_create_product_categories();
    
    // 创建产品
    cold_transport_create_demo_products($category_ids);
    
    // 创建菜单
    cold_transport_create_menus();
    
    // 设置主题选项
    cold_transport_set_theme_options();
    
    // 标记为已导入
    update_option('cold_transport_demo_imported', true);
    
    return true;
}

/**
 * 删除演示数据
 */
function cold_transport_remove_demo_content() {
    // 删除页面
    $pages = array('home', 'about', 'products', 'contact');
    foreach ($pages as $page) {
        $page_id = get_option('cold_transport_' . $page . '_page_id');
        if ($page_id) {
            wp_delete_post($page_id, true);
        }
    }
    
    // 删除产品
    $products = get_posts(array(
        'post_type' => 'product',
        'numberposts' => -1,
        'post_status' => 'any'
    ));
    
    foreach ($products as $product) {
        wp_delete_post($product->ID, true);
    }
    
    // 删除产品分类
    $terms = get_terms(array(
        'taxonomy' => 'product_category',
        'hide_empty' => false
    ));
    
    foreach ($terms as $term) {
        wp_delete_term($term->term_id, 'product_category');
    }
    
    // 删除菜单
    $menu = wp_get_nav_menu_object('主菜单 | Main Menu');
    if ($menu) {
        wp_delete_nav_menu($menu->term_id);
    }
    
    // 重置主题选项
    update_option('show_on_front', 'posts');
    delete_option('cold_transport_demo_imported');
}

/**
 * 添加演示数据导入界面
 */
function cold_transport_add_demo_import_page() {
    add_theme_page(
        __('导入演示数据 | Import Demo Content', 'cold-transport'),
        __('演示数据 | Demo Content', 'cold-transport'),
        'manage_options',
        'cold-transport-demo-import',
        'cold_transport_demo_import_page'
    );
}
add_action('admin_menu', 'cold_transport_add_demo_import_page');

/**
 * 演示数据导入页面
 */
function cold_transport_demo_import_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Cold Transport Pro - 演示数据导入 | Demo Content Import', 'cold-transport'); ?></h1>
        
        <?php
        if (isset($_POST['import_demo_content']) && check_admin_referer('cold_transport_import_demo')) {
            if (cold_transport_import_demo_content()) {
                echo '<div class="notice notice-success"><p>' . __('演示数据导入成功！ | Demo content imported successfully!', 'cold-transport') . '</p></div>';
            } else {
                echo '<div class="notice notice-error"><p>' . __('演示数据导入失败！ | Demo content import failed!', 'cold-transport') . '</p></div>';
            }
        }
        
        if (isset($_POST['remove_demo_content']) && check_admin_referer('cold_transport_remove_demo')) {
            cold_transport_remove_demo_content();
            echo '<div class="notice notice-success"><p>' . __('演示数据已删除！ | Demo content removed!', 'cold-transport') . '</p></div>';
        }
        ?>
        
        <div class="card">
            <h2><?php _e('导入演示数据 | Import Demo Content', 'cold-transport'); ?></h2>
            <p><?php _e('点击下面的按钮导入演示数据，包括： | Click the button below to import demo content including:', 'cold-transport'); ?></p>
            <ul>
                <li><?php _e('示例页面（首页、关于我们、产品中心、联系我们） | Sample pages (Home, About, Products, Contact)', 'cold-transport'); ?></li>
                <li><?php _e('产品分类和示例产品 | Product categories and sample products', 'cold-transport'); ?></li>
                <li><?php _e('导航菜单 | Navigation menu', 'cold-transport'); ?></li>
                <li><?php _e('主题设置 | Theme settings', 'cold-transport'); ?></li>
            </ul>
            
            <form method="post">
                <?php wp_nonce_field('cold_transport_import_demo'); ?>
                <p>
                    <input type="submit" name="import_demo_content" class="button button-primary" 
                           value="<?php _e('导入演示数据 | Import Demo Content', 'cold-transport'); ?>">
                </p>
            </form>
        </div>
        
        <div class="card">
            <h2><?php _e('删除演示数据 | Remove Demo Content', 'cold-transport'); ?></h2>
            <p><?php _e('警告：这将删除所有演示数据，包括页面、产品和分类。此操作不可逆！ | Warning: This will remove all demo content including pages, products and categories. This action cannot be undone!', 'cold-transport'); ?></p>
            
            <form method="post" onsubmit="return confirm('<?php _e('确定要删除演示数据吗？此操作不可逆！ | Are you sure you want to remove the demo content? This cannot be undone!', 'cold-transport'); ?>');">
                <?php wp_nonce_field('cold_transport_remove_demo'); ?>
                <p>
                    <input type="submit" name="remove_demo_content" class="button button-secondary" 
                           value="<?php _e('删除演示数据 | Remove Demo Content', 'cold-transport'); ?>">
                </p>
            </form>
        </div>
    </div>
    <?php
}
?>
