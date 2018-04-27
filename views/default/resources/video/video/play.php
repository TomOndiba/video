<?php 


/**
 * Get page components to view a video
 *
 * @param int $guid GUID of a video entity.
 * @return array
 */
// get the video id as input

$guid = elgg_extract('guid', $vars);


	$video = get_entity($guid);
	if (!$video) {
		register_error(elgg_echo('noaccess'));
		$_SESSION['last_forward_from'] = current_page_url();
		forward('');
	}
	
	
	// TM: Starts
	
	// TM: VIDEO VIDES UPDATE
	   $video->updateVideoViews();
	  
	// Views menu
	// user if statement to avoid Fatal error: incase no view yet e.g Call to a member function getVideoViews() on null
	  if($video->conversion_done) {
	 $view_info = $video->getVideoViews();
	$view_info = (!$view_info) ? 0 : $view_info;
	$Video_views_text = elgg_echo('video:views', array((int)$view_info));
	  }
	  
	  //
	 $owner = elgg_get_page_owner_entity();
	 
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
	]);
	
	// Video url or location
    $video_url = $video->getURL();

	//set the url
	$elgg_get_site_entity = elgg_get_site_entity();
	$site_name = $elgg_get_site_entity->name;
	$the_site_description = $elgg_get_site_entity->description;
	
         $the_site_url = elgg_get_site_url() . "video/all";
         $our_site_url = elgg_get_site_url(); // playlist url
	
	$logo_url = elgg_get_site_url() . "mod/video/graphics/logo/myadventhome_tube_elgg.png";
	
	$date = elgg_view_friendly_time($video->time_created);

	// TM: Ends

	if (elgg_instanceof($owner, 'group')) {
		elgg_push_breadcrumb($crumbs_title, "video/group/$owner->guid/all");
	} else {
		elgg_push_breadcrumb($crumbs_title, "video/owner/$owner->username");
	}
	

	$title = $video->title;
	$video_title = $video->title;
	$description =  $video->description;
	elgg_push_breadcrumb($title);
	if ($video->conversion_done) {
		$video_mind_menu = elgg_view_entity($video, array(
		'full_view' => true,
		'title' => false, // We do not want the title to show up
		
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
	
	// return $params;
	// Compute only if it will be displayed...
if (elgg_is_logged_in()) {

}else {
	
$upload = elgg_get_site_url() ."login";
$register = elgg_get_site_url() ."register";
$register_title = elgg_echo('register');
$videos_upload = elgg_echo('login'); 

$watch_later = elgg_echo('watch:later');
$sign_in_add_playlist = elgg_echo('sign:in:add:playlist');
$webui_popover_content = '<div class="webui-popover-content"><h5>' . $watch_later .  '</h5>' . $sign_in_add_playlist . '<a href="' . $register . '" class="btn btn-primary"><span class="glyphicon glyphicon-log-in"></span>' . $videos_upload . '</a></div>';
	
}

if (elgg_is_logged_in()) {
	elgg_register_menu_item('title', array(
		'name' => 'add',
		'href' => 'video/add/' . elgg_get_logged_in_user_guid(),
		'text' => elgg_echo("videos:add"),
		'link_class' => 'elgg-button elgg-button-action',
		'is_trusted' => true, // TM
	));
}

// $content = elgg_view_entity($video, array('full_view' => true));

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	// 'sidebar' => elgg_view('izap_videos/sidebar', array('page' => 'play')),
));


		
//TM: video/output start THis code has to be just like this function does not work	


/**
 * Display a video tag and its source tags
 *
 * @uses $vars['sources']
 * @uses $vars['poster']
 * @uses $vars['controls']
 * @uses $vars['width']
 */


$defaults = array(
	'sources' => array(),
	'poster' => '',
	'controls' => 'controls',
	'width' => '100%',
	'preload' => 'metadata',
);

 $vars = array_merge($defaults, $vars);

$sources = $vars['sources'];
unset($vars['sources']);

$attributes = elgg_format_attributes($vars);


elgg_load_library('elgg:video');

$video_vars = array('sources' => $video->getSources());

$formatDict = [
		// Map youtube qualities names
		"0" => 'label="auto" res="0"', // auto
		"256x144" => 'label="144p" res="144"', // 144p tiny label='phone' res='144'
		"426x240" => 'label="240p" res="240"', // 240p small for (VCD Players)
		"640x360" => 'label="360p" res="360"', // 360p medium
		"854x480" => 'label="480p" res="480" selected="true" ', // 480p large SD
		"1280x720" => 'label="720p" res="720"', // 720p hd720 HD
		"1920x1080" => 'label="1080p" res="1080"', // 1080p hd1080 HD
	];

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
  //  var_dump ($key);
    $ssource = $val[$key]->getURL(); // without [$key], getURL() throws an error.
  
    $url = elgg_normalize_url( $ssource);
	$url = elgg_format_url($url);
	
	
	//TM:
	// Let us find values like formats, resolutions
	// $format = $source-> resolution;
	$format = $value-> resolution;
	$source_format = $value-> format;
	
	// var_dump ($source_format);
	
	
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

/*******
*
* TM: Video test
*
*****/

// $vector = video_get_flavor_settings();
$vector = video_get_resolution_options();

function diverse_array($vector) {
    $result = array();
    foreach($vector as $key1 => $value1)
        foreach($value1 as $key2 => $value2)
            $result[$key2][$key1] = $value2;
    return $result;
} 


$diverse_array = diverse_array($vector);

// var_dump ($diverse_array);

$flavors = video_get_flavor_settings();
		foreach ($flavors as $flavor) {

            //  var_dump ($flavor);
            if (empty($flavor['resolution'])) {
			// Use resolution of the parent in the filename
			$resolution = $video->resolution;
			
		} else {
			$video_resolution = $flavor['resolution'];
			$resolution = $video->$flavor['resolution'];
		}      
}

// $array1 = array(320x240,640x360,426x240);
$array1 = array(320);

 $compare_two_array_values =  compare_two_array_values($array1, $array2);           


$array = array(
          "database.name" => "my_db_name",
           "database.host" => "myhost.com",
           "database.user" => "admin",
           "database.pass" => "a secret."
       );
 
       $search = array_contains_key($array, "database");

$cypher = CaesarCypher($array1);

	
	$check_mytube_dimensions = check_mytube_dimensions();
	
?>
<!DOCTYPE html>
<html lang="us">
    <head>
       
 <?php 
	//  video head links, metas, title, and stylesheet
	echo elgg_view_resource('video/video/css/css', array());
     
?>   
       
    </head>

    <body>
    
      
<!-- TOP BAR NAVIGATIO STARTS -->    

  <nav class="navbar navbar-default navbar-fixed-top ">
    <ul class="items-container">


<!--- left topbar menu items starts here -->	
<li>
            <ul class="left-side">
                
                <li>
                    <button class="btn btn-default navbar-btn pull-left" id="buttonMenu" ><span class="fa fa-bars"></span></button>
                    <script>
                        $('#buttonMenu').click(function (event) {
                            event.stopPropagation();
                            $('#sidebar').fadeToggle();

                        });

                        $(document).on("click", function () {
                            $("#sidebar").fadeOut();
                        });
                        $("#sidebar").on("click", function (event) {
                            event.stopPropagation();
                        });
                    </script>
                </li>
                <li>
                    <a class="navbar-brand" href="<?php echo $the_site_url; ?>" >
                        <img src="<?php echo $logo_url ;  ?>" alt="<?php echo  $the_site_description ;  ?>" class="img-responsive ">
                    </a>
                </li>
            </ul>
            
            
            <!-- top bar main Search  --> 
                <?php 
			//  video head top bar Search box
			 echo elgg_view('page/elements/mainsearch', array());
     
      		 ?> 
            
            
            
            
</li>
<!--- left topbar menu items ends here -->	




<!--- right topbar menu items starts here -->	    
                <?php 
			//   top bar right topbar menu
			 echo elgg_view('page/elements/right_topbar_menu', array());
      		 ?> 
<!--- right topbar menu items ends here -->	   

     
      
</ul>      
    
    
    
<!-- Left sideBarContainer starts here -->
	<div id="sidebar" class="list-group-item" style="display: none;">
        <div id="sideBarContainer">
            

           <!-- Elgg owners block   -->          
  
         
            
            <ul class="nav navbar">


            <?php  
          
            echo elgg_view('page/elements/owner_block', array());  
       
           ?>        

                

                <!-- categories -->

                <li>
                    <hr>
                    <h3 class="text-danger">More from <?php echo $site_name; ?></h3>
                </li>
                
                <!-- categories END -->

                <li>
                    <hr>
                </li>
                <li>
                    <a href="<?php echo elgg_get_site_url() ?>about">
                        <span class="glyphicon fab fa-dashcube"></span>
                        About
                    </a>
                </li>
                 <li>
                    <a href="<?php echo elgg_get_site_url() ?>terms">
                        <span class="glyphicon fas fa-comments"></span>
                        Terms
                    </a>
                </li>
                 <li>
                    <a href="<?php echo elgg_get_site_url() ?>privacy">
                        <span class="glyphicon fa fa-lock fa-menu"></span>
                        Privacy
                    </a>
                </li>
                

            </ul>
        </div>
    </div>
<!-- Left sideBarContainer ends here -->    
    
     
 </nav>
      
<!-- TOP BAR NAVIGATIO ENDS -->      
      
      

        <div class="container-fluid principalContainer" itemscope itemtype="http://schema.org/VideoObject">
            <style>
    .compress{
        position: absolute;
        top: 50px;
    }
</style>
<div class="row main-video" id="mvideo">
    <div class="col-sm-2 col-md-2 firstC"></div>
    <div class="col-sm-8 col-md-8 secC">
        <div id="videoContainer">
            <div id="floatButtons" style="display: none;">
                <p class="btn btn-outline btn-xs move">
                    <i class="fa fa-arrows"></i>
                </p>
                <button type="button" class="btn btn-outline btn-xs" onclick="closeFloatVideo();floatClosed = 1;">
                    <i class="fa fa-close"></i>
                </button>
            </div>
            
         <!-- TM: MAIN VIDEO STARTS HERE -->   
            
            <div id="main-video" class="embed-responsive embed-responsive-16by9">
            
                <video poster="<?php echo $video_stage_icon; ?> " controls crossorigin 
                       class="embed-responsive-item video-js vjs-default-skin vjs-16-9 vjs-big-play-centered" 
                       id="mainVideo"  data-setup='{ "aspectRatio": "16:9" }'>

   <!-- TOM ELGG TRIAL -->



<?php 

// output our Source tags for video

    echo $source_tags;


?>


   
     <!-- TOM ELGG TRIAL -->               
                    
                    
                                     <p>If you can't view this video, your browser does not support HTML5 videos</p>
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a web browser that                        <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>

                </video>
                                    <div style="position: absolute; top: 0; left: 0; opacity: 0.5; filter: alpha(opacity=50);">
                        <a href="<?php echo $the_site_url ; ?>">
                      
                            <img src="<?php echo $video_image; ?>">
                        </a>
                    </div>
                    
                            </div>
        </div>
    </div>

    <div class="col-sm-2 col-md-2"></div>
</div>
<!--/row-->
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
                            document.location = '<?php echo $video_url; ?> ';
                        }
        
                });
        });
        player.persistvolume({
            namespace: "YouPHPTube"
        });
    });
