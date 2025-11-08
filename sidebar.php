<?php
/**
 * 侧边栏模板
 * Sidebar Template
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
    
    <!-- 搜索小工具 -->
    <section class="widget widget_search">
        <h3 class="widget-title"><?php _e('搜索产品 | Search Products', 'cold-transport'); ?></h3>
        <?php get_search_form(); ?>
    </section>
    
    <!-- 产品分类小工具 -->
    <section class="widget widget_categories">
        <h3 class="widget-title"><?php _e('产品分类 | Product Categories', 'cold-transport'); ?></h3>
        <ul>
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'product_category',
                'hide_empty' => true,
                'orderby' => 'count',
                'order' => 'DESC'
            ));
            
            foreach ($categories as $category) {
                echo '<li><a href="' . get_term_link($category) . '">' . $category->name . ' <span class="count">(' . $category->count . ')</span></a></li>';
            }
            ?>
        </ul>
    </section>
    
    <!-- 热门产品小工具 -->
    <section class="widget widget_popular_products">
        <h3 class="widget-title"><?php _e('热门产品 | Popular Products', 'cold-transport'); ?></h3>
        <ul>
            <?php
            $popular_products = new WP_Query(array(
                'post_type' => 'product',
                'posts_per_page' => 5,
                'meta_key' => '_view_count',
                'orderby' => 'meta_value_num',
                'order' => 'DESC'
            ));
            
            while ($popular_products->have_posts()) {
                $popular_products->the_post();
                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
            wp_reset_postdata();
            ?>
        </ul>
    </section>
    
    <!-- 联系我们小工具 -->
    <section class="widget widget_contact">
        <h3 class="widget-title"><?php _e('联系我们 | Contact Us', 'cold-transport'); ?></h3>
        <div class="contact-info">
            <p><strong><?php _e('电话: | Phone:', 'cold-transport'); ?></strong> +86 000-0000-0000</p>
            <p><strong><?php _e('邮箱: | Email:', 'cold-transport'); ?></strong> info@example.com</p>
            <p><strong><?php _e('地址: | Address:', 'cold-transport'); ?></strong> <?php _e('中国山东省济宁市泗水县 | Sishui County, Jining City, Shandong Province, China', 'cold-transport'); ?></p>
        </div>
        <a href="<?php echo home_url('/contact'); ?>" class="btn btn-primary btn-small">
            <?php _e('立即联系 | Contact Now', 'cold-transport'); ?>
        </a>
    </section>
    
    <?php dynamic_sidebar('sidebar-1'); ?>
    
</aside>
