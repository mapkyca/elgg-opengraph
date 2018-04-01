<?php
/**
 * Open Graph/Twitter Cards/Schema.org headers for Elgg.
 * Provides side wide and object specific headers for Elgg.
 *
 * @licence GNU Public License version 2
 * @link https://github.com/mapkyca/elgg-opengraph
 * @link https://www.marcus-povey.co.uk
 * @link https://wzm.me
 * @author Marcus Povey <marcus@marcus-povey.co.uk>
 * @author RiverVanRain <hello@wzm.me>
*/

elgg_register_event_handler('init', 'system', function() {
	
	// Register header
    elgg_extend_view('page/elements/head', 'opengraph/header');
	
	//OPENGRAPH
	// Handle request for headers (hook in and pull objects where possible)
    elgg_register_plugin_hook_handler('header', 'opengraph', function ($hook, $handler, $return, $params){
		
		// See if we can get an object by URL (see https://github.com/mapkyca/elgg-webmention for other uses and commentary) 
		if ($object = elgg_trigger_plugin_hook('getbyurl', 'object', [
				'url' => $params['url']
			], false)) {
            
			// We can handle this object, so fill out some details
			$return['og:url'] = $object->getUrl();
            $return['og:image'] = $object->getIconURL('large');
           
		   // User profiles
			if ($object instanceof ElggUser) {
                $return['og:type'] = 'profile';
            }
            
			return $return;
        }
    });
	
	//TWITTERCARDS
	elgg_register_plugin_hook_handler('header', 'twittercards', function ($hook, $handler, $return, $params){
		if ($object = elgg_trigger_plugin_hook('getbyurl', 'object', [
				'url' => $params['url']
			], false)) {
            
			$return['twitter:url'] = $object->getUrl();
            $return['twitter:image'] = $object->getIconURL('large');
            
			if ($object instanceof ElggUser && $object->twitter) {
                $return['twitter:creator'] = '@'.$object->twitter;
            }
            
			return $return;
        }
    });
	
	//SCHEMA
	elgg_register_plugin_hook_handler('header', 'schema', function ($hook, $handler, $return, $params){
		if ($object = elgg_trigger_plugin_hook('getbyurl', 'object', [
				'url' => $params['url']
			], false)) {
            
			$return['image'] = $object->getIconURL('large');
           
		   return $return;
        }
    });
    
    // By way of example, have a default profile handler
	elgg_register_plugin_hook_handler('getbyurl', 'object', function ($hook_name, $entity_type, $return, $params) {
        
		if (preg_match("/".str_replace('/','\/', elgg_get_site_url())."profile\/([a-zA-Z0-9]*)/", $params['url'], $match)) {
			return get_user_by_username($match[1]);
        }
		
    });

});
