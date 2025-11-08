<?php
/**
 * 404错误页面模板
 * 404 Not Found Template
 */

get_header(); ?>

<div class="container main-container">
    <div class="error-404-page">
        
        <div class="error-content">
            <div class="error-code">
                <span class="error-number">404</span>
                <span class="error-text"><?php _e('页面未找到 | Page Not Found', 'cold-transport'); ?></span>
            </div>
            
            <div class="error-message">
                <h1><?php _e('抱歉，您要查找的页面不存在。 | Sorry, the page you are looking for does not exist.', 'cold-transport'); ?></h1>
                <p><?php _e('可能是URL地址输入错误，或者页面已被移动或删除。 | The page may have been moved, deleted, or you may have entered the wrong URL.', 'cold-transport'); ?></p>
            </div>
            
            <div class="error-actions">
                <a href="<?php echo home_url('/'); ?>" class="btn btn-primary btn-large">
                    <?php _e('返回首页 | Return to Homepage', 'cold-transport'); ?>
                </a>
                
                <a href="javascript:history.back()" class="btn btn-secondary btn-large">
                    <?php _e('返回上页 | Go Back', 'cold-transport'); ?>
                </a>
                
                <a href="<?php echo get_post_type_archive_link('product'); ?>" class="btn btn-outline btn-large">
                    <?php _e('浏览产品 | Browse Products', 'cold-transport'); ?>
                </a>
            </div>
            
            <!-- 搜索框 -->
            <div class="error-search">
                <p><?php _e('或者尝试搜索您要找的内容： | Or try searching for what you were looking for:', 'cold-transport'); ?></p>
                <?php get_search_form(); ?>
            </div>
            
            <!-- 热门内容推荐 -->
            <div class="error-suggestions">
                <h3><?php _e('您可能感兴趣的内容： | You might be interested in:', 'cold-transport'); ?></h3>
                
                <div class="suggestions-grid">
                    <?php
                    // 推荐热门产品
                    $popular_products = new WP_Query(array(
                        'post_type' => 'product',
                        'posts_per_page' => 3,
                        'meta_key' => '_view_count',
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC'
                    ));
                    
                    if ($popular_products->have_posts()) :
                    ?>
                        <div class="suggestion-section">
                            <h4><?php _e('热门产品 | Popular Products', 'cold-transport'); ?></h4>
                            <ul class="suggestion-list">
                                <?php while ($popular_products->have_posts()) : $popular_products->the_post(); ?>
                                    <li>
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    <?php endif;
                    wp_reset_postdata();
                    ?>
                    
                    <?php
                    // 推荐产品分类
                    $product_categories = get_terms(array(
                        'taxonomy' => 'product_category',
                        'hide_empty' => true,
                        'number' => 3
                    ));
                    
                    if ($product_categories && !is_wp_error($product_categories)) :
                    ?>
                        <div class="suggestion-section">
                            <h4><?php _e('产品分类 | Product Categories', 'cold-transport'); ?></h4>
                            <ul class="suggestion-list">
                                <?php foreach ($product_categories as $category) : ?>
                                    <li>
                                        <a href="<?php echo get_term_link($category); ?>"><?php echo $category->name; ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <div class="suggestion-section">
                        <h4><?php _e('快速链接 | Quick Links', 'cold-transport'); ?></h4>
                        <ul class="suggestion-list">
                            <li><a href="<?php echo home_url('/about'); ?>"><?php _e('关于我们 | About Us', 'cold-transport'); ?></a></li>
                            <li><a href="<?php echo home_url('/contact'); ?>"><?php _e('联系我们 | Contact', 'cold-transport'); ?></a></li>
                            <li><a href="<?php echo home_url('/news'); ?>"><?php _e('新闻资讯 | News', 'cold-transport'); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</div>

<?php get_footer(); ?>
