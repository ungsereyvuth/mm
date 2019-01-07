<?php
if(!$usersession->isLogin()){goto skip_user_menu;}
$web_config = web_config(array('thumbnail_path','profile_pic_path','no_pic'));
$picPath = $web_config['thumbnail_path'];$profilePath = $web_config['profile_pic_path'];
$avatar = $no_pic = $web_config['no_pic'];
$photo=$usersession->info()->photo;
if($photo<>''){	
	if(file_exists($_SERVER['DOCUMENT_ROOT'].$picPath.$photo)){
		$avatar =$picPath.$photo;
	}elseif(file_exists($_SERVER['DOCUMENT_ROOT'].$profilePath.$photo)){
		$avatar =$profilePath.$photo;
	}else{
		$avatar =$no_pic;
	}
}
?>
<aside id="left-panel">

<!-- User info -->
<div class="login-info">
	<span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
		
		<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
			<img src="<?=$avatar?>" alt="me" class="online" /> 
			<span>
				<?=mb_convert_case($usersession->info()->fullname, MB_CASE_TITLE, 'UTF-8')?>
			</span>
			<i class="fa fa-angle-down"></i>
		</a> 
		
	</span>
</div>
<!-- end user info -->

<nav>
	<!-- 
	NOTE: Notice the gaps after each icon usage <i></i>..
	Please note that these links work a bit different than
	traditional href="" links. See documentation for details.
	-->

	<ul>


		<?php		
		$active_page = $pageData->originalclass;
		$active_page_id = isset($pageData->label->label->$active_page->id)?$pageData->label->label->$active_page->id:0;
		if(isset($pageData->data->component->user_menu)){

			foreach($pageData->data->component->user_menu as $key=>$value){
				if(isset($value['child']) and is_array($value['child'])){
					$sub_menu='';$sub_active=false;
					foreach($value['child'] as $sub_key=>$sub_value){
						$orderingtxt = isAdmin($usersession->info()->id)?'​('.$sub_value['ordering'].')':'';
						if($active_page_id==$sub_value['page_id']){$active_class='active';$sub_active=true;}else{$active_class='';}
						$sub_menu.='<li class="'.$active_class.'"><a href="/'.$pageData->lang->selected.$sub_value['url'].'" title="'.$sub_value['title'].$orderingtxt.'"><span class="menu-item-parent">'.$sub_value['icon'].' '.$sub_value['title'].'</span><span id="menu_'.$sub_value['code'].'"></span></a></li>';
					}
					$orderingtxt = isAdmin($usersession->info()->id)?'​('.$value['ordering'].')':'';
					echo '<li class="'.($sub_active?'open':'').'"><a href="#" title="'.$value['title'].$orderingtxt.'">'.$value['icon'].' <span class="menu-item-parent">'.$value['title'].' <span id="menu_'.$value['code'].'"></span></span></a>
								<ul id="menu_'.$value['id'].'" style="'.($sub_active?'display: block;':'').'">'.$sub_menu.'</ul>

						<li>';

				}else{
					$orderingtxt = isAdmin($usersession->info()->id)?'​('.$value['ordering'].')':'';
					echo '<li class="'.($active_page_id==$value['page_id']?'active':'').'" title="'.$value['title'].$orderingtxt.'​">
								<a href="/'.$pageData->lang->selected.$value['url'].'">'.$value['icon'].' <span class="menu-item-parent">'.$value['title'].'<span id="menu_'.$value['code'].'"></span></span></a>
							</li>';
				}
			}
		}
		?>

	</ul>
</nav>

<span class="minifyme" data-action="minifyMenu"> 
	<i class="fa fa-arrow-circle-left hit"></i> 
</span>

</aside>
<!-- END NAVIGATION -->

<?php skip_user_menu: ?>

