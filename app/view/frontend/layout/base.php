<?php 
if (!isset($_SESSION)) session_start(); 
//---- start page variables
$selected_language = $pageData->lang->selected; 
$lang_list = $pageData->lang->getlist; 
$pageArr = array_values(array_filter($pageData->page));//filter to remove empty elements and array_values to reset its keys
if(count($pageArr)){$pagename = end($pageArr);}else{$pagename = 'home';}
if(is_array($pagename)){
	$pagetitle = $pagename['title'];
}else{
	$pagetitle = 'Untitled';
	foreach($layout_cate as $cate_value){
		$catetitle = $cate_value['title'];
		$pagetitle = isset($pageData->label->$catetitle->$pagename->title)?$pageData->label->$catetitle->$pagename->title:'Untitled';
		if(isset($pageData->label->$catetitle->$pagename->title)){break;}
	}
}
$pagetitle=strip_tags($pagetitle);
//---- end page variables
//---- start check if login/logout required
if($pageData->loginRequired and !$usersession->isLogin()){$_SESSION['nexturl']=$_GET['url'];$_SESSION['nextpagetitle']=$pagetitle;header("location: /$selected_language".$pageData->label->label->login->url);
}elseif($pageData->logoutRequired and $usersession->isLogin()){header("location: /$selected_language".$usersession->info()->homepage);}
//---- end check if login/logout required
//---- start breadcrumb
$breadcrumb_txt = '<li><span style="color:#279fbb;"><i class="fa fa-angle-double-right"></i></span> <a href="/'.$selected_language.($pageData->label->menu->home->url=='/'?'':$pageData->label->menu->home->url).'">'.$pageData->label->menu->home->title.'</a></li>';
if(count($pageArr)){
	foreach($pageArr as $key=>$value){
		if($key==(count($pageArr)-1)){
			if(is_array($value)){
				$breadcrumb_txt .= '<li class="active tooltips" title="'.$value['title'].'">'.((mb_strlen($value['title'],"utf-8")>50)?(mb_substr($value['title'],0,20,"utf-8").'...'):$value['title']).'</li>';
			}else{
				$bc_txt = 'Untitled';
				foreach($layout_cate as $cate_value){
					$catetitle = $cate_value['title'];
					$bc_txt = isset($pageData->label->$catetitle->$value->title)?$pageData->label->$catetitle->$value->title:'Untitled';
					if(isset($pageData->label->$catetitle->$value->title)){break;}
				}	
				$breadcrumb_txt .= '<li class="active">'.$bc_txt.'</li>';
			}
		}else{
			if(is_array($value)){
				$breadcrumb_txt .= '<li><a href="/'.$selected_language.$value['url'].'">'.$value['title'].'</a></li>';
			}else{
				$bc_url = '#';$bc_txt = 'Untitled';
				foreach($layout_cate as $cate_value){
					$catetitle = $cate_value['title'];
					$bc_url = '/'.$selected_language.(isset($pageData->label->$catetitle->$value->url)?$pageData->label->$catetitle->$value->url:'Untitled');
					$bc_txt = isset($pageData->label->$catetitle->$value->title)?$pageData->label->$catetitle->$value->title:'Untitled';
					if(isset($pageData->label->$catetitle->$value->title)){break;}
				}				
				$breadcrumb_txt .= '<li><a href="'.$bc_url.'">'.$bc_txt.'</a></li>';
			}
		}
	}
}//---- end breadcrumb
//----- start get user avata pic/profile pic
if($usersession->isLogin()){
$picPath = web_config('profile_pic_path');$no_pic = web_config('no_pic');
$photo_url = $picPath.$usersession->info()->photo;
if($photo_url == $picPath or !file_exists($_SERVER['DOCUMENT_ROOT'].$photo_url)){$photo_url=$no_pic;}}
//----- end get user avata pic/profile pic
//getting feature photo
if(!isset($feature_img) or !file_exists($_SERVER['DOCUMENT_ROOT'].$feature_img)){$feature_img=$pageData->label->system_title->sys->icon;}
//getting feature des
if(!isset($feature_des)){$feature_des='';}
//--- check if social network sharing bottom allowed
$sn=web_config('allowed_sn');
?>    

    