</script>
                <div class="row">
                    <div class="col-sm-1 col-md-1"></div>
                    <div class="col-sm-6 col-md-6">
                        <div class="row bgWhite list-group-item">
                            <div class="row divMainVideo">
                                <div class="col-xs-4 col-sm-4 col-md-4">
<!--Video Icon  -->                                 
                      <img src="<?php echo $video_icon ; ?>" alt="<?php echo  $title; ?> " class="img-responsive   rotate0" height="130" itemprop="thumbnail"  />
                                   
         <time class="duration" itemprop="duration" datetime="<?php echo $video_duration_pt_time;  ?>" ><?php echo $video_duration;  ?></time>
                                    
        <meta itemprop="thumbnailUrl" content="<?php echo $video_icon; ?>" />
                                    <meta itemprop="contentURL" content="<?php echo  $video_url ; ?>" />
                                    <meta itemprop="embedURL" content="<?php echo  $video_url; ?>" />
                                    <meta itemprop="uploadDate" content="<?php echo  $date_updated_updated_string; ?>" /><!-- 2017-12-08 10:12:48 -->
                                    <meta itemprop="description" content="<?php echo $description ; ?> " />
                                </div>
                                
<!-- TM: TITLE SECTIONG   -->                                
                                <div class="col-xs-8 col-sm-8 col-md-8">
                                    <h1 itemprop="name">
                                    <?php echo  $title; ?>                                                
                                      <small>
                                            <span class="label label-success"><?php echo $video_access; ?></span>
                                      </small>
                                    </h1>
                                    
