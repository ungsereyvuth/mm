<?php
//include_once("app/model/db.php");
//include_once("app/model/language.php");

//web custom functions
function tbl_style($txt){
	$new_txt = str_replace(array('boder','style','width','cellpadding'),array('data-border','data-style','data-width','data-cellpadding'),$txt);
	$new_txt = str_replace('<table','<table border="1" cellpadding="3" width="100%" style="border-collapse: collapse;"',$new_txt);
	
	return $new_txt;
}


//web system functions

function is_session_started() {
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

function trim_arr($value) {
    // sanitize array or string values
    if (is_array($value)){array_walk_recursive($value, 'sanitize_value');
    }else{sanitize_value($value);}
    return $value;
}
function sanitize_value(&$value){$value = trim($value);}

function checkusername($username,$length=6){
	if(preg_match('/^\w{'.$length.',}$/', $username)) { // \w equals "[0-9A-Za-z_]"
		// valid username, alphanumeric & longer than or equals 6 chars
		return true;
	}else{return false;}
}

function isGranted($cmd){
	$usersession = new usersession; //if ajax become slow, try to change this to global decare: global $usersession
	$qry = new connectDb;$result=true;$inherited=$dir='';
	$check = $qry->qry_assoc("SELECT id,required_login,inherited,dir FROM layout_page_controller where model='$cmd' and is_ajax=1 and active=1 limit 1");
	if(count($check)){
		$inherited=$check[0]['inherited'];$dir=$check[0]['dir'];
		//if(!$check[0]['required_login'] or ($check[0]['required_login'] and $usersession->isLogin() and in_array($check[0]['id'],explode(',',$usersession->info()->privileges)))){$result=true;}
		if(($check[0]['required_login'] and !$usersession->isLogin()) or ($check[0]['required_login'] and $usersession->isLogin() and !in_array($check[0]['id'],explode(',',$usersession->info()->privileges)))){$result=false;}
	}else{
		//record undefined ajax request	
	}
	return (object) array('result'=>$result,'inherited'=>$inherited,'dir'=>$dir);
}

function orginUrl(){	
			$url_text = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:'';
			$url_text = ltrim($url_text, '/');
			$url_parameters = explode("/",$url_text);
			//check if the language code is set in the url. if yes, store it and remove from the array.
			if(strlen($url_parameters[0])==2){
				$url_text = str_replace($url_parameters[0].'/','',$url_text);
				//unset($url_parameters[0]);
				//$url_parameters = array_values($url_parameters);				
				
			}
			if(strlen($url_text)==2){$url_text = '';}
			return $url_text;
}

function substr_unicode($str,$length){return mb_substr($str,0,$length,'UTF-8');}

function remove_tag_p($text){return str_replace(array('<p>','</p>'),'',$text);}
function remove_tag_img($text,$replacedby=''){return preg_replace("/<img[^>]+\>/i", $replacedby, $text);}

function cleanstr($string) {
   $string = str_replace(' ', '_', $string); // Replaces all spaces with underscore.
   $string = preg_replace('/[^A-Za-z0-9\_]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '_', $string); // Replaces multiple hyphens with single one.
}

function isDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function khMonth($monthnum){
	$monthnum=intval($monthnum);
	$khMonth = array('មករា','កុម្ភៈ','មីនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ');
	$enMonth = array('January','February','March','April','May','June','July ','August','September','October','November','December',
);
	if(getLanguage(false)=='kh'){return $khMonth[($monthnum-1)];}else{return $enMonth[($monthnum-1)];}
}

function khmerDate($date,$format='full'){
	$invalid_date = array('','0000-00-00','0000-00-00 00:00:00','0000-00-00 00:00:00.000000');
	if(in_array($date,$invalid_date)){return 'N/A';}
	$d = date("d",strtotime($date));
	$m = date("m",strtotime($date));
	$y = date("Y",strtotime($date));
	
	$h = date("H",strtotime($date));
	$i = date("i",strtotime($date));
	$s = date("s",strtotime($date));
	
	$khmerMonth = array('មករា','កុម្ភៈ','មីនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ');
	$long_date = 'ថ្ងៃទី'.enNum_khNum($d).' ខែ'.$khmerMonth[$m-1].' ឆ្នាំ'.enNum_khNum($y);
	$full = enNum_khNum($d).' '.$khmerMonth[$m-1].' '.enNum_khNum($y);
	$full_dt = enNum_khNum($d).' '.$khmerMonth[$m-1].' '.enNum_khNum($y).' '.enNum_khNum($h).':'.enNum_khNum($i);
	$khdate = array('d'=>enNum_khNum($d),'m'=>$khmerMonth[$m-1],'y'=>enNum_khNum($y),'long_date'=>$long_date,'full'=>$full,'full_dt'=>$full_dt);
	$endate = array('d'=>$d,'m'=>$m,'y'=>$y,'full'=>date("d/m/Y",strtotime($date)),'full_dt'=>date("d/m/Y H:i",strtotime($date)));
	
	if(getLanguage(false)=='kh'){return $khdate[$format];}else{return $endate[$format];}
	
}

function defaultLanguage($return_id=true){
	$qry = new connectDb;
	$lang_data = $qry->qry_assoc("select id,code from language where set_default=1 limit 1");			
	$languageid = $lang_data[0]['id']; $languagecode = $lang_data[0]['code'];
	return $return_id?$languageid:$languagecode;
}

function getLanguage($return_id=true){
			//default language from db as language id
			$qry = new connectDb;
			$lang_data = $qry->qry_assoc("select id,code from language where set_default=1 limit 1");			
			$language = $lang_data[0]['id']; $language_code = $lang_data[0]['code'];
			
			if(isset($_GET['url'])){
				$url_text = $_GET['url'];
				$url_parameters = explode("/",$url_text);
				//check if the language code is set in the url. if yes, store it and remove from the array.
				if(strlen($url_parameters[0])==2){
					$language_code = $url_parameters[0];
					unset($url_parameters[0]);
					$url_parameters = array_values($url_parameters);
				}
				//check if language code in the url is valid. if not, set to default.
				$language_check = $qry->qry_assoc("select id from language where code='$language_code' and active=1 limit 1");
				if(count($language_check)==1){$language = $language_check[0]['id']; }
			}
			if($return_id){return $language;}else{return $language_code;}
}

function getFirstPara($string){
	if(strpos($string, "</p>")!==false){
		$string = substr($string,0, strpos($string, "</p>")+4);
	}else{$string = substr($string,0, 50);}
	$string = str_replace("<p>", "", str_replace("</p>", "", $string));
	return $string;
}

function downloadcounter($file_url){
	$qry = new connectDb;$datetime = date("Y-m-d H:i:s");
	$check_db = $qry->qry_assoc("select * from download where file_url='$file_url' and active=1");
	if(count($check_db)){
		$qry->update("update download set download=(download+1),last_download_date='$datetime' where file_url='$file_url' and active=1");
	}else{
		$qry->insert("insert into download set file_url='$file_url',download=1,last_download_date='$datetime'");
	}
}
function totaldownload($file_url){
	$qry = new connectDb;
	$downloadinfo = $qry->qry_assoc("select * from download where file_url='$file_url' and active=1");
	$totaldownload = count($downloadinfo)?$downloadinfo[0]['download']:0;
	return $totaldownload;
}

function gender($abv){
	global $layout,$layout_label;	
	
	$genders = array('m'=>$layout_label->label->m->icon.' '.$layout_label->label->m->title,'f'=>$layout_label->label->f->icon.' '.$layout_label->label->f->title);
	if(isset($genders[$abv])){
		return $genders[$abv];
	}else{ return 'N/A';}
}

function web_config($settingName){
	$qry = new connectDb; $returnvalue='';	
	if(is_array($settingName)){$cond="settingName IN('".implode("','",$settingName)."')";}
	else{$cond="settingName='$settingName'";}
	$setting = $qry->qry_assoc("select * from generalsetting where $cond and active=1");
	if(count($setting)>1){
		$returnvalue=array();
		foreach($setting as $key=>$value){
			$returnvalue[$value['settingName']]=$value['settingValue'];
		}
	}elseif(count($setting)==1){
		$returnvalue=$setting[0]['settingValue'];
	}
	return $returnvalue;
}

function content($code){
	$qry = new connectDb; 	
	//get text for default language
	if(is_array($code)){		
		$getcode = implode("','",$code);		
	}else{		
		$getcode = $code;		
	}
	$content = array();
	$contentData = $qry->qry_assoc("select c.*,IFNULL(t.title_t, c.title) title,IFNULL(t.description_t, c.description) description from content c 
									left join content_t t on t.main_id=c.id and t.language_id=".getLanguage()." and t.active=1
									where c.code IN ('$getcode') and c.active=1");
	foreach($contentData as $key=>$value){$content[$value['code']] = $value;}
	
	return $content;
}

function role_allowed($userid){
	$qry = new connectDb;$allowed=false;
	$roleData = $qry->qry_assoc("SELECT * FROM user_role WHERE id=(select role_id from users where id=$userid limit 1) and active=1 limit 1");
	if(count($roleData)){$allowed=true;}
	return $allowed;
}

function authorizedUsers($function_id){
	$qry = new connectDb;$authorizedUsers=array();
	$roleData = $qry->qry_assoc("SELECT * FROM user_role WHERE CONCAT(',',privileges,',') like CONCAT('%,','$function_id',',%')");
	foreach($roleData as $key=>$value){$authorizedUsers[]=$value['code'];}
	return $authorizedUsers;
}

function is_localhost() {
    $whitelist = array( '127.0.0.1', '::1' );
    if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) )
        return true;
}

function emailbook(){
	$qry = new connectDb;
	return $qry->qry_assoc("SELECT book.* from 
							(SELECT name,email FROM subscription where active=1
							UNION
							select concat(COALESCE(u.lastname,''),' ',COALESCE(u.firstname,'')) name,u.email from users u where u.notif=1 and u.active=1) book
							where book.email IS NOT NULL
							group by book.email");
}

function mailTemplate($code){
	$qry = new connectDb;
	return $qry->qry_assoc("SELECT * FROM email_template where code='$code' limit 1");
}

function mailContent($code,$data,$template=''){//if template provided, no need code (just put blank)
	$content=$subject='';
	if($template==''){$template = mailTemplate($code);}
	if(count($template) and is_array($data)){
		$content=$template[0]['content'];$subject=$template[0]['subject'];
		foreach($data as $key=>$value){
			$content = str_replace('[{'.$key.'}]', $value, $content);
		}
	}
	return array('subject'=>$subject,'content'=>$content);
}

function sendMail($to,$subject, $message){//$type: type of mail to get specific mail content, $data: optional data for specific mail type
	if(is_localhost()){return (object) array('isSent'=>true,'msg'=>'<i class="fa fa-exclamation-circle"></i> sendMail is disable in localhost');exit;}
	
	global $layout,$layout_label;	
	$formatDate = date("d M Y H:i A");
	if(filter_var($to, FILTER_VALIDATE_EMAIL)){	
		$content = content('email_footer');
		$email_footer = $content['email_footer'];
		
		$content = '		
		<div style="padding:5px; background-color:#e2e2e2;color: white;">
			<div style="float:left;"><img src="'.((strpos(strtolower($layout_label->system_title->sys->icon), 'http://') !== false)?'':'http://'.$_SERVER['HTTP_HOST']).$layout_label->system_title->sys->icon.'" height="70" /></div>
			<div style="float:right; text-align:right;color: #38405d;padding-top: 20px;">'.$formatDate.'<br />'.$layout_label->system_title->sys->title.'</div>
			<div style="clear:both;"></div>
		</div>
		<div style=" width:100%;padding:10px 0 10px 0;">	
		'.$message.'		
		</div>
		<span style="font-size:11px;">
			Sent by: '.$layout_label->system_title->sys->title.'<br />
			Website: <a href="'.$layout_label->system_title->sys->url.'">'.$layout_label->system_title->sys->url.'</a>
		</span>
		</p>			
		<hr />
		<div style="font-size:11px;color:#888888;">'.$email_footer['description'].'</div>
		'; 
										
		$headers  = 'MIME-Version: 1.0' . PHP_EOL;
		$headers .= 'Content-type: text/html; charset=UTF-8' . PHP_EOL;
		$headers .= 'From: '.$layout_label->system_title->sys->title.' <noreply@'.str_replace('http://','',$layout_label->system_title->sys->url).'>' . PHP_EOL;
		
		if(web_config('enable_email')){
			$sent = mail($to, $subject, $content, $headers) ;		
			if($sent){$result=true;$msg='<i class="fa fa-check"></i> Email was successfully sent to '.$to;}else{$result=false;$msg='<i class="fa fa-exclamation-circle"></i> Sending Error';}
		}else{$result=false;$msg='<i class="fa fa-exclamation-circle"></i> Email was disabled';}
	}else{$result=false;$msg='<i class="fa fa-exclamation-circle"></i> Invalid Email';}
	return (object) array('isSent'=>$result,'msg'=>$msg);
}

function isAdmin($id){
	$result = false;$adminCode = array('superuser','admin');$qry = new connectDb;
	$roleInfo = $qry->qry_assoc("select * from user_role where id=(select role_id from users where id=$id limit 1) limit 1");
	if(count($roleInfo) and in_array($roleInfo[0]['code'],$adminCode)){$result = true;}
	return $result;
}

function isThisUserRole($id,$rolename){
	$result = false;$roleCode = explode(',',$rolename);$qry = new connectDb;
	$roleInfo = $qry->qry_assoc("select code from user_role where id=(select role_id from users where id=$id limit 1) limit 1");
	if(count($roleInfo) and in_array($roleInfo[0]['code'],$roleCode)){$result = true;}
	return $result;
}

function admin_emails($check_notif=false){
	$qry = new connectDb; $emails = array();
	$adminInfo = $qry->qry_assoc("select * from users where role_id IN (select id from user_role where code IN('admin','superuser')) ".($check_notif?"and notif=1":"")." and active=1");
	foreach($adminInfo as $value){if(filter_var($value['email'], FILTER_VALIDATE_EMAIL)){$emails[] = $value['email'];}}
	return $emails;
}

function subscription_emails(){
	$qry = new connectDb; $subscribe_emails = array();$user_emails = array();
	//get from subscription db
	$subscriptionInfo = $qry->qry_assoc("select * from subscription where active=1");
	foreach($subscriptionInfo as $value){if(filter_var($value['email'], FILTER_VALIDATE_EMAIL)){$subscribe_emails[] = $value['email'];}}
	//get from user db
	$userInfo = $qry->qry_assoc("select * from users where notif=1 and active=1");
	foreach($userInfo as $value){if(filter_var($value['email'], FILTER_VALIDATE_EMAIL)){$user_emails[] = $value['email'];}}
	//merge emails
	$emails = array_unique(array_merge($subscribe_emails,$user_emails), SORT_REGULAR);;
	return $emails;
}

function validateForm($reg_fields,$opt_fields,$prev_err=array()){
	global $layout_label;$err_fields=array();
	//if have previous error, add it together
	foreach($prev_err as $val){$err_fields[]=$val;}
	
	$temp_fields=array();
	foreach($reg_fields as $value){foreach($value as $sub_key=>$sub_value){$temp_fields[]=$sub_key;}}		
	$required_fields = array_diff($temp_fields,$opt_fields);
	$required_val = array();
	foreach($required_fields as $value){$required_val[$value]=array_key_exists($value,$reg_fields['file'])?$reg_fields['file'][$value]:(array_key_exists($value,$reg_fields['email'])?$reg_fields['email'][$value]:$reg_fields['text'][$value]);}		
	if(in_array('',$required_val)){	
		foreach($required_val as $key=>$value){
			if($value==''){$err_fields[]= array('name'=>$key,'msg'=>$layout_label->message->blank_data->title);}
			if(array_key_exists($key,$reg_fields['file'])){if(!isset($reg_fields['file'][$key]['type']) or $reg_fields['file'][$key]['type']==''){$err_fields[]= array('name'=>$key,'msg'=>$layout_label->message->no_file->title);}}
		}	
	}
	return $err_fields;
}

function lreplace($search, $replace, $subject){
   	$pos = strripos($subject, $search);
   	if($pos !== false){
       	$subject = substr_replace($subject, $replace, $pos, strlen($search));
   	}
   	return $subject;
}

function generateList($language,$currentPage,$rowsPerPage,$navAction,$sql_statement,$fix_pagination=''){
	$layout = new layout_label;$qry = new connectDb;
	$lang_data = (object) $layout->languagecode($language);
	$langaugecode = $lang_data->selected;
	
	$layout_label = (object) $layout->translated($language);
	$list_nav_info = $layout_label->label->list_nav_info->icon.'&nbsp;'.$layout_label->label->list_nav_info->title;
	$no_data = $layout_label->label->no_data->icon.' '.$layout_label->label->no_data->title;
	
	//fix pagination
	$original_sql_statement=$sql_statement;
	if($fix_pagination<>''){
		$sql_statement=lreplace('ORDER BY','group by '.$fix_pagination.' ORDER BY',$sql_statement);		
	}
	
	//work with total page		
	$totalRow = $qry->qry_count($sql_statement);
	$totalPages = $totalRow/$rowsPerPage;
	if($totalRow%$rowsPerPage>0){$totalPages = intval($totalPages) + 1;}
	
	//get the target page number	
	$targetPage = 1;$nav_btn_disable = array();
	if($navAction=='first'){
		$targetPage = 1;
	}elseif($navAction=='prev'){
		$targetPage = $currentPage-1;
	}elseif($navAction=='next'){
		$targetPage = $currentPage+1;
	}elseif($navAction=='last'){
		$targetPage = $totalPages;
	}elseif($navAction=='goto'){
		$targetPage = $currentPage;
	}
	
	//get goto select num range
	$beginNum = ($targetPage-20)<1?1:($targetPage-20);
	$leadingNum = ($targetPage+20)>$totalPages?$totalPages:($targetPage+20);
	$lastNum= ($totalPages-$leadingNum)>20?($totalPages-20):($leadingNum+1);
	
	//get goto select list	
	$gotoSelectNum = array();
	if($totalPages>100){
		for($i=$beginNum;$i<=$leadingNum;$i++){
			$gotoSelectNum[$i] = enNum_khNum($i);
		}
		if($leadingNum<$totalPages){
			for($i=$lastNum;$i<=$totalPages;$i++){
				$gotoSelectNum[$i] = enNum_khNum($i);
			}
		}
	}else{
		for($i=1;$i<=$totalPages;$i++){
			$gotoSelectNum[$i] = enNum_khNum($i);
		}
	}
	
	if($totalPages==1 or $totalPages==0){
		$nav_btn_disable = array('nav_first'=>0,'nav_prev'=>0,'nav_next'=>0,'nav_last'=>0);
	}elseif($targetPage==1){
		$nav_btn_disable = array('nav_first'=>0,'nav_prev'=>0,'nav_next'=>1,'nav_last'=>1);
	}elseif($targetPage==$totalPages){
		$nav_btn_disable = array('nav_first'=>1,'nav_prev'=>1,'nav_next'=>0,'nav_last'=>0);
	}else{
		$nav_btn_disable = array('nav_first'=>1,'nav_prev'=>1,'nav_next'=>1,'nav_last'=>1);
	}
	$startIndex = ($targetPage-1)*$rowsPerPage;
	$startIndex = $startIndex>=0?$startIndex:0;	
	//sql for export to excel
	$fullsql = $original_sql_statement;
	if($fix_pagination<>''){
		$fix_data = $qry->qry_assoc($sql_statement." LIMIT ".$startIndex.",$rowsPerPage");
		$fix_ids=array();$con_fix='';
		foreach($fix_data as $key=>$value){$fix_ids[]=$value['id'];}
		if(count($fix_ids)){
			$fix_pagination_parts = explode('.',$fix_pagination);if(count($fix_pagination_parts)>1){$tname=$fix_pagination_parts[0].'.';}else{$tname='';}
			$con_fix='('.$fix_pagination.' IN ('.implode(',',$fix_ids).') or '.$tname.'id IN ('.implode(',',$fix_ids).')) and ';			
		}
		$partsql=lreplace('where','where '.$con_fix,$original_sql_statement);
	}else{
		$partsql = $original_sql_statement." LIMIT ".$startIndex.",$rowsPerPage";
	}
	$rowData = $qry->qry_assoc($partsql);
	if($fix_pagination<>''){
		//combine parent and child items
		$new_data=array();
		foreach($rowData as $value){
			if($value['parent_id']){	
				if(!isset($new_data[$value['parent_id']])){$new_data[$value['parent_id']]=array();}
				$new_data[$value['parent_id']]['child'][$value['sub_id']]=$value;
			}else{
				$new_data[$value['main_id']]=$value;
				$new_data[$value['main_id']]['child']=array();
			}
		}
		$rowData=$new_data;
	}
	
	//get currentl load rows number
	$totalLoadedRows = $startIndex+count($rowData);
	
	$list_nav_info = str_replace(array('[current]','[total]','[rows]'),array(enNum_khNum($targetPage),enNum_khNum($totalPages),enNum_khNum($totalRow)),$list_nav_info);
	return array('totalLoadedRows'=>$totalLoadedRows,'rowData'=>$rowData,'startIndex'=>$startIndex,'totalPages'=>$totalPages,'totalRow'=>$totalRow,'targetPage'=>$targetPage,'gotoSelectNum'=>$gotoSelectNum,'nav_btn_disable'=>$nav_btn_disable,'list_nav_info'=>$list_nav_info,'langaugecode'=>$langaugecode,'fullsql'=>$fullsql,'partsql'=>$partsql);
}

function pagination_btn($main_url,$active_query,$current_page,$totalpages){
	//remove last slash if exists
	$last_char = substr($main_url, -1);
	if($last_char=='/'){$main_url=substr($main_url, 0, -1);}
	//pagination btn
	$pagination_btn = array('first'=>array('disabled'=>true,'text'=>'<i class="fa fa-angle-double-left"></i> First','url'=>$main_url.'?'.$active_query.'page=1'),
						'previous'=>array('disabled'=>true,'text'=>'<i class="fa fa-angle-left"></i> Previous','url'=>$main_url.'?'.$active_query.'page='.($current_page-1)),
						'next'=>array('disabled'=>true,'text'=>'Next <i class="fa fa-angle-right"></i>','url'=>$main_url.'?'.$active_query.'page='.($current_page+1)),
						'last'=>array('disabled'=>true,'text'=>'Last <i class="fa fa-angle-double-right"></i>','url'=>$main_url.'?'.$active_query.'page='.$totalpages));
	if($current_page>1 and $current_page<$totalpages){
		$pagination_btn['first']['disabled']=false;
		$pagination_btn['previous']['disabled']=false;
		$pagination_btn['next']['disabled']=false;
		$pagination_btn['last']['disabled']=false;
	}elseif($current_page==1 and $current_page<$totalpages){
		$pagination_btn['next']['disabled']=false;
		$pagination_btn['last']['disabled']=false;
	}elseif($current_page>1 and $current_page==$totalpages){
		$pagination_btn['first']['disabled']=false;
		$pagination_btn['previous']['disabled']=false;
	}
	return $pagination_btn;
}

function adduserlog($action_name,$action_data=''){
	global $layout_label,$usersession;
	//add to user log
	$qry = new connectDb;
	$userlog_id=0;
	//$result=false;	
	$action_id=0;
	//check if valid cmd
	if($action_name<>''){
		$action_info = $qry->qry_assoc("select id from layout_page_controller where model='$action_name' limit 1");
		if(count($action_info)){$action_id=$action_info[0]['id'];}
	}
	if($action_id){
		$userIP = getClientIP();$datetime = date("Y-m-d H:i:s"); $browser_info = addslashes(json_encode(getBrowser()));	
		$ipInfo = ipInfo($userIP);$isp = isset($ipInfo->org)?$ipInfo->org:'';
		//if userid is null (visitor feedback has no id)
		$user_id = $usersession->isLogin()?$usersession->info()->id:"NULL";
		$userlog_id=$qry->insert("insert into user_activity set user_id=$user_id,action_id=$action_id, action_data='$action_data',ip='$userIP',isp='$isp',browser_info='$browser_info',datetime='$datetime'");	
		//$result=true;
	}
	return $userlog_id;
}



function userinfo($id){
	if(!$id){return array();}
	$qry = new connectDb;
	$rowData = $qry->qry_assoc("select u.*,role.code role_code,role.title role_name from users u left join user_role role on role.id=u.role_id where u.id=$id limit 1");
	return count($rowData)?$rowData[0]:array();
}

function roleinfo($id){
	$qry = new connectDb;
	$rowData = $qry->qry_assoc("select * from user_role where id=$id limit 1");
	return count($rowData)?$rowData[0]:array();
}

function blankrow($tbl){
	$qry = new connectDb;
	$blankdata = array();
	$rowData = $qry->qry_assoc("SHOW COLUMNS FROM $tbl");
	foreach($rowData as $key=>$value){$blankdata[$value['Field']] = '';}	
	return $blankdata;
}

function isRecent($datetimeString){
	$start_date = new DateTime($datetimeString);
	$now_datetime = new DateTime(date("Y-m-d H:i:s"));												
	$interval = $start_date->diff($now_datetime);
	$days = $interval->days;
	
	$result=false;
	if($days<=7){$result=true;}
	return $result;
}

function romanic_number($integer, $upcase = true) 
{ 
    $table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1); 
    $return = ''; 
    while($integer > 0) 
    { 
        foreach($table as $rom=>$arb) 
        { 
            if($integer >= $arb) 
            { 
                $integer -= $arb; 
                $return .= $rom; 
                break; 
            } 
        } 
    } 

    return $return; 
}

function post($var) {
	if(isset($_POST[$var])){
		return (trim($_POST[$var]));
	}else{
		return '';
	}
}
function get($var){
	if (isset($_GET[$var])) {
		return (trim($_GET[$var]));
	}else{
		return '';
	}
}

/*function getStringBetween($string, $start, $end){// use stripos for case-insensitive, without 'i' will be case-sensitive
    $string = " ".$string;
    $ini = stripos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = stripos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}*/

function getStringBetween($str, $startDelimiter, $endDelimiter) { //r
  $contents = array();
  $startDelimiterLength = strlen($startDelimiter);
  $endDelimiterLength = strlen($endDelimiter);
  $startFrom = $contentStart = $contentEnd = 0;
  while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
    $contentStart += $startDelimiterLength;
    $contentEnd = strpos($str, $endDelimiter, $contentStart);
    if (false === $contentEnd) {
      break;
    }
    $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
    $startFrom = $contentEnd + $endDelimiterLength;
  }

  return $contents;
}
function remove_media_code($string){
	$files_in_des = getStringBetween($string, '{{', '}}');
	if(count($files_in_des)){
		$codes = '{{'.implode('}},{{',$files_in_des).'}}';
		$codes = explode(',',$codes);
		$string=str_replace($codes,'',$string);	
	}
	return $string;
}

