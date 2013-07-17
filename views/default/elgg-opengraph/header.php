<?php

    // Make sure we don't get any nasty errors when no settings are present
    if (!elgg_get_config('site_opengraph'))
        elgg_set_config('site_opengraph', array());

    // Set some sensible defaults, merging with overrides from config settings
    elgg_set_config('site_opengraph', array_merge(array(
        'og:title' => $vars['title'],
        'og:type' => 'website',
        'og:url' => current_page_url(),
        'og:site_name' => elgg_get_config('sitename')
    ), elgg_get_config('site_opengraph')));


    $headers = elgg_trigger_plugin_hook('header', 'opengraph', array('url' => current_page_url()), elgg_get_config('site_opengraph'));
    
    foreach ($headers as $property => $content) {
        ?>
<meta property="<?=$property;?>" content="<?=$content;?>" />
        <?php
    }