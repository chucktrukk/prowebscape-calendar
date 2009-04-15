<?php
#$basePath = '/Users/prowebscape/Sites/CMS/MODx/current/assets/snippets/calendar/';
require_once($basePath.'classes/simplepie/simplepie.inc');
require_once($basePath.'classes/class.simplepie-gcalendar.php');
require_once($basePath.'classes/class.Calendar_Events.php');

/* Snippet Parameters */
$useModx     	= (isset($useModx))			? $useModx	 		: true;
$emails      	= (isset($emails))   		? $emails    		: "usa__en@holiday.calendar.google.com";
$offset     	= (isset($offset))  		? $offset   		: "now";
$order      	= (isset($order))   		? $order    		: true;
$useCache   	= (isset($useCache))		? $useCache 		: true;
$template   	= (isset($template))		? $template 		: 'default';
$display    	= (isset($display)) 		? $display  		: 'calendar';
$limit      	= (isset($limit))   		? $limit    		: 10;
$showPastEvents	= (isset($showPastEvents))  ? $showPastEvents   : true;
/* end of Snippet Parameters */

extract($_GET);    
$year  = isset($_GET['year'])   ? $year     : date('Y');
$month = isset($_GET['month'])  ? $month    : date('m');

$startMin = gmdate('Y-m-d',mktime(0, 0, 0, gmdate($month)-2  , gmdate("d"), gmdate($year)));
$startMax = gmdate('Y-m-d',mktime(0, 0, 0, gmdate($month)+2  , gmdate("d"), gmdate($year)));

if (!$showPastEvents) {
    $startMin = date("Y-m-d");
}

/* Set URL to use */
if ($useModx) {
	/* Modx Site */
	$docId     	= $modx->documentIdentifier;
	$this_page 	= $modx->makeUrl($docId);

	$url_arg	= '&';
	if($modx->config['friendly_urls'] == 1) {
  		$arg = '?';
	}
	
	$this_page .= $url_arg;
} else {
	/* Non-Modx Site */
	$this_page = basename($_SERVER['REQUEST_URI']);
	if (strpos($this_page, "?") !== false) $this_page = reset(explode("?", $this_page));
	$this_page  = 'index.php';
	$this_page .= '?';
}

$emails = explode(',', $emails);
$urls 	= array();
foreach ($emails as $email){
	$urls[] = SimplePie_GCalendar::create_feed_url($email);
}
$feed = new SimplePie_GCalendar();

    /* GCalendar Parameters */
    $feed->set_show_past_events(1);
    $feed->set_sort_ascending(1);
    $feed->set_orderby_by_start_date(1);
    $feed->set_expand_single_events(1);
    $feed->set_start_min_date($startMin);
    $feed->set_start_max_date($startMax);
    $feed->set_max_results();
    $feed->set_cal_query();

    /* SimplePie Parameters */
    if ($useCache)
    $feed->set_cache_location($basePath . 'cache');
    else
    $feed->enable_cache(false);
    
    $feed->set_feed_url($urls);
	$feed->enable_order_by_date(FALSE);
	$feed->init();
	$feed->handle_content_type();
	$gcalendar_data = $feed->get_items();
	
	$cal_dates = array();
	
	for ($i = 0; $i < sizeof($gcalendar_data) ; $i++){
        $item = $gcalendar_data[$i];
		
		$startDate = $item->get_start_time();
		$endDate   = $item->get_end_time();
        $cal_dates[] = array(
                'sortDate'  => $item->get_start_time(),
                'startDate' => date("M j, y g:i", $startDate - $offset),
                'endDate'   => date("M j, y g:i", $endDate - $offset),
                'pubDate'   => date("M j, y g:i", $item->get_publish_date()),
                'title'     => $item->get_title(),
                'where'     => $item->get_location(),
                'link'      => $item->get_link(),
                'status'    => $item->get_status(),
                'description' => $item->get_description(),
                'startDay'      => date('j', $startDate - $offset),
                'startMonth'    => date('n', $startDate - $offset),
                'startYear'     => date('Y', $startDate - $offset),
                'startHour'     => date('g', $startDate - $offset),
                'startMinute'   => date('i', $startDate - $offset),
                'startMeridiem' => date('A', $startDate - $offset),
                'endDay'        => date('j', $endDate - $offset),
                'endMonth'      => date('n', $endDate - $offset),
                'endYear'       => date('Y', $endDate - $offset),
                'endHour'       => date('g', $endDate - $offset),
                'endMinute'     => date('i', $endDate - $offset),
                'endMeridiem'   => date('A', $endDate - $offset),
            );
	}

