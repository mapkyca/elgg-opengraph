Open Graph support for Elgg
===========================

The Open Graph protocol <http://ogp.me/> is a way of providing rich content information for pages when shared on social networks.

This is quite powerful, but at the basic level it provides a way for content creators to control how the share stub looks when shared on networks like Facebook or Google +.

What this plugin does
---------------------
This plugin adds Open Graph meta headers to your Elgg site (with reasonable defaults), and provides a framework for you to add specific open graph headers to object pages and specific URLS.

Installation
------------
 * Place this plugin in mod/elgg-opengraph and activate it via your admin panel.
 * Optionally override the default open graph headers by providing a default array in settings.php, e.g.

```php
	$CONFIG->site_opengraph = array(
		'og:image' => elgg_get_site_url() . 'mod/my_theme/graphics/site_logo.png',
		'og:site_name' => 'My site',
		'og:description' => "The Coolest site on tha interwebs!",
	);	
```

Usage
-----

 * The default installation provides sensible basic defaults for everything other than og:image
 * Provide URL specific overrides by listening to the the 'header', 'opengraph' hook, e.g.

```php
	elgg_register_plugin_hook_handler('header', 'opengraph', function ($hook, $handler, $return, $params){
           
            if (preg_match('/'.str_replace('/','\\/',elgg_get_site_url()).'mypage/', $params['url'])) {
                $return['og:description'] = 'New description here...';
                
                return $return;
            }
            
        });
```
 * To return details about a specific object type, add a hook for  'getbyurl', 'object', e.g.

```php
	elgg_register_plugin_hook_handler('getbyurl', 'object', function ($hook_name, $entity_type, $return_value, $parameters) {
		global $CONFIG;

		if (preg_match("/".str_replace('/','\/', $CONFIG->wwwroot)."myobjecturl\/([0-9]*)/", $parameters['url'], $match)) {
	    
		    return get_entity((int)$match[1]);
	    
		}
	});
```

See
---
 * Author: Marcus Povey <http://www.marcus-povey.co.uk>
 * Plugin Homepage <https://github.com/mapkyca/elgg-opengraph>
 * The Open Graph Protocol <http://ogp.me/>

 
