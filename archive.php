<?php
/**
 * 归档页面模板
 */
get_header(); ?>

<div class="container main-container">
    <div class="content-area">
        <header class="archive-header">
            <h1 class="archive-title">
                <?php
                if (is_category()) {
                    single_cat_title();
                } elseif (is_tag()) {
                    single_tag_title();
                } elseif (is_author()) {
                    printf(__('作者归档: %s', 'cold-transport'), get_the_author());
                } elseif (is_day()) {
                    printf(__('每日归档: %s', 'cold-transport'), get_the_date());
                } elseif (is_month()) {
                    printf(__('月度归档: %s', 'cold-transport'), get_the_date('F Y'));
                } elseif (is_year()) {
                    printf(__('年度归档: %s', 'cold-transport'), get_the_date('Y'));
                } else {
                    _e('归档', 'cold-transport');
                }
                ?>
            </h1>
            
            <?php if (term_description()) : ?>
                <div class="archive-description">
                    <?php echo term_description(); ?>
                </div>
            <?php endif; ?>
        </header>
        
        <?php get_template_part('content', 'archive'); ?>
    </div>
</div>

<?php get_footer(); ?>
