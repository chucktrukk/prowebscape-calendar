<?php
require_once( dirname(__FILE__).'/class.Calendar.php' );
class Calendar_Events extends Calendar
{
    
    var $url;
    var $template = array();
    
    /**
    * Returns markup for displaying the calendar.
    *
    * @return
    * @public
    */
    function display ( )
    {
        $data = array(
                        'url'           => $this->url,
                        'dayNames'      => $this->dspDayNames(),
                        'calendar'      => $this->dspDayCells(),
            );
        
        $data = array_merge($data, $this->dspNavigation());
        
        $output = $this->tpl['calendar'];
        foreach ($data as $k => $v)
        {
            $output = str_replace('[+' . $k . '+]', $v, $output);
        }
        
        return $output;
    }

    function dspNavigation()
    {
        
        $yr = $nextYear = $previousYear = $this->getYear();
        $mo = $this->getMonth();
        $prevYear = $yr -1;
        $nextYear = $yr +1;
                        
        $prevMonth      = gmdate('m',mktime('6', '1', '1', gmdate($mo)-1 , '6', $yr));
        $prevMonthName  = gmdate('F',mktime('6', '1', '1', gmdate($mo)-1 , '6', $yr));
        $nextMonth      = gmdate('m',mktime('6', '1', '1', gmdate($mo)+1 , '6', $yr));
        $nextMonthName  = gmdate('F',mktime('6', '1', '1', gmdate($mo)+1 , '6', $yr));
                
        $prevLink  = 'year='.$yr.'&month='.$prevMonth;
        $nextLink  = 'year='.$yr.'&month='.$nextMonth;

        if ($mo == '1')
        {
            $prevLink = 'year='.$prevYear.'&month='.$prevMonth;
        }
        elseif ($mo == '12')
        {
            $nextLink = 'year='.$nextYear.'&month='.$nextMonth;
        }
        
                
        $data = array(
                        'monthName'     => $this->getFullMonthName(),
                        'nextMonth'     => $nextMonth,
                        'nextMonthName' => $nextMonthName,
                        'prevMonth'     => $prevMonth,
                        'prevMonthName' => $prevMonthName,
                        'nextYear'      => $nextYear,
                        'prevYear'      => $prevYear,
                        'nextLink'      => $nextLink,
                        'prevLink'      => $prevLink,
                        'thisYear'      => $yr,
            );


        return $data;
    }

    /**
    * Displays the row of day names.
    *
    * @return string
    * @private
    */
    function dspDayNames ( )
    {
        $names = array('2004-10-24','2004-10-25','2004-10-26','2004-10-27','2004-10-28'
                      ,'2004-10-29','2004-10-30',);
        
        $output = '<tr>';
    
        for( $i=0; $i<7; $i++ ) 
        {
            $output .= '<th width="14%">'.strftime( $this->dayNameFmt, strtotime($names[$i]) ).'</th>';
        }
    
        $output .= '</tr>';
        return $output;
    }

    /**
    * Displays all day cells for the month
    *
    * @return string
    * @private
    */
    function dspDayCells ( )
    {
        $i = 0; // cell counter
    
        $output = '<tr>';
    
        // first display empty cells based on what weekday the month starts in]
        for( $c=0; $c<$this->startOffset; $c++ ) 
        {
            $i++;
            
            $output .= $this->tpl['notInMonth'];
            
        } // end offset cells
    
        // write out the rest of the days, at each sunday, start a new row.
        for( $d=1; $d<=$this->endDay; $d++ )
        {
            $i++;
            
            $output .= $this->dspDayCell( $d );
    
            if ( $i%7 == 0 ) 
            {
                $output .= '</tr>';
            }
            
            if ( $d<$this->endDay && $i%7 == 0 ) 
            {
                $output .= '<tr>';
            }
        }
        
        // fill in the final row
        $left = 7 - ( $i%7 );
        
        if ( $left < 7)  
        {
            for ( $c=0; $c<$left; $c++ )
            { 
              #$output .= '<td class="notInMonth">&nbsp;</td>';
              $output .= $this->tpl['notInMonth'];
            }
            $output .= '</tr>';
        }    
    
        return $output;       
    }

    /**
    * outputs the contents for a given day
    *
    * @param integer, day
    * @abstract
    */
    function dspDayCell ( $day )
    {
        $eventOutput = '';
        if ($events = $this->getDaysEvents($day))
        {
            $output  = $this->tpl['dayWithEvent'];
            
            foreach ($events as $e)
            {
                $template = $this->tpl['eachEvent'];

                foreach ($e as $k => $v)
                {
                    $template = str_replace('[+' . $k . '+]', $v, $template);
                }
                
                $eventOutput .= $template;
        
            }
        }
        else
        {
            $output  = $this->tpl['dayNoEvent'];        
        }
        
        $output = str_replace('[+day+]', $day, $output);
        $output = str_replace('[+events+]', $eventOutput, $output);        
        
        return $output;
    }

    /**
    * Adds an event on a day
    *
    * @param string $day
    * @param array $array (of all values to be parsed)
    * @return null
    * @access public
    */
    function addEvent($day, $array)
    {
        $this->events[(int) $day][] = $array;
    }

    /**
    * Returns an array of the events on a day.
    *
    * @param integer $day
    * @return array
    * @access private
    */
    function getDaysEvents($day)
    {   
        if (0 < count($this->events[ $day ]))
        {
            return $this->events[$day];
        }
        else
        {
            return FALSE;
        }
    }    
}
?>