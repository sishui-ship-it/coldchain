<?php
/**
 * 产品分类小工具
 * Product Categories Widget
 */

if (!defined('ABSPATH')) {
    exit;
}

class Cold_Transport_Product_Categories_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'cold_transport_product_categories',
            __('产品分类 | Product Categories', 'cold-transport'),
            array(
                'description' => __('显示产品分类列表 | Display product categories list', 'cold-transport'),
                'classname' => 'widget_product_categories'
            )
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('产品分类 | Product Categories', 'cold-transport');
        $show_count = !empty($instance['show_count']) ? true : false;
        $hierarchical = !empty($instance['hierarchical']) ? true : false;
        $dropdown = !empty($instance['dropdown']) ? true : false;
        
        echo $args['before_widget'];
        
        if ($title) {
            echo $args['before_title'] . apply_filters('widget_title', $title) . $args['after_title'];
        }
        
        $cat_args = array(
            'taxonomy' => 'product_category',
            'orderby' => 'name',
            'show_count' => $show_count,
            'hierarchical' => $hierarchical,
            'title_li' => '',
            'hide_empty' => false
        );
        
        if ($dropdown) {
            $cat_args['show_option_none'] = __('选择分类 | Select Category', 'cold-transport');
            wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
            ?>
            <script>
            jQuery(document).ready(function($) {
                $('.widget_product_categories select').change(function() {
                    window.location.href = $(this).val();
                });
            });
            </script>
            <?php
        } else {
            echo '<ul>';
            wp_list_categories(apply_filters('widget_categories_args', $cat_args));
            echo '</ul>';
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : '';
        $show_count = isset($instance['show_count']) ? (bool) $instance['show_count'] : false;
        $hierarchical = isset($instance['hierarchical']) ? (bool) $instance['hierarchical'] : false;
        $dropdown = isset($instance['dropdown']) ? (bool) $instance['dropdown'] : false;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('标题: | Title:', 'cold-transport'); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_count); ?> 
                   id="<?php echo $this->get_field_id('show_count'); ?>" 
                   name="<?php echo $this->get_field_name('show_count'); ?>">
            <label for="<?php echo $this->get_field_id('show_count'); ?>">
                <?php _e('显示产品数量 | Show product counts', 'cold-transport'); ?>
            </label>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($hierarchical); ?> 
                   id="<?php echo $this->get_field_id('hierarchical'); ?>" 
                   name="<?php echo $this->get_field_name('hierarchical'); ?>">
            <label for="<?php echo $this->get_field_id('hierarchical'); ?>">
                <?php _e('显示层级关系 | Show hierarchy', 'cold-transport'); ?>
            </label>
        </p>
        
        <p>
            <input class="checkbox" type="checkbox" <?php checked($dropdown); ?> 
                   id="<?php echo $this->get_field_id('dropdown'); ?>" 
                   name="<?php echo $this->get_field_name('dropdown'); ?>">
            <label for="<?php echo $this->get_field_id('dropdown'); ?>">
                <?php _e('显示为下拉菜单 | Display as dropdown', 'cold-transport'); ?>
            </label>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['show_count'] = !empty($new_instance['show_count']) ? 1 : 0;
        $instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
        $instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;
        
        return $instance;
    }
}

// 注册小工具
function cold_transport_register_widgets() {
    register_widget('Cold_Transport_Product_Categories_Widget');
}
add_action('widgets_init', 'cold_transport_register_widgets');
?>
