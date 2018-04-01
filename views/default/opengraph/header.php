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

$owner = elgg_get_page_owner_entity();
$profile_url = elgg_get_site_url().'profile/'.$owner->username;

//Description
if ((elgg_in_context('profile') || elgg_in_context('group_profile')) && $owner->description) {
	$owner_description = urldecode(html_entity_decode(strip_tags(elgg_get_excerpt($owner->description, 250))));
    $owner_description = str_replace(array(
        "\r",
        "\n",
		"'",
		"\"",
    ), '', $owner_description);
    $meta_description = $owner_description;
}

else {
    $meta_description = elgg_get_site_entity()->description;
}

$opendesc = strip_tags($meta_description);

//OPENGRAPH
if (!elgg_get_config('site_opengraph')){
	elgg_set_config('site_opengraph', []);
}

elgg_set_config('site_opengraph', 
	array_merge([
		'og:title' => $vars['title'],
		'og:type' => 'website',
		'og:url' => current_page_url(),
		'og:description' => $opendesc,
		'og:site_name' => elgg_get_config('sitename'),
	], elgg_get_config('site_opengraph')
));

$headers = elgg_trigger_plugin_hook('header', 'opengraph', ['url' => current_page_url()], elgg_get_config('site_opengraph'));
    
foreach ($headers as $property => $content) {
?>
	<meta property="<?=$property;?>" content="<?=$content;?>" />
<?php
}

//TWITTERCARDS
if (!elgg_get_config('site_twittercards')){
	elgg_set_config('site_twittercards', []);
}

elgg_set_config('site_twittercards', 
	array_merge([
		'twitter:title' => $vars['title'],
		'twitter:url' => current_page_url(),
		'twitter:description' => $opendesc,
		'twitter:card' => 'summary',
	], elgg_get_config('site_twittercards')
));

$headers = elgg_trigger_plugin_hook('header', 'twittercards', ['url' => current_page_url()], elgg_get_config('site_twittercards'));

foreach ($headers as $name => $content) {
?>
	<meta name="<?=$name;?>" content="<?=$content;?>" />
<?php
}

//SCHEMA
if (!elgg_get_config('site_schema')){
	elgg_set_config('site_schema', []);
}

elgg_set_config('site_schema', array_merge([
    'name' => $vars['title'],
	'description' => $opendesc,
], elgg_get_config('site_schema')));

$headers = elgg_trigger_plugin_hook('header', 'schema', ['url' => current_page_url()], elgg_get_config('site_schema'));

foreach ($headers as $itemprop => $content) {
?>
	<meta itemprop="<?=$itemprop;?>" content="<?=$content;?>" />
<?php
}

if (elgg_in_context('profile')) {
?>
	<link href="<?=$profile_url;?>" rel="publisher">
<?php
}