$feed->__destruct();
unset($feed);
/* end of SimplePie code */

/* beginning of Sorting */
if ($cal_dates)
{
    $date = array();
    foreach ($cal_dates as $key => $row) {
        $date[$key]  = $row['sortDate'];
    }

    if ($order)
    array_multisort($date, SORT_ASC, $cal_dates);
    else
    array_multisort($date, SORT_DESC, $cal_dates);
}
/* beginning of Sorting */

/* Beginning of Calendar Output Code */
if ($display == 'calendar')
{
    $cal = new Calendar_Events ($year, $month);
        /*Calendar Parser parameters */
        $cal->setDayNameFormat('%a');
        $cal->url = $this_page;
        if ($template)
        {
            $cal->tpl['calendar']      = file_get_contents($basePath. 'templates/' .$template. '/calendar.tpl');
            $cal->tpl['dayNoEvent']    = file_get_contents($basePath. 'templates/' .$template. '/dayNoEvent.tpl');
            $cal->tpl['dayWithEvent']  = file_get_contents($basePath. 'templates/' .$template. '/dayWithEvent.tpl');
            $cal->tpl['eachEvent']     = file_get_contents($basePath. 'templates/' .$template. '/eachEvent.tpl');
            $cal->tpl['notInMonth']    = file_get_contents($basePath. 'templates/' .$template. '/notInMonth.tpl');
        } else {
            $cal->tpl['calendar']      = file_get_contents($basePath. 'templates/default/calendar.tpl');
            $cal->tpl['dayNoEvent']    = file_get_contents($basePath. 'templates/default/dayNoEvent.tpl');
            $cal->tpl['dayWithEvent']  = file_get_contents($basePath. 'templates/default/dayWithEvent.tpl');
            $cal->tpl['eachEvent']     = file_get_contents($basePath. 'templates/default/eachEvent.tpl');
            $cal->tpl['notInMonth']    = file_get_contents($basePath. 'templates/default/notInMonth.tpl');
        }
    
        if ($cal_dates)
        {
    
            foreach ($cal_dates as $date)
            {
                if ($date['status'] != "canceled" && $date['startMonth'] == $month && strlen(trim($date['sortDate'])) > 0)
                {
                    $cal->addEvent($date['startDay'], $date);
                }
            }
            
            #echo '<pre>';
            #print_r($cal_dates);
            #echo '</pre>';
        }
    $output = $cal->display();
}
/* End of Calendar Output */

/* Beginning of List Output */
if ($display == 'list')
{
    $tpl['wrapper']      = file_get_contents($basePath. 'templates/' .$template. '/wrapper.tpl');
    $tpl['eachEvent']    = file_get_contents($basePath. 'templates/' .$template. '/eachEvent.tpl');
    $tpl['eachEventAlt'] = file_get_contents($basePath. 'templates/' .$template. '/eachEventAlt.tpl');

    if ($cal_dates)
    {
        $innerList = '';
        for ($i = 0; $i < $limit; $i++)
        {
        	if ($cal_dates[$i]['startMonth'] == $month )
        	{
	            if($i % 2) 
	            {
	                $eachEvent = $tpl['eachEvent'];
	            } else {
	                $eachEvent = $tpl['eachEventAlt'];
	            }
	            
	            foreach ($cal_dates[$i] as $key => $value)
	            {
	                $eachEvent = str_replace('[+' . $key . '+]', $value, $eachEvent);
	            }
	            
	            $innerList .= $eachEvent;
        	}
        	
        }
        
        $output = str_replace('[+events+]', $innerList, $tpl['wrapper']);
    }

}
/* End of List Output */
/*Do the Output */

echo $output;