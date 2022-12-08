<?php
get_header();
// Custom Elementor 404 page
if (get_theme_mod('custom_404_page', '') != '' && futurio_check_elementor()) {
    futurio_generate_header(true, true, true, false, true, false);
    ?>
    <div class="container-fluid main-container page-builders" role="main">
        <div class="page-area">	
            <!-- start content container -->
            <div class="row">
                <article class="col-md-12">
                    <div class="futurio-content main-content-page">                            
                        <div class="single-entry-summary">                              
                            <?php
                            $elementor_404_ID = get_theme_mod('custom_404_page', '');
                            echo do_shortcode('[elementor-template id="' . $elementor_404_ID . '"]');
                            ?>
                        </div>
                    </div>      

                </article>       
            </div>
            <!-- end content container -->
        </div>
    </div>
    <?php
    get_footer();
} else {
    futurio_generate_header(true, true, true, true, false, true);
    ?>
    <!-- start content container -->
    <div class="row">
        <div class="col-md-<?php futurio_main_content_width_columns(); ?> <?php futurio_sidebar_position('content') ?>">
            <div class="main-content-page">
                <div class="error-template text-center">
                    <h1>
                        <?php esc_html_e('Oops! That page can&rsquo;t be found.', 'futurio'); ?>
                    </h1>
                    <p class="error-details">
                        <?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'futurio'); ?>
                    </p>
                    <div class="error-actions">
                        <?php get_search_form(); ?>    
                    </div>
                </div>
            </div>
        </div>

        <?php get_sidebar(); ?>

    </div>
    <!-- end content container -->

    <?php
    get_footer();
}
