<?php
/**
 * The main template file
 * 主模板文件
 *
 * @package Cold_Transport_Pro
 */

get_header(); ?>

<div class="container main-container">
    <div class="content-area">
        <?php if (have_posts()) : ?>
            
            <header class="page-header">
                <?php if (is_home() && !is_front_page()) : ?>
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                <?php elseif (is_search()) : ?>
                    <h1 class="page-title">
                        <?php 
                        printf(
                            __('搜索结果: %s | Search Results: %s', 'cold-transport'),
                            '<span>' . get_search_query() . '</span>'
                        );
                        ?>
                    </h1>
                <?php elseif (is_archive()) : ?>
                    <h1 class="page-title">
                        <?php
                        if (is_category()) {
                            single_cat_title();
                        } elseif (is_tag()) {
                            single_tag_title();
                        } elseif (is_author()) {
                            printf(__('作者: %s | Author: %s', 'cold-transport'), '<span class="vcard">' . get_the_author() . '</span>');
                        } elseif (is_day()) {
                            printf(__('每日归档: %s | Daily Archives: %s', 'cold-transport'), '<span>' . get_the_date() . '</span>');
                        } elseif (is_month()) {
                            printf(__('月度归档: %s | Monthly Archives: %s', 'cold-transport'), '<span>' . get_the_date(_x('F Y', 'monthly archives date format', 'cold-transport')) . '</span>');
                        } elseif (is_year()) {
                            printf(__('年度归档: %s | Yearly Archives: %s', 'cold-transport'), '<span>' . get_the_date(_x('Y', 'yearly archives date format', 'cold-transport')) . '</span>');
                        } elseif (is_tax('product_category')) {
                            single_term_title();
                        } else {
                            _e('归档 | Archives', 'cold-transport');
                        }
                        ?>
                    </h1>
                    <?php
                    // 显示分类描述
                    $term_description = term_description();
                    if (!empty($term_description)) {
                        printf('<div class="taxonomy-description">%s</div>', $term_description);
                    }
                    ?>
                <?php endif; ?>
            </header>

            <div class="posts-grid">
                <?php
                // 开始循环
                while (have_posts()) : 
                    the_post();
                    
                    /**
                     * 包含文章格式模板
                     * 如果存在 content-{post-type}.php 则使用，否则使用默认
                     */
                    $post_type = get_post_type();
                    $template_part = 'content';
                    
                    if ('product' === $post_type) {
                        $template_part = 'content-product';
                    }
                    ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                    <?php
                                    the_post_thumbnail('product-thumb', array(
                                        'alt' => get_the_title(),
                                        'class' => 'post-thumbnail-img'
                                    ));
                                    ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <header class="post-header">
                                <?php
                                if (is_sticky() && is_home() && !is_paged()) {
                                    printf('<span class="sticky-post">%s</span>', __('推荐 | Featured', 'cold-transport'));
                                }
                                ?>
                                
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                
                                <div class="post-meta">
                                    <span class="post-date">
                                        <time datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </span>
                                    
                                    <span class="post-author">
                                        <?php
                                        printf(
                                            __('作者: %s | By: %s', 'cold-transport'),
                                            '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . get_the_author() . '</a>'
                                        );
                                        ?>
                                    </span>
                                    
                                    <?php if ('post' === get_post_type()) : ?>
                                        <span class="post-categories">
                                            <?php the_category(', '); ?>
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if (!post_password_required() && (comments_open() || get_comments_number())) : ?>
                                        <span class="comments-link">
                                            <?php
                                            comments_popup_link(
                                                __('留言 0 | 0 Comments', 'cold-transport'),
                                                __('留言 1 | 1 Comment', 'cold-transport'),
                                                __('留言 % | % Comments', 'cold-transport')
                                            );
                                            ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </header>
                            
                            <div class="post-summary">
                                <?php
                                if (has_excerpt()) {
                                    the_excerpt();
                                } else {
                                    echo wp_trim_words(get_the_content(), 55, '...');
                                }
                                ?>
                            </div>
                            
                            <footer class="post-footer">
                                <a href="<?php the_permalink(); ?>" class="read-more-btn">
                                    <?php _e('阅读更多 | Read More', 'cold-transport'); ?>
                                    <span class="screen-reader-text">
                                        <?php printf(__('关于 %s | About %s', 'cold-transport'), get_the_title()); ?>
                                    </span>
                                </a>
                                
                                <?php if ('product' === get_post_type()) : ?>
                                    <div class="product-meta">
                                        <?php
                                        $terms = get_the_terms(get_the_ID(), 'product_category');
                                        if ($terms && !is_wp_error($terms)) {
                                            echo '<div class="product-categories">';
                                            foreach ($terms as $term) {
                                                printf('<span class="product-category">%s</span>', $term->name);
                                            }
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </footer>
                        </div>
                    </article>
                    
                <?php endwhile; ?>
            </div>

            <?php
            // 分页导航
            the_posts_pagination(array(
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('页 | Page', 'cold-transport') . ' </span>',
                'prev_text'          => __('&laquo; 上一页 | Previous', 'cold-transport'),
                'next_text'          => __('下一页 &raquo; | Next', 'cold-transport'),
                'screen_reader_text' => __('文章导航 | Posts navigation', 'cold-transport'),
            ));
            ?>

        <?php else : ?>
            
            <div class="no-content">
                <?php if (is_search()) : ?>
                    
                    <h2 class="page-title">
                        <?php _e('未找到相关内容 | Sorry, but nothing matched your search terms.', 'cold-transport'); ?>
                    </h2>
                    
                    <div class="search-form-no-results">
                        <p><?php _e('请尝试使用其他关键词搜索 | Please try again with some different keywords.', 'cold-transport'); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                    
                <?php else : ?>
                    
                    <h2 class="page-title">
                        <?php _e('暂无内容 | Nothing here', 'cold-transport'); ?>
                    </h2>
                    
                    <div class="page-content">
                        <p>
                            <?php 
                            _e('看起来这里还没有内容。或许搜索可以帮到您？ | It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'cold-transport'); 
                            ?>
                        </p>
                        <?php get_search_form(); ?>
                    </div>
                    
                <?php endif; ?>
            </div>

        <?php endif; ?>
    </div>
    
    <?php
    // 侧边栏
    if (is_active_sidebar('sidebar-1')) {
        echo '<aside class="sidebar">';
        dynamic_sidebar('sidebar-1');
        echo '</aside>';
    }
    ?>
</div>

<?php get_footer(); ?>
