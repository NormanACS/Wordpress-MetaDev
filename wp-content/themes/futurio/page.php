<?php
get_header();

futurio_generate_header(true, true, true, true, true, true);
?>

<!-- start content container -->
<div class="row">
    <article class="col-md-<?php futurio_main_content_width_columns(); ?> <?php futurio_sidebar_position('content') ?>">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>                          
                <div <?php post_class(); ?>>
                    <?php if (get_theme_mod('single_title_position', 'full') == 'inside') { ?>
                        <?php if (futurio_get_meta('disable_title') != 'disable') { ?>
                            <header>                              
                                <?php the_title('<h1 class="single-title">', '</h1>'); ?>
                                <time class="posted-on published" datetime="<?php the_time('Y-m-d'); ?>"></time>                                                        
                            </header>
                        <?php } ?>
                    <?php } ?>
                    <?php if (get_theme_mod('single_featured_image', 'full') == 'inside') { ?>
                        <?php if (futurio_get_meta('disable_featured_image') != 'disable') { ?>
                            <?php futurio_thumb_img('futurio-single', '', false); ?>
                        <?php } ?>
                    <?php } ?>
                    <div class="futurio-content main-content-page">                            
                        <div class="single-entry-summary">                              
                            <?php do_action('futurio_before_content'); ?>
                            <?php the_content(); ?>
                            <?php do_action('futurio_after_content'); ?>
                        </div>                               
                        <?php wp_link_pages(); ?>

                        <?php comments_template(); ?>
                    </div>
                </div>        
            <?php endwhile; ?>        
        <?php else : ?>            
            <?php get_template_part('content', 'none'); ?>        
        <?php endif; ?>    
    </article>       
    <?php
    if (futurio_get_meta('sidebar') != 'no_sidebar') {
        get_sidebar();
    }
    ?>
</div>
<!-- end content container -->

<?php get_footer(); ?>
