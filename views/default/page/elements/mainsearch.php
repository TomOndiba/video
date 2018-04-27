<?php
// https://github.com/Centillien/videos/blob/a30a9cc04a85a9b25bc376ccbf9b6881d65d74d2/views/default/page/elements/search.php#L3
$site_name = elgg_get_site_entity()->name;
// $action = elgg_get_site_url() ."videos/youtube";
$action = elgg_get_site_url() ."search";

$search_videos = elgg_echo('videos:search:videos');
$search = elgg_echo('videos:search');

$htmlBody = <<<END
    
<!--[if !IE]><!-->       <!--<![endif]-->

 <!-- TM: added to stop icon breaking from input box -->  


<topbar-ypt-searchbox id="search" class="style-scope topbar-ypt-masthead" role="search" mode="legacy">
    
    <form id="search-form" action=" $action " class="style-scope topbar-ypt-searchbox">
      
     
      
      <div id="container" class="style-scope topbar-ypt-searchbox">
        <div id="search-input" slot="search-input"><input id="search" autocapitalize="none" autocomplete="off" autocorrect="off" autofocus="" 
		name="q" tabindex="0" spellcheck="false" placeholder="$search" aria-label="$search" aria-haspopup="false" role="combobox" 
		aria-autocomplete="list" dir="ltr" style="outline: medium none currentcolor;" class="topbar-ypt-searchbox" type="text"   required
		inlength="4" maxlength="156">
		
       </div>
        <div id="search-container" slot="search-container" class=" "></div>
       
        
        <button is="karatasi-icon-button-light" id="search-icon" class="search-icon style-scope topbar-ypt-searchbox" aria-label="Search" hidden="">
          <ypt-icon class="style-scope topbar-ypt-searchbox" disable-upgrade="">
          </ypt-icon>
        </button>

        <karatasi-tooltip for="search-icon" prefix="" class="style-scope topbar-ypt-searchbox" role="tooltip" tabindex="-1">

    <div id="tooltip" class="hidden style-scope karatasi-tooltip">
      Search
    </div>
  </karatasi-tooltip>
      </div>

      <button id="search-icon-legacy" class=" style-scope topbar-ypt-searchbox" aria-label="Search">
        <ypt-icon class="style-scope topbar-ypt-searchbox">
       
       <!--
        <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" 
		style="pointer-events: none; display: block; width: 100%; height: 100%;" class="style-scope ypt-icon"><g class="style-scope ypt-icon">
        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" class="style-scope ypt-icon"></path>
      </g></svg>
    -->
    
      <span class="fa fa-search"></span><!-- TM: added Fontowsome -->
  
  </ypt-icon>
        <karatasi-tooltip prefix="" class="style-scope topbar-ypt-searchbox" role="tooltip" tabindex="-1">
    

    <div id="tooltip" class="hidden style-scope karatasi-tooltip">
      Search
    </div>
  </karatasi-tooltip>
      </button>
   
    </form>
  </topbar-ypt-searchbox>


 <!-- TM: added to stop icon breaking from input box --> 



END;

echo $htmlBody;



