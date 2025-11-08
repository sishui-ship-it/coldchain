<?php
/**
 * Cold Transport Pro - 产品自定义字段
 * Product Custom Fields
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * 注册产品自定义字段
 */
function cold_transport_register_product_meta_boxes() {
    add_meta_box(
        'cold_transport_product_details',
        __('产品详细信息 | Product Details', 'cold-transport'),
        'cold_transport_product_details_callback',
        'product',
        'normal',
        'high'
    );
    
    add_meta_box(
        'cold_transport_technical_specs',
        __('技术参数 | Technical Specifications', 'cold-transport'),
        'cold_transport_technical_specs_callback',
        'product',
        'normal',
        'high'
    );
    
    add_meta_box(
        'cold_transport_product_features',
        __('产品特色 | Product Features', 'cold-transport'),
        'cold_transport_product_features_callback',
        'product',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'cold_transport_register_product_meta_boxes');

/**
 * 产品详细信息回调函数
 */
function cold_transport_product_details_callback($post) {
    wp_nonce_field('cold_transport_save_product_data', 'cold_transport_meta_nonce');
    
    $product_sku = get_post_meta($post->ID, '_product_sku', true);
    $product_price = get_post_meta($post->ID, '_product_price', true);
    $product_currency = get_post_meta($post->ID, '_product_currency', true);
    $product_weight = get_post_meta($post->ID, '_product_weight', true);
    $product_dimensions = get_post_meta($post->ID, '_product_dimensions', true);
    $is_featured = get_post_meta($post->ID, '_featured_product', true);
    $product_status = get_post_meta($post->ID, '_product_status', true);
    
    ?>
    <div class="cold-transport-meta-fields">
        <div class="meta-field">
            <label for="product_sku"><?php _e('产品编号 | SKU:', 'cold-transport'); ?></label>
            <input type="text" id="product_sku" name="product_sku" value="<?php echo esc_attr($product_sku); ?>" class="widefat">
            <p class="description"><?php _e('产品的唯一标识符 | Unique identifier for the product', 'cold-transport'); ?></p>
        </div>
        
        <div class="meta-field">
            <label for="product_price"><?php _e('参考价格 | Reference Price:', 'cold-transport'); ?></label>
            <input type="text" id="product_price" name="product_price" value="<?php echo esc_attr($product_price); ?>" class="widefat">
        </div>
        
        <div class="meta-field">
            <label for="product_currency"><?php _e('货币单位 | Currency:', 'cold-transport'); ?></label>
            <select id="product_currency" name="product_currency" class="widefat">
                <option value="CNY" <?php selected($product_currency, 'CNY'); ?>>CNY (人民币)</option>
                <option value="USD" <?php selected($product_currency, 'USD'); ?>>USD (美元)</option>
                <option value="EUR" <?php selected($product_currency, 'EUR'); ?>>EUR (欧元)</option>
            </select>
        </div>
        
        <div class="meta-field">
            <label for="product_weight"><?php _e('重量 | Weight:', 'cold-transport'); ?></label>
            <input type="text" id="product_weight" name="product_weight" value="<?php echo esc_attr($product_weight); ?>" class="widefat">
            <p class="description"><?php _e('例如: 2.5吨 | Example: 2.5 tons', 'cold-transport'); ?></p>
        </div>
        
        <div class="meta-field">
            <label for="product_dimensions"><?php _e('尺寸 | Dimensions:', 'cold-transport'); ?></label>
            <input type="text" id="product_dimensions" name="product_dimensions" value="<?php echo esc_attr($product_dimensions); ?>" class="widefat">
            <p class="description"><?php _e('例如: 长×宽×高 | Example: L×W×H', 'cold-transport'); ?></p>
        </div>
        
        <div class="meta-field">
            <label>
                <input type="checkbox" name="featured_product" value="yes" <?php checked($is_featured, 'yes'); ?>>
                <?php _e('设为特色产品 | Mark as Featured Product', 'cold-transport'); ?>
            </label>
        </div>
        
        <div class="meta-field">
            <label for="product_status"><?php _e('产品状态 | Product Status:', 'cold-transport'); ?></label>
            <select id="product_status" name="product_status" class="widefat">
                <option value="available" <?php selected($product_status, 'available'); ?>><?php _e('现货供应 | Available', 'cold-transport'); ?></option>
                <option value="custom" <?php selected($product_status, 'custom'); ?>><?php _e('支持定制 | Custom Order', 'cold-transport'); ?></option>
                <option value="coming" <?php selected($product_status, 'coming'); ?>><?php _e('即将上市 | Coming Soon', 'cold-transport'); ?></option>
            </select>
        </div>
    </div>
    <?php
}

/**
 * 技术参数回调函数
 */
function cold_transport_technical_specs_callback($post) {
    $specs = get_post_meta($post->ID, '_technical_specs', true);
    $specs = is_array($specs) ? $specs : array();
    
    ?>
    <div class="cold-transport-specs-fields">
        <div id="specs-container">
            <?php if (!empty($specs)) : ?>
                <?php foreach ($specs as $index => $spec) : ?>
                    <div class="spec-field-group">
                        <div class="spec-field">
                            <label><?php _e('参数名称 | Parameter Name:', 'cold-transport'); ?></label>
                            <input type="text" name="spec_name[]" value="<?php echo esc_attr($spec['name']); ?>" class="widefat" placeholder="<?php _e('例如: 载重量 | Example: Load Capacity', 'cold-transport'); ?>">
                        </div>
                        <div class="spec-field">
                            <label><?php _e('参数值 | Value:', 'cold-transport'); ?></label>
                            <input type="text" name="spec_value[]" value="<?php echo esc_attr($spec['value']); ?>" class="widefat" placeholder="<?php _e('例如: 5吨 | Example: 5 tons', 'cold-transport'); ?>">
                        </div>
                        <div class="spec-field">
                            <label><?php _e('单位 | Unit:', 'cold-transport'); ?></label>
                            <input type="text" name="spec_unit[]" value="<?php echo esc_attr($spec['unit']); ?>" class="widefat" placeholder="<?php _e('例如: 吨 | Example: tons', 'cold-transport'); ?>">
                        </div>
                        <button type="button" class="button remove-spec"><?php _e('删除 | Remove', 'cold-transport'); ?></button>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="spec-field-group">
                    <div class="spec-field">
                        <label><?php _e('参数名称 | Parameter Name:', 'cold-transport'); ?></label>
                        <input type="text" name="spec_name[]" class="widefat" placeholder="<?php _e('例如: 载重量 | Example: Load Capacity', 'cold-transport'); ?>">
                    </div>
                    <div class="spec-field">
                        <label><?php _e('参数值 | Value:', 'cold-transport'); ?></label>
                        <input type="text" name="spec_value[]" class="widefat" placeholder="<?php _e('例如: 5吨 | Example: 5 tons', 'cold-transport'); ?>">
                    </div>
                    <div class="spec-field">
                        <label><?php _e('单位 | Unit:', 'cold-transport'); ?></label>
                        <input type="text" name="spec_unit[]" class="widefat" placeholder="<?php _e('例如: 吨 | Example: tons', 'cold-transport'); ?>">
                    </div>
                    <button type="button" class="button remove-spec"><?php _e('删除 | Remove', 'cold-transport'); ?></button>
                </div>
            <?php endif; ?>
        </div>
        
        <button type="button" id="add-spec" class="button button-primary"><?php _e('添加参数 | Add Parameter', 'cold-transport'); ?></button>
        
        <script type="text/html" id="spec-template">
            <div class="spec-field-group">
                <div class="spec-field">
                    <label><?php _e('参数名称 | Parameter Name:', 'cold-transport'); ?></label>
                    <input type="text" name="spec_name[]" class="widefat" placeholder="<?php _e('例如: 载重量 | Example: Load Capacity', 'cold-transport'); ?>">
                </div>
                <div class="spec-field">
                    <label><?php _e('参数值 | Value:', 'cold-transport'); ?></label>
                    <input type="text" name="spec_value[]" class="widefat" placeholder="<?php _e('例如: 5吨 | Example: 5 tons', 'cold-transport'); ?>">
                </div>
                <div class="spec-field">
                    <label><?php _e('单位 | Unit:', 'cold-transport'); ?></label>
                    <input type="text" name="spec_unit[]" class="widefat" placeholder="<?php _e('例如: 吨 | Example: tons', 'cold-transport'); ?>">
                </div>
                <button type="button" class="button remove-spec"><?php _e('删除 | Remove', 'cold-transport'); ?></button>
            </div>
        </script>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('#add-spec').on('click', function() {
            var template = $('#spec-template').html();
            $('#specs-container').append(template);
        });
        
        $(document).on('click', '.remove-spec', function() {
            $(this).closest('.spec-field-group').remove();
        });
    });
    </script>
    
    <style>
    .spec-field-group {
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        background: #f9f9f9;
    }
    .spec-field {
        margin-bottom: 10px;
    }
    .spec-field label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    </style>
    <?php
}