<!-- TM: video thumpnail SECTIONG   --> 
                                    
                           <div class="col-xs-12 col-sm-12 col-md-12"><div class="pull-left">
<!-- Video Owners Icon -->                 
     <img src="<?php echo $user_icon ; ?>" alt="" class="img img-responsive img-circle zoom" style="max-width: 40px;"/> 
       
   
     
   
<!-- OWNER INFO -->    
                          
                        </div><div class="commentDetails" style="margin-left:45px;"><div class="commenterName text-muted"><strong>  
                      
                       <?php echo $author_text;  ?>
  
                        
                        </strong><br>
                        
                        <div class="btn-group"><button class='btn btn-xs subscribeButton1'><span class='fa'></span> <b class='text'>Subscribe</b></button><button class='btn btn-xs subscribeButton1'><b class='textTotal'>8</b></button></div><div id="popover-content" class="hide">
        <div class="input-group">
          <input type="text" placeholder="E-mail" class="form-control"  id="subscribeEmail">
          <span class="input-group-btn">
          <button class="btn btn-primary" id="subscribeButton12">Subscribe</button>
          </span>
        </div>
    </div><script>
$(document).ready(function () {
$(".subscribeButton1").popover({
placement: 'bottom',
trigger: 'manual',
    html: true,
	content: function() {
          return $('#popover-content').html();
        }
});
});
</script><script>
            $(document).ready(function () {
                $(".subscribeButton1").off("click");
                $(".subscribeButton1").click(function () {
                    email = $('#subscribeEmail').val();
                    console.log(email);
                    if (validateEmail(email)) {
                        subscribe(email, 1);
                    } else {
                        $('.subscribeButton1').popover("toggle");
                        $("#subscribeButton12").click(function () {
                            $(".subscribeButton1").trigger("click");
                        });
                    }
                });
            });
        </script><br><small>2 weeks</small></div></div></div>
                                    <span class="watch-view-count pull-right text-muted" itemprop="interactionCount">
                                    
                                    <?php 
                                    // Video
                                    echo $Video_views_text;
                                    
                                    ?>
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 watch8-action-buttons text-muted">
                                    

                                    <button class="btn btn-default no-outline" id="addBtn" data-placement="bottom">
                                        <span class="fa fa-plus"></span> Add to </button>
                                    
                                    
