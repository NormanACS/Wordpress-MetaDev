<?php
$materialis_tabs = apply_filters('materialis_info_page_tabs', array(
    'getting-started' => array(
        'title'   => __('Getting started', 'materialis'),
        'partial' => get_template_directory() . "/inc/infopage-parts/getting-started.php",
    ),
    'free-vs-pro'     => array(
        'title'   => __('Free vs PRO', 'materialis'),
        'partial' => get_template_directory() . "/inc/infopage-parts/free-vs-pro.php",
    ),

));

$currentTab = (isset($_REQUEST['tab']) && isset($materialis_tabs[$_REQUEST['tab']])) ? $_REQUEST['tab'] : 'getting-started';

?>


<div class="wrap about-wrap full-width-layout materialis-page">
    <h1><?php _e('Thanks for choosing Materialis!', 'materialis'); ?></h1>
    <p><?php _e('We\'re glad you chose our theme and we hope it will help you create a beautiful site in no time!<br> If you have any suggestions, don\'t hesitate to leave us some feedback.', 'materialis'); ?></p>

    <img class="site-badge" src="https://extendthemes.com/materialis/wp-content/uploads/2018/06/logo-materialis-260.png">
    <h2 class="nav-tab-wrapper wp-clearfix">

        <?php foreach ($materialis_tabs as $tabID => $tab): ?>
            <a href="?page=materialis-welcome&tab=<?php echo $tabID; ?>" class="nav-tab <?php echo($tabID === $currentTab ? 'nav-tab-active' : '') ?>"><?php echo $tab['title'] ?></a>
            <?php $first = false; ?>
        <?php endforeach; ?>
    </h2>

    <div class="tab-group">
        <div class="tab-item tab-item-active">
            <?php
            if ( isset( $materialis_tabs[ $currentTab ]['partial'] ) ) {
                require $materialis_tabs[ $currentTab ]['partial'];
            } else {
                call_user_func( $materialis_tabs[ $currentTab ]['callback'] );
            }
            ?>
        </div>
    </div>
</div>
