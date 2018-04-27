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
$siteurl = $the_site_url;



$css_url = elgg_get_site_url() . "mod/video/views/default/css";

//set the url for js
$js_url = elgg_get_site_url() . "mod/video/views/default/js/js";


// graphic icon  
$favicon = elgg_get_site_url() . 'mod/video/graphics/logo/favicon.png';

$icon_logo = elgg_get_site_url() . 'mod/video/graphics/logo/index.png';
$icon_thumbs_sprit = elgg_get_site_url() . 'mod/video/graphics/logo/thumbsSprit.jpg';

// JS
$jquery_ui_min  = $js_url. '/jquery-ui.min.js';
$video_js  = $js_url. '/video.js';
$videojs_ads_min_js = $js_url. '/videojs.ads.min.js';
$bootstrap_min_js = $js_url. '/bootstrap.min.js';
$sweetalert_min_js = $js_url. '/sweetalert.min.js';
$jquery_bootpag_min_js = $js_url. '/jquery.bootpag.min.js';
$jquery_bootgrid_js = $js_url. '/jquery.bootgrid.js';
$bootstrap_select_min_js = $js_url. '/bootstrap-select.min.js';
$script_js = $js_url. '/script.js';
$bootstrap_toggle_min_js = $js_url. '/bootstrap-toggle.min.js';
$js_cookie_js = $js_url. '/js.cookie.js';
$jquery_flagstrap_min_js = $js_url. '/jquery.flagstrap.min.js';
$videojs_resolution_switcher_js = $js_url. '/videojs-resolution-switcher.js';
$videojs_thumbnails_js = $js_url. '/videojs.thumbnails.js';
$videojs_ima_js = $js_url. '/videojs.ima.js';

$adTagUrl = '';

$videojs_zoomrotate_js  = $js_url. '/videojs.zoomrotate.js';
$videojs_persistvolume_js  = $js_url. '/videojs.persistvolume.js';
$jquery_webui_popover_min_js  = $js_url. '/jquery.webui-popover.min.js';
$bootstrap_list_filter_min_js  = $js_url. '/bootstrap-list-filter.min.js';

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
	// $video_icon = elgg_view_entity_icon($video, 'small');
	// $video_icon = $video->getIconURL('medium');

  $has_icon = $video->getIconURL;
  
  if ($has_icon){
	$video_icon = $video->getIconURL([
		'size' => 'large',
		// 'type' => 'video',
	]);
	
	$video_stage_icon = $video->getIconURL([
		'size' => 'large',
		// 'type' => 'video',
	]);



	// $user_icon = $owner->getIconURL('small');
	$user_icon = $owner->getIconURL([
		'size' => 'medium',
		// 'type' => 'video',
	]);

	$video_url = $video->getURL();
  }
	
	
	
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





echo <<<HTML



        <script src="$jquery_ui_min" type="text/javascript"></script>
        <script>
                        /*** Handle jQuery plugin naming conflict between jQuery UI and Bootstrap ***/
                        $.widget.bridge('uibutton', $.ui.button);
                        $.widget.bridge('uitooltip', $.ui.tooltip);
        </script>
        <script src="$video_js" type="text/javascript"></script>
        <script src="$videojs_ads_min_js" type="text/javascript"></script>
        
<footer>
        
        
        
            <ul class="list-inline">
            <li>
                Powered by <a href="$the_site_url" class="external btn btn-outline btn-primary btn-xs" target="_blank">$themsitename</a>
            </li>
            <li>
                <a href="$the_site_url" class="external btn btn-outline btn-primary btn-xs" target="_blank"><span class="sr-only">Facebook</span><i class="fa fa-fw fa-facebook"></i></a>
            </li>
            <li>
                <a href="$the_site_url" class="external btn btn-outline btn-primary btn-xs" target="_blank"><span class="sr-only">Google Plus</span><i class="fa fa-fw fa-google-plus"></i></a>
            </li>
        </ul>
        </footer>
<script type="application/ld+json">
    {
    "@context": "http://schema.org/",
    "@type": "Product",
    "name": " $themsitename ",
    "version": "$themsitename",
    "image": " $icon_logo ",
    "description": "$description"
    }
</script>
<script>
    $(function () {
    });
