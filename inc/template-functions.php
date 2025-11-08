<?php
/**
 * Cold Transport Pro - 模板函数
 * Template Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 获取相关产品
 */
function cold_transport_get_related_products($post_id, $limit = 4) {
    $terms = get_the_terms($post_id, 'product_category');
    
    if (!$terms || is_wp_error($terms)) {
        return false;
    }
    
    $term_ids = wp_list_pluck($terms, 'term_id');
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $limit,
        'post__not_in' => array($post_id),
        'tax_query' => array(
            array(
                'taxonomy' => 'product_category',
                'field' => 'term_id',
                'terms' => $term_ids,
            )
        ),
        'orderby' => 'rand'
    );
    
    return new WP_Query($args);
}

/**
 * 获取产品特色图片
 */
function cold_transport_get_product_featured_image($post_id, $size = 'large') {
    if (has_post_thumbnail($post_id)) {
        return get_the_post_thumbnail($post_id, $size);
    }
    
    // 默认图片
    return '<img src="' . get_template_directory_uri() . '/assets/images/product-placeholder.jpg" alt="' . get_the_title($post_id) . '">';
}

/**
 * 获取产品技术参数
 */
function cold_transport_get_product_specifications($post_id) {
    $specs = get_post_meta($post_id, '_technical_specs', true);
    
    if (!$specs || !is_array($specs)) {
        return false;
    }
    
    return $specs;
}

/**
 * 获取产品应用场景
 */
function cold_transport_get_application_scenarios($post_id) {
    $scenarios = get_post_meta($post_id, '_application_scenarios', true);
    
    if (!$scenarios) {
        return false;
    }
    
    return wpautop($scenarios);
}

/**
 * 显示产品分类面包屑
 */
function cold_transport_product_breadcrumbs($post_id) {
    $terms = get_the_terms($post_id, 'product_category');
    
    if (!$terms || is_wp_error($terms)) {
        return;
    }
    
    $breadcrumbs = array();
    $breadcrumbs[] = '<a href="' . home_url() . '">' . __('首页 | Home', 'cold-transport') . '</a>';
    $breadcrumbs[] = '<a href="' . get_post_type_archive_link('product') . '">' . __('产品中心 | Products', 'cold-transport') . '</a>';
    
    foreach ($terms as $term) {
        $breadcrumbs[] = '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
    }
    
    $breadcrumbs[] = '<span class="current">' . get_the_title($post_id) . '</span>';
    
    echo '<nav class="breadcrumb"><div class="breadcrumb-inner">' . implode(' <span class="breadcrumb-separator">›</span> ', $breadcrumbs) . '</div></nav>';
}

/**
 * 产品视图计数
 */
function cold_transport_track_product_views($post_id) {
    if (!is_singular('product')) {
        return;
    }
    
    $count_key = '_view_count';
    $count = get_post_meta($post_id, $count_key, true);
    
    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}
add_action('wp_head', 'cold_transport_track_product_views');

/**
 * 获取热门产品
 */
function cold_transport_get_popular_products($limit = 5) {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $limit,
        'meta_key' => '_view_count',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_query' => array(
            array(
                'key' => '_view_count',
                'value' => '0',
                'compare' => '>',
                'type' => 'NUMERIC'
            )
        )
    );
    
    return new WP_Query($args);
}

/**
 * 产品搜索表单
 */
function cold_transport_product_search_form() {
    ?>
    <form role="search" method="get" class="product-search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="hidden" name="post_type" value="product">
        <div class="search-field-group">
            <input type="search" class="search-field" placeholder="<?php _e('搜索产品... | Search products...', 'cold-transport'); ?>" value="<?php echo get_search_query(); ?>" name="s" required>
            <button type="submit" class="search-submit">
                <span class="search-icon">🔍</span>
                <span class="search-text"><?php _e('搜索 | Search', 'cold-transport'); ?></span>
            </button>
        </div>
        
        <div class="search-filters">
            <label class="filter-label">
                <input type="checkbox" name="featured" value="1" <?php checked(isset($_GET['featured']) && $_GET['featured'] == '1'); ?>>
                <?php _e('仅显示特色产品 | Featured Only', 'cold-transport'); ?>
            </label>
            
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'product_category',
                'hide_empty' => true,
            ));
            
            if ($categories && !is_wp_error($categories)) :
            ?>
                <select name="product_category">
                    <option value=""><?php _e('所有分类 | All Categories', 'cold-transport'); ?></option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category->slug; ?>" <?php selected(isset($_GET['product_category']) && $_GET['product_category'] == $category->slug); ?>>
                            <?php echo $category->name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
        </div>
    </form>
    <?php
}