function encodeString($string,$key) {
		if(is_numeric($string)){$string = $string*120119898;}
		$key = sha1($key);
		$strLen = strlen($string);
		$keyLen = strlen($key);
		$j = 0;
		$hash ="";
		for ($i = 0; $i < $strLen; $i++) {
			$ordStr = ord(substr($string,$i,1));
			if ($j == $keyLen) { $j = 0; }
			$ordKey = ord(substr($key,$j,1));
			$j++;
			$hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
		}
		return $hash;
	}

function decodeString($string,$key) {
		$key = sha1($key);
		$strLen = strlen($string);
		$keyLen = strlen($key);
		$j = 0;
		$hash = "";
		for ($i = 0; $i < $strLen; $i+=2) {
			$ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
			if ($j == $keyLen) { $j = 0; }
			$ordKey = ord(substr($key,$j,1));
			$j++;
			$hash .= chr($ordStr - $ordKey);
		}
		if(is_numeric($hash)){$hash = $hash/120119898;}
		return $hash;
	}

function enNum_khNum($str,$absolute=false){
	$khNum = array('០','១','២','៣','៤','៥','៦','៧','៨','៩');
	$newStr = '';
	for($i=0;$i<strlen($str);$i++){
		if(is_numeric(substr($str,$i,1))){
			$newStr .= $khNum[substr($str,$i,1)];
		}else{
			$newStr .= substr($str,$i,1);
		}		
	}
	//more keywords
	$newStr=str_replace(array('km','hours','mins'),array('គម','ម៉ោង','នាទី'),$newStr);
	if($absolute){return $newStr;}
	else{if(getLanguage(false)=='kh'){return $newStr;}else{return $str;}}
	
	
}

