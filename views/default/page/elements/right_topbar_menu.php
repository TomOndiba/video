<?php

$owner = elgg_get_page_owner_entity();
	if (!$owner) {
		forward('video/all');
	}
$username = $owner->name;
$site_name = elgg_get_site_entity()->name;

$action = elgg_get_site_url() ."search";

$search_videos = elgg_echo('videos:search:videos');
$search = elgg_echo('videos:search');

 //  video head top bar Search box
 $small_right_topbar_menu = elgg_view('page/elements/search', array());
 
 // User right topbar menu alt login account 
 $right_topbar_menu_alt = elgg_view('page/elements/right_topbar_menu_alt', array());

$user_icon = $owner->getIconURL([
		'size' => 'medium',
		// 'type' => 'video',
	]);
	
$myadventhome_logo_url = elgg_get_site_url() . "mod/video/graphics/logo/MyAdvetHome_Tube.png";
	
	
// Compute only if it will be displayed...
if (elgg_is_logged_in()) {
	
$upload = elgg_get_site_url() ."video/add/$owner->guid";
$videos_upload = elgg_echo('videos:upload'); 
$visible_button = '<i class="fas fa-upload"></i><span class="badge onlineApplications" style=" background: rgba(255,0,0,1); color: #FFF;">' . $videos_upload . '</span>';
}else {
	
$upload = elgg_get_site_url() ."login";
$register = elgg_get_site_url() ."register";
$register_title = elgg_echo('register');
$videos_upload = elgg_echo('login'); 
	
// Upload button	
$invisible_button = 	'<i class="fa fa-lock fa-menu"   > <span class="glyphicon   "></span> &nbsp; '    . $videos_upload . '</i>' ;
                               
// register button
$invisible_register_button = 	'<i class=" fa fa-user fa-menu"   > <span class="glyphicon   "></span> &nbsp; '    . $register_title . '</i>' ;
$register_button = '<li class="dropdown"><a href="' . $register. '" class=" btn btn-default navbar-btn"> ' .  $invisible_register_button . '</a> <ul class="dropdown-menu dropdown-menu-right notify-drop" id="availableLive"></ul></li>  ';       

}
	

$htmlBody = <<<END

 <li>

            <div class="navbar-header">
                <button type="button" class=" navbar-toggle btn btn-default navbar-btn" data-toggle="collapse" data-target="#myNavbar" style="padding: 6px 12px;">
                    <span class="fa fa-bars"></span>                      
                </button>
            </div>
            

            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="right-menus">

               <!-- small top bar Search  --> 
                 $small_right_topbar_menu                             
                            
<style>
    .liveVideo{
        position: relative;
    }
    .liveVideo .liveNow{
        position: absolute;
        bottom: 5px;
        right: 5px;
        background-color: rgba(255,0,0,0.7);
    }
</style>

    <li class="dropdown">
    <a href=" $upload " class=" btn btn-default navbar-btn">
        <!-- upload or login  button -->
        $visible_button
        $invisible_button
    </a>
    <ul class="dropdown-menu dropdown-menu-right notify-drop" id="availableLive"></ul>
</li>


<style>

    .dropdown-submenu {
        position: relative;
    }

    .open2{
        z-index: 99999;
    }

    .dropdown-submenu .dropdown-menu {
        margin-right: 50px;
        margin-left: -200px;
    }
</style>
<li>

<!--  top bar right buttons-->

    <div class="btn-group">   
        <button id="avatar-btn" type="button" aria-haspopup="true" class="style-scope mahd-topbar-menu-button-renderer    dropdown-toggle   "  data-toggle="dropdown"   aria-label="User profile photo that opens list of alternate accounts"   >
        <mah-img-shadow height="32" width="32" class="style-scope mahd-topbar-menu-button-renderer no-transition" style="background-color: transparent;" loaded="">
		<img id="img" class="style-scope mah-img-shadow" src="$user_icon" width="32" height="32">
		</mah-img-shadow>

</button>
        
        <ul class="dropdown-menu dropdown-menu-right" role="menu">

           <!-- topbar_right_menu_alt starts -->
             
           $right_topbar_menu_alt
           
           <!-- topbar_right_menu_alt ends -->

        </ul>   
    </div>

            <!-- Right top side bar -->

</li>

<script>
    $(document).ready(function () {
        $('.dropdown-submenu a.test').on("click", function (e) {

            $('.open2').slideUp();
            if ($(this).next('ul').hasClass('open2')) {
                $(this).next('ul').slideUp();
                $(this).next('ul').removeClass('open2');
            } else {
                $(this).next('ul').slideDown();
                $(this).next('ul').addClass('open2');
            }
            e.stopPropagation();
            e.preventDefault();
        });

        $('li[data-toggle="tooltip"]').tooltip({
            animated: 'fade',
            html: true
        });
    });
</script>                    
                  
  <!-- Sign UP button starts -->    

        $register_button
        
                </ul>
            </div>

        </li>

END;

echo $htmlBody;



