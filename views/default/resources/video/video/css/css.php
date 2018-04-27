<?php

/* CSS for Video  */

// Let us get the current playing video guid, video entity, then find next video guid later
$guid = (int) get_input('guid');
	
	$video = get_entity($guid);
	
       $owner = elgg_get_page_owner_entity();
	 
	$site = elgg_get_site_entity();
	$themsitename = $site->name;
 	$thesitedescription = $site->description;
 	$site_name = $themsitename;   
 	
	//set the url
$the_site_url = elgg_get_site_url();
$siteurl = elgg_get_site_url();



$css_url = elgg_get_site_url() . "mod/video/views/default/css";

//set the url for js
$js_url = elgg_get_site_url() . "mod/video/views/default/js/js";


// graphic icon  
$favicon = elgg_get_site_url() . 'mod/video/graphics/logo/favicon.png';

// CSS
$bootstrap = $css_url.'/bootstrap.css';
$sweetalert = $css_url.'/sweetalert.css';
$bootstrap_select_min =  $css_url.'/bootstrap-select.min.css';
$flags =  $css_url.'/flags.css';
$jquery_bootgrid = $css_url. '/jquery.bootgrid.css';
$default_css =  $css_url.'/default.css';
$main_again =  $css_url.'/main.css'; // Check to see if it is the same as the other main.css bellow
$font_awesome_min  = $css_url.'/font-awesome.min.css';
$font_awesome_all = $css_url.'/font-awesome-all/fontawesome-all.min.css';
$bootstrap_toggle_min =  $css_url.'/bootstrap-toggle.min.css';








$videojs_resolution_switcher  =  $css_url.'/videojs-resolution-switcher.css';
$videojs_thumbnails  =  $css_url.'/videojs.thumbnails.css';
$main =  $css_url.'/css/main.css'; // check for duplicate- in a diffrent file
$videojs_ima =  $css_url.'/videojs.ima.css'; // Ads.ima
$video_js_min = $css_url.'/video-js.min.css';
$videojs_ads = $css_url.'/videojs.ads.css'; // Ads.ads
$jquery_webui_popover_min = $css_url.'/jquery.webui-popover.min.css';


$player = $css_url.'/player.css';
$social =  $css_url.'/social.css';
$jquery_ui_min  =   $css_url.'/jquery-ui.min.css';





// JS
$googleapis_ima3 = '//imasdk.googleapis.com/js/sdkloader/ima3.js'; // TM: Laeve this alone load from google servers GOOGLE 
$jquery_3_2_0_min  = $js_url. '/jquery-3.2.0.min.js';




// Google Analytics
$analytics = 'https://www.google-analytics.com/analytics.js'; // Leave this alone Google servers

$google_analytics =  "";
$google_page_view =  "";

	if (elgg_instanceof($owner, 'group')) {
		elgg_push_breadcrumb($crumbs_title, "video/group/$owner->guid/all");
	} else {
		elgg_push_breadcrumb($crumbs_title, "video/owner/$owner->username");
	}

	
	$title = $video->title;
	$description =  $video->description;
	elgg_push_breadcrumb($title);
	if ($video->conversion_done) {
		$video_mind_menu = elgg_view_entity($video, array(
		'full_view' => true,
		'title' => false, // We do not want the title to show u
		
		));
		 $comments .= elgg_view_comments($video);
	} else {
		$string = elgg_echo('video:conversion_pending');
		$video_mind_menu .= "<div>$string</div>";
		$comments .= "<div>$string</div>";
	}
	
	
	
	// Elgg access
	$access = $video->access_id;
	$video_access = elgg_view('output/access', [
			'value' => $access,
			]);
	
	
	 
	$crumbs_title = $owner->name; 
	$owner_link = elgg_view('output/url', array(
	'href' => "video/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
	));
	$author_text = elgg_echo('byline', array($owner_link));

	$video_icon = $video->getIconURL([
		'size' => 'large',
	]);
	
	$video_stage_icon = $video->getIconURL([
		'size' => 'large',

	]);

	$user_icon = $owner->getIconURL([
		'size' => 'medium',
		// 'type' => 'video',
	]);
	
	$video_url = $video->getURL();

	
	
	
	
	// DATES
	// Time created
//  Time is represented as an XSD:Duration Date Type
//The letters in PT11H00M00 – P: Period, T: Time, H: Hours, M: Minutes see http://www.w3schools.com/schema/schema_dtypes_date.asp
// Parse and create ISO 8601 Date and time intervals, like PT15M in PHP
//https://stackoverflow.com/questions/3721085/parse-and-create-iso-8601-date-and-time-intervals-like-pt15m-in-php
 // $pt_time
 
 $date = elgg_view_friendly_time($video->time_created);

 
  $video_duration = $video->duration; // e.g 00:06:51

