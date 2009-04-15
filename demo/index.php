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
<a href="#" style="color: yellow; font-size: 24px">click me to Download Snippet. (not available)</a>
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
				<p>Coming soon...</p>
			</div>
        </div>
    </div>

</div>
</body>
</html>