<?php
/**
 * 产品归档页模板
 * Product Archive Template
 */

get_header(); ?>

<div class="container main-container">
    <div class="products-archive-page">
        
        <!-- 归档页头部 -->
        <header class="archive-header">
            <h1 class="archive-title">
                <?php
                if (is_tax('product_category')) {
                    single_term_title();
                } elseif (is_post_type_archive('product')) {
                    _e('产品中心 | Products Center', 'cold-transport');
                } else {
                    the_archive_title();
                }
                ?>
            </h1>
            
            <?php
            $description = term_description();
            if ($description) :
            ?>
                <div class="archive-description">
                    <?php echo $description; ?>
                </div>
            <?php endif; ?>
        </header>
        
        <!-- 产品分类筛选 -->
        <div class="product-filters">
            <div class="filter-section">
                <h3 class="filter-title"><?php _e('产品分类 | Product Categories', 'cold-transport'); ?></h3>
                
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'product_category',
                    'hide_empty' => true,
                ));
                
                if ($categories && !is_wp_error($categories)) :
                ?>
                    <ul class="category-filter">
                        <li class="category-item <?php echo !is_tax('product_category') ? 'active' : ''; ?>">
                            <a href="<?php echo get_post_type_archive_link('product'); ?>">
                                <?php _e('全部产品 | All Products', 'cold-transport'); ?>
                            </a>
                        </li>
                        
                        <?php foreach ($categories as $category) : ?>
                            <li class="category-item <?php echo is_tax('product_category', $category->slug) ? 'active' : ''; ?>">
                                <a href="<?php echo get_term_link($category); ?>">
                                    <?php echo $category->name; ?>
                                    <span class="product-count">(<?php echo $category->count; ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            
            <!-- 搜索筛选 -->
            <div class="filter-section">
                <div class="search-filter">
                    <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="hidden" name="post_type" value="product">
                        <input type="search" name="s" placeholder="<?php _e('搜索产品... | Search products...', 'cold-transport'); ?>" 
                               value="<?php echo get_search_query(); ?>">
                        <button type="submit"><?php _e('搜索 | Search', 'cold-transport'); ?></button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- 产品网格 -->
        <div class="products-archive-content">
            <?php if (have_posts()) : ?>
                
                <div class="products-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        
                        <article id="product-<?php the_ID(); ?>" <?php post_class('product-card'); ?>>
                            
                            <!-- 产品图片 -->
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="product-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('product-thumb', array(
                                            'alt' => get_the_title(),
                                            'loading' => 'lazy'
                                        )); ?>
                                    </a>
                                    
                                    <!-- 特色产品标记 -->
                                    <?php if (get_post_meta(get_the_ID(), '_featured_product', true) === 'yes') : ?>
                                        <span class="featured-badge">
                                            <?php _e('推荐 | Featured', 'cold-transport'); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="product-content">
                                <header class="product-header">
                                    <h2 class="product-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    
                                    <div class="product-meta">
                                        <?php
                                        $terms = get_the_terms(get_the_ID(), 'product_category');
                                        if ($terms && !is_wp_error($terms)) :
                                        ?>
                                            <span class="product-category">
                                                <?php
                                                $term_names = array();
                                                foreach ($terms as $term) {
                                                    $term_names[] = $term->name;
                                                }
                                                echo implode(', ', $term_names);
                                                ?>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <span class="product-date">
                                            <?php echo get_the_date(); ?>
                                        </span>
                                    </div>
                                </header>
                                
                                <div class="product-excerpt">
                                    <?php
                                    if (has_excerpt()) {
                                        the_excerpt();
                                    } else {
                                        echo wp_trim_words(get_the_content(), 30, '...');
                                    }
                                    ?>
                                </div>
                                
                                <!-- 产品特性标签 -->
                                <?php
                                $features = get_post_meta(get_the_ID(), '_product_features', true);
                                if ($features && is_array($features)) :
                                ?>
                                    <div class="product-tags">
                                        <?php
                                        $display_features = array_slice($features, 0, 3);
                                        foreach ($display_features as $feature) :
                                        ?>
                                            <span class="product-tag"><?php echo esc_html($feature); ?></span>
                                        <?php endforeach; ?>
                                        
                                        <?php if (count($features) > 3) : ?>
                                            <span class="product-tag more-tag">+<?php echo count($features) - 3; ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <footer class="product-footer">
                                    <a href="<?php the_permalink(); ?>" class="product-link">
                                        <?php _e('查看详情 | View Details', 'cold-transport'); ?>
                                        <span class="link-arrow">→</span>
                                    </a>
                                    
                                    <!-- 快速操作 -->
                                    <div class="quick-actions">
                                        <button class="quick-action-btn" data-action="inquire" data-product="<?php the_ID(); ?>">
                                            <?php _e('询价 | Inquire', 'cold-transport'); ?>
                                        </button>
                                        <button class="quick-action-btn" data-action="compare" data-product="<?php the_ID(); ?>">
                                            <?php _e('对比 | Compare', 'cold-transport'); ?>
                                        </button>
                                    </div>
                                </footer>
                            </div>
                        </article>
                        
                    <?php endwhile; ?>
                </div>
                
                <!-- 分页 -->
                <div class="products-pagination">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => __('&laquo; 上一页 | Previous', 'cold-transport'),
                        'next_text' => __('下一页 &raquo; | Next', 'cold-transport'),
                        'screen_reader_text' => __('产品分页导航 | Products Pagination', 'cold-transport'),
                    ));
                    ?>
                </div>
                
            <?php else : ?>
                
                <div class="no-products-found">
                    <div class="no-products-content">
                        <h2><?php _e('未找到产品 | No Products Found', 'cold-transport'); ?></h2>
                        <p><?php _e('抱歉，没有找到符合条件的产品。请尝试其他搜索条件或浏览所有产品。 | Sorry, no products were found matching your criteria. Please try different search terms or browse all products.', 'cold-transport'); ?></p>
                        
                        <div class="no-products-actions">
                            <a href="<?php echo get_post_type_archive_link('product'); ?>" class="btn btn-primary">
                                <?php _e('浏览所有产品 | Browse All Products', 'cold-transport'); ?>
                            </a>
                            <a href="<?php echo home_url('/contact'); ?>" class="btn btn-secondary">
                                <?php _e('联系我们 | Contact Us', 'cold-transport'); ?>
                            </a>
                        </div>
                    </div>
                </div>
                
            <?php endif; ?>
        </div>
        
    </div>
</div>

<?php get_footer(); ?>
