<?php
/***************************************************************************
 *   awEventCalendar                                                       *
 *                                                                         *
 *   Copyright (C) 2006-2008 Artur Wiebe                                   *
 *   wibix@gmx.de                                                          *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 ***************************************************************************/
$locale['EC000'] = "awEventCal";
$locale['EC001'] = "Events";
$locale['EC002'] = "Notice";
$locale['EC003'] = "Warning";
$locale['awec_no_events']	= 'No events.';
$locale['EC005'] = "About...";
$locale['EC006']	= 'Sure you want to delete?';
$locale['EC007'] = "My";
$locale['awec_logins'] = "Registrations";
$locale['EC009'] = "Month";
$locale['EC010'] = "Year";
$locale['EC011'] = "Search";
$locale['awec_week']	= 'Week';
//
$locale['EC013'] = "New Events";
$locale['awec_user_birthday']	= array(
	'title'	=> '%ss birthday',
	'body'	=> '%1 is %2 years old.',
);
$locale['awec_user']		= 'User birthday';
$locale['awec_link']		= 'Link to the event';

$locale['awec_add']		= 'Add';
$locale['awec_save_changes']	= 'Save Changes';
$locale['awec_edit']		= 'Edit';
$locale['awec_none']		= '[None]';
$locale['awec_name']		= 'Name';
$locale['awec_or']		= 'or';
$locale['awec_export']		= 'Export';
$locale['awec_login_start']	= 'Login Begin';
$locale['awec_login_end']	= 'Login End';
$locale['awec_status']		= 'Status';
$locale['awec_publish']		= 'Publish';

$locale['awec_today']		= 'Today';

$locale['awec_location']	= 'Location';

$locale['awec_calendar_view'] = array(
	'week'	=> 'Week',
	'month'	=> 'Month',
	'year'	=> 'Year',
);


// edit_event.php
$locale['EC100'] = "New Event";
$locale['EC101'] = "Edit Event";
$locale['EC102'] = "To Event";
$locale['EC103'] = "Title";
$locale['awec_description'] = 'Description';
$locale['awec_date']	= 'Date';
$locale['awec_beginn']	= 'From';
$locale['awec_end']	= 'To';
$locale['awec_options'] = "Options";
$locale['awec_repeat'] = "Repeat";
$locale['EC108'] = "Private event";
$locale['EC109'] = "Allow registrations to event";
$locale['EC110'] = "Maximum registrations (0 means infinite)";
$locale['EC110_1'] = "0 for infinite";
$locale['EC111'] = "Save";
$locale['EC112'] = "Deactivate smileys";
$locale['EC113'] = array(
	0		=> 'Event successfully updated!',
	EC_ELOGIN	=> "No registrations for private events allowed.",
	EC_EDB		=> "Error while updating database.",
	EC_ESTATUS	=> "This event has to be released by an admin.",
	EC_EACCESS	=> "No access limits for private events allowed.",
	EC_EIMG		=> "Invalid picture upload.",
	'date'		=> "Invalid date",
	'end_date'	=> 'Repeat util: Invalid date',
);
$locale['EC114'] = "Registrations for this event not possible.";
$locale['EC115'] = array(
	1 => "Maximum number of registrations reached.",
	2 => "Invalid status value.",
	3 => "Could not update status of registration.",
	4 => "No receiver specified.",
);
$locale['EC116'] = "Access";
//$locale['EC117'] = "";
$locale['awec_mandatory']	= '(mandatory)';
$locale['awec_break']		= '** The text after %s, won\'t appear in the side panel. This way you can avoid overfilled side panel.';
$locale['EC119'] = "Please fill out all mandatory fields (*)!";
$locale['awec_date_fmt']	= 'Day.Month.Year Hour:Minutes';
$locale['awec_time_fmt']	= 'Hours:Minutes';
$locale['EC121'] = "Picture";
$locale['EC122'] = "Misc";
$locale['EC123'] = "End";
$locale['EC124'] = "Allow registrations only in this time period.";
$locale['EC125'] = array(
	0 => '[None]',
	1 => 'Yearly',
	2 => 'Monthly',
	4 => 'Weekly',
	8 => 'Daily',
);
$locale['awec_private_saving']		= 'Private events can be "published" immediately.';
$locale['awec_endless_repeat']		= 'Endless Repetition';
$locale['awec_end_repeat']		= 'Repeat until';
$locale['awec_save_draft']		= 'Save as Draft';
$locale['awec_save_release']		= 'Save and Submit';
$locale['awec_save_publish']		= 'Save and Publish';
$locale['awec_cycle']			= 'Cycle';


// aw_ecal_panel.php
$locale['EC200'] = "Submit New Event";
$locale['EC202'] = "Tomorrow";
$locale['EC203'] = "New Events need to be checked!.";
$locale['EC204'] = "My Events";
$locale['EC205'] = "Birthday(s)";
$locale['EC206'] = "My Registrations";
$locale['EC207'] = "[more]";
$locale['EC208'] = 'Following %s days';
$locale['EC209'] = array(
	'today'		=> 'Today',
	'tomorrow'	=> 'Tomorrow',
	'others'	=> 'More...',
);


