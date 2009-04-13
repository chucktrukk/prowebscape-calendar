<link href="calendar/templates/default/calendar.css" media="screen" rel="stylesheet" type="text/css" />
<div id="calendar-full">
<table border="0" cellspacing="2" cellpadding="0" class="month" >

        <tr class="navigation">
            <td class="monthnavigation" colspan="2">
                <a class="previous" href="[+url+][+prevLink+]">&lt;&lt; [+prevMonthName+]</a>
            </td>
            
            <td class="monthname" colspan="3">
                [+monthName+] [+thisYear+]
            </td>
            
            <td class="monthnavigation" colspan="2">
                <a class="next" href="[+url+][+nextLink+]">[+nextMonthName+] &gt;&gt;</a>
            </td>
        </tr>
        
        <tr class="dayname">
            <td>Sunday</td>
            <td>Monday</td>
            <td>Tuesday</td>
            <td>Wednesday</td>
            <td>Thursday</td>
            <td>Friday</td>
            <td>Saturday</td>
        </tr>

        [+calendar+]
</table>
</div>