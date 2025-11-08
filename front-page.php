<?php
/**
 * The front page template file
 * 首页模板文件
 *
 * @package Cold_Transport_Pro
 */

get_header(); ?>

<!-- 英雄区域 -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">
                <?php _e('专业冷链运输解决方案专家 | Professional Cold Chain Transportation Solutions', 'cold-transport'); ?>
            </h1>
            
            <p class="hero-description">
                <?php _e('专注于冷藏车、鸡苗运输车的研发与制造，为全球客户提供可靠的运输设备 | Specializing in the R&D and manufacturing of refrigerated trucks and chick transport vehicles, providing reliable transportation equipment for global customers', 'cold-transport'); ?>
            </p>
            
            <div class="hero-actions">
                <a href="<?php echo esc_url(home_url('/products')); ?>" class="btn btn-primary btn-large">
                    <?php _e('查看产品 | View Products', 'cold-transport'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-secondary btn-large">
                    <?php _e('联系我们 | Contact Us', 'cold-transport'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 产品分类展示 -->
<section class="product-categories-section">
    <div class="container">
        <h2 class="section-title">
            <?php _e('产品中心 | Product Center', 'cold-transport'); ?>
        </h2>
        
        <div class="categories-grid">
            <!-- 冷藏车分类 -->
            <div class="category-card">
                <div class="category-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/refrigerated-truck.jpg" 
                         alt="<?php _e('冷藏运输车 | Refrigerated Truck', 'cold-transport'); ?>">
                </div>
                <div class="category-content">
                    <h3><?php _e('冷藏运输车 | Refrigerated Trucks', 'cold-transport'); ?></h3>
                    <p><?php _e('适用于食品、医药等冷链运输需求，保持恒温运输 | Suitable for food, pharmaceutical and other cold chain transportation needs, maintaining constant temperature transportation', 'cold-transport'); ?></p>
                    <ul class="category-features">
                        <li><?php _e('温度范围: -25°C 至 +25°C | Temperature range: -25°C to +25°C', 'cold-transport'); ?></li>
                        <li><?php _e('多种容量选择 | Multiple capacity options', 'cold-transport'); ?></li>
                        <li><?php _e('节能环保设计 | Energy-saving and eco-friendly design', 'cold-transport'); ?></li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/product-category/refrigerated')); ?>" class="category-link">
                        <?php _e('了解更多 | Learn More', 'cold-transport'); ?>
                    </a>
                </div>
            </div>
            
            <!-- 鸡苗运输车分类 -->
            <div class="category-card">
                <div class="category-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chick-transport.jpg" 
                         alt="<?php _e('鸡苗运输车 | Chick Transport Vehicle', 'cold-transport'); ?>">
                </div>
                <div class="category-content">
                    <h3><?php _e('鸡苗运输车 | Chick Transport Vehicles', 'cold-transport'); ?></h3>
                    <p><?php _e('专业活禽运输，保证运输安全，通风保温系统完善 | Professional live poultry transportation, ensuring transportation safety with complete ventilation and insulation systems', 'cold-transport'); ?></p>
                    <ul class="category-features">
                        <li><?php _e('智能通风系统 | Intelligent ventilation system', 'cold-transport'); ?></li>
                        <li><?php _e('温度湿度控制 | Temperature and humidity control', 'cold-transport'); ?></li>
                        <li><?php _e('安全舒适运输 | Safe and comfortable transportation', 'cold-transport'); ?></li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/product-category/chick-transport')); ?>" class="category-link">
                        <?php _e('了解更多 | Learn More', 'cold-transport'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 特色产品展示 -->
<section class="featured-products-section">
    <div class="container">
        <h2 class="section-title">
            <?php _e('特色产品 | Featured Products', 'cold-transport'); ?>
        </h2>
        
        <?php
        // 查询特色产品
        $featured_args = array(
            'post_type'      => 'product',
            'posts_per_page' => 6,
            'meta_query'     => array(
                array(
                    'key'     => '_featured_product',
                    'value'   => 'yes',
                    'compare' => '='
                )
            )
        );
        
        $featured_products = new WP_Query($featured_args);
        
        if ($featured_products->have_posts()) :
        ?>
            <div class="featured-products-grid">
                <?php while ($featured_products->have_posts()) : $featured_products->the_post(); ?>
                    <article class="featured-product-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="product-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('product-thumb'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="product-content">
                            <h3>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            
                            <div class="product-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <div class="product-meta">
                                <?php
                                $terms = get_the_terms(get_the_ID(), 'product_category');
                                if ($terms && !is_wp_error($terms)) {
                                    echo '<span class="product-category">';
                                    foreach ($terms as $term) {
                                        echo esc_html($term->name);
                                        break; // 只显示第一个分类
                                    }
                                    echo '</span>';
                                }
                                ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="product-link">
                                <?php _e('查看详情 | View Details', 'cold-transport'); ?>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <div class="view-all-products">
                <a href="<?php echo esc_url(home_url('/products')); ?>" class="btn btn-outline">
                    <?php _e('查看所有产品 | View All Products', 'cold-transport'); ?>
                </a>
            </div>
            
        <?php else : ?>
            <div class="no-featured-products">
                <p><?php _e('暂无特色产品，请先添加产品并标记为特色 | No featured products yet. Please add products and mark them as featured.', 'cold-transport'); ?></p>
            </div>
        <?php endif; 
        wp_reset_postdata();
        ?>
    </div>
</section>

<!-- 公司优势 -->
<section class="company-advantages-section">
    <div class="container">
        <h2 class="section-title">
            <?php _e('我们的优势 | Our Advantages', 'cold-transport'); ?>
        </h2>
        
        <div class="advantages-grid">
            <div class="advantage-card">
                <div class="advantage-icon">🏭</div>
                <h3><?php _e('专业制造 | Professional Manufacturing', 'cold-transport'); ?></h3>
                <p><?php _e('20年专业经验，先进的生产设备 | 20 years of professional experience with advanced production equipment', 'cold-transport'); ?></p>
            </div>
            
            <div class="advantage-card">
                <div class="advantage-icon">🔧</div>
                <h3><?php _e('技术支持 | Technical Support', 'cold-transport'); ?></h3>
                <p><?php _e('专业技术团队，完善的售后服务 | Professional technical team with complete after-sales service', 'cold-transport'); ?></p>
            </div>
            
            <div class="advantage-card">
                <div class="advantage-icon">🌍</div>
                <h3><?php _e('全球服务 | Global Service', 'cold-transport'); ?></h3>
                <p><?php _e('产品出口多个国家，国际质量标准 | Products exported to multiple countries with international quality standards', 'cold-transport'); ?></p>
            </div>
            
            <div class="advantage-card">
                <div class="advantage-icon">💡</div>
                <h3><?php _e('定制方案 | Custom Solutions', 'cold-transport'); ?></h3>
                <p><?php _e('根据客户需求提供个性化定制方案 | Provide personalized solutions based on customer needs', 'cold-transport'); ?></p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