function khNum_enNum($str,$absolute=false){
	$khNum = array('០','១','២','៣','៤','៥','៦','៧','៨','៩');
	$newStr = '';
	for($i=0;$i<mb_strlen($str,'UTF-8');$i++){
		if(in_array(mb_substr($str,$i,1,'UTF-8'),$khNum)){
			$newStr .= array_search(mb_substr($str,$i,1,'UTF-8'),$khNum);
		}else{
			$newStr .= mb_substr($str,$i,1,'UTF-8');
		}		
	}
	if($absolute){return $newStr;}
	else{if(getLanguage(false)<>'kh'){return $newStr;}else{return $str;}}
}


function filesize_formatted($path)
{
    $size = filesize($_SERVER['DOCUMENT_ROOT'].$path);
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

function format_filesize($size){
	$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
	$power = $size > 0 ? floor(log($size, 1024)) : 0;
	return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

/*function singleCell_qry($field,$tbl,$cond){
	$resultInArray = mysqli_fetch_assoc(exec_query_utf8("SELECT ".$field." FROM ".$tbl.($cond==''?'':' WHERE ').$cond));
	return $resultInArray[$field];
}

function qry_arr($field,$tbl,$cond){
	$resultInArray = mysqli_fetch_array(exec_query_utf8("SELECT ".$field." FROM ".$tbl.($cond==''?'':' WHERE ').$cond),MYSQLI_ASSOC);
	return $resultInArray;
}*/

function file_detail($filename){
	global $layout,$layout_label;	
	
	$doc_icon = array('pdf'=>array('icon'=>'<i class="fa fa-file-pdf-o fa-fw"></i>','name_en'=>'PDF Document','name_kh'=>$layout_label->label->doc->title.' PDF'),
					'png'=>array('icon'=>'<i class="fa fa-file-image-o fa-fw"></i>','name_en'=>'Picture','name_kh'=>'រូបភាព'),
					'gif'=>array('icon'=>'<i class="fa fa-file-image-o fa-fw"></i>','name_en'=>'Picture','name_kh'=>'រូបភាព'),
					'jpg'=>array('icon'=>'<i class="fa fa-file-image-o fa-fw"></i>','name_en'=>'Picture','name_kh'=>'រូបភាព'),
					'jpeg'=>array('icon'=>'<i class="fa fa-file-image-o fa-fw"></i>','name_en'=>'Picture','name_kh'=>'រូបភាព'),
					'doc'=>array('icon'=>'<i class="fa fa-file-word-o fa-fw"></i>','name_en'=>'Word Document','name_kh'=>'ឯកសារ Word'),
					'docx'=>array('icon'=>'<i class="fa fa-file-word-o fa-fw"></i>','name_en'=>'Word Document','name_kh'=>'ឯកសារ Word'),
					'xls'=>array('icon'=>'<i class="fa fa-file-excel-o fa-fw"></i>','name_en'=>'Excel Document','name_kh'=>'ឯកសារ Excel'),
					'xlsx'=>array('icon'=>'<i class="fa fa-file-excel-o fa-fw"></i>','name_en'=>'Excel Document','name_kh'=>'ឯកសារ Excel'),
					'ppt'=>array('icon'=>'<i class="fa fa-file-powerpoint-o fa-fw"></i>','name_en'=>'PowerPoint Document','name_kh'=>'ឯកសារ PowerPoint'),
					'pptx'=>array('icon'=>'<i class="fa fa-file-powerpoint-o fa-fw"></i>','name_en'=>'PowerPoint Document','name_kh'=>'ឯកសារ PowerPoint'),
					'zip'=>array('icon'=>'<i class="fa fa-file-archive-o fa-fw"></i>','name_en'=>'Compressed File','name_kh'=>'ឯកសារ Zip'),
					'rar'=>array('icon'=>'<i class="fa fa-file-archive-o fa-fw"></i>','name_en'=>'Compressed File','name_kh'=>'ឯកសារ Rar'),
					'mp3'=>array('icon'=>'<i class="fa fa-file-audio-o fa-fw"></i>','name_en'=>'Audio','name_kh'=>'សំលេង'),
					'wav'=>array('icon'=>'<i class="fa fa-file-audio-o fa-fw"></i>','name_en'=>'Audio','name_kh'=>'សំលេង'),
					'wma'=>array('icon'=>'<i class="fa fa-file-audio-o fa-fw"></i>','name_en'=>'Audio','name_kh'=>'សំលេង'),
					'avi'=>array('icon'=>'<i class="fa fa-file-video-o fa-fw"></i>','name_en'=>'Video','name_kh'=>'វីឌីអូ'),
					'mp4'=>array('icon'=>'<i class="fa fa-file-video-o fa-fw"></i>','name_en'=>'Video','name_kh'=>'វីឌីអូ'),
					'flv'=>array('icon'=>'<i class="fa fa-file-video-o fa-fw"></i>','name_en'=>'Video','name_kh'=>'វីឌីអូ')
				);

	$extension = explode(".",$filename);
	$extension = strtolower(end($extension));
	$ext_icon=array('icon'=>'<i class="fa fa-file-text-o fa-fw"></i>','name_en'=>'Document','name_kh'=>'ឯកសារ');
	if(array_key_exists($extension,$doc_icon)){$ext_icon=$doc_icon[$extension];}
	return $ext_icon;
}

function rndStr($length) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

function dateTimeAgo($datetimeString,$lang='kh'){
	$start_date = new DateTime($datetimeString);
	$now_datetime = new DateTime(date("Y-m-d H:i:s"));
											
	$recieved_date = date_format(date_create($datetimeString),'d/m/Y');	
											
	$interval = $start_date->diff($now_datetime);
	$year_ago = $interval->y;$month_ago = $interval->m;$day_ago = $interval->d;$hour_ago = $interval->h;$minute_ago = $interval->i;$second_ago = $interval->s;										
	$datetime_ago = '';
											
	if($year_ago==0 and $month_ago==0 and $day_ago==0 and $hour_ago==0 and $minute_ago==0){
	$datetime_ago = ($second_ago<=1?"":(($second_ago>1 and $second_ago<4)?" few":$second_ago)).($lang=='kh'?' វិនាទីមុន':($second_ago<=1?" just now":" seconds ago"));
	}elseif($year_ago==0 and $month_ago==0 and $day_ago==0 and $hour_ago==0){
	$datetime_ago = $minute_ago.($lang=='kh'?' នាទីមុន':($minute_ago>1?" minutes ago":" minute ago"));
	}elseif($year_ago==0 and $month_ago==0 and $day_ago==0){
	$datetime_ago = $hour_ago.($lang=='kh'?' ម៉ោងមុន':($hour_ago>1?" hours ago":" hour ago"));
	}elseif($year_ago==0 and $month_ago==0){
	$datetime_ago = $day_ago.($lang=='kh'?' ថ្ងៃមុន':($day_ago>1?" days ago":" day ago"));
	}elseif($year_ago==0){
	$datetime_ago = $month_ago.($lang=='kh'?' ខែមុន':($month_ago>1?" months ago":" month ago"));
	}else{
	$datetime_ago = $recieved_date;
	}
	return $lang=='kh'?enNum_khNum($datetime_ago):$datetime_ago;		
}

function timePeriod($startDate,$endDate,$format=true){
	$start_date = new DateTime($startDate);
	$end_date = new DateTime($endDate);
											
	$interval = $start_date->diff($end_date);
	//$year_ago = $interval->y;$month_ago = $interval->m;$day_ago = $interval->d;$hour_ago = $interval->h;$minute_ago = $interval->i;$second_ago = $interval->s;										
	
/*	$formatedPeriod = '';	
	$totalHours = ($year_ago*365*24)+($month_ago*30*24)+$hour_ago;
	$totalMinutes = $minute_ago;
	$totalSeconds = $second_ago;						
	if($totalHours>0){
		$formatedPeriod = $totalHours.' ម៉ោង '.($totalMinutes>0?$totalMinutes.' នាទី':'');
	}elseif($totalMinutes>0){
		$formatedPeriod = $totalMinutes.' នាទី'.($totalSeconds>0?$totalSeconds.' វិនាទី':'');
	}elseif($totalSeconds>0){
		$formatedPeriod = $totalSeconds.' វិនាទី';
	}
	$json = array('hours'=>$totalHours,'minutes'=>$totalMinutes,'seconds'=>$totalSeconds);*/
	
	return $interval;		
}

function date_rang_status($start_date,$end_date){
	$today = time();$status='';
	$_start_date = strtotime($start_date);
	$_end_date = strtotime($end_date);
	if($today>=$_start_date and $today<=$_end_date){$status='today';}
	elseif($today<$_start_date){$status='future';}
	elseif($today>$_end_date){$status='past';}
	return $status;
}

function isTesting(){
	$test = false;
	$testing_ip = web_config('testing_ip');
	$ips = explode(",",$testing_ip);
	if(in_array(getClientIP(),$ips)){$test = true;}
	return $test;
}

function getClientIP(){
	// Get user IP address
	if ( isset($_SERVER['HTTP_CLIENT_IP']) && ! empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
	}
	
	$ip = filter_var($ip, FILTER_VALIDATE_IP);
	$ip = ($ip === false) ? '0.0.0.0' : $ip;	
	return $ip;
}

function file_contents_exist($url, $response_code = 200)
{
    $headers = get_headers($url);

    if (substr($headers[0], 9, 3) == $response_code)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function ipInfo($ip) {
	$url = "http://ipinfo.io/{$ip}";$details=array();
	//if (@fopen($url,"r") and !is_localhost() and file_contents_exist($url)) {
	//	$details = json_decode(file_get_contents($url));
	//}
    
    return $details;
}

function visitors_counter() {
	//set cookie
	$cookie_name = "visitor";
	if(!isset($_COOKIE[$cookie_name])) {   		
		$cookie_value = rndStr(40);
		setcookie($cookie_name, $cookie_value, time() + (43200 * 30), "/"); // 43200 = half day or 12 hours
	}else{$cookie_value = $_COOKIE[$cookie_name];}	
	$qry = new connectDb;$today=date("Y-m-d");$datetime =date("Y-m-d H:i:s");$visitorip = getClientIP();
	//check if ip alr exist today
	$vistorsData = $qry->qry_assoc("SELECT * FROM visitors where cookie='$cookie_value' and date='$today'");
	if(count($vistorsData)){ 
		$qry->update("update visitors set views=(views+1),datetime='$datetime' where cookie='$cookie_value' and date='$today'");
	}else{
		$qry->insert("insert into visitors set ip='$visitorip',cookie='$cookie_value',date='$today',datetime='$datetime'");
	}
}

function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}
function showimage($path,$filename){
	$default_path = '/images/';
	$default_filename = 'no_image.png';	
	
	if (file_exists($_SERVER['DOCUMENT_ROOT'].$path.$filename) and $filename<>'') {
		$valid_img = $path.$filename;
	} else {
		$valid_img = $default_path.$default_filename;
	}
	return $valid_img;
}

function thumbnail($filename){
	$origin_pic_path = web_config('post_doc_path');
	$resized_pic_path = web_config('resized_pic_path');
	$thumbnail_path = web_config('thumbnail_path');
	$no_pic = web_config('no_pic');
	
	if($filename<>''){
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$thumbnail_path.$filename)){		
			$showfile = $thumbnail_path.$filename;
		}else{
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$resized_pic_path.$filename)){
				$showfile = $resized_pic_path.$filename;
			}else{
				if(file_exists($_SERVER['DOCUMENT_ROOT'].$origin_pic_path.$filename)){
					$showfile = $origin_pic_path.$filename;
				}else{$showfile = $no_pic;}
			}			
		}
	}else{$showfile = $no_pic;}
	
	return $showfile;
}

