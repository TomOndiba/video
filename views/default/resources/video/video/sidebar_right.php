<?php

$owner = elgg_get_page_owner_entity();

$get_videos_list = get_all_videos_lists();

$video_movie = elgg_echo('Movies'); 

foreach ($get_videos_list as $entity => $video) { 

       $video_guid = $video->getGUID(); 
 
  if($video->conversion_done) {
	 $view_info = $video->getVideoViews();
	$view_info = (!$view_info) ? 0 : $view_info;
	$Video_views_text = elgg_echo('video:views', array((int)$view_info));
	  }
	  
	  $author_text = elgg_echo('byline', array($owner_link));
	$video_icon = $video->getIconURL([
		'size' => 'large',
	]);
	
	$video_src_url = $video->getIconURL([
		'size' => 'large',
	]);
	
	$video_src_gif_url = $video->getIconURL([
		'size' => 'small',
	]);

	$video_userPhotoUrl = $owner->getIconURL([
		'size' => 'medium',
		// 'type' => 'video',
	]);
	

	$video_url = $video->getURL();  
	 
	$crumbs_title = $owner->name; 
	$owner_link = elgg_view('output/url', array(
	'href' => "video/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
	));
	
  $video_title = $video->title;
  
   
	// Elgg access
	$access = $video->access_id;
	
	
	$video_access = elgg_view('output/access', [
			'value' => $access,
			]);
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

	$video_sidebar =  '<div class="col-lg-12 col-sm-12 col-xs-12 bottom-border" id="divVideo-';
	
	$video_sidebar .=   $video_guid ; //' video url'; ; //e.g integer 286 
	$video_sidebar .= '" itemscope itemtype="http://schema.org/VideoObject">';
	
 	// image starts
 	$video_sidebar .= '<a href=" ';
 	$video_sidebar .=   $video_url ; //' video url'; 
               
       	$video_sidebar .= ' " title=" ';
      	$video_sidebar .=   $video_title ; //' video url'; 
       	$video_sidebar .= ' " class="videoLink"> ';
       
      	// ThumbsImage
      	$video_sidebar .= ' <div class="col-lg-5 col-sm-5 col-xs-5 nopadding thumbsImage" >';
      	$video_sidebar .= ' <img src="';
      	$video_sidebar .=   $video_src_url ; // ' .jpg video src url'; 
	
      	$video_sidebar .= ' " alt="';
      	$video_sidebar .=   $video_title ; 
      	$video_sidebar .= ' " class="thumbsJPG img-responsive   rotate0" height="130" />';
     
      	$video_sidebar .= ' <img src="';
      	$video_sidebar .=   $video_src_gif_url ; // ' .gif animation video src url'; 
      	$video_sidebar .= ' " style="position: absolute; top: 0; display: none;" alt="';
       	$video_sidebar .=   $video_title ; 
       	$video_sidebar .= '  " id="thumbsGIF';
       	$video_sidebar .=   $video_guid ; //' video url'; ; //e.g integer 286 
       	$video_sidebar .= ' " class="thumbsGIF img-responsive   rotate0" height="130" />';
       	$video_sidebar .= ' <meta itemprop="thumbnailUrl" content="';
       	$video_sidebar .= $video_thumbnailUrl ; 
       	$video_sidebar .= ' " />';
       	$video_sidebar .= ' <meta itemprop="uploadDate" content="';
       	$video_sidebar .=   $date_updated_updated_string ; //  uploadDate e.g  2017-12-08 10:12:59
       	$video_sidebar .= ' " />';
       	
      	$video_sidebar .= ' <time class="duration" itemprop="duration" datetime="';
        $video_sidebar .=   $video_duration_pt_time ; //  uploadDate e.g  PT0H2M26S
        $video_sidebar .= ' " >';
        $video_sidebar .= $video_duration ; //  $video duration e.g  0:02:26
	$video_sidebar .= ' </time>';

        $video_sidebar .= '</div> <div class="col-lg-7 col-sm-7 col-xs-7 videosDetails"><div class="text-uppercase row">';
        $video_sidebar .= '<strong itemprop="name" class="title">';
        $video_sidebar .=   $video_title ; 
        $video_sidebar .= ' </strong></div><div class="details row" itemprop="description"><div><strong>';
        
         $video_sidebar .= $video_category ; // Category: 
        $video_sidebar .= ' </strong><span class="fa fa-film"></span>';
        $video_sidebar .= $video_movie; // Movies: 
        $video_sidebar .= ' </div><div><strong class="">';
         $video_sidebar .= $Video_views_text;   // Views  :
        $video_sidebar .= ' </strong></div>';
         $video_sidebar .= ' <div><div class="pull-left"><img src="';
         $video_sidebar .= $video_userPhotoUrl ; 
        $video_sidebar .= ' " alt="" class="img img-responsive img-circle zoom" style="max-width: 20px;"/></div> ';
        $video_sidebar .= '<div class="commentDetails" style="margin-left:25px;"><div class="commenterName text-muted"><strong>';
        $video_sidebar .= $video_username   ; // Views  :
        $video_sidebar .= '</strong> <small>';
        $video_sidebar .= $date   ; // e.g 2 weeks
        $video_sidebar .= ' </small></div></div></div></div><div class="row">';
        $video_sidebar .= '<span class="label label-success">';
        $video_sidebar .= $video_access   ; // Public :
        $video_sidebar .= '</span></div></div></a></div>';


      echo $video_sidebar;

}