// duration in seconds to Format a duration as ISO 8601
 $video_pt = $video_duration;
 
$durationInDotsToseconds = durationInDotsToseconds($video_pt);
 
// format Array ( [hours] => 420839 [minutes] => 40 [seconds] => 41 )
$video_duration_parts_time = secondsToDuration ($durationInDotsToseconds);

// format 
$video_duration_pt_time = formatDuration($video_duration_parts_time);

// TM: ENDS Creating ISO 8601 durations 
 
 $object_created = $video->time_created;
 $object_updated = $video->time_updated;
 
 
 $day_month_year = strftime("%d %B %Y",$object_created);
 $machine_year_day_month = date('Y-m-d H:i', $object_created);
	
	// convert unixtimstamp 1501024416 to date string 2017-07-25T23:13:36+00:00
	//  (ISO 8601 date, PHP 5+)
	$date_created_time_string =  gmdate("c", $object_created);
	
 if ($object_updated) {

	$date_updated_updated_string =  gmdate("c", $object_updated);	
	// The Time formart like this one  6:43 PM EDT, Sat July 29, 2017
	$the_human_year_day_month = strftime(" %I:%M %p %Z, %a %B %d, %Y",$object_updated);
	
} else {

	$date_updated_updated_string =  gmdate("c", $object_created);
	
	// The Time formart like this one  6:43 PM EDT, Sat July 29, 2017
	$the_human_year_day_month = strftime(" %I:%M %p %Z, %a %B %d, %Y",$object_created);
}

// Facebook

$fb_app_id =  774958212660408; // Edit this to your own site facebook info



foreach ($links as $attributes) {
 echo elgg_format_element('link', $attributes);
}
$stylesheets = elgg_get_loaded_css();
foreach ($stylesheets as $url) {

 echo  elgg_format_element('link', array('rel' => 'stylesheet', 'href' => $url));
}    


echo <<<HTML


 <title> $title  </title>
        <meta name="generator" content=" $thesitedescription  " />
        <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content=" $thesitedescription ">
<meta name="author" content=" $crumbs_title ">


<link rel="icon" href="$favicon">


<link href="$bootstrap" rel="stylesheet" type="text/css"/>
<link href="$sweetalert" rel="stylesheet" type="text/css"/>
<link href="$bootstrap_select_min" rel="stylesheet" type="text/css"/>
<link href="$flags" rel="stylesheet" type="text/css"/>
<link href="$jquery_bootgrid" rel="stylesheet" type="text/css"/>
<link href="$default_css" rel="stylesheet" type="text/css" id="theme"/>
<link href="$main_again" rel="stylesheet" type="text/css"/>
<link href="$font_awesome_min" rel="stylesheet" type="text/css"/>
<link href="$font_awesome_all" rel="stylesheet" type="text/css"/>

<link href="$bootstrap_toggle_min" rel="stylesheet" type="text/css"/>

          

<script src="$jquery_3_2_0_min" type="text/javascript"></script>
<script>
    var webSiteRootURL = '$the_site_url';
</script>
<script>
    // Your site Tube Analytics
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '$analytics', 'ga');

    ga($google_analytics);
    ga($google_page_view);
</script>
<link href="$videojs_resolution_switcher" rel="stylesheet" type="text/css"/><style></style>
<link href="$videojs_thumbnails" rel="stylesheet" type="text/css"/><style></style>
<link href="$main" rel="stylesheet" type="text/css"/>

<script src="$googleapis_ima3"></script>
<link href="$videojs_ima" rel="stylesheet" type="text/css"/><style>.ima-ad-container{z-index:1000 !important;}</style>
        <link rel="image_src" href=" $video_icon  " />
        <link href="$video_js_min" rel="stylesheet" type="text/css"/>
        <link href="$videojs_ads" rel="stylesheet" type="text/css"/>
        <link href="$player" rel="stylesheet" type="text/css"/>
        <link href="$social" rel="stylesheet" type="text/css"/>
        <link href="$jquery_webui_popover_min" rel="stylesheet" type="text/css"/>
        <link href="$jquery_ui_min" rel="stylesheet" type="text/css"/>
        <meta property="fb:app_id"             content="$fb_app_id" />
        <meta property="og:url"                content=" $video_url" />
        <meta property="og:type"               content="video.other" />
        <meta property="og:title"              content="$title" />
        <meta property="og:description"        content="$description" />
        <meta property="og:image"              content="$video_stage_icon" />
        <meta property="og:image:width"        content="1280" />
        <meta property="og:image:height"       content="720" />

        <meta property="video:duration" content=" $video_duration "  />
        <meta property="duration" content=" $video_duration "  />



HTML;
 