function resizedpic($filename){
	$origin_pic_path = web_config('post_doc_path');
	$resized_pic_path = web_config('resized_pic_path');
	$no_pic = web_config('no_pic');
	
	if($filename<>''){
		if(file_exists($_SERVER['DOCUMENT_ROOT'].$resized_pic_path.$filename)){
			$showfile = $resized_pic_path.$filename;
		}else{
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$origin_pic_path.$filename)){
				$showfile = $origin_pic_path.$filename;
			}else{$showfile = $no_pic;}
		}		
	}else{$showfile = $no_pic;}
	
	return $showfile;
}

function allowed_file($file_ref,$config='all'){
	$result=true;$msg = 'file allowed';
	$config=($config=='')?'all':$config;
	$temporary = explode(".", $file_ref["name"]);
	$file_extension = strtolower(end($temporary));
	//get file format
	$qry = new connectDb;$validextensions=$validtype=$max_size=array();
	//get allowed format set
	$formatConfig = $qry->qry_assoc("SELECT format_id FROM fileformat_config where cmd='$config' and active=1");
	if(count($formatConfig)){
		$config = $formatConfig[0]['format_id'];
		$formatConfig_sql = $config==''?"":("id IN (".$formatConfig[0]['format_id'].") and") ;
		$formatInfo = $qry->qry_assoc("SELECT * FROM fileformat where $formatConfig_sql active=1");
		foreach($formatInfo as $key=>$value){
			$exts = explode(",",$value['ext']);
			$validextensions=array_merge($validextensions,$exts);
			$types = explode(",",$value['type']);
			$validtype=array_merge($validtype,$types);
			
			foreach($exts as $exts_value){$max_size[$exts_value] = $value['max_size'];}		
		}

		if(isset($file_ref["type"]) and $file_ref["type"]<>''){
			if(in_array($file_ref["type"], $validtype) and in_array(strtolower($file_extension), $validextensions)){
				if($file_ref["size"] <= ($max_size[$file_extension]*1000000)){
					if ($file_ref["error"] > 0){$result=false;$msg=$file_ref["error"];}
				}else{$result=false;$msg='File size must be less than '.$max_size[$file_extension].'MB';}
			}else{$result=false;$msg='Invalid file type';}			
		}else{$result=false;$msg='Please select a file';}
	}else{$result=false;$msg="Invalid format config";}
	
	return array('result'=>$result,'msg'=>$msg,'ext'=>$file_extension);
}

