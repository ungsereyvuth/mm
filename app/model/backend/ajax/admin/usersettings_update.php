<?php
class usersettings_update{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$result = false;$msg=$layout_label->message->update_failed->icon.' '.$layout_label->message->update_failed->title;
		//$refresh_listname = 'admin_chargingrate';
		$err_fields=array();$uploaded_files=array();
		//get post data
		$reg_fields = array('text'=>array('recordid'=>addslashes($_POST['recordid']),
											'active'=>isset($_POST['active'])?1:0,
											'pending'=>isset($_POST['pending'])?0:1),
							'email'=>array(),
							'file'=>array());
		$recordid=decodeString($reg_fields['text']['recordid'],$encryptKey);
		if($recordid<>$usersession->info()->id and isAdmin($usersession->info()->id)){$admin_edit=true;}else{$admin_edit=false;}
	
		$opt_fields = array('active','pending');
	
		$err_fields=validateForm($reg_fields,$opt_fields);		
		if(!count($err_fields)){
			//check if exists		
			if(is_numeric($recordid) and $recordid>=0){
				$check_exist = $qry->qry_assoc("select id from users where id=$recordid");
				if(!count($check_exist)){$msg='Invalid user data';$err_fields[]= array('name'=>'error','msg'=>$msg);}
				elseif($recordid<>$usersession->info()->id and !isAdmin($usersession->info()->id)){
					$msg='No permission to perform this request';$err_fields[]= array('name'=>'error','msg'=>$msg);
				}
			}else{
				$msg='Invalid data request';
				$err_fields[]= array('name'=>'error','msg'=>$msg);
			}
		}
		
		//add service
		if(!count($err_fields)){
			$datetime = date("Y-m-d H:i:s");
			$qry->update("update users set 
								pending=".$reg_fields['text']['pending'].",
								active=".$reg_fields['text']['active'].",
								last_updated_by=".$usersession->info()->id.",
								last_updated_date='$datetime'
								where id=$recordid limit 1");	
			
			//add to user log			
			adduserlog($_POST['cmd'],$recordid);
			$result = true;$msg=$layout_label->message->update_success->icon.' '.$layout_label->message->update_success->title;;
		}	
		echo json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields));
	}	
}	



?>