</script>
<script src="$bootstrap_min_js" type="text/javascript"></script>
<script src="$sweetalert_min_js" type="text/javascript"></script>
<script src="$jquery_bootpag_min_js " type="text/javascript"></script>
<script src="$jquery_bootgrid_js" type="text/javascript"></script>
<script src="$bootstrap_select_min_js" type="text/javascript"></script>
<script src="$script_js" type="text/javascript"></script>
<script src="$bootstrap_toggle_min_js" type="text/javascript"></script>
<script src="$js_cookie_js" type="text/javascript"></script>
<script src="$jquery_flagstrap_min_js" type="text/javascript"></script>
<script src="$videojs_resolution_switcher_js" type="text/javascript"></script><script>$(document).ready(function () {if(typeof player == 'undefined'){player = videojs('mainVideo');}player = videojs('mainVideo').videoJsResolutionSwitcher();
                    function changeVideoSrc(vid_obj, source) {vid_obj.updateSrc(source);vid_obj.src(source);vid_obj.load();vid_obj.play();}});</script><script src="$videojs_thumbnails_js" type="text/javascript"></script><script>$(document).ready(function () { if(typeof player == 'undefined'){player = videojs('mainVideo');}player.thumbnails({0: {
                src: '$icon_thumbs_sprit',
                style: {
                  left: '-75px',
                  width: '3000px',
                  height: '84px',
                  clip: 'rect(0, 150px, 84px, 0)'
                }
              },6: {
            style: {
                left: '-225px',
                clip: 'rect(0, 300px, 84px, 150px)'
            }
          },13: {
            style: {
                left: '-375px',
                clip: 'rect(0, 450px, 84px, 300px)'
            }
          },19: {
            style: {
                left: '-525px',
                clip: 'rect(0, 600px, 84px, 450px)'
            }
          },26: {
            style: {
                left: '-675px',
                clip: 'rect(0, 750px, 84px, 600px)'
            }
          },32: {
            style: {
                left: '-825px',
                clip: 'rect(0, 900px, 84px, 750px)'
            }
          },39: {
            style: {
                left: '-975px',
                clip: 'rect(0, 1050px, 84px, 900px)'
            }
          },45: {
            style: {
                left: '-1125px',
                clip: 'rect(0, 1200px, 84px, 1050px)'
            }
          },52: {
            style: {
                left: '-1275px',
                clip: 'rect(0, 1350px, 84px, 1200px)'
            }
          },58: {
            style: {
                left: '-1425px',
                clip: 'rect(0, 1500px, 84px, 1350px)'
            }
          },65: {
            style: {
                left: '-1575px',
                clip: 'rect(0, 1650px, 84px, 1500px)'
            }
          },72: {
            style: {
                left: '-1725px',
                clip: 'rect(0, 1800px, 84px, 1650px)'
            }
          },78: {
            style: {
                left: '-1875px',
                clip: 'rect(0, 1950px, 84px, 1800px)'
            }
          },85: {
            style: {
                left: '-2025px',
                clip: 'rect(0, 2100px, 84px, 1950px)'
            }
          },91: {
            style: {
                left: '-2175px',
                clip: 'rect(0, 2250px, 84px, 2100px)'
            }
          },98: {
            style: {
                left: '-2325px',
                clip: 'rect(0, 2400px, 84px, 2250px)'
            }
          },104: {
            style: {
                left: '-2475px',
                clip: 'rect(0, 2550px, 84px, 2400px)'
            }
          },111: {
            style: {
                left: '-2625px',
                clip: 'rect(0, 2700px, 84px, 2550px)'
            }
          },117: {
            style: {
                left: '-2775px',
                clip: 'rect(0, 2850px, 84px, 2700px)'
            }
          },124: {
            style: {
                left: '-2925px',
                clip: 'rect(0, 3000px, 84px, 2850px)'
            }
          }}); });</script><script src="$videojs_ima_js" type="text/javascript"></script><script>

function fixAdSize(){
    ad_container = $('#mainVideo_ima-ad-container');
    if(ad_container.length){
        height = ad_container.css('height');
        width = ad_container.css('width');
        $($('#mainVideo_ima-ad-container div:first-child')[0]).css({'height': height});
        $($('#mainVideo_ima-ad-container div:first-child')[0]).css({'width': width});
    }
}
$(function () {
    player = videojs('mainVideo');
    var options = {
        id: 'mainVideo',
        adTagUrl: '$adTagUrl'
    };
    player.ima(options);
    // Remove controls from the player on iPad to stop native controls from stealing
    // our click
    var contentPlayer = document.getElementById('content_video_html5_api');
    if ((navigator.userAgent.match(/iPad/i) ||
            navigator.userAgent.match(/Android/i)) &&
            contentPlayer.hasAttribute('controls')) {
        contentPlayer.removeAttribute('controls');
    }

    // Initialize the ad container when the video player is clicked, but only the
    // first time it's clicked.
    var startEvent = 'click';
    if (navigator.userAgent.match(/iPhone/i) ||
            navigator.userAgent.match(/iPad/i) ||
            navigator.userAgent.match(/Android/i)) {
        startEvent = 'touchend';
    }
    player.one(startEvent, function () {
        player.ima.initializeAdDisplayContainer();
    });
    
    setInterval(function(){ fixAdSize(); }, 100);
});
</script>
        <script src="$videojs_zoomrotate_js" type="text/javascript"></script>
        <script src="$videojs_persistvolume_js" type="text/javascript"></script>
        <script src="$jquery_webui_popover_min_js" type="text/javascript"></script>
        <script src="$bootstrap_list_filter_min_js" type="text/javascript"></script>





HTML;