function resize_pic($url, $filename, $width = 1100, $watermark=false, $height = true) {
	 // download and create gd image
	 $image = ImageCreateFromString(file_get_contents($url));
	 // calculate resized ratio
	 // Note: if $height is set to TRUE then we automatically calculate the height based on the ratio
	 $height = $height === true ? (ImageSY($image) * $width / ImageSX($image)) : $height;
	 // create image 
	 $output = ImageCreateTrueColor($width, $height);
	 ImageCopyResampled($output, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));
	 //-------- start add water mark
	 
	 if($width>500 and $watermark){
		 //add copyright logo	
		$stamp = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].web_config('watermark_copyright'));	
		// Set the margins for the stamp and get the height/width of the stamp image
		$marge_right = 10;
		$marge_bottom = 10;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);
		imagecopy($output, $stamp, imagesx($output) - $sx - $marge_right, imagesy($output) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
		
		//full pic watermark
		/*$stamp = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'].web_config('watermark_txt'));	
		// Set the margins for the stamp and get the height/width of the stamp image
		//$marge_right = 10;
		//$marge_bottom = 10;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);
		imagecopy($output, $stamp, 0, 0, 0, 0, $sx, $sy);*/
	 }
	 //-------- end add water mark
	 // save image
	 ImageJPEG($output, $filename, 60); 
	 // return resized image
	 return $output; // if you need to use it
}
//resize_pic("images/CAM00297.jpg", "CAM00297.jpg");
// for large: width:1100, q 70
// for thumbnail: width 300, q 70

