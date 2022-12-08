<?php

if(!is_active_sidebar('materialis_pages_sidebar'))
{
    return;
}

?>

<div class="sidebar page-sidebar">
    <?php dynamic_sidebar('materialis_pages_sidebar'); ?>
</div>