/**
 * 产品特色回调函数
 */
function cold_transport_product_features_callback($post) {
    $features = get_post_meta($post->ID, '_product_features', true);
    $features = is_array($features) ? $features : array();
    
    ?>
    <div class="cold-transport-features-fields">
        <p><?php _e('输入产品的主要特色，每行一个特色 | Enter product features, one per line', 'cold-transport'); ?></p>
        <textarea name="product_features" rows="10" class="widefat" placeholder="<?php _e('例如: 节能环保设计 | Example: Energy-saving and eco-friendly design', 'cold-transport'); ?>"><?php echo implode("\n", $features); ?></textarea>
        <p class="description"><?php _e('每行输入一个特色功能 | Enter one feature per line', 'cold-transport'); ?></p>
    </div>
    <?php
}

/**
 * 保存自定义字段数据
 */
function cold_transport_save_product_data($post_id) {
    if (!isset($_POST['cold_transport_meta_nonce']) || !wp_verify_nonce($_POST['cold_transport_meta_nonce'], 'cold_transport_save_product_data')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // 保存产品基本信息
    $fields = array(
        'product_sku' => '_product_sku',
        'product_price' => '_product_price',
        'product_currency' => '_product_currency',
        'product_weight' => '_product_weight',
        'product_dimensions' => '_product_dimensions',
        'product_status' => '_product_status'
    );
    
    foreach ($fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$field]));
        }
    }
    
    // 保存特色产品标记
    $featured = isset($_POST['featured_product']) ? 'yes' : 'no';
    update_post_meta($post_id, '_featured_product', $featured);
    
    // 保存技术参数
    $specs = array();
    if (isset($_POST['spec_name']) && is_array($_POST['spec_name'])) {
        for ($i = 0; $i < count($_POST['spec_name']); $i++) {
            if (!empty($_POST['spec_name'][$i])) {
                $specs[] = array(
                    'name' => sanitize_text_field($_POST['spec_name'][$i]),
                    'value' => sanitize_text_field($_POST['spec_value'][$i]),
                    'unit' => sanitize_text_field($_POST['spec_unit'][$i])
                );
            }
        }
    }
    update_post_meta($post_id, '_technical_specs', $specs);
    
    // 保存产品特色
    if (isset($_POST['product_features'])) {
        $features = explode("\n", sanitize_textarea_field($_POST['product_features']));
        $features = array_map('trim', $features);
        $features = array_filter($features);
        update_post_meta($post_id, '_product_features', $features);
    }
}
add_action('save_post_product', 'cold_transport_save_product_data');

