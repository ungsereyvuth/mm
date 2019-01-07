<?php
class newRole{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$refresh_listname='rolelist';
		$result = false;$msg=$layout_label->message->insert_failed->icon.' '.$layout_label->message->insert_failed->title;
		$uploaded_files=array();
		//get post data
		$reg_fields = array('text'=>array(	'recordid'=>addslashes($_POST['recordid']),
											'code'=>addslashes(str_replace(' ','_',$_POST['code'])),	
											'title'=>addslashes($_POST['title']),						
											'auth_level'=>addslashes($_POST['auth_level']),		
											'homepage'=>addslashes($_POST['homepage']),		
											'active'=>isset($_POST['active'])?1:0),
							'email'=>array(),
							'file'=>array());
		$isNew = (isset($_POST['recordid']) and $_POST['recordid']<>'')?false:true;
		$opt_fields = array('recordid','homepage','active');
		$err_fields=validateForm($reg_fields,$opt_fields);		
		if(!count($err_fields)){
			if(!$isNew){
				//check if exists
				$recordid=decodeString($reg_fields['text']['recordid'],$encryptKey);
				if(is_numeric($recordid) and $recordid>=0){
					$check_exist = $qry->qry_count("select id from user_role where id=$recordid");
					if(!$check_exist){$msg='Data not exists';$err_fields[]= array('name'=>'error','msg'=>$msg);}
				}else{
					$msg='Invalid data request';
					$err_fields[]= array('name'=>'error','msg'=>$msg);
				}	
			}
			
			//check if code exists
			if(!count($err_fields)){
				$check_exist = $qry->qry_count("select id from user_role where code='".$reg_fields['text']['code']."' ".($isNew?"":"and id<>$recordid"));
				if($check_exist){$msg='Duplicate role code';$err_fields[]= array('name'=>'error','msg'=>$msg);}
			}
		}
		
		//add service
		if(!count($err_fields)){
			$datetime = date("Y-m-d H:i:s");
			//echo $reg_fields['text']['icon'];exit;			
			$sql = "code='".$reg_fields['text']['code']."',
					title='".$reg_fields['text']['title']."',
					auth_level='".$reg_fields['text']['auth_level']."',
					homepage='".$reg_fields['text']['homepage']."',					
					active=".$reg_fields['text']['active'].",";
			if($isNew){
				$recordid=$qry->insert("insert into user_role set $sql created_by=".$usersession->info()->id.",created_date='$datetime'");
			}else{
				$qry->update("update user_role set $sql last_updated_by=".$usersession->info()->id.",last_updated_date='$datetime' where id=$recordid limit 1");				
			}			
			//add to user log			
			adduserlog($_POST['cmd'],$recordid.($isNew?'_add':'_update'));
			$result = true;$msg=$layout_label->message->insert_success->icon.' '.$layout_label->message->insert_success->title;;
		}	
		return json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields,'refresh_listname'=>$refresh_listname));	
	}		
}	



?>