// view_event.php
$locale['EC300'] = "Event";
$locale['EC301'] = $locale['EC113'][3];
$locale['EC302'] = "Warning! User not in the database.";
$locale['EC303'] = "Unknown";
$locale['EC305'] = "Delete";
$locale['EC306'] = "Publish";
$locale['EC307'] = 'Deactivate';
//EC308
$locale['EC309'] = array(
	0 => "Not subscribed to this event.",
	1 => "Definitely agreed.",
	2 => "Preliminary agreed.",
	3 => "Canceled",
	4 => "Invited",
);
$locale['EC310'] = array(
	1 => "Agree definitely",
	2 => "Agree preliminary",
	3 => "Cancel",
);
$locale['EC311'] = "Current status:";
$locale['EC312'] = "Comment";
$locale['EC313'] = "Send E-Mail";
$locale['EC314'] = "Send an e-mail to each";
$locale['EC315'] = "Send one e-mail to all";
$locale['EC316'] = "Send";
$locale['EC317'] = "Some description would be fine. Thx!";
$locale['EC318'] = "No receivers specified. Please change this!";
$locale['awec_all'] = "All";
$locale['EC320'] = "E-mail(s) have been sent!";
$locale['EC321'] = "HTML-Format";
$locale['EC322'] = "Invite";
$locale['EC323'] = "Use CTRL-/SHIFT to select multiple users";
$locale['EC324'] = 'Send PM';
$locale['awec_invite_title']	= 'Invitation';
$locale['awec_invite_body']	= 'You were invited.';


// calendar.php
$locale['awec_calendar'] = "Calendar";
$locale['EC401'] = "Birthdays in this month";
$locale['EC402'] = "View";
$locale['awec_month_view'] = array(
	'calendar'	=> 'Calendar',
	'list'		=> 'List',
	'clist'		=> 'CList',
);


// browse.php
$locale['EC450'] = "Year";
$locale['awec_show'] = "Show";


// new_events.php
$locale['EC500'] = "New Events";
$locale['EC501'] = "No new events to check.";
$locale['EC502'] = array(
	1 => "Could not publish event, since it was altered meanwhile. Please check it again!",
);


// search.php
$locale['EC550'] = "Search for";
$locale['EC551'] = array(
	'AND'	=> 'All words',
	'OR'	=> 'At least on word',
	'-'	=> 'This statement as one word',
);
$locale['EC552'] = "Events found.";
$locale['EC554'] = "Your search should be 3 letters in size at least";


// my_events.php
$locale['EC600'] = "My Events";
$locale['EC601'] = "No events submitted yet.";
$locale['EC602'] = array(
	0	=> 'Others',
	1	=> 'Private',
);
$locale['awec_status_desc'] = array(
	AWEC_PUBLISHED	=> 'Published',
	AWEC_PENDING	=> 'Waiting for being published',
	AWEC_DRAFT	=> 'Draft',
);
$locale['awec_status_longdesc'] = array(
	AWEC_PUBLISHED	=> 'Published',
	AWEC_PENDING	=> 'Waiting for being published',
	AWEC_DRAFT	=> 'Event is in draft mode.',
);


// admin.php
$locale['EC700'] = "Settings";
$locale['EC701'] = "Admin-Group";
$locale['EC702'] = "Check new events by the Admin-Group";
$locale['EC703'] = "Submit events by";
$locale['EC704'] = "Show description of today's events in the side panel.";
$locale['awec705']	= 'Treat user birthdays like events.';
$locale['EC706'] = "Show birthdays to";
$locale['EC711'] = 'Date/Time Format';
$locale['EC712'] = "Birthdays";
$locale['EC713'] = "Standard";
$locale['EC714'] = "Only used when not specified by theme.";
$locale['EC715'] = "Delete Events";
$locale['EC716'] = 'Delete all events older than specified number of days.';
$locale['EC716_']	= 'Repeated events will not be deleted!';
$locale['EC717'] = array(
	0	=> "Saved",
	1	=> "Old events deleted!",
);
$locale['awec_confirm_del']	= 'Events will be deleted irrevocably';
$locale['EC719'] = "%d - yay of the month, numeric (00..31)
%m - month, numeric (00..12)
%Y - year, numeric, four digits
%H - hours
%i - minutes
More information about format of the function DATE_FORMAT: <a href='http://dev.mysql.com/doc/refman/4.1/en/date-and-time-functions.html#id3022503' target='_blank'>Here</a>";
$locale['EC720'] = "Preview";
$locale['EC721'] = "Days";
$locale['EC722'] = "Next days in side panel";
$locale['EC723'] = "Week starts on sunday";
$locale['EC724'] = "Side-Panel";
$locale['EC725'] = "Supported only:";
$locale['EC726'] = 'Time';
$locale['awec_default_month_view']	= 'Default month view';
$locale['awec_custom_css']		= 'Use custom CSS (see README)';
$locale['awec_alt_side_calendar']	= 'Use alternative Side-Calendar';
$locale['awec_user_can_edit']		= 'Existing events can be edited';
$locale['awec_show_week']		= 'Show week';
$locale['awec_default_calendar_view']	= 'Default calendar view';

// admin_cats.php
$locale['awec_cats']		= 'Categories';
$locale['awec_cat']		= 'Category';

// admin/misc.php
$locale['EC750']		= 'Misc';
$locale['awec_old_events']	= 'Past Events';

// include/db_update.php
$locale['EC800'] = "Update available";
$locale['EC801'] = "The following SQL-Statements will be executed";
$locale['EC802'] = "Start Update...";
//
$locale['EC804'] = "Done - Proceed!";
$locale['EC805'] = "OK";
$locale['EC806'] = "Error";
//
$locale['awec_pls_delete']	= 'Please delete these files:';


// others
$locale['EC900'] = array(
	0 => '--',
	1 => 'January',
	2 => 'February',
	3 => 'March',
	4 => 'April',
	5 => 'May',
	6 => 'June',
	7 => 'July',
	8 => 'August',
	9 => 'September',
	10 => 'October',
	11 => 'November',
	12 => 'December',
);
$locale['EC901'] = array(
	0 => 'Su',
	1 => 'Mo',
	2 => 'Tu',
	3 => 'We',
	4 => 'Th',
	5 => 'Fr',
	6 => 'Sa',
	7 => 'Su',
);
?>
