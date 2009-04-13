<link href="calendar/templates/mini/calendar.css" media="screen" rel="stylesheet" type="text/css" />
<div id="calendar-mini">
<table border="0" cellspacing="2" cellpadding="0" class="month" >

        <tr class="navigation">
            <td class="monthnavigation" colspan="2">
                <a class="previous" href="[+url+][+prevLink+]">&lt;&lt;</a>
            </td>
            
            <td class="monthname" colspan="3">
                [+monthName+]
            </td>
            
            <td class="monthnavigation" colspan="2">
                <a class="next" href="[+url+][+nextLink+]">&gt;&gt;</a>
            </td>
        </tr>
        
        <tr class="dayname">
            <td>Sun</td>
            <td>Mon</td>
            <td>Tue</td>
            <td>Wed</td>
            <td>Thu</td>
            <td>Fri</td>
            <td>Sat</td>
        </tr>

        [+calendar+]
</table>
</div>