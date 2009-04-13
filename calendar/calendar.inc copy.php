<?php


//v0.91: Nice error message if there are no events to display, requested by Tomas. Thanks!
//v0.90: Feature: clickable links in descriptions (start them http://). Thank you, Adam!
//       Feature: display end times, requested by Lucy. Thanks!
//       Feature: group by date, requested by Lucy. Thanks!
//       Note: I now use PHP5 - while this code should continue working in PHP4, beware!
//       http://james.cridland.net/code


/////////
//Configuration
//

$language = (isset($language))? $language : "english";

$email      = (isset($email)) ? $email : "youremail@gmail.com"; #The 'Calendar ID' code (as shown in your 'calendar settings' page)

$dateformat = (isset($dateformat)) ? $dateformat : "D, M j Y";   # Date format you want your details to appear. 10 March 2009 - see http://www.php.net/date for details
$timeformat = (isset($timeformat)) ? $timeformat : "g:i A";    # 12.15am
$offset     = (isset($offset))     ? $offset     : "now";     # $offset = "-1 month";   # you can use "+1 hour" here for example. Time offset - if times are appearing too early or too late on your website, change this.

$order          = (isset($order))          ? $order          : 'a';   # Order of Output.  True for Reverse Chronilogical and False for Chronilogical
$showPastEvents = (isset($showPastEvents)) ? $showPastEvents : 1;     # Show Events For This Many Days Out
$lastEvent      = (isset($lastEvent))      ? $lastEvent      : 30;    # Show Events For This Many Days Out
$maxEvents      = (isset($maxEvents))      ? $maxEvents      : 30;    # Show only this many events
$skipEvents     = (isset($skipEvents))     ? $skipEvents     : 0;     # Skip this many events.  This way you can make two snippet calls and jump around
$debug          = (isset($debug))          ? $debug          : false; # Change this to 'true' to see some debug code
$howMany        = (isset($howMany))        ? $howMany        : 200;   # ...and how many you want to display (leave at 999 for everything)
$GroupByDate    = (isset($GroupByDate))    ? $GroupByDate    : false; # Change the above to 'false' if you don't want to group this by dates, but remember to add ###DATE### in the event_display if you do.
$disableCache   = (isset($disableCache))   ? $disableCache   : false;  # disable cache? Good for screencasts and adding many new items
$showAlways     = (isset($showAlways))     ? $showAlways     : true; # Always show the full calendar?

$docId          = $modx->documentIdentifier;
$thisURL        = $modx->makeUrl($docId);
#$thisURL       = 'http://localhost/Tests/Calendar2/gcal.php';    #non-modx site
#$basePath      = dirname(__FILE__) . '/';                        #non-modx site

/****************************************************/
/*************** End of Configuration ***************/
/****************************************************/
$debugOutput = '';

$dayID = false; # init false to display current day
extract($_GET);    
$yearID  = isset($_GET['yearID'])? $yearID : gmdate('Y');
$monthID = isset($_GET['monthID'])? $monthID : gmdate('m');
    
$startMax = gmdate('Y-m-d',mktime(0, 0, 0, gmdate($monthID)  , gmdate("d")+$lastEvent, gmdate($yearID)));
$startMin = gmdate('Y-m-d',mktime(0, 0, 0, gmdate($monthID)  , gmdate("d")-$lastEvent, gmdate($yearID)));

if ($showPastEvents == '0')
{
    $startMin = date("Y-m-d");
}

# Initialize Calendar class
    require_once ($basePath.'classes/class.Calendar_Events.php'); # The Calendar Class
    $calendar = new Calendar_Events ($yearID, $monthID );
    $calendar->setDayNameFormat('%a');
    $calendar->url = $thisURL;
    $calendar->tpl['calendar']      = file_get_contents($basePath. 'template/calendar.tpl');
    $calendar->tpl['dayNoEvent']    = file_get_contents($basePath. 'template/dayNoEvent.tpl');
    $calendar->tpl['dayWithEvent']  = file_get_contents($basePath. 'template/dayWithEvent.tpl');
    $calendar->tpl['eachEvent']     = file_get_contents($basePath. 'template/eachEvent.tpl');
    $calendar->tpl['notInMonth']    = file_get_contents($basePath. 'template/notInMonth.tpl');
    
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

//
//End of configuration block
/////////



if ($debug) {
    error_reporting (E_ALL);
    $debugOutput .= "<h1>monthID: $monthID</h1><h1>yearID: $yearID</h1>";
    $debugOutput .= "<P>Debug mode is on.</p>";
}

