<?php

/**
 * Open Graph headers for Elgg.
 * Provides side wide and object specific open graph headers for Elgg.
 *
 * @licence GNU Public License version 2
 * @link https://github.com/mapkyca/elgg-opengraph
 * @link http://www.marcus-povey.co.uk
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 */


elgg_register_event_handler('init', 'system', function() {
            
    // Register header
    elgg_extend_view('page/elements/head', 'elgg-opengraph/header');
    
    // Handle request for headers (hook in and pull objects where possible)
    elgg_register_plugin_hook_handler('header', 'opengraph', function ($hook, $handler, $return, $params){
	
        // See if we can get an object by URL (see https://github.com/mapkyca/elgg-webmention for other uses and commentary) 
        if ($object = elgg_trigger_plugin_hook('getbyurl', 'object', array('url' => $params['url']), false))
        { 
            // We can handle this object, so fill out some details
            $return['og:url'] = $object->getUrl();
            $return['og:image'] = $object->getIconURL('large');
            
            // User profiles
            if (elgg_instanceof($object, 'user')) {
                $return['og:type'] = 'profile';
            }
            
            // Set description on some objects
            if (!empty($object->description))
				$return['og:description'] = $object->description;
            
            return $return;
        }
        
    });
    
    // By way of example, have a default profile handler
    elgg_register_plugin_hook_handler('getbyurl', 'object', function ($hook_name, $entity_type, $return_value, $parameters) {
        global $CONFIG;
        
        if (preg_match("/".str_replace('/','\/', $CONFIG->wwwroot)."profile\/([a-zA-Z0-9]*)/", $parameters['url'], $match)) {
        
            return get_user_by_username($match[1]);
            
        }
    });
    
    
});
