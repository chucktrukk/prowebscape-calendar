<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
        
		<title>Demo - Calendar</title>
		
        <meta name="description" content="">
        <meta name="keywords" content="">
		
        <link   type="text/css"       href="tpl-default/css/all.css" media="screen" rel="stylesheet" />
        <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.cookie.js"></script>
        
<script type="text/javascript">
	$(function() {
		var which_tab = $.cookie('which_tab') || 0; 

		$("#tabs").tabs({
			selected: which_tab,
			select: function(e,ui){ 
			    $.cookie('which_tab', ui.index); 
			} 			
		});
	});
</script>

	</head>
<body>
<div class="download" style="background: #000; color: #fff; border: 1px solid #e3e3e3; height: 100px; line-height: 100px; text-align: center">
<a href="http://github.com/chucktrukk/prowebscape-calendar/tree/master" style="color: yellow; font-size: 24px">Download from Github</a>
</div>

<div class="container">
	<div class="header">
	</div>

    <div class="content">
    <div class="content-wrap">
		<div id="tabs">
			<ul>
				<li><a href="#mini-calendar">Mini Calendar</a></li>
				<li><a href="#default-calendar">Default Calendar</a></li>
				<li><a href="#ical">iCal Example</a></li>
				<li><a href="#event-list">Event List</a></li>
				<li><a href="#instructions">Instructions</a></li>
			</ul>
			
			<div id="mini-calendar">
				<h2>Mini Calendar</h2>
				
				<div class="info">
					<h3>Snippet call:</h3>
					[!Calendar? &email=`usa__en@holiday.calendar.google.com` &offset=`-2 hours` &template=`mini`!]
					<h3>Template Files</h3>
					<a class="code" href="calendar/templates/mini/calendar.css">calendar.css</a>
					<a class="code" href="calendar/templates/mini/calendar.tpl">calendar.tpl</a>
					<a class="code" href="calendar/templates/mini/dayNoEvent.tpl">dayNoEvent.tpl</a>
					<a class="code" href="calendar/templates/mini/dayWithEvent.tpl">dayWithEvent.tpl</a>
					<a class="code" href="calendar/templates/mini/eachEvent.tpl">eachEvent.tpl</a>
					<a class="code" href="calendar/templates/mini/notInMonth.tpl">notInMonth.tpl</a>
				</div>
				<?php
					$useModx	= false;
				    $basePath 	= 'calendar/';
				    $emails     = 'usa__en@holiday.calendar.google.com';
				    $offset     = '-2 hours';
				    $template   = 'mini';
				    include 'calendar/calendar.inc.php';
				?>
			</div>
			<div id="default-calendar">
				<h2>Default Calendar</h2>

				<div class="info">
					<h3>Snippet call:</h3>
					[!Calendar? &email=`usa__en@holiday.calendar.google.com,christian__en@holiday.calendar.google.com` &offset=`-2 hours` &template=`default`!]
					<h3>Template Files</h3>
					<a class="code" href="calendar/templates/default/calendar.css">calendar.css</a>
					<a class="code" href="calendar/templates/default/calendar.tpl">calendar.tpl</a>
					<a class="code" href="calendar/templates/default/dayNoEvent.tpl">dayNoEvent.tpl</a>
					<a class="code" href="calendar/templates/default/dayWithEvent.tpl">dayWithEvent.tpl</a>
					<a class="code" href="calendar/templates/default/eachEvent.tpl">eachEvent.tpl</a>
					<a class="code" href="calendar/templates/default/notInMonth.tpl">notInMonth.tpl</a>
				</div>
				
				<?php
					$emails		= 'usa__en@holiday.calendar.google.com,christian__en@holiday.calendar.google.com';
				    $template   = 'default';
				    include 'calendar/calendar.inc.php';
				?>
			</div>
			<div id="ical">
				<h2>iCalendar example</h2>

				<div class="info">
					<h3>Inspiration</h3>
					From: <a href="http://www.stefanoverna.com/log/create-astonishing-ical-like-calendars-with-jquery">http://www.stefanoverna.com/log/create-astonishing-ical-like-calendars-with-jquery</a>
					
					<h3>Snippet call:</h3>
					[!Calendar? &email=`usa__en@holiday.calendar.google.com` &offset=`-2 hours` &display=`calendar` &template=`ical`!]
					
					<h3>Template Files</h3>
					<a class="code" href="calendar/templates/ical/calendar.css">calendar.css</a>
					<a class="code" href="calendar/templates/ical/calendar.tpl">calendar.tpl</a>
					<a class="code" href="calendar/templates/ical/dayNoEvent.tpl">dayNoEvent.tpl</a>
					<a class="code" href="calendar/templates/ical/dayWithEvent.tpl">dayWithEvent.tpl</a>
					<a class="code" href="calendar/templates/ical/eachEvent.tpl">eachEvent.tpl</a>
					<a class="code" href="calendar/templates/ical/notInMonth.tpl">notInMonth.tpl</a>
				</div>
				
				<?php
					$emails		= 'usa__en@holiday.calendar.google.com,christian__en@holiday.calendar.google.com';
				    $template   = 'ical';
				    $display    = 'calendar';
				    include 'calendar/calendar.inc.php';
				?>
			</div>
			<div id="event-list">
				<h2>Event List</h2>

				<div class="info">
					<h3>Snippet call:</h3>
					[!Calendar? &email=`usa__en@holiday.calendar.google.com` &offset=`-2 hours` &template=`list` <strong>&display=`list`</strong>!]
					
					<h3>Template Files</h3>
					<a class="code" href="calendar/templates/default/event-list.css">event-list.css</a>
					<a class="code" href="calendar/templates/default/eachEvent.tpl">eachEvent.tpl</a>
					<a class="code" href="calendar/templates/default/eachEventAlt.tpl">eachEventAlt.tpl</a>
					<a class="code" href="calendar/templates/default/wrapper.tpl">wrapper.tpl</a>
				</div>
				
				<?php
					$emails		= 'usa__en@holiday.calendar.google.com,christian__en@holiday.calendar.google.com';
				    $template   = 'list';
				    $display    = 'list';
				    include 'calendar/calendar.inc.php';
				?>
			</div>			
			<div id="instructions">
				<h2>Instructions</h2>
			
				<h3>Install on modx</h3>
				<ol class="install">
					<li>Upload 'calendar' to /assets/snippets/calendar/</li>
					<li>Create a new snippet called 'Calendar'</li>
					<li>Snippet Description: '<strong>1.0</strong>'</li>
					<li>Paste the following as the snippet code:
						<br/>$basePath = $modx->config['base_path'] . '/assets/snippets/calendar/';
						<br/>include $basePath . 'calendar.inc.php'
					</li>
				</ol>
				
				<h3>Available snippet parameters</h3>
					<ul class="parameters">
						<li>
							<span class="name">useModx</span>
							<span class="value">true or false</span>
							<span class="details">Default: true. You can use this thing outside of modx. How cool is that?</span>
						</li>
						<li>
							<span class="name">emails</span>
							<span class="value">any google calendar email</span>
							<span class="details">Default: usa__en@holiday.calendar.google.com. You can use multiple calendars seperated by a comma</span>
						</li>
						<li>
							<span class="name">offset</span>
							<span class="value">+1 hour, +3 hours, -4 hours</span>
							<span class="details">Default: now. If the times are wrong on the calendar, you can fix them by setting the offset</span>
						</li>
						<li>
							<span class="name">order</span>
							<span class="value">true or false</span>
							<span class="details">Default: true. True sorts ascending. False sorts descending.</span>
						</li>
						<li>
							<span class="name">useCache</span>
							<span class="value">true or false</span>
							<span class="details">Default: true. You only want to turn this off if you are debugging or demoing this to a client.</span>
						</li>
						<li>
							<span class="name">template</span>
							<span class="value">name of folder inside calendar/templates/</span>
							<span class="details">Default: default.</span>
						</li>
						<li>
							<span class="name">display</span>
							<span class="value">calendar or list</span>
							<span class="details">Default: calendar. Do you want to show the calendar or an ordered list?</span>
						</li>
						<li>
							<span class="name">limit</span>
							<span class="value">any number</span>
							<span class="details">Default: 10. This is for display: list. And it's buggy. Anyone want to fix it?</span>
						</li>
						<li>
							<span class="name">showPastEvents</span>
							<span class="value">true or false</span>
							<span class="details">Default: true. You probably only want to set this false for display: list</span>
						</li>
					</ul>
					
					<h3>Available template placeholders</h3>
					<ul class="placeholders">
						<li>
							<span class="name">[+startDate+]</span>
							<span class="value">M j, y g:i</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+endDate+]</span>
							<span class="value">M j, y g:i</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+pubDate+]</span>
							<span class="value">M j, y g:i</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+title+]</span>
							<span class="value">Title of event</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+where+]</span>
							<span class="value">Location of event</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+link+]</span>
							<span class="value">Link to event page in google calendar</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+status+]</span>
							<span class="value">onfirmed really means confirmed</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+description+]</span>
							<span class="value">Description of event</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+startDay+], [+endDay+]</span>
							<span class="value">Day of the month without leading zeros - 1 to 31</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+startMonth+], [+endMonth+]</span>
							<span class="value">Numeric representation of a month, without leading zeros - 1 through 12</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+startYear+], [+endYear+]</span>
							<span class="value">A full numeric representation of a year, 4 digits - Examples: 1999 or 2003</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+startHour+], [+endHour+]</span>
							<span class="value">12-hour format of an hour without leading zeros	1 through 12</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+startMinute+], [+endMinute+]</span>
							<span class="value">Minutes with leading zeros - 00 to 59</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+startMeridiem+], [+endMeridiem+]</span>
							<span class="value">Uppercase Ante meridiem and Post meridiem - AM or PM</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+calName+]</span>
							<span class="value">Name of the calendar feed - Example: 'US Holidays'</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+calNameClean+]</span>
							<span class="value">Name of the calendar feed in URL form - Example: 'us-holidays'</span>
							<div class="clear">&nbsp;</div>
						</li>
						<li>
							<span class="name">[+calEmail+]</span>
							<span class="value">Email of the calendar feed</span>
							<div class="clear">&nbsp;</div>
						</li>

					</ul>
			</div>
        </div>
    </div>

</div>
</body>
</html>