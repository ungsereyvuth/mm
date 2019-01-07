<?php
$picPath = web_config('thumbnail_path');$avatar =$no_pic = web_config('no_pic');$photo=$usersession->info()->photo;
if($photo<>''){
$avatar =$picPath.$photo;
$avatar = (!file_exists($_SERVER['DOCUMENT_ROOT'].$avatar))?$no_pic:$avatar;
}
?>
<div class="col-md-<?=$col_sidebar?> col-sm-pull-<?=(12-$col_sidebar)?> pad10 v_mgn5 ">    
    <div class="nav-side-menu">
        <div class="brand">
        	<div class="inline-block v_pad5">
			<img src="/assets/frontend/img/blank_img_square.png" class="img-responsive bg_pic_cover media-object rounded-x inline-block" style="background-image: url(<?=$avatar?>);">
            </div>
			<?=ucwords($usersession->info()->fullname)?>
        </div>
        <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>      
            <div class="menu-list">      
                <ul id="menu-content" class="menu-content collapse out">
                	<?php		
					$active_page = $pageData->fileview;
					$active_page_id = isset($pageData->label->label->$active_page->id)?$pageData->label->label->$active_page->id:0;
					foreach($pageData->data->component->user_menu as $key=>$value){
						if(isset($value['child']) and is_array($value['child'])){
							$sub_menu='';$sub_active=false;
							foreach($value['child'] as $sub_key=>$sub_value){
								if($active_page_id==$sub_value['page_id']){$active_class='active';$sub_active=true;}else{$active_class='';}
								$sub_menu.='<li class="'.$active_class.'"><a href="/'.$pageData->lang->selected.$sub_value['url'].'">'.$sub_value['icon'].' '.$sub_value['title'].'</a></li>';
							}
							echo '<li data-toggle="collapse" data-target="#menu_'.$value['id'].'" class="collapsed">
									 <a href="#" data-toggle="collapse">'.$value['icon'].' '.$value['title'].' <span class="arrow"></span></a>									 
								</li>
								<ul id="menu_'.$value['id'].'" class="sub-menu collapse '.($sub_active?'in':'').'">'.$sub_menu.'</ul>';
						}else{
							echo '<li class="'.($active_page_id==$value['page_id']?'active':'').'"><a href="/'.$pageData->lang->selected.$value['url'].'">'.$value['icon'].' '.$value['title'].'</a></li>';
						}
					}
					?>
                </ul>
         </div>
    </div>
</div>

<?php //var_dump($pageData->data->component->user_menu); ?>