<!-- Popup 4 Add to playlist button -->
            
            <?php 
            // Video add to the playlist
           echo $webui_popover_content;
           
           ?>
                
                                    <script>
                                        function loadPlayLists() {
                                            $.ajax({
                                                url: '<?php echo $the_site_url; ?>',
                                                success: function (response) {
                                                    $('#searchlist').html('');
                                                    for (var i in response) {
                                                        if (!response[i].id) {
                                                            continue;
                                                        }
                                                        console.log(response[i]);
                                                        var icon = "lock"
                                                        if (response[i].status == "public") {
                                                            icon = "globe"
                                                        }

                                                        var checked = "";
                                                        for (var x in response[i].videos) {
                                                            if (response[i].videos[x].id ==285) {
                                                                checked = "checked";
                                                            }
                                                        }

                                                        $("#searchlist").append('<a class="list-group-item"><i class="fa fa-' + icon + '"></i> <span>' + response[i].name + '</span><div class="material-switch pull-right"><input id="someSwitchOptionDefault' + response[i].id + '" name="someSwitchOption' + response[i].id + '" class="playListsIds" type="checkbox" value="' + response[i].id + '" ' + checked + '/><label for="someSwitchOptionDefault' + response[i].id + '" class="label-success"></label></div></a>');
                                                    }
                                                    $('#searchlist').btsListFilter('#searchinput', {itemChild: 'span'});
                                                    $('.playListsIds').change(function () {
                                                        modal.showPleaseWait();
                                                        $.ajax({
                                                            url: '<?php echo $our_site_url?>playListAddVideo.json',
                                                            method: 'POST',
                                                            data: {
                                                                'videos_id': 285,
                                                                'add': $(this).is(":checked"),
                                                                'playlists_id': $(this).val()
                                                            },
                                                            success: function (response) {
                                                                console.log(response);
                                                                modal.hidePleaseWait();
                                                            }
                                                        });
                                                        return false;
                                                    });
                                                }
                                            });
                                        }
                                        $(document).ready(function () {
                                            loadPlayLists();
                                            $('#addBtn').webuiPopover();
                                            $('#addPlayList').click(function () {
                                                modal.showPleaseWait();
                                                $.ajax({
                                                    url: '<?php echo $our_site_url?>addNewPlayList',
                                                    method: 'POST',
                                                    data: {
                                                        'videos_id': 285,
                                                        'status': $('#publicPlayList').is(":checked") ? "public" : "private",
                                                        'name': $('#playListName').val()
                                                    },
                                                    success: function (response) {
                                                        if (response.status * 1 > 0) {
                                                            // update list
                                                            loadPlayLists();
                                                            $('#searchlist').btsListFilter('#searchinput', {itemChild: 'span'});
                                                            $('#playListName').val("");
                                                            $('#publicPlayList').prop('checked', true);
                                                        }
                                                        modal.hidePleaseWait();
                                                    }
                                                });
                                                return false;
                                            });

                                        });
                                    </script>
                                    
