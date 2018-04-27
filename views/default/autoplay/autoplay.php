<?php
/**
 * Get page components to view a video.
 *
 * @param int $guid GUID of a video entity.
 * @return array
 */
// get the video id as input

$owner = elgg_get_page_owner_entity();

// Let us get the current playing video guid, video entity, then find next video guid later
$video_guid = (int) get_input('guid');
// $video = get_entity($video_guid);
$video_entities = get_all_owner_videos();
  $count  = count($video_entities);        
      
 if ($count > 0) {


 $our_outoplay_video_guid = array_get_next($video_entities, $video_guid);
 
 $video = get_entity($our_outoplay_video_guid);

 $video_vars = array('sources' => $video->getSources());

$container_guid = array('$container_guid' => $video->getSources());
 
  
        foreach ($entities as $entity => $video_entities) {
 
       $the_video_guid = $video_entities->getGUID(); 

  
  
    if (!is_array($video_entities)) {
    
		
	}
  
        }


$backwards = $array;

// Just to be safe, let’s ensure we're on the first element of the array
 reset($array_split );

// If we’re looking for a specific key, we do this
while (!in_array(key($array), [$video_guid, null])) {
    next($array);
}

}

 $new_array = array();

if ($video_vars) {

$composts = $video_vars;

//looping through two-dimensional indexed associative array

// $video_vars_array = array($video_vars);

$format = array(); // tom
$Vsource = array();
$source_tags = '';

// use the foreach loop in combination with the for loop to access all the keys, elements or values inside a PHP multidimensional array

// Printing all the keys and values one by one

 $keys = array_keys($video_vars);

 $count = 0;
foreach ($video_vars as $Vsource => $val) {

 for($i = 0; $i < count($video_vars); $i++) {
      
   foreach($video_vars[$keys[$i]] as $key => $value) {
  
   // Remove NULL value from an array... only print array with 0, 1, 2 ... but not Null arrays.
          if (array_filter( $video_vars, 'strlen' ))$count++;      
  
    $url = elgg_normalize_url( $ssource);
	$url = elgg_format_url($url);
	
	
	//TM:
	// Let us find values like formats, resolutions
	// $format = $source-> resolution;
	$format = $value-> resolution;
	$source_format = $value-> format;

	if (array_key_exists($format, $formatDict)){
		$result = $formatDict[$format];
	}
	else {
		$result = '';
	}

	$source_tags .= "<source src=\"$url\" type=\"video/$source_format\"  $result  >";
      
             } 
    }          
      
}

foreach($video_vars_array as $a=>$b){
foreach($b as $c=>$d){

foreach($d as $e=>$f){

}
}
}

// accessing elements from 3-dimensional product array.
 
for($l=0;$l<3;$l++){
	for($r=0;$r<3;$r++)
	{
		for($c=0;$c<3;$c++)
		{ // echo $video_vars_array[$l][$r][$c];
		}

	}
}

	}

$video_vars = $video;

// Views menu
	// user if statement to avoid Fatal error: incase no view yet e.g Call to a member function getVideoViews() on null
	  if($video->conversion_done) {
	 $view_info = $video->getVideoViews();
	$view_info = (!$view_info) ? 0 : $view_info;
	$Video_views_text = elgg_echo('video:views', array((int)$view_info));
	  }
	$crumbs_title = $owner->name; 
	$owner_link = elgg_view('output/url', array(
	'href' => "video/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
	));
	$author_text = elgg_echo('byline', array($owner_link));
	
	// Video icon
	
	$video_icon = $video->getIconURL([
		'size' => 'large',
	]);
	
	$video_stage_icon = $video->getIconURL([
		'size' => 'large',
	]);

	$user_icon = $owner->getIconURL([
		'size' => 'medium',
	]);

$video_url = $video->getURL();

 $video_title = $video->title;
	// Elgg access
	$access = $video->access_id;
	$video_access = elgg_view('output/access', [
			'value' => $access,
			]);

$date = elgg_view_friendly_time($video->time_created);  
	  
	// TM: Ends

	if (elgg_instanceof($owner, 'group')) {
		elgg_push_breadcrumb($crumbs_title, "video/group/$owner->guid/all");
	} else {
		elgg_push_breadcrumb($crumbs_title, "video/owner/$owner->username");
	}
	
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
 
  $video_duration = $video->duration; // e.g 00:06:51

// duration in seconds to Format a duration as ISO 8601
 $video_pt = $video_duration;
 
$durationInDotsToseconds = durationInDotsToseconds($video_pt);
 
// format Array ( [hours] => 420839 [minutes] => 40 [seconds] => 41 )
$video_duration_parts_time = secondsToDuration ($durationInDotsToseconds);

// ISO 8601 durations format e.g  PT0H1M19S
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

// $videos = elgg_list_entities($options);
 $the_video = '';

	

if (elgg_is_logged_in()) {
	elgg_register_menu_item('title', array(
		'name' => 'add',
		'href' => 'video/add/' . elgg_get_logged_in_user_guid(),
		'text' => elgg_echo("videos:add"),
		'link_class' => 'elgg-button elgg-button-action',
		'is_trusted' => true, // TM
	));
}
	
//TM: video/output start THis code has to be just like this function does not work	


echo <<<HTML


<!-- TM: Starts AUTO PLAY VIDOE -->
                            
              <div class="col-lg-12 col-sm-12 col-xs-12 bottom-border autoPlayVideo" itemscope itemtype="http://schema.org/VideoObject" style="display: none;" >
           <a href=" $video_url " title=" $video_title " class="videoLink">

