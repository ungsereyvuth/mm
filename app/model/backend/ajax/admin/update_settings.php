<?php
class update_settings{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$result = false;$msg=$layout_label->message->update_failed->title;
		$err_fields=array();$datetime = date("Y-m-d H:i:s");
		$settingname = decodeString($_POST['settingname'],$encryptKey);
		$settingvalue = $_POST['settingvalue'];
		if($settingname<>'' and $settingvalue<>''){			
			$check_row = $qry->qry_assoc("SELECT * FROM generalsetting where settingName='$settingname' limit 1");
			if(count($check_row)){	
				//check data type
				$data_verified=true;
				if(($check_row[0]['is_bool'] or $check_row[0]['is_num']) and !is_numeric($settingvalue)){$data_verified=false;}
				if($data_verified){
					$qry->update("update generalsetting set settingValue='$settingvalue', last_modified_date='$datetime',last_modified_by=".$usersession->info()->id." where settingName='$settingname' limit 1");
					$result = true;$msg=$layout_label->message->update_success->title;
					//add to user log			
					adduserlog('update_settings',$usersession->info()->id);
				}else{$err_fields[]= array('name'=>'settingvalue','msg'=>$layout_label->message->number_only->title);}
			}else{$err_fields[]= array('name'=>'settingvalue','msg'=>$layout_label->message->invalid_data->title);}
		}else{$err_fields[]= array('name'=>'settingvalue','msg'=>$layout_label->message->blank_data->title);}
								
		echo  json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields));
	}	
}	



?>