/**
 * 在管理列表中添加自定义列
 */
function cold_transport_product_columns($columns) {
    $new_columns = array();
    
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        
        if ($key === 'title') {
            $new_columns['product_sku'] = __('产品编号 | SKU', 'cold-transport');
            $new_columns['product_price'] = __('参考价格 | Price', 'cold-transport');
            $new_columns['featured'] = __('特色 | Featured', 'cold-transport');
        }
    }
    
    return $new_columns;
}
add_filter('manage_product_posts_columns', 'cold_transport_product_columns');

/**
 * 显示自定义列内容
 */
function cold_transport_product_custom_column($column, $post_id) {
    switch ($column) {
        case 'product_sku':
            $sku = get_post_meta($post_id, '_product_sku', true);
            echo $sku ? $sku : '-';
            break;
            
        case 'product_price':
            $price = get_post_meta($post_id, '_product_price', true);
            $currency = get_post_meta($post_id, '_product_currency', true);
            if ($price) {
                echo $price . ' ' . $currency;
            } else {
                echo '-';
            }
            break;
            
        case 'featured':
            $featured = get_post_meta($post_id, '_featured_product', true);
            echo $featured === 'yes' ? '⭐' : '-';
            break;
    }
}
add_action('manage_product_posts_custom_column', 'cold_transport_product_custom_column', 10, 2);

/**
 * 使自定义列可排序
 */
function cold_transport_product_sortable_columns($columns) {
    $columns['product_sku'] = 'product_sku';
    $columns['product_price'] = 'product_price';
    $columns['featured'] = 'featured';
    return $columns;
}
add_filter('manage_edit-product_sortable_columns', 'cold_transport_product_sortable_columns');

/**
 * 自定义列排序逻辑
 */
function cold_transport_product_column_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    $orderby = $query->get('orderby');
    
    switch ($orderby) {
        case 'product_sku':
            $query->set('meta_key', '_product_sku');
            $query->set('orderby', 'meta_value');
            break;
            
        case 'product_price':
            $query->set('meta_key', '_product_price');
            $query->set('orderby', 'meta_value_num');
            break;
            
        case 'featured':
            $query->set('meta_key', '_featured_product');
            $query->set('orderby', 'meta_value');
            break;
    }
}
add_action('pre_get_posts', 'cold_transport_product_column_orderby');
?>