<!-- div starts thumbsImage  -->              
               
             <div class="col-lg-5 col-sm-5 col-xs-5 nopadding thumbsImage">
             <img src=" $video_icon " alt=" $video_title " class="img-responsive   rotate0" height="130" itemprop="thumbnail" />
             <img src=" $video_icon " style="position: absolute; top: 0; display: none;" alt=" $video_title " id="thumbsGIF283" class="thumbsGIF img-responsive   rotate0" height="130" />
             <meta itemprop="thumbnailUrl" content="$video_icon " />
             <meta itemprop="contentURL" content="$video_url " />
             <meta itemprop="embedURL" content="$video_url" />
             <meta itemprop="uploadDate" content=" $date_created_time_string " />
             <time class="duration" itemprop="duration" datetime=" $video_duration_pt_time "> $video_duration </time>
    
             </div>
     
<!-- div ends  thumbsImage  -->                                     

<!-- div starts videosDetails  -->
                                    
           <div class="col-lg-7 col-sm-7 col-xs-7 videosDetails">
           
           
          <div class="text-uppercase row"><strong itemprop="name" class="title"> $video_title </strong></div>

<!-- div starts description  -->
    
          <div class="details row text-muted" itemprop="description">
                   <div><strong>Category: </strong><span class="fa fa-film"></span>Movies  </div>
		   <div> <strong class=""> $Video_views_text </strong></div>
   
<!-- div starts pull-left  -->    
             	   <div><div class="pull-left"><img src="
             	   
             	   $user_icon
             	   
             	   " alt="" class="img img-responsive img-circle zoom" style="max-width: 40px;"/></div>
             	   
             	   <div class="commentDetails" style="margin-left:45px;"><div class="commenterName"><strong> $crumbs_title </strong> <small>
             	   $date  </small>

             	    </div></div></div></div>
<!-- div ends pull-left  -->              	           
             	           
                          <div class="row"><span class="label label-success"> $video_access </span> </div>
       
                          
         </div>
<!-- div ends  description  -->                               

 			</a>
          </div>
                            
<!-- TM: Ends AUTO PLAY VIDOE -->  



<!--/row section moved -->
<script>
    function compress(t) {
        console.log("compress");
        $('#mvideo').find('.firstC').removeClass('col-sm-2');
        $('#mvideo').find('.firstC').removeClass('col-md-2');
        $('#mvideo').find('.firstC').addClass('col-sm-1');
        $('#mvideo').find('.firstC').addClass('col-md-1');
        $('#mvideo').find('.secC').removeClass('col-sm-8');
        $('#mvideo').find('.secC').removeClass('col-md-8');
        $('#mvideo').find('.secC').addClass('col-sm-6');
        $('#mvideo').find('.secC').addClass('col-md-6');
        $('.rightBar').addClass('compress');
        setInterval(function () {
            $('.principalContainer').css({'min-height': $('.rightBar').height()});
        }, 2000);
        $('#mvideo').removeClass('main-video');
        left = $('#mvideo').find('.secC').offset().left + $('#mvideo').find('.secC').width() + 30;
        $(".compress").css('left', left);

        t.removeClass('fa-compress');
        t.addClass('fa-expand');
    }
    function expand(t) {
        $('#mvideo').find('.firstC').removeClass('col-sm-1');
        $('#mvideo').find('.firstC').removeClass('col-md-1');
        $('#mvideo').find('.firstC').addClass('col-sm-2');
        $('#mvideo').find('.firstC').addClass('col-md-2');
        $('#mvideo').find('.secC').removeClass('col-sm-6');
        $('#mvideo').find('.secC').removeClass('col-md-6');
        $('#mvideo').find('.secC').addClass('col-sm-8');
        $('#mvideo').find('.secC').addClass('col-md-8');
        $(".compress").css('left', "");
        $('.rightBar').removeClass('compress');
        $('#mvideo').addClass('main-video');
        console.log("expand");
        t.removeClass('fa-expand');
        t.addClass('fa-compress');
    }
    function toogleEC(t) {
        if (t.hasClass('fa-expand')) {
            expand(t);
            Cookies.set('compress', false, {
                path: '/',
                expires: 365
            });
        } else {
            compress(t);
            Cookies.set('compress', true, {
                path: '/',
                expires: 365
            });
        }
    }
    var player;
    $(document).ready(function () {


        $(window).on('resize', function () {
            left = $('#mvideo').find('.secC').offset().left + $('#mvideo').find('.secC').width() + 30;
            $(".compress").css('left', left);
        });

        //Prevent HTML5 video from being downloaded (right-click saved)?
        $('#mainVideo').bind('contextmenu', function () {
            return false;
        });
        fullDuration = strToSeconds('');
        player = videojs('mainVideo');

        // Extend default
        var Button = videojs.getComponent('Button');
        var teater = videojs.extend(Button, {
            //constructor: function(player, options) {
            constructor: function () {
                Button.apply(this, arguments);
                //this.addClass('vjs-chapters-button');
                this.addClass('fa-compress');
                this.addClass('fa');
                this.controlText("Teater");
                if (Cookies.get('compress') === "true") {
                    toogleEC(this);
                }
            },
            handleClick: function () {
                toogleEC(this);
            }
        });

        // Register the new component
        videojs.registerComponent('teater', teater);
        player.getChild('controlBar').addChild('teater', {}, 8);

        player.zoomrotate({rotate:0, zoom: 1});
        player.ready(function () {
setTimeout(function () { player.play();}, 150);                this.on('ended', function () {
                    console.log("Finish Video");
                            if (Cookies.get('autoplay') && Cookies.get('autoplay') !== 'false') {
                           
                           // The URL for the Elgg Video autoplay location
                            document.location = ' $video_url ';
                        }
        
                });
        });
        player.persistvolume({
            namespace: "YouPHPTube"
        });
    });
</script>





HTML;
 