function upload($path,$file_ref,$newfile,$watermark=false,$formatConfig=''){	
	$result=0;$msg=$filename=$newfilename='';$filesize='0KB';$filetype='';
	$filepath = $_SERVER['DOCUMENT_ROOT'].$path;$file_detail=$thumbnail_path='';$isPic = false;
	$filepath_root = $path; //$filepath_root = '/documents/';
	$allowed_file = allowed_file($file_ref,$formatConfig);
	if($allowed_file['result']){
		$newfilename = str_replace(array(".".strtolower($allowed_file['ext'])," ","(",")"),array("_".time()."_".rand(0,100000).".".strtolower($allowed_file['ext']),"_","",""),strtolower($file_ref['name']));
		//$newfilename = $file_ref['name'].'_'.$newfile.($newfile==''?'':'_').time().".".$allowed_file['ext'];
		if(file_exists($filepath . $newfilename)) {$result=0;$msg = 'exist';}
		else{
			$sourcePath = $file_ref['tmp_name']; // Storing source path of the file in a variable
			$targetPath = $filepath.$newfilename; // Target path where file is to be stored
			move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file						
			$result=1;$msg = 'uploaded';
			
			//create thumnail and resize
			$file_detail = file_detail($newfilename);
			if($file_detail['name_en']=='Picture'){
				$isPic = true;
				//get dir location
				$thumbnail_path=web_config('thumbnail_path');
				$filepath_root=$resized_path=web_config('resized_pic_path');
				$resized_pic_path_root = $_SERVER['DOCUMENT_ROOT'].$resized_path;
				$thumbnail_path_root = $_SERVER['DOCUMENT_ROOT'].$thumbnail_path;
				//save thumbnail
				resize_pic($targetPath, $thumbnail_path_root.$newfilename,500);
				//save resize pic
				resize_pic($targetPath, $resized_pic_path_root.$newfilename,1100,$watermark);
			}
			
			$filename=$file_ref["name"];
			$filesize=$file_ref["size"];
			$filetype=$file_ref["type"];
		}
	}else{$msg = $allowed_file['msg'];}
	$data = array('result'=>$result,'msg'=>$msg,'filename'=>$filename,'newfilename'=>$newfilename,'isPic'=>$isPic,'file_detail'=>$file_detail,'thumbnail_path'=>$thumbnail_path,'filePath'=>$filepath_root,'filesize'=>format_filesize($filesize),'filetype'=>$filetype);
	return $data;
}

