<?php
/**
 * 搜索页面模板
 * Search Results Template
 */

get_header(); ?>

<div class="container main-container">
    <div class="search-results-page">
        
        <header class="search-results-header">
            <h1 class="search-results-title">
                <?php
                printf(
                    __('搜索结果: "%s" | Search Results for: "%s"', 'cold-transport'),
                    '<span class="search-query">' . get_search_query() . '</span>'
                );
                ?>
            </h1>
            
            <div class="search-results-count">
                <?php
                global $wp_query;
                printf(
                    _n('找到 %d 个结果 | Found %d result', '找到 %d 个结果 | Found %d results', $wp_query->found_posts, 'cold-transport'),
                    $wp_query->found_posts
                );
                ?>
            </div>
        </header>
        
        <!-- 搜索表单 -->
        <div class="search-form-container">
            <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                <div class="search-field-group">
                    <input type="search" 
                           class="search-field" 
                           placeholder="<?php _e('输入关键词搜索... | Enter keywords to search...', 'cold-transport'); ?>" 
                           value="<?php echo get_search_query(); ?>" 
                           name="s" 
                           required>
                    <button type="submit" class="search-submit">
                        <span class="search-icon">🔍</span>
                        <span class="search-text"><?php _e('搜索 | Search', 'cold-transport'); ?></span>
                    </button>
                </div>
                
                <!-- 搜索筛选 -->
                <div class="search-filters">
                    <label class="filter-label">
                        <input type="radio" name="post_type" value="any" <?php checked(!isset($_GET['post_type']) || $_GET['post_type'] === 'any'); ?>>
                        <?php _e('全部内容 | All Content', 'cold-transport'); ?>
                    </label>
                    
                    <label class="filter-label">
                        <input type="radio" name="post_type" value="product" <?php checked(isset($_GET['post_type']) && $_GET['post_type'] === 'product'); ?>>
                        <?php _e('仅产品 | Products Only', 'cold-transport'); ?>
                    </label>
                    
                    <label class="filter-label">
                        <input type="radio" name="post_type" value="post" <?php checked(isset($_GET['post_type']) && $_GET['post_type'] === 'post'); ?>>
                        <?php _e('仅文章 | Posts Only', 'cold-transport'); ?>
                    </label>
                    
                    <label class="filter-label">
                        <input type="radio" name="post_type" value="page" <?php checked(isset($_GET['post_type']) && $_GET['post_type'] === 'page'); ?>>
                        <?php _e('仅页面 | Pages Only', 'cold-transport'); ?>
                    </label>
                </div>
            </form>
        </div>
        
        <!-- 搜索结果 -->
        <div class="search-results-content">
            <?php if (have_posts()) : ?>
                
                <div class="search-results-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        
                        <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); ?>>
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="result-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('thumbnail'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="result-content">
                                <header class="result-header">
                                    <h2 class="result-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                    
                                    <div class="result-meta">
                                        <span class="result-type">
                                            <?php
                                            $post_type = get_post_type_object(get_post_type());
                                            echo $post_type->labels->singular_name;
                                            ?>
                                        </span>
                                        
                                        <span class="result-date">
                                            <?php echo get_the_date(); ?>
                                        </span>
                                        
                                        <?php if (get_post_type() === 'product') : ?>
                                            <?php
                                            $terms = get_the_terms(get_the_ID(), 'product_category');
                                            if ($terms && !is_wp_error($terms)) :
                                            ?>
                                                <span class="result-category">
                                                    <?php
                                                    $term_names = array();
                                                    foreach ($terms as $term) {
                                                        $term_names[] = $term->name;
                                                    }
                                                    echo implode(', ', $term_names);
                                                    ?>
                                                </span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </header>
                                
                                <div class="result-excerpt">
                                    <?php
                                    // 高亮显示搜索关键词
                                    $excerpt = get_the_excerpt();
                                    $search_query = get_search_query();
                                    $excerpt = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<mark>$1</mark>', $excerpt);
                                    echo $excerpt;
                                    ?>
                                </div>
                                
                                <footer class="result-footer">
                                    <a href="<?php the_permalink(); ?>" class="result-link">
                                        <?php _e('阅读更多 | Read More', 'cold-transport'); ?>
                                        <span class="link-arrow">→</span>
                                    </a>
                                </footer>
                            </div>
                        </article>
                        
                    <?php endwhile; ?>
                </div>
                
                <!-- 搜索分页 -->
                <div class="search-pagination">
                    <?php
                    the_posts_pagination(array(
                        'prev_text' => __('&laquo; 上一页 | Previous', 'cold-transport'),
                        'next_text' => __('下一页 &raquo; | Next', 'cold-transport'),
                        'screen_reader_text' => __('搜索结果分页 | Search Results Pagination', 'cold-transport'),
                    ));
                    ?>
                </div>
                
            <?php else : ?>
                
                <div class="no-search-results">
                    <div class="no-results-content">
                        <h2><?php _e('未找到相关内容 | No Results Found', 'cold-transport'); ?></h2>
                        <p><?php _e('抱歉，没有找到与您的搜索词相关的内容。请尝试： | Sorry, no content was found matching your search terms. Please try:', 'cold-transport'); ?></p>
                        
                        <ul class="suggestions-list">
                            <li><?php _e('使用不同的关键词 | Using different keywords', 'cold-transport'); ?></li>
                            <li><?php _e('检查拼写错误 | Checking for spelling errors', 'cold-transport'); ?></li>
                            <li><?php _e('尝试更通用的术语 | Trying more general terms', 'cold-transport'); ?></li>
                            <li><?php _e('减少搜索词数量 | Reducing the number of search terms', 'cold-transport'); ?></li>
                        </ul>
                        
                        <div class="no-results-actions">
                            <a href="<?php echo home_url('/'); ?>" class="btn btn-primary">
                                <?php _e('返回首页 | Return to Home', 'cold-transport'); ?>
                            </a>
                            <a href="<?php echo get_post_type_archive_link('product'); ?>" class="btn btn-secondary">
                                <?php _e('浏览产品 | Browse Products', 'cold-transport'); ?>
                            </a>
                        </div>
                    </div>
                </div>
                
            <?php endif; ?>
        </div>
        
    </div>
</div>

<?php get_footer(); ?>
