<?php
class activateitem{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$result=false;$msg=$layout_label->message->update_failed->title;$err_fields=array();$datetime = date("Y-m-d H:i:s");
		$refresh_listname='';
		$codes = explode('|',decode($data['recordid']));//id_listname
		if(count($codes)==2){
			$recordid=$codes[0];$refresh_listname=$codes[1];
			if(is_numeric($recordid) and $recordid>0){		
				$exist = $qry->qry_count("SELECT id FROM v_items where id=$recordid limit 1");
				if($exist){
					$qry->update("update v_items set active = NOT active,last_updated_date='$datetime',last_updated_by=".$usersession->info()->id." where id=$recordid limit 1");
					$result = true;$msg=$layout_label->message->update_success->title;
					//add to user log			
					adduserlog($_POST['cmd'],$recordid.'_update');
				}else{$msg='Invalid data request';}
			}else{$msg='Invalid data request';}
		}else{$msg='Invalid data request';}
		
		echo json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields,'refresh_listname'=>$refresh_listname));
	}	
}	



?>