/**
 * 显示产品分类网格
 */
function cold_transport_display_product_categories($args = array()) {
    $defaults = array(
        'parent' => 0,
        'number' => 6,
        'orderby' => 'name',
        'order' => 'ASC'
    );
    
    $args = wp_parse_args($args, $defaults);
    
    $categories = get_terms(array(
        'taxonomy' => 'product_category',
        'hide_empty' => true,
        'parent' => $args['parent'],
        'number' => $args['number'],
        'orderby' => $args['orderby'],
        'order' => $args['order']
    ));
    
    if (!$categories || is_wp_error($categories)) {
        return;
    }
    
    echo '<div class="product-categories-grid">';
    
    foreach ($categories as $category) {
        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
        $image = $thumbnail_id ? wp_get_attachment_image($thumbnail_id, 'medium') : '';
        $link = get_term_link($category);
        
        echo '<div class="product-category-card">';
        echo '<a href="' . esc_url($link) . '" class="category-link">';
        
        if ($image) {
            echo '<div class="category-image">' . $image . '</div>';
        }
        
        echo '<div class="category-content">';
        echo '<h3 class="category-title">' . $category->name . '</h3>';
        
        if ($category->description) {
            echo '<p class="category-description">' . wp_trim_words($category->description, 15) . '</p>';
        }
        
        echo '<span class="category-count">' . sprintf(_n('%d 产品 | %d product', '%d 产品 | %d products', $category->count, 'cold-transport'), $category->count) . '</span>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
    }
    
    echo '</div>';
}

/**
 * 产品比较功能
 */
function cold_transport_product_comparison_table($product_ids) {
    if (empty($product_ids) || count($product_ids) < 2) {
        return;
    }
    
    $products = get_posts(array(
        'post_type' => 'product',
        'post__in' => $product_ids,
        'posts_per_page' => -1
    ));
    
    if (empty($products)) {
        return;
    }
    
    echo '<div class="product-comparison-table">';
    echo '<table class="comparison-table">';
    echo '<thead><tr><th>' . __('参数 | Parameter', 'cold-transport') . '</th>';
    
    foreach ($products as $product) {
        echo '<th><a href="' . get_permalink($product->ID) . '">' . get_the_title($product->ID) . '</a></th>';
    }
    echo '</tr></thead>';
    
    echo '<tbody>';
    
    // 技术参数比较
    $specs_to_compare = array('capacity', 'temperature_range', 'power', 'dimensions');
    
    foreach ($specs_to_compare as $spec) {
        echo '<tr>';
        echo '<td class="spec-name">' . cold_transport_get_spec_label($spec) . '</td>';
        
        foreach ($products as $product) {
            $value = get_post_meta($product->ID, '_spec_' . $spec, true);
            echo '<td>' . ($value ? $value : '-') . '</td>';
        }
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

/**
 * 获取技术参数标签
 */
function cold_transport_get_spec_label($spec_key) {
    $labels = array(
        'capacity' => __('容量 | Capacity', 'cold-transport'),
        'temperature_range' => __('温度范围 | Temperature Range', 'cold-transport'),
        'power' => __('功率 | Power', 'cold-transport'),
        'dimensions' => __('尺寸 | Dimensions', 'cold-transport'),
        'weight' => __('重量 | Weight', 'cold-transport'),
        'material' => __('材质 | Material', 'cold-transport')
    );
    
    return isset($labels[$spec_key]) ? $labels[$spec_key] : $spec_key;
}

/**
 * 多语言切换器
 */
function cold_transport_language_switcher() {
    if (function_exists('pll_the_languages')) {
        // Polylang 支持
        pll_the_languages(array('show_flags' => 1, 'show_names' => 1));
    } elseif (function_exists('icl_get_languages')) {
        // WPML 支持
        $languages = icl_get_languages('skip_missing=0');
        if (!empty($languages)) {
            echo '<div class="language-switcher">';
            foreach ($languages as $language) {
                $class = $language['active'] ? 'active' : '';
                echo '<a href="' . $language['url'] . '" class="' . $class . '">';
                echo $language['native_name'];
                echo '</a>';
            }
            echo '</div>';
        }
    } else {
        // 简单语言切换
        echo '<div class="language-switcher">';
        echo '<a href="?lang=zh" class="lang-option">中文</a>';
        echo '<a href="?lang=en" class="lang-option">English</a>';
        echo '</div>';
    }
}
?>
