<?php
/**
 * GCalendar is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GCalendar is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GCalendar.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Allon Moritz
 * @copyright 2007-2009 Allon Moritz
 * @version $Revision: 0.2.0 $
 */

if (!defined('SIMPLEPIE_NAMESPACE_GOOGLE_CALENDAR_ITEM')) {
	define('SIMPLEPIE_NAMESPACE_GOOGLE_CALENDAR_ITEM', 'http://schemas.google.com/g/2005');
}

if (!defined('SIMPLEPIE_NAMESPACE_GOOGLE_CALENDAR_FEED')) {
	define('SIMPLEPIE_NAMESPACE_GOOGLE_CALENDAR_FEED', 'http://schemas.google.com/gCal/2005');
}

/**
 * SimplePie_GCalendar is the SimplePie extension which provides some
 * helper methods as well as a correct sorting of the items.
 */
class SimplePie_GCalendar extends SimplePie {

	var $show_past_events = TRUE;
	var $sort_ascending = TRUE;
	var $orderby_by_start_date = TRUE;
	var $expand_single_events = TRUE;
	var $start_min_date = "";
	var $start_max_date = "";
	var $max_results = 2500;
	var $cal_language = "";
	var $cal_query = "";
	var $meta_data = array();

	/**
	 * If the method $this->get_items() should include past events.
	 */
	function set_show_past_events($value = FALSE){
		$this->show_past_events = $value;
	}

	/**
	 * If is set to true the closest event is the first in the returning items.
	 * So it makes sense to call enable_order_by_date(false) before fetching
	 * the data to prevent from sorting twice.
	 */
	function set_sort_ascending($value = TRUE){
		$this->sort_ascending = $value;
	}

	/**
	 * The method $this->get_items() will return the events ordered by
	 * the start date if set to true otherwise by the publish date.
	 *
	 */
	function set_orderby_by_start_date($value = TRUE){
		$this->orderby_by_start_date = $value;
	}

	/**
	 * If the method $this->get_items() should treat reccuring events
	 * as one item.
	 */
	function set_expand_single_events($value = TRUE){
		$this->expand_single_events = $value;
	}

	/**
	 * Sets the start date of the feed. If empty it
	 * will be today.
	 */
	function set_start_min_date($value = ""){
		$this->start_min_date = $value;
	}

	/**
	 * Sets the end date of the feed. If empty it
	 * will be next month.
	 */
	function set_start_max_date($value = ""){
		$this->start_max_date = $value;
	}

	/**
	 * Sets the end date of the feed. If empty it
	 * will be next month.
	 */
	function set_max_results($value = 2500){
		$this->max_results = $value;
	}
		
	/**
	 * Sets the language of the feed. Something like
	 * en or en_GB or de.
	 */
	function set_cal_language($value = ""){
		$this->cal_language = $value;
	}
	
	/**
	 * If this parameter is set the feed will just contain events
	 * which contain the given parameter in the titel or the description.
	 * 
	 * @param $value
	 */
	function set_cal_query($value = ""){
		$this->cal_query = $value;
	}

	/**
	 * Overrides the default ini method and sets automatically
	 * SimplePie_Item_GCalendar as item class.
	 * It ensures that the feed url is correct if $calendar_type=='full'.
	 */
	function init(){
		$this->set_item_class('SimplePie_Item_GCalendar');

		$new_url;
		if (!empty($this->multifeed_url)){
			$tmp = array();
			foreach ($this->multifeed_url as $value)
			$tmp[] = $this->check_url($value);
			$new_url = $tmp;
		}else
		$new_url = $this->check_url($this->feed_url);
		$this->set_feed_url($new_url);

		parent::init();
	}

