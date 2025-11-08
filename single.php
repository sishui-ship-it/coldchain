<?php
/**
 * The template for displaying all single posts
 * 文章详情页模板
 *
 * @package Cold_Transport_Pro
 */

get_header(); ?>

<div class="container main-container">
    <div class="content-area">
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                
                <header class="post-header">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <h1 class="post-title"><?php the_title(); ?></h1>
                    
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
                        
                        <?php if (has_category()) : ?>
                            <span class="post-categories">
                                <?php the_category(', '); ?>
                            </span>
                        <?php endif; ?>
                        
                        <?php if (comments_open() || get_comments_number()) : ?>
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
                
                <div class="post-content">
                    <?php the_content(); ?>
                    
                    <?php
                    // 分页链接（如果文章有<!--nextpage-->）
                    wp_link_pages(array(
                        'before'      => '<div class="page-links">' . __('页面: | Pages:', 'cold-transport'),
                        'after'       => '</div>',
                        'link_before' => '<span class="page-number">',
                        'link_after'  => '</span>',
                    ));
                    ?>
                </div>
                
                <footer class="post-footer">
                    <?php if (has_tag()) : ?>
                        <div class="post-tags">
                            <span class="tags-label"><?php _e('标签: | Tags:', 'cold-transport'); ?></span>
                            <?php the_tags('', ', ', ''); ?>
                        </div>
                    <?php endif; ?>
                </footer>
            </article>
            
            <!-- 文章导航 -->
            <nav class="post-navigation">
                <div class="nav-previous">
                    <?php
                    previous_post_link(
                        '%link',
                        '<span class="nav-arrow">←</span> <span class="nav-content"><span class="nav-label">' . __('上一篇 | Previous', 'cold-transport') . '</span><span class="nav-title">%title</span></span>'
                    );
                    ?>
                </div>
                
                <div class="nav-next">
                    <?php
                    next_post_link(
                        '%link',
                        '<span class="nav-content"><span class="nav-label">' . __('下一篇 | Next', 'cold-transport') . '</span><span class="nav-title">%title</span></span> <span class="nav-arrow">→</span>'
                    );
                    ?>
                </div>
            </nav>
            
            <!-- 相关文章 -->
            <?php
            $related_posts = cold_transport_get_related_posts(get_the_ID());
            if ($related_posts->have_posts()) :
            ?>
                <section class="related-posts">
                    <h3 class="related-title"><?php _e('相关文章 | Related Posts', 'cold-transport'); ?></h3>
                    <div class="related-posts-grid">
                        <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                            <article class="related-post">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="related-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="related-content">
                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <span class="related-date"><?php echo get_the_date(); ?></span>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php endif;
            wp_reset_postdata();
            ?>
            
            <!-- 评论区域 -->
            <?php
            if (comments_open() || get_comments_number()) {
                comments_template();
            }
            ?>
            
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
