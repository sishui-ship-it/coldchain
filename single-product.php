<?php
/**
 * 产品详情页模板
 * Single Product Template
 */

get_header(); ?>

<div class="container main-container">
    <div class="product-detail-page">
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="product-<?php the_ID(); ?>" <?php post_class('product-single'); ?>>
                
                <!-- 产品面包屑导航 -->
                <nav class="product-breadcrumb">
                    <?php
                    if (function_exists('yoast_breadcrumb')) {
                        yoast_breadcrumb('<div class="breadcrumbs">', '</div>');
                    } else {
                        echo '<div class="breadcrumbs">';
                        echo '<a href="' . home_url() . '">' . __('首页 | Home', 'cold-transport') . '</a>';
                        echo '<span class="sep"> &raquo; </span>';
                        echo '<a href="' . get_post_type_archive_link('product') . '">' . __('产品中心 | Products', 'cold-transport') . '</a>';
                        
                        $terms = get_the_terms(get_the_ID(), 'product_category');
                        if ($terms && !is_wp_error($terms)) {
                            echo '<span class="sep"> &raquo; </span>';
                            echo '<a href="' . get_term_link($terms[0]) . '">' . $terms[0]->name . '</a>';
                        }
                        
                        echo '<span class="sep"> &raquo; </span>';
                        echo '<span class="current">' . get_the_title() . '</span>';
                        echo '</div>';
                    }
                    ?>
                </nav>
                
                <div class="product-detail-content">
                    
                    <!-- 产品图片区域 -->
                    <div class="product-gallery">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="main-product-image">
                                <a href="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" 
                                   data-fancybox="product-gallery">
                                    <?php the_post_thumbnail('large', array(
                                        'alt' => get_the_title(),
                                        'class' => 'product-main-img'
                                    )); ?>
                                    <span class="zoom-icon">🔍</span>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <!-- 产品图库 -->
                        <?php
                        $gallery_images = get_post_meta(get_the_ID(), '_product_gallery', true);
                        if ($gallery_images) :
                        ?>
                            <div class="product-gallery-thumbs">
                                <?php foreach ($gallery_images as $image_id) : ?>
                                    <div class="gallery-thumb">
                                        <a href="<?php echo wp_get_attachment_image_url($image_id, 'full'); ?>" 
                                           data-fancybox="product-gallery">
                                            <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- 产品信息区域 -->
                    <div class="product-info">
                        <header class="product-header">
                            <h1 class="product-title"><?php the_title(); ?></h1>
                            
                            <div class="product-meta">
                                <?php
                                $terms = get_the_terms(get_the_ID(), 'product_category');
                                if ($terms && !is_wp_error($terms)) :
                                ?>
                                    <span class="product-category">
                                        <strong><?php _e('分类: | Category:', 'cold-transport'); ?></strong>
                                        <?php
                                        $term_links = array();
                                        foreach ($terms as $term) {
                                            $term_links[] = '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
                                        }
                                        echo implode(', ', $term_links);
                                        ?>
                                    </span>
                                <?php endif; ?>
                                
                                <span class="product-sku">
                                    <strong><?php _e('产品编号: | SKU:', 'cold-transport'); ?></strong>
                                    <?php echo get_post_meta(get_the_ID(), '_product_sku', true) ?: 'N/A'; ?>
                                </span>
                                
                                <span class="product-date">
                                    <strong><?php _e('更新时间: | Updated:', 'cold-transport'); ?></strong>
                                    <?php echo get_the_modified_date(); ?>
                                </span>
                            </div>
                        </header>
                        
                        <div class="product-description">
                            <?php the_content(); ?>
                        </div>
                        
                        <!-- 产品特色 -->
                        <?php
                        $features = get_post_meta(get_the_ID(), '_product_features', true);
                        if ($features) :
                        ?>
                            <div class="product-features">
                                <h3><?php _e('产品特色 | Product Features', 'cold-transport'); ?></h3>
                                <ul class="features-list">
                                    <?php foreach ($features as $feature) : ?>
                                        <li class="feature-item">
                                            <span class="feature-icon">✓</span>
                                            <span class="feature-text"><?php echo esc_html($feature); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <!-- 技术参数表格 -->
                        <div class="technical-specifications">
                            <h3><?php _e('技术参数 | Technical Specifications', 'cold-transport'); ?></h3>
                            
                            <?php
                            $specs = get_post_meta(get_the_ID(), '_technical_specs', true);
                            if ($specs && is_array($specs)) :
                            ?>
                                <table class="specs-table">
                                    <thead>
                                        <tr>
                                            <th><?php _e('参数名称 | Parameter', 'cold-transport'); ?></th>
                                            <th><?php _e('规格 | Specification', 'cold-transport'); ?></th>
                                            <th><?php _e('单位 | Unit', 'cold-transport'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($specs as $spec) : ?>
                                            <tr>
                                                <td><?php echo esc_html($spec['name']); ?></td>
                                                <td><?php echo esc_html($spec['value']); ?></td>
                                                <td><?php echo esc_html($spec['unit']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else : ?>
                                <p class="no-specs"><?php _e('暂无技术参数信息 | No technical specifications available', 'cold-transport'); ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- 应用场景 -->
                        <div class="application-scenarios">
                            <h3><?php _e('应用场景 | Application Scenarios', 'cold-transport'); ?></h3>
                            <div class="scenarios-content">
                                <?php
                                $scenarios = get_post_meta(get_the_ID(), '_application_scenarios', true);
                                echo wpautop($scenarios);
                                ?>
                            </div>
                        </div>
                        
                        <!-- 产品操作区域 -->
                        <div class="product-actions">
                            <div class="action-buttons">
                                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-large">
                                    <?php _e('获取报价 | Get Quote', 'cold-transport'); ?>
                                </a>
                                
                                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-secondary btn-large">
                                    <?php _e('在线咨询 | Online Consultation', 'cold-transport'); ?>
                                </a>
                                
                                <button class="btn btn-outline btn-large" onclick="window.print()">
                                    <?php _e('打印页面 | Print Page', 'cold-transport'); ?>
                                </button>
                            </div>
                            
                            <div class="product-share">
                                <span class="share-label"><?php _e('分享: | Share:', 'cold-transport'); ?></span>
                                <div class="share-buttons">
                                    <a href="#" class="share-btn wechat" title="<?php _e('微信分享 | WeChat Share', 'cold-transport'); ?>">
                                        <span class="share-icon">💬</span>
                                    </a>
                                    <a href="#" class="share-btn linkedin" title="<?php _e('LinkedIn分享 | LinkedIn Share', 'cold-transport'); ?>">
                                        <span class="share-icon">💼</span>
                                    </a>
                                    <a href="#" class="share-btn twitter" title="<?php _e('Twitter分享 | Twitter Share', 'cold-transport'); ?>">
                                        <span class="share-icon">🐦</span>
                                    </a>
                                    <a href="mailto:?subject=<?php echo rawurlencode(get_the_title()); ?>&body=<?php echo rawurlencode(get_permalink()); ?>" 
                                       class="share-btn email" title="<?php _e('邮件分享 | Email Share', 'cold-transport'); ?>">
                                        <span class="share-icon">✉️</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- 相关产品 -->
                <section class="related-products">
                    <h2 class="section-title"><?php _e('相关产品 | Related Products', 'cold-transport'); ?></h2>
                    
                    <?php
                    $related_args = array(
                        'post_type' => 'product',
                        'posts_per_page' => 4,
                        'post__not_in' => array(get_the_ID()),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_category',
                                'field' => 'term_id',
                                'terms' => wp_get_post_terms(get_the_ID(), 'product_category', array('fields' => 'ids')),
                            )
                        )
                    );
                    
                    $related_products = new WP_Query($related_args);
                    
                    if ($related_products->have_posts()) :
                    ?>
                        <div class="related-products-grid">
                            <?php while ($related_products->have_posts()) : $related_products->the_post(); ?>
                                <article class="related-product-card">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="related-product-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('product-thumb'); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="related-product-content">
                                        <h3>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        
                                        <div class="related-product-excerpt">
                                            <?php the_excerpt(); ?>
                                        </div>
                                        
                                        <a href="<?php the_permalink(); ?>" class="related-product-link">
                                            <?php _e('查看详情 | View Details', 'cold-transport'); ?>
                                        </a>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        </div>
                    <?php else : ?>
                        <p class="no-related-products">
                            <?php _e('暂无相关产品 | No related products available', 'cold-transport'); ?>
                        </p>
                    <?php endif;
                    wp_reset_postdata();
                    ?>
                </section>
                
            </article>
            
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
