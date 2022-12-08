<?php if (is_active_sidebar('futurio-homepage-area')) { ?>
    <div class="homepage-main-content-page">
        <div class="homepage-area"> 
            <?php
            if (is_active_sidebar('futurio-homepage-area')) {
                dynamic_sidebar('futurio-homepage-area');
            }
            ?>
        </div>
    </div>
<?php } ?>
