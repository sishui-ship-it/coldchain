<?php
/**
 * The template for displaying the footer
 * 网站底部模板
 *
 * @package Cold_Transport_Pro
 */

?>

	</div><!-- #main-content -->

	<footer id="site-footer" class="site-footer" role="contentinfo">
		<div class="container">
			
			<!-- 页脚主要内容区域 -->
			<div class="footer-content">
				
				<!-- 公司信息 -->
				<div class="footer-section company-info">
					<div class="footer-logo">
						<?php if (has_custom_logo()) : ?>
							<?php the_custom_logo(); ?>
						<?php else : ?>
							<h3><?php bloginfo('name'); ?></h3>
						<?php endif; ?>
					</div>
					
					<p class="footer-description">
						<?php 
						_e('专业冷藏车、鸡苗运输车制造商，提供全方位的冷链运输解决方案。 | Professional refrigerated truck and chick transport vehicle manufacturer, providing comprehensive cold chain transportation solutions.', 'cold-transport'); 
						?>
					</p>
					
					<div class="social-links">
						<a href="#" class="social-link wechat" title="<?php _e('微信 | WeChat', 'cold-transport'); ?>">
							<span class="social-icon">💬</span>
							<span class="social-text"><?php _e('微信 | WeChat', 'cold-transport'); ?></span>
						</a>
						<a href="#" class="social-link linkedin" title="<?php _e('领英 | LinkedIn', 'cold-transport'); ?>">
							<span class="social-icon">💼</span>
							<span class="social-text"><?php _e('领英 | LinkedIn', 'cold-transport'); ?></span>
						</a>
						<a href="#" class="social-link facebook" title="<?php _e('脸书 | Facebook', 'cold-transport'); ?>">
							<span class="social-icon">👍</span>
							<span class="social-text"><?php _e('脸书 | Facebook', 'cold-transport'); ?></span>
						</a>
					</div>
				</div>
				
				<!-- 产品链接 -->
				<div class="footer-section product-links">
					<h4 class="footer-title"><?php _e('产品中心 | Products', 'cold-transport'); ?></h4>
					<?php
					// 显示产品分类菜单
					wp_nav_menu(array(
						'theme_location' => 'footer',
						'menu_class'     => 'footer-menu',
						'container'      => false,
						'fallback_cb'    => 'cold_transport_footer_product_links',
						'depth'          => 1,
					));
					?>
				</div>
				
				<!-- 联系信息 -->
				<div class="footer-section contact-info">
					<h4 class="footer-title"><?php _e('联系我们 | Contact', 'cold-transport'); ?></h4>
					<div class="contact-details">
						<div class="contact-item">
							<span class="contact-icon">📞</span>
							<span class="contact-text">+86 000-0000-0000</span>
						</div>
						<div class="contact-item">
							<span class="contact-icon">✉️</span>
							<span class="contact-text">info@example.com</span>
						</div>
						<div class="contact-item">
							<span class="contact-icon">📍</span>
							<address class="contact-text">
								<?php _e('中国山东省济宁市泗水县 | Sishui County, Jining City, Shandong Province, China', 'cold-transport'); ?>
							</address>
						</div>
					</div>
				</div>
				
				<!-- 快速链接 -->
				<div class="footer-section quick-links">
					<h4 class="footer-title"><?php _e('快速链接 | Quick Links', 'cold-transport'); ?></h4>
					<ul class="quick-links-menu">
						<li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('首页 | Home', 'cold-transport'); ?></a></li>
						<li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php _e('关于我们 | About', 'cold-transport'); ?></a></li>
						<li><a href="<?php echo esc_url(home_url('/products')); ?>"><?php _e('产品展示 | Products', 'cold-transport'); ?></a></li>
						<li><a href="<?php echo esc_url(home_url('/news')); ?>"><?php _e('新闻资讯 | News', 'cold-transport'); ?></a></li>
						<li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php _e('联系我们 | Contact', 'cold-transport'); ?></a></li>
					</ul>
				</div>
				
			</div>
			
			<!-- 页脚底部 -->
			<div class="footer-bottom">
				<div class="footer-copyright">
					<p>
						&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
						<?php _e('版权所有 | All rights reserved.', 'cold-transport'); ?>
					</p>
				</div>
				
				<div class="footer-links">
					<a href="<?php echo esc_url(home_url('/privacy')); ?>">
						<?php _e('隐私政策 | Privacy Policy', 'cold-transport'); ?>
					</a>
					<a href="<?php echo esc_url(home_url('/terms')); ?>">
						<?php _e('使用条款 | Terms of Service', 'cold-transport'); ?>
					</a>
					<a href="<?php echo esc_url(home_url('/sitemap')); ?>">
						<?php _e('网站地图 | Sitemap', 'cold-transport'); ?>
					</a>
				</div>
			</div>
			
		</div>
	</footer>

	<!-- 返回顶部按钮 -->
	<button id="back-to-top" class="back-to-top" aria-label="<?php _e('返回顶部 | Back to top', 'cold-transport'); ?>">
		↑
	</button>

	<?php wp_footer(); ?>

</body>
</html>
