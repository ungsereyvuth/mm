<?php
include_once("app/model/lib/db.php");
include_once("app/model/lib/language.php");
//layout text category
$layout = new layout_label;
$language = $layout->activeLanguage();
$language_code = $layout->activeLanguage(false);
$layout_cate = (object) ($layout->layout_cate());
$layout_label = (object) ($layout->translated($language));
$lang = (object) $layout->languagecode($language);
include_once("app/model/lib/functions.php");
include_once("app/model/lib/checklogin.php");
include_once("app/model/lib/checksession.php");
//app variables
$usersession = new usersession($language); //isLoign(),info()
include_once("app/model/lib/phpExcel/standardReport.php");
//include_once("app/model/upload.php");

class application{
	public function run(){	
		global $usersession,$layout_cate,$encryptKey,$language,$language_code;

		$url_text = isset($_GET['url'])?$_GET['url']:'';
		$url_parameters = explode("/",$url_text);
		//check if the language code is set in the url. if yes, store it and remove from the array.
		if(strlen($url_parameters[0])==2){
			$url_text = str_replace(array($url_parameters[0].'/',$url_parameters[0]),'',$url_text);
			unset($url_parameters[0]);$url_parameters = array_values($url_parameters);
		}
		if($url_text==''){$url_parameters[0]='home';}//if no query string, set class home as default

		

		$qry = new pageController;
		$pageData = $qry->data($url_parameters); 
		$dir = $pageData->dir; $more_dir = $pageData->more_dir; 
		$fileview = 'app/view/'.$dir.'content/'.$more_dir.$pageData->fileview.'.php';		

		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$fileview)) { 
			if($pageData->layoutRequired){include 'app/view/'.$dir.'stdPage.php';
			}else{include $fileview;}
		}
	}
}

class pageController{
	public function data($param){ 
		global $usersession,$layout_label,$lang,$encryptKey;
		$qry = new connectDb; $content=$page_com=array();$dir = 'frontend/';$more_dir='';
		$request_data = array();$inherited = '';
		//-------- start preparing request page code ---------------
		if(count($param)==1){$getClassName = addslashes($param[0]);}else{
			$getClassName = $param[0].'_'.$param[1];
			foreach($param as $key=>$value){if($key>1){$request_data[] = $value;}}
		}		
		//-------- start checking page validity --------------- -> also check if there is inherited class for the page instead of it std name
		$checkpage = $qry->qry_assoc("select id,dir,is_ajax,is_webpage,is_backend,inherited from layout_page_controller where model='$getClassName' and active=1");
		//recheck model
		if(!count($checkpage)){
			$getClassName = $param[0];$request_data = array();
			foreach($param as $key=>$value){if($key>0){$request_data[] = $value;}}
			$checkpage = $qry->qry_assoc("select id,dir,is_ajax,is_webpage,is_backend,inherited from layout_page_controller where model='$getClassName' and active=1");
		}

		$pagevalid = count($checkpage)?true:false; 
		if(!$pagevalid){$getClassName='pagenotfound';$request_data=array();}else{
			$inherited = $checkpage[0]['inherited'];$more_dir=$checkpage[0]['dir'];
			$dir=$checkpage[0]['is_backend']?'backend/':$dir;
		}
		$adjust_classname = $inherited<>''?$inherited:$getClassName;
		if($inherited<>''){
			$adjust_classname = $inherited; 
			//get extra dir from inherited class
			$inherited_data = $qry->qry_assoc("select dir from layout_page_controller where model='$inherited' and active=1");
			$more_dir = count($inherited_data)?$inherited_data[0]['dir']:$more_dir; 
		}else{$adjust_classname = $getClassName;}
		if ($pagevalid and $checkpage[0]['is_webpage'] and file_exists($_SERVER['DOCUMENT_ROOT']."/app/model/".$dir."page/".$more_dir.$adjust_classname.".php")) {
			include_once("app/model/".$dir."page/".$more_dir.$adjust_classname.".php");
		}
		if ($pagevalid and $checkpage[0]['is_ajax'] and file_exists($_SERVER['DOCUMENT_ROOT']."/app/model/".$dir."ajax/ajax_controller.php")) { 
			include_once("app/model/".$dir."ajax/ajax_controller.php");$request_data['dir'] = $dir;
		}		
		if(!class_exists($adjust_classname)){$getClassName=$adjust_classname='pagenotfound';$request_data=array();} 
		//-------- start checking page property --------------- -> although inherited class is defined but still keep original page properties/components
		$page_config = $qry->qry_assoc("select * from layout_page_controller where model='$getClassName' and active=1");
		$page_config = $page_config[0]; 
		//check page authentication
		if($page_config['required_login'] and $getClassName<>'ajax_request' and $getClassName<>'admin_ajax_request'){//if ajax, no need check authentication here. ajax can check it own
			if($usersession->isLogin()){
				$privileges = explode(',',$usersession->info()->privileges);
				if(!in_array($page_config['id'],$privileges)){$getClassName=$adjust_classname='pagenotfound';$request_data=array();}
			}else{goto setObj;}
		} 
		//-------- start rechecking page validty and exclude ajax request --------------- -> get output from inherited class if defined, otherwise get from its std class		
		$classData = new $adjust_classname;   
		$content = (object) $classData->data($request_data);
		if($getClassName<>'ajax_request' and $getClassName<>'admin_ajax_request' and $getClassName<>'admin_ajax_realtimeupload' and isset($content->pageExist) and !$content->pageExist){ 
			$getClassName=$adjust_classname='pagenotfound';
			$classData = new $getClassName;
			$content = (object) $classData->data();
			$page_config = $qry->qry_assoc("select * from layout_page_controller where model='$getClassName' and active=1");
			$page_config = $page_config[0];
			$more_dir=$page_config['dir'];
			$dir='frontend/';
		}
		//-------- start getting page components --------------- -> components from std page (not inherited page)
		$page_com = array();
		if($page_config['components']<>''){
			$components = $page_config['components'];
			$page_com_data = $qry->qry_assoc("select * from layout_page_component where id IN ($components) and active=1");
			include_once("app/model/".$dir."component.php");
			foreach($page_com_data as $key=>$value){
				$com_data = new $value['component_name'];
				$page_com[$value['component_name']]=$com_data->data(array('data'=>$request_data,'page'=>$getClassName));
			}
		} 
		//-------- start define page properties ---------------
		setObj:
		$obj = new stdClass();
		$obj->loginRequired = $page_config['required_login'];
		$obj->logoutRequired = $page_config['required_logout'];
		$obj->layoutRequired = $page_config['required_layout'];
		$obj->lang = $lang;
		$obj->label = (object) $layout_label;
		$obj->page = isset($content->breadcrumb)?$content->breadcrumb:array($getClassName);
		$obj->fileview =$adjust_classname;
		$obj->originalclass =$getClassName;
		$obj->more_dir =$more_dir;
		$obj->dir =$dir;
		$obj->data = (object) array('content'=> $content,'component'=>(object) $page_com);	
		return $obj;
	}	
}

class pagenotfound{
	public function data($msg=''){
		global $usersession,$layout_label,$lang;		
		if($msg=='' or is_array($msg)){$msg=$layout_label->label->error404->title;}				
		return (object) array('title'=>'404','des'=>$msg);
	}	
}
?>