// Make sure that correct version of SimplePie is loaded
if (SIMPLEPIE_VERSION<1) { 
    echo "<P><B>Fatal error</b><BR>You need to be running SimplePie v1.0 or above for this to work.</p>"; 
    die; 
}

// Form the XML address.
$calendar_xml_address = "http://www.google.com/calendar/feeds/".$email."/public/full?start-min=".$startMin.'&start-max='.$startMax."&max-results=2500&orderby=starttime&sortorder=$order&singleevents=true";

// Set the offset correctly
$offset=(strtotime("now")-strtotime($offset));

// 
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


if($feed->get_items()) 
{
    foreach ($feed->get_items() as $item) {
     
        // We want to grab the Google-namespaced <gd:when> tag.
        $when = $item->get_item_tags('http://schemas.google.com/g/2005', 'when');
     
        // Now, let's grab the Google-namespaced <gd:where> tag.
        $gd_where = $item->get_item_tags('http://schemas.google.com/g/2005', 'where');
        $location = $gd_where[0]['attribs']['']['valueString'];
        //and the status tag too, come to that
        $gd_status = $item->get_item_tags('http://schemas.google.com/g/2005', 'eventStatus');
        $status = substr( $gd_status[0]['attribs']['']['value'], -8);
     
        $when = $item->get_item_tags('http://schemas.google.com/g/2005', 'when');
        $startdate = $when[0]['attribs']['']['startTime']; 
        $enddate = $when[0]['attribs']['']['endTime']; 
        $unixstartdate = getGoogleDate($startdate);
        $unixenddate = getGoogleDate($enddate);
        $where = $item->get_item_tags('http://schemas.google.com/g/2005', 'where'); 
        $location = $where[0]['attribs']['']['valueString']; 
    
        // If there's actually a title here (private events don't have titles) and it's not cancelled...
    if (strlen(trim($item->get_title()))>1 && $status != "canceled" && strlen(trim($startdate)) > 0) 
    {
            $temp[] = array(
                            'startDate'     => gmdate($dateformat, $unixstartdate - $offset), 
                            'startTime'     => gmdate($timeformat, $unixstartdate - $offset),
                            'endDate'       => gmdate($dateformat, $unixenddate - $offset),
                            'endTime'       => gmdate($timeformat, $unixenddate - $offset), 
                            'where'         => $location, 
                            'title'         => $item->get_title(), 
                            'description'   => $item->get_description(), 
                            'link'          => $item->get_link(),
                            'starts'        => gmdate('g:i A', $unixstartdate - $offset),
                            'ends'          => gmdate('g:i A', $unixenddate - $offset),
                            'startDay'      => gmdate('j', $unixstartdate - $offset),
                            'startMonth'    => gmdate('n', $unixstartdate - $offset),
                            'startYear'     => gmdate('Y', $unixstartdate - $offset),
                            'endDay'        => gmdate('j', $unixenddate - $offset),
                            'endMonth'      => gmdate('n', $unixenddate - $offset),
                            'endYear'       => gmdate('Y', $unixenddate - $offset),
                );
                
            if ($debug) { 
                $debugOutput .= "<br/>Added ".$item->get_title();
            }
        } 
    
    }
    
    # Sort the bookings into time order
    if ($order != "d")
    { 
        sort($temp);  # Sort the events into chronological order.
    } 
    else 
    {
        rsort($temp);
    }
}

if ($debug) {
    $debugOutput .= '<pre>';
    $debugOutput .= print_r($temp, true);
    $debugOutput .= '</pre>';
}

$items_shown=0; 
$old_date="";
$output = '';
// Loop through the (now sorted) array, and display what we wanted.
foreach ($temp as $item) 
{

    if (($howMany>0 && $items_shown<$howMany)) 
    {

        if ($item['startMonth'] == $monthID)
        {
            $calendar->addEvent($item['startDay'], $item);
        }
        
        if ($GroupByDate) 
        {
            if ($gCalDate!=$old_date) 
            { 
                $output .= $temp_dateheader;
                $old_date=$gCalDate;
            }
        }

        $output .= $temp_event;
        $items_shown++;
    }
}

if ($items_shown != 0 || $showAlways != false)
{
    echo $calendar->display();
} else {
    echo $event_error; 
}

if ($debug) { 
    $debugOutput .= "<pre>";
    $debugOutput .= wordwrap(highlight_string(file_get_contents($calendar_xml_address),true),80);
    $debugOutput .= "</pre>";
    
    echo $debugOutput;
}


?>