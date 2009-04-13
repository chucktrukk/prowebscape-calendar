<?php
$basePath = '/Users/prowebscape/Sites/CMS/MODx/current/assets/snippets/calendar/';

if (!function_exists('getGoogleDate'))
{
    function getGoogleDate ($output) {
    	if (strpos($output, 'T')) {
    		$mystring = str_replace('T', ' ', $output);
    		$mystring = substr($mystring, 0,16);
    		$dt = strtotime($mystring);
    		return $dt;
    	}
    	else {
    		$dt = strtotime($output);
    	    return $dt;
    	}
    }
}
//Where your simplepie.inc is (mine's in the root for some reason)
require_once($basePath.'classes/simplepie/simplepie.inc');

// Cache location for your XML file
$cache_location= $basePath . 'cache';

$calendar_xml_address = "http://www.google.com/calendar/feeds/fellowshipchurchjackson@gmail.com/public/full?start-min=2009-02-15&start-max=2009-04-01&max-results=1&orderby=starttime&sortorder=a&singleevents=true";

$feed = new SimplePie();        # Let's create a new SimplePie object
$feed->set_cache_location($cache_location); # Set the cache location

if ($debug || $disableCache != false)
{
    $feed->enable_cache(false);
}

if ($debug) {
    $debugOutput .= "<p>Offset is $offset.</p><p>We're going to go and grab <a href='$calendar_xml_address'>this feed</a>.</p>";
}


$feed->set_feed_url($calendar_xml_address); # This is the feed we'll use
$feed->enable_order_by_date(false);         # Let's turn this off because we're just going to re-sort anyways, and there's no reason to waste CPU doing it twice.
$feed->init();                              # Initialize the feed so that we can use it.
$feed->handle_content_type();               # Make sure the content is being served out to the browser properly.
$temp = array();                            # We'll use this for re-sorting the items based on the new date.

echo '<pre>';
if($feed->get_items()) 
{
    foreach ($feed->get_items() as $item) {
        print_r($item);
    }
}

echo '</pre>';