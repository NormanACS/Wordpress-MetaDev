<?php
get_header();

futurio_generate_header(true, true, true, false, true, false);
?>
<div class="container-fluid main-container page-builders" role="main">
    <div class="page-area">	
        <!-- start content container -->
        <div class="row">
            <article class="col-md-12">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>                          
                        <div <?php post_class(); ?>>
                            <div class="futurio-content main-content-page">                            
                                <div class="single-entry-summary">                              
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>        
                    <?php endwhile; ?>        
                <?php else : ?>            
                    <?php get_template_part('content', 'none'); ?>        
                <?php endif; ?>    
            </article>       
        </div>
        <!-- end content container -->

        <?php get_footer(); ?>