function deleteFile($path,$filename,$addRoot=true){
	if($filename==''){return false;}
	if($addRoot){$fullDir = $_SERVER['DOCUMENT_ROOT'].$path.$filename;}else{$fullDir = $path.$filename;}
	if(file_exists($fullDir)){unlink($fullDir);}
}

/* creates a compressed zip file */
function create_zip($files = array(),$destination = '',$overwrite = false) {
	$result = true;$msg='success';
	$destination = $_SERVER['DOCUMENT_ROOT'].$destination;
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { $result = false;$msg='file exist'; goto returnResult; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($_SERVER['DOCUMENT_ROOT'].$file)) {
				$valid_files[] = $_SERVER['DOCUMENT_ROOT'].$file;
				//update download counter
				downloadcounter($file);
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			 $result = false; $msg='zip creation failed'; goto returnResult; 
		}
		//add the files
		foreach($valid_files as $file) {
			$file_parts = explode('/',$file);
			$zip->addFile($file,end($file_parts));
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		if(!file_exists($destination)){ $result = false; $msg='zip file not found'; goto returnResult; }
	}
	else
	{
		 $result = false; $msg='no file to create zip'; goto returnResult; 
	}
	
	returnResult:
	return array('result'=>$result,'msg'=>$msg);
}
function days_in_month($month, $year) {
	if($month!=2) {
		if($month==9||$month==4||$month==6||$month==11)
			return 30;
		else
			return 31;
	}
	else
		return $year%4==""&&$year%100!="" ? 29 : 28;
}
function date_range_array($from_date,$to_date){
	$start=new DateTime($from_date);
	$interval=new DateInterval('P1D');
	$end=new DateTime($to_date);
	$end = $end->modify( '+1 day' ); 
	$period = new DatePeriod($start,$interval,$end);
	$array=array();
	foreach( $period as $date) { $array[] = $date->format('Y-m-d'); }	
	return $array;	
}
function gettoken(){global $encryptKey;
	$token = encodeString(rand(10,1000).'_'.time(),$encryptKey);
	return $token;
}
function check_token($token){global $encryptKey;$result = false;
	$raw_token =explode('_',decodeString($token,$encryptKey));
	$time = end($raw_token);
	if(is_numeric($time) and (time()-$time<=3600)){//token valid for 1h
		$result = true;
	}
	return $result;
}

//multiple dimension array search
function search_keys($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search_keys($subarray, $key, $value));
        }
    }

    return $results;
}

function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {			
        $sort_col[$key] = $row[$col];
		//if(!isset($row[$col])){var_dump($row);exit;}
    }
    array_multisort($sort_col, $dir, $arr);
}

