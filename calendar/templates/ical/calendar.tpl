<link href="calendar/templates/ical/calendar.css" media="screen" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="calendar/templates/ical/jquery.coda.js"></script>

<div id="calendar-ical">
<table border="0" cellspacing="0" cellpadding="0">
	<thead>
        <tr class="navigation">
            <th class="monthnavigation" colspan="2">
                <a class="previous" href="[+url+][+prevLink+]">&lt;&lt; [+prevMonthName+]</a>
            </th>
            
            <th class="monthname" colspan="3">
                [+monthName+] [+thisYear+]
            </th>
            
            <th class="monthnavigation" colspan="2">
                <a class="next" href="[+url+][+nextLink+]">[+nextMonthName+] &gt;&gt;</a>
            </th>
        </tr>    
        <tr>
            <th>Sun</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th>Sat</th>
        </tr>
	</thead>
	
        [+calendar+]

	<tfoot>        
        <tr>
            <th>Sun</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th>Sat</th>
        </tr>
	</tfoot>
</table>
</div>