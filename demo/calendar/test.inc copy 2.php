<?php
$basePath = '/Users/prowebscape/Sites/CMS/MODx/current/assets/snippets/calendar/';
require_once($basePath.'classes/simplepie/simplepie.inc');

#$calendar_xml_address = "http://www.google.com/calendar/feeds/fellowshipchurchjackson@gmail.com/public/full?start-min=2009-02-15&start-max=2009-04-01&max-results=1&orderby=starttime&sortorder=a&singleevents=true";

$feedUrl  = 'http://www.google.com/calendar/feeds/[+email_address+]';
$feedUrl .= '';
$emails = explode(',',$email);
$tempCounter = 0;
$addresses = array();
foreach ($emails as $addy) {
	$addresses[$tempCounter] = "http://www.google.com/calendar/feeds/".$addy."/public/full?start-min=".$startMin.'&start-max='.$startMax."&max-results=2500&orderby=starttime&sortorder=$order&singleevents=true";
	$addressDebug .= '<a href="' . $addresses[$tempCounter] . '">' . $addresses[$tempCounter] . '</a> ';
	$tempCounter++;
	}



$feed = new SimplePie();        # Let's create a new SimplePie object
$feed->set_feed_url('http://www.google.com/calendar/feeds/fellowshipchurchjackson@gmail.com/public/full?results=1&singleevents=true');
$feed->enable_order_by_date(false);
$feed->init();
$feed->handle_content_type();
$temp = array();

foreach ($feed->get_items() as $item) {
 
	$when = $item->get_item_tags('http://schemas.google.com/g/2005', 'when');
	   $gd_startTime = $when[0]['attribs']['']['startTime'];
	   $gd_endTime   = $when[0]['attribs']['']['endTime'];
	    
    $status = $item->get_item_tags('http://schemas.google.com/g/2005', 'eventStatus');
        $eventStatus = substr( $status[0]['attribs']['']['value'], -8);

	$realStartTime = SimplePie_Misc::parse_date($gd_startTime);
	$realEndTime   = SimplePie_Misc::parse_date($gd_endTime);
 
	// Let's format it with date(). This will be the date we display.
	$readableStartTime = date('M j, Y', $realStartTime);
	$readableEndTime = date('M j, Y', $realEndTime);
		
	$title = $item->get_title();
    $description = $item->get_description();
    $link = $item->get_link();
    
	// This is how each item will be displayed. We're adding it to the array we created earlier, and indexing it by the $sortDate.
	$temp[] = array(
	       'title'     => $title,
	       'startTime' => $readableStartTime,
	       'endTime'   => $readableEndTime,
	       'link'      => $link,
	       'status'    => $eventStatus,
	       'sortDate'  => $realStartTime,
	       'description'   => $description,
	   );
    
}
 
// Change this to krsort() to display with the furthest event first.
foreach ($temp as $key => $row) {
    $date[$key]  = $row['sortDate'];
}

#array_multisort($date, SORT_DESC, $temp);
array_multisort($date, SORT_ASC, $temp);
    echo '<pre>';
	print_r($temp);
	echo '</pre>';