function pageControlItems($privilege_id='',$is_backend='',$required_login='',$is_menu='',$is_ajax='',$is_webpage=''){
	$qry = new connectDb; global $usersession,$lang;
	//get service category id
	$data_new=array();
	$cond_pri_id = $privilege_id!==''?"page.id IN ($privilege_id) and":"";
	$is_backend = $is_backend!==''?"page.is_backend=$is_backend and":"";
	$required_login = $required_login!==''?"page.required_login=$required_login and":"";
	$is_menu = $is_menu!==''?"page.is_menu=$is_menu and":"";
	$is_ajax = $is_ajax!==''?"page.is_ajax=$is_ajax and":"";
	$is_webpage = $is_webpage!==''?"page.is_webpage=$is_webpage and":"";
	$data=$qry->qry_assoc("select page.id,page.parent_id,page.model,page.page_id,page.ordering,if(label_t.title<>'',label_t.title,label.title) title, label.url, label.icon,label.code from layout_page_controller page
									left join layout_text_item label on label.id = page.page_id
									left join layout_text_item_t label_t on label_t.item_id = label.id and label_t.language_id=$lang->id and label_t.active=1
									where $cond_pri_id $is_backend $required_login $is_menu $is_ajax $is_webpage page.active=1 order by label.priority asc");

	foreach($data as $key=>$value){
		if($value['parent_id']){
			$data_new[$value['parent_id']]['child'][]=$value;
		}else{
			if(isset($data_new[$value['id']]['child']) and count($data_new[$value['id']]['child'])){
				$data_new[$value['id']]=array_merge($value,$data_new[$value['id']]);
			}else{
				$data_new[$value['id']]=$value;
			}				
		}		
	}
	//re-arrang menu order	
	foreach($data_new as $key=>$value){
		if(!isset($value['id'])){//remove menu, if its parent's status is inactive
			unset($data_new[$key]);
		}elseif(isset($value['child']) and is_array($value['child']) and count($value['child'])>1){
			$arranged_child = $value['child'];
			array_sort_by_column($arranged_child, 'ordering');
			$data_new[$key]['child']=$arranged_child;
		}
	}
	array_sort_by_column($data_new, 'ordering');
	return $data_new;
}

function create_app_file($is_backend,$is_ajax,$is_webpage,$model_name,$prev_model_name='',$dir=''){
	$type = $is_backend?'backend':'frontend';
	//standard files	
	$model_stdpath="app/model/$type/page/";
	$model_path=$model_stdpath.$dir;
	$stdModel=$model_stdpath."stdModel.php";
	$ajax_stdpath="app/model/$type/ajax/";
	$ajax_path=$ajax_stdpath.$dir;
	$stdAjax=$ajax_stdpath."stdAjax.php";
	$view_stdpath="app/view/$type/content/";
	$view_path=$view_stdpath.$dir;
	$stdView=$view_stdpath."stdView.php";
	$all_files = array('model'=>array('path'=>$model_path,'stdfile'=>$stdModel,'stdtxt'=>'stdModel'),
						'ajax'=>array('path'=>$ajax_path,'stdfile'=>$stdAjax,'stdtxt'=>'stdAjax'),
						'view'=>array('path'=>$view_path,'stdfile'=>$stdView,'stdtxt'=>'stdView'));
	//control file creation
	if($is_ajax and !$is_webpage){
		unset($all_files['model'],$all_files['view']);
	}elseif(!$is_ajax and $is_webpage){
		unset($all_files['ajax']);
	}elseif(!$is_ajax and !$is_webpage){
		$all_files = array();
	}
	
	// ------ check if app file alr exists,modify, otherwise, create new
	foreach($all_files as $key=>$value){
		if($prev_model_name<>'' and file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$value['path'].$prev_model_name.'.php')) {
			//rename filename
			$fname=$value['path'].$model_name.'.php';
			$renamed = rename($value['path'].$prev_model_name.'.php', $fname);
			//modify
			if($key<>'view' and $renamed){				
				$fhandle = fopen($fname,"r");
				$content = fread($fhandle,filesize($_SERVER['DOCUMENT_ROOT'].'/'.$fname));		
				$content = str_replace($prev_model_name,$model_name,$content);		
				$fhandle = fopen($fname,"w");
				fwrite($fhandle,$content);
				fclose($fhandle);	
			}
		}elseif(!file_exists($_SERVER['DOCUMENT_ROOT'].'/'.$value['path'].$model_name.'.php')){
			
			//copy and create script
			$fname=$value['path'].$model_name.'.php';
			$copied = copy($value['stdfile'], $fname);
			//prepare script
			if($key<>'view' and $copied){				
				$fhandle = fopen($fname,"r");
				$content = fread($fhandle,filesize($_SERVER['DOCUMENT_ROOT'].'/'.$fname));		
				$content = str_replace($value['stdtxt'],$model_name,$content);		
				$fhandle = fopen($fname,"w");
				fwrite($fhandle,$content);
				fclose($fhandle);
			}
		}
	}
}

function khDatePeriod($from,$to){
	$blankdate = array('','0000-00-00');
	
	if($from==$to){$returndate=in_array($from,$blankdate)?'N/A':khmerDate($from);}
	else{
		$returndate=(in_array($from,$blankdate)?'N/A':khmerDate($from)).' → '.(in_array($to,$blankdate)?'N/A':khmerDate($to));
	}
	return $returndate;
}

function randomArray($arr,$length=1){
    if($length<=count($arr)){
        $rand_keys = array_rand($arr, $length);
        $rnd = array_intersect_key($arr, array_flip($rand_keys));
    }else{$rnd = array();}
    return $rnd;
}

function isJson($string) {
 json_decode($string);
 return ((json_last_error() == JSON_ERROR_NONE) and !is_numeric($string));
}

function TrimTrailingZeroes($nbr) {
    return strpos($nbr,'.')!==false ? rtrim(rtrim($nbr,'0'),'.') : $nbr;
}

function decode($input){
	global $encryptKey;
	return decodeString($input,$encryptKey);
}
function encode($input){
	global $encryptKey;
	return encodeString($input,$encryptKey);
}

function get_coordinates($city, $street, $province)
{
    $address = urlencode($city.','.$street.','.$province);
    $url = "http://maps.google.com/maps/api/geocode/json?key=AIzaSyCk68AIicPkiiERUM-IOGRAh08dYznWz2s&address=$address&sensor=false&region=Poland";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response);
    $status = $response_a->status;

    if ( $status == 'ZERO_RESULTS' )
    {
        return FALSE;
    }
    else
    {
        $return = array('lat' => $response_a->results[0]->geometry->location->lat, 'long' => $long = $response_a->results[0]->geometry->location->lng);
        return $return;
    }
}
function getDistanceBetweenPoints($lat1, $lon1, $lat2, $lon2) {
    $theta = $lon1 - $lon2;
    $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    $kilometers = $miles * 1.609344;
    return number_format($kilometers,1);
}
function GetDrivingDistance($lat1, $lat2, $long1, $long2)
{
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?key=AIzaSyCk68AIicPkiiERUM-IOGRAh08dYznWz2s&origins=".number_format($lat1,6).",".number_format($long1,6)."&destinations=".number_format($lat2,6).",".number_format($long2,6)."&mode=driving&language=en-US";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $response_a = json_decode($response, true);
	if(isset($response_a['rows'][0]['elements'][0]['distance']['text'])){
		$dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
		$time = $response_a['rows'][0]['elements'][0]['duration']['text'];
	}else{
		$direct_dist=getDistanceBetweenPoints($lat1, $long1, $lat2, $long2);
		$dist = $direct_dist.' km';
		$time = '';
	}

    return array('distance' => enNum_khNum($dist), 'time' => enNum_khNum($time));
}

function nearestDistance($datarow,$frompoint,$limit=3,$order=SORT_ASC){
	$frommap=explode(',',$frompoint);
	if(!is_array($datarow) or count($frommap)<2){return $datarow;}
	$newrow=array();
	foreach($datarow as $v){		
		$tomap=explode(',',$v['map']);
		if(count($tomap)<2){continue;}//lat,long,zoom (zoon not required)
		$v['distance']=enNum_khNum(getDistanceBetweenPoints($frommap[0], $frommap[1], $tomap[0], $tomap[1]).' km');
		$newrow[]=$v;
	}	
	//re-order
	array_sort_by_column($newrow, 'distance', $order);
	//get limit
	if($limit){
		$newrow=array_slice($newrow, 0, $limit);
	}
	
	return $newrow;
}

//=============================== custom functions =====================================================================================================




?>