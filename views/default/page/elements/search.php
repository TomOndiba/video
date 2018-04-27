<?php
// https://github.com/Centillien/videos/blob/a30a9cc04a85a9b25bc376ccbf9b6881d65d74d2/views/default/page/elements/search.php#L3
$site_name = elgg_get_site_entity()->name;
$action = elgg_get_site_url() ."search";

$search_videos = elgg_echo('videos:search:videos');
$search = elgg_echo('videos:search');

$htmlBody = <<<END

              <div class="mobile-visible">
                        <form class="navbar-form navbar-left" id="searchForm"  action="$action" >
                            <div class="input-group" >
                                <div class="form-inline">
                                    <input class="form-control" type="text" name="q" placeholder="Search">
                                    <button class="input-group-addon form-control"  style="width: 50px;" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                </div>
                            </div>
                        </form>
                    </div>

END;

echo $htmlBody;
