<?php
$footer_info_links=$social_network='';
foreach($pageData->label->footer_info_links as $key=>$value){	
	$footer_info_links.='<li><a href="/'.$pageData->lang->selected.$value->url.'">'.$value->title.'</a></li>';
}
foreach($pageData->label->social_network as $key=>$value){	
	$social_network.='<a target="new" class="link-1 icon mdi '.$value->icon.'" href="'.$value->url.'"></a>';
}

?>
      <!-- Page Footer-->
      <footer class="section footer-classic">
        <div class="footer-classic-main bg-image context-dark" style="background-image: url(/assets/frontend/img/wallpapers/footer_info.png);">
          <div class="container">
            <div class="footer-classic-layout">
              <div class="footer-classic-layout-item">
                <div class="footer-classic-item-block">
                  <ul class="list list-sm">
                    <?=$footer_info_links?>
                  </ul>
                </div>
              </div>
              <div class="footer-classic-layout-item footer-classic-item-block-2"> 
                <h5 class="footer-classic-title"><?=$pageData->label->label->contact->title?></h5>
                <div class="footer-classic-item-block">
                  	<?=$pageData->data->component->footer->footer_contact?>
                  	<div class="group group-sm">
                  		<?=$social_network?>
                	</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-classic-aside">
          <div class="container">
            <p class="rights"><span>&copy;&nbsp; </span><span><span><?=enNum_khNum(date("Y"))?></span> <?=$pageData->label->label->copyrighted_by->title?></span> <span>&nbsp;</span><span><?=$pageData->label->system_title->sys->title?></span></p>
          </div>
        </div>
      </footer>