<?php
/* 
 * VIDEO User topbar alt 
 * 
 */
$owner = elgg_get_page_owner_entity();
$url = elgg_get_site_url();
$site = elgg_get_site_entity();
$title = $site->name;
$prev_q = get_input('q', '');
/* Use custom menus from theme settings
 * Accepted values :
 * empty => use hardcoded elgg user menu (below)
 * any other value => display corresponding menu (using translations if available)
 * 
 * Test to display menu : $menu => false = do not use menu | $name = display menu $name
 * 
 */
$topbar_menu = false;
$topbar_menu_public = false;

$menu = false;

// Login url

$upload = elgg_get_site_url() ."video/add/$owner->guid";

$user_icon = $owner->getIconURL([
		'size' => 'medium',
		// 'type' => 'video',
	]);
	
$myadventhome_logo_url = elgg_get_site_url() . "mod/video/graphics/logo/MyAdvetHome_Tube.png";


// log in token
 $ts = time();
 $token = generate_action_token($ts);

// Compute only if it will be displayed...
if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
	$ownguid = $own->guid;
	$ownusername = $own->username;

	// Demandes de contact en attente : affiché seulement s'il y a des demandes en attente
	$friendrequests_options = array("type" => "user", "count" => true, "relationship" => "friendrequest", "relationship_guid" => $own->guid, "inverse_relationship" => true);
	$friendrequests_count = elgg_get_entities_from_relationship($friendrequests_options);
	$friendrequests = '';
	if ($friendrequests_count == 1) {
		$friendrequests .= '<a class="elgg-menu-counter" href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('video:friendinvite') . '">' . $friendrequests_count . '</a>';
	} else if ($friendrequests_count > 1) {
		$friendrequests .= '<a class="elgg-menu-counter" href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('video:friendinvites') . '">' . $friendrequests_count . '</a>';
	}
	
	// Messages non lus
	if (elgg_is_active_plugin('messages')) {
		$num_messages = (int)messages_count_unread();
		if ($num_messages != 0) {
			$text = "$num_messages";
			$tooltip = elgg_echo("messages:unreadcount", array($num_messages));
			$new_messages_counter = '<a class="elgg-menu-counter" href="' . $url . 'messages/inbox/' . $ownusername . '" title="' . $tooltip . '">' . $text . '</a>';
		}
	}
	if (elgg_is_active_plugin('site_notifications')) {
		$site_notifications_count = elgg_get_entities_from_metadata(array(
					'type' => 'object',
					'subtype' => 'site_notification',
					'owner_guid' => $own->guid,
					'metadata_name' => 'read',
					'metadata_value' => false,
					'count' => true,
				));
		$new_notifications_counter = '';
		if ($site_notifications_count > 0) {
			$tooltip = '';
			$text = "$site_notifications_count";
			$new_notifications_counter .= '<a class="elgg-menu-counter" href="' . $url . 'site_notifications/view/' . $ownusername . '" title="' . $tooltip . '">' . $text . '</a>';
		}
	}
	
	// Login_as menu link
	$loginas_logout = '';
	if (elgg_is_active_plugin('login_as')) {
		$session = elgg_get_session();
		$original_user_guid = $session->get('login_as_original_user_guid');
		if ($original_user_guid) {
			$original_user = get_entity($original_user_guid);
			$loginas_title = elgg_echo('login_as:return_to_user', array($ownusername, $original_user->username));
			$loginas_html = elgg_view('login_as/topbar_return', array('user_guid' => $original_user_guid));
			$loginas_logout = '<li id="logout">' . elgg_view('output/url', array('href' => $url . "action/logout_as", 'text' => $loginas_html, 'is_action' => true, 'name' => 'login_as_return', 'title' => $loginas_title, 'class' => 'login-as-topbar')) . '</li>';
		}
	}
	// @TODO : demandes en attente dans les groupes dont l'user est admin ou co-admin
	// @TODO : comptes à valider en attente
	// @TODO : autres indicateurs d'actions admin ?
}

           // TOPBAR LOGGED IN MENU : personal tools and administration
	if (elgg_is_logged_in()) {
	
	
	echo '<li class="dropdown-header">';
	echo $username;
	echo '</li><li  class="dropdown-submenu active" style=" min-width: 165px;"><img style="height: 60px; width: 60px; float: left;" class="img img-responsive  img-thumbnail " src="';
        echo $user_icon;
            
        echo  '"/><img style= "height: 60px; width: 100px;" class="img img-responsive  img-thumbnail" src="';
        echo $myadventhome_logo_url;
        echo '"/></li><li class="divider"></li>';

			echo '<div class="menu-topbar-toggle"><i class="fa fa-user fa-menu"></i> ' . elgg_echo('video:menu:topbar') . '</div>';
			?>
			<ul class="elgg-menu elgg-menu-topbar elgg-menu-topbar-alt" id="menu-topbar">
				<li><a href="<?php echo $url . 'profile/' . $ownusername; ?>" id="esope-profil"><img src="<?php echo $own->getIconURL('topbar'); ?>" alt="<?php echo $own->name; ?>" /> <?php echo $own->name; ?></a></li>
				<?php if (elgg_is_active_plugin('messages')) { ?>
				<li id="msg">
					<a href="<?php echo $url . 'messages/inbox/' . $ownusername; ?>"><i class="far fa-envelope"></i>&nbsp;   <?php /* echo elgg_echo('messages'); */ ?></a>
					<?php if ($new_messages_counter) { echo $new_messages_counter; } ?>
				</li>
				<li id="notifications">
					<a href="<?php echo $url . 'site_notifications/view/' . $ownusername; ?>"><i class="fa fa-info-circle"> </i></a>
					<?php if ($new_notifications_counter) { echo $new_notifications_counter; } ?>
				</li>
				<?php } ?>
				<li id="man">
					<a href="<?php echo $url . 'friends/' . $ownusername; ?>"><?php echo elgg_echo('friends'); ?></a> 
					<?php echo $friendrequests; ?>
				</li>
				<li id="usersettings"><a href="<?php echo $url . 'settings/user/' . $ownusername; ?>"><i class="fa fa-cog setting icon"></i>&nbsp; <?php echo elgg_echo('video:usersettings'); ?></a></li>
						<!--
				<li><?php echo elgg_echo('video:myprofile'); ?></a>
						<li><a href="<?php echo $url . 'profile/' . $ownusername . '/edit'; ?>"><?php echo elgg_echo('profile:edit'); ?></a></li>
						<li><a href="<?php echo $url . 'avatar/edit/' . $ownusername . '/edit'; ?>"><?php echo elgg_echo('avatar:edit'); ?></a></li>
				</li>
						//-->
				<?php if (elgg_is_admin_logged_in()) { ?>
					<li id="admin"><a href="<?php echo $url . 'admin/dashboard/'; ?>"><i class="fa fa-cogs settings icon"></i> &nbsp;<?php echo elgg_echo('admin'); ?></a></li>
				<?php } ?>
			
				<?php if ($loginas_logout) { echo $loginas_logout; } ?>
				<li id="logout"><?php echo elgg_view('output/url', array('href' => $url . "action/logout", 'text' => '<i class="fas fa-sign-out-alt"></i> &nbsp;' . elgg_echo('logout'), 'is_action' => true)); ?></li>
				<?php
				if ($language_selector) {
					echo '<li class="language-selector">' . $language_selector . '</li>';
				}
				?>
			</ul>
			<?php
			echo '<div class="clearfloat"></div>';
}else {
	 
	            echo '<div class="menu-topbar-toggle"><i class="fa fa-gear"></i> &nbsp;' . elgg_echo('video:menu:topbar') . '</div>';	
?>
                           
<div>

    <a href=" <?php echo $url . 'login?__elgg_token='; ?><?php echo $token ?>&__elgg_ts=<?php echo $ts ?>  " class="btn btn-success btn-block">
                                <span class="glyphicon glyphicon-log-in fa fa-user fa-menu "></span>&nbsp;
                                <?php echo  elgg_echo('login'); ?>                        
   </a>
      
</div>
                        


<?php
                        
                        echo $login_form;

  }   ?>