<!-- TM: Share, LIKE SECTIONG   -->                                    
                                    
                                    
                                    <a href="#" class="btn btn-default no-outline" id="shareBtn">
                                        <span class="fa fa-share"></span> Share                                    </a>
                                    <a href="#" class="btn btn-default no-outline pull-right " id="dislikeBtn"
                                                                               data-toggle="tooltip" title="Don´t like this video? Sign in to make your opinion count."
                                       >
                                        <span class="fa fa-thumbs-down"></span> <small>0</small>
                                    </a>			
                                    <a href="#" class="btn btn-default no-outline pull-right " id="likeBtn"
                                                                               data-toggle="tooltip" title="Like this video? Sign in to make your opinion count."
                                       >
                                        <span class="fa fa-thumbs-up"></span> <small>0</small>
                                    </a>
                                    
                                    
<!-- TM: Share, LIKE SECTIONG   -->                                 
                                    <script>
                                        $(document).ready(function () {

                                                    $("#dislikeBtn, #likeBtn").click(function () {

                                                    $(this).tooltip("show");
                                                    return false;
                                                });
        
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>

                        <div class="row bgWhite list-group-item" id="shareDiv">
                            <div class="tabbable-panel">
                                <div class="tabbable-line text-muted">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link " href="#tabShare" data-toggle="tab">
                                                <span class="fa fa-share"></span>
                                                Share                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " href="#tabEmbeded" data-toggle="tab">
                                                <span class="fa fa-code"></span>
                                                Embeded                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#tabEmail" data-toggle="tab">
                                                <span class="fa fa-envelope"></span>
                                                E-mail                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content clearfix">
                                        <div class="tab-pane active" id="tabShare">
                                                                                       
<ul class="social-network social-circle">
    <li><a href="https://www.facebook.com/sharer.php?u=<?php echo $video_url; ?> title=<?php echo $video_title; ?>" target="_blank" class="icoFacebook" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
    
<li><a href="http://twitter.com/home?status=<?php echo $video_title; ?>+<?php echo $video_url; ?>" target="_blank"  class="icoTwitter" title="Twitter"><i class="fab fa-twitter"></i></a></li>


<li><a href="https://plus.google.com/share?url=<?php echo $video_url; ?>" target="_blank"  class="icoGoogle" title="Google +"><i class="fab fa-google-plus-g"></i></a></li>
</ul>                         </div>
                                        <div class="tab-pane" id="tabEmbeded">
                                            <h4><span class="glyphicon glyphicon-share"></span> Share Video:</h4>
                                            <textarea class="form-control" style="min-width: 100%" rows="5">&lt;iframe width=&quot;640&quot; height=&quot;480&quot; style=&quot;max-width: 100%;max-height: 100%;&quot; src=&quot;<?php echo $video_url; ?>; frameborder=&quot;0&quot; allowfullscreen=&quot;allowfullscreen&quot; class=&quot;YouPHPTubeIframe&quot;&gt;&lt;/iframe&gt;</textarea>
                                        </div>
                                        <div class="tab-pane" id="tabEmail">
                                                                                            <strong>
                                                    <a href="<?php echo $the_site_url; ?>login">Sign in now!</a>
                                                </strong>
                                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row bgWhite list-group-item">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-lg-12">
                                
 <!--- ELGG VIDEO MENU  -->   
 
                        <?php echo $video_mind_menu; ?>
                             
                                    <div class="col-xs-4 col-sm-2 col-lg-2 text-right"><strong>Category:</strong></div>
                                    <div class="col-xs-8 col-sm-10 col-lg-10"><a class="btn btn-xs btn-default"  href="https://demo.youphptube.com/cat/movies"><span class="fa fa-film"></span> Movies</a></div>


                                    <div class="col-xs-4 col-sm-2 col-lg-2 text-right"><strong>Description: </strong> </div>
                                    <div class="col-xs-8 col-sm-10 col-lg-10" itemprop="description"><?php echo $title; ?>  </div>
                                </div>
                            </div>

                        </div>
                        <script>
                            $(document).ready(function () {
                                $("#shareDiv").slideUp();
                                $("#shareBtn").click(function () {
                                    $("#shareDiv").slideToggle();
                                    return false;
                                });
                            });
                        </script>
                        <div class="row bgWhite list-group-item">
                        
<?php                         
    // elgg comments                   
 echo $comments                      
 
 
 ?>                           
<!-- TM: Comments -->    

<!-- TM: Commnets End here  -->                             
                            
                            
                        </div>
                        
                        




                    </div>
                    
                    
                    
<!-- TM: Right bar starts here  -->                    
                    
                    <div class="col-sm-4 col-md-4 bgWhite list-group-item rightBar">
                                   <div class="col-lg-12 col-sm-12 col-xs-12 autoplay text-muted" style="display: none;">
                                <strong>
                                    Up Next                                </strong>
                                <span class="pull-right">
                                    <span>
                                        Autoplay                                    </span>
                                    <span>
                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="bottom"  title="When autoplay is enabled, a suggested video will automatically play next."></i>
                                    </span>
                                    <input type="checkbox" data-toggle="toggle" data-size="mini" class="saveCookie" name="autoplay">
                                </span>
                            </div>
                            
                         
<!-- TM: Starts AUTO PLAY VIDOE -->     
  
	<?php 
	
	echo elgg_view('autoplay/autoplay', array()); 
	
	?>

                            
<!-- TM: Starts Google ads  -->  

<?php echo elgg_view('adsbygoogle/adsbygoogle', array()); ?>                            
                            
                                                    
            <div class="col-lg-12 col-sm-12 col-xs-12 extraVideos nopadding"></div>
            
            
                        <!-- videos List -->
                        <div id="videosList">
                            <div class="col-md-8 col-sm-12 " >
    <select class="form-control" id="sortBy" >
        <option value="newest" data-icon="glyphicon-sort-by-attributes" value="desc" selected='selected'> Date Added (newest)</option>
        <option value="oldest" data-icon="glyphicon-sort-by-attributes-alt" value="asc" > Date Added (oldest)</option>
        <option value="popular" data-icon="glyphicon-thumbs-up"  > Most Popular</option>
        <option value="views_count" data-icon="glyphicon-eye-open"  > Most Watched</option>
    </select>
</div>
<div class="col-md-4 col-sm-12">
    <select class="form-control" id="rowCount">
        <option selected='selected'>10</option>
        <option >20</option>
        <option >30</option>
        <option >40</option>
        <option >50</option>
    </select>
</div>

<!---TM: starts of right Sidebar -->  

<?php 
	// Elgg video right_sidebar
	echo elgg_view_resource('video/video/sidebar_right', array());
?>

<!---TM: End of right Sidebar -->    
      
    
    <ul class="pages">
</ul>
<div class="loader" id="pageLoader" style="display: none;"></div>
                                                                 
<!-- Javascript for outloader  -->
                       
                       
                       
                       
                       </div>
                        <!-- End of videos List -->

                        <script>
                            var fading = false;
                            $(document).ready(function () {

                                $("input.saveCookie").each(function () {
                                    var mycookie = Cookies.get($(this).attr('name'));
                                    console.log($(this).attr('name'));
                                    console.log(mycookie);
                                    if (mycookie && mycookie == "true") {
                                        $(this).prop('checked', mycookie);
                                        $('.autoPlayVideo').slideDown();
                                    }
                                });
                                $("input.saveCookie").change(function () {
                                    console.log($(this).attr('name'));
                                    console.log($(this).prop('checked'));
                                    var auto = $(this).prop('checked');
                                    if (auto) {
                                        $('.autoPlayVideo').slideDown();
                                    } else {
                                        $('.autoPlayVideo').slideUp();
                                    }
                                    Cookies.set($(this).attr("name"), auto, {
                                        path: '/',
                                        expires: 365
                                    });
                                });
                                setTimeout(function () {
                                    $('.autoplay').slideDown();
                                }, 1000);
                                // Total Itens 6
                            });
                        </script>
                    </div>
                    <div class="col-sm-1 col-md-1"></div>
                </div>
                
        </div>
        
<!-- Footer Js scripts -->

    <?php 
	//  video head links, metas, title, and stylesheet
	echo elgg_view_resource('video/video/js/js', array());
     
      ?>   


        
        
    </body>
</html>