	/**
	 * Creates an url depending on the variables $show_past_events, etc.
	 * and returns a valid google calendar feed url.
	 */
	function check_url($url_to_check){
		$tmp = str_replace("/basic","/full",$url_to_check);
		if(!strpos($tmp,'?'))
		$tmp = $this->append($tmp,'?');
		else{
			if(!(substr($tmp, -1) === '&'))
			$tmp = $this->append($tmp,'&');
		}
		if($this->show_past_events)
		$tmp = $this->append($tmp,'futureevents=false&');
		else
		$tmp = $this->append($tmp,'futureevents=true&');
		if($this->sort_ascending)
		$tmp = $this->append($tmp,'sortorder=ascending&');
		else
		$tmp = $this->append($tmp,'sortorder=descending&');
		if($this->orderby_by_start_date)
		$tmp = $this->append($tmp,'orderby=starttime&');
		else
		$tmp = $this->append($tmp,'orderby=lastmodified&');
		if($this->expand_single_events)
		$tmp = $this->append($tmp,'singleevents=true&');
		else
		$tmp = $this->append($tmp,'singleevents=false&');
		if($this->start_min_date)
		$tmp = $this->append($tmp,'start-min=' . $this->start_min_date . '&');
		else
		$tmp = $this->append($tmp,'start-min=' .date('Y-m-d', mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))). '&');
		if($this->start_max_date)
		$tmp = $this->append($tmp,'start-max=' .$this->start_max_date. '&');
		else
		$tmp = $this->append($tmp,'start-max=' .date('Y-m-d', mktime(0, 0, 0, date('m')+2, date('d'), date('Y'))). '&');
		if($this->max_results)
		$tmp = $this->append($tmp,'max-results=' .$this->max_results. '&');
		else
		$tmp = $this->append($tmp,'max-results=2500&');
		if(!empty($this->cal_language))
		$tmp = $this->append($tmp,'hl='.$this->cal_language.'&');
		if(!empty($this->cal_query))
		$tmp = $this->append($tmp,'q='.$this->cal_query.'&');
		return $tmp;
	}

	/**
	 * Internal helper method to append a straing to an other one.
	 */
	function append($value, $appendix){
		$pos = strpos($value,$appendix);
		if($pos === FALSE)
		$value .= $appendix;
		return $value;
	}

	/**
	 * Returns the timezone of the feed.
	 */
	function get_timezone(){
		$tzvalue = $this->get_feed_tags(SIMPLEPIE_NAMESPACE_GOOGLE_CALENDAR_FEED, 'timezone');
		return $tzvalue[0]['attribs']['']['value'];
	}

	/**
	 * Sets the given value for the given key which is accessible in the get(...) method.
	 * @param $key
	 * @param $value
	 */
	function put($key, $value){
		$this->meta_data[$key] = $value;
	}

	/**
	 * Returns the value for the given key which is set in the set(...) method.
	 * @param $key
	 * @return the value
	 */
	function get($key){
		return $this->meta_data[$key];
	}

	/**
	 * Creates a valid feed url for the given email address.
	 * If the magic cookie parameter is set it will return the private feed url.
	 */
	function create_feed_url($email_address, $magic_cookie = null){
		$type = 'public';
		if($magic_cookie != null)
		$type = 'private-'.$magic_cookie;

		return 'http://www.google.com/calendar/feeds/'.$email_address.'/'.$type.'/full';
	}
}

/**
 * The GCalendar Item which provides more google calendar specific
 * functions like the location of the event, etc.
 */
class SimplePie_Item_GCalendar extends SimplePie_Item {

	function get_id(){
		return substr($this->get_link(),strpos(strtolower($this->get_link()),'eid=')+4);
	}

	function get_publish_date(){
		$pubdate = $this->get_date('Y-m-d\TH:i:s\Z');
		return SimplePie_Item_GCalendar::tstamptotime($pubdate);
	}

	function get_location(){
		$gd_where = $this->get_item_tags(SIMPLEPIE_NAMESPACE_GOOGLE_CALENDAR_ITEM, 'where');
		return $gd_where[0]['attribs']['']['valueString'];
	}

	function get_status(){
		$gd_where = $this->get_item_tags(SIMPLEPIE_NAMESPACE_GOOGLE_CALENDAR_ITEM, 'eventStatus');
		return substr( $gd_where[0]['attribs']['']['value'], -8);
	}

	function get_start_time($as_timestamp = TRUE){
		$when = $this->get_item_tags(SIMPLEPIE_NAMESPACE_GOOGLE_CALENDAR_ITEM, 'when');
		$startdate = $when[0]['attribs']['']['startTime'];
		if($as_timestamp)
		return SimplePie_Item_GCalendar::tstamptotime($startdate);
		return $startdate;
	}

	function get_end_time($as_timestamp = TRUE){
		$when = $this->get_item_tags(SIMPLEPIE_NAMESPACE_GOOGLE_CALENDAR_ITEM, 'when');
		$enddate = $when[0]['attribs']['']['endTime'];
		if($as_timestamp)
		return SimplePie_Item_GCalendar::tstamptotime($enddate);
		return $enddate;
	}

	function tstamptotime($tstamp) {
		// converts ISODATE to unix date
		// 1984-09-01T14:21:31Z
		sscanf($tstamp,"%u-%u-%uT%u:%u:%uZ",$year,$month,$day,$hour,$min,$sec);
		$newtstamp=mktime($hour,$min,$sec,$month,$day,$year);
		return $newtstamp;
	}

	function compare($gc_sp_item1, $gc_sp_item2){
		$time1 = $gc_sp_item1->get_start_time();
		$time2 = $gc_sp_item2->get_start_time();
		if(!$gc_sp_item1->get_feed()->orderby_by_start_date){
			$time1 = $gc_sp_item1->get_publish_date();
			$time2 = $gc_sp_item2->get_publish_date();
		}
		return $time1-$time2;
	}

    function get_name() {
    	$gd_who = $this->get_item_tags(SIMPLEPIE_NAMESPACE_GOOGLE_CALENDAR_ITEM, 'who');
    	return $gd_who[0]['attribs']['']['valueString'];
    }
    
    function get_email() {
    	$gd_who = $this->get_item_tags(SIMPLEPIE_NAMESPACE_GOOGLE_CALENDAR_ITEM, 'who');
    	return $gd_who[0]['attribs']['']['email'];    
    }
}