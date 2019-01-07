<?php
class newContentTranslation{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$refresh_listname='labelList';
		$result = false;$msg=$layout_label->message->insert_failed->icon.' '.$layout_label->message->insert_failed->title;
		$uploaded_files=array();
		//get post data
		$reg_fields = array('text'=>array(	'recordid'=>addslashes($_POST['recordid']),
											'language_id'=>addslashes($_POST['language_id']),
											'title_t'=>addslashes($_POST['title_t']),	
											'description_t'=>addslashes($_POST['description_t']),											
											'active'=>isset($_POST['active'])?1:0),
							'email'=>array(),
							'file'=>array());
		$opt_fields = array('active');
		$err_fields=validateForm($reg_fields,$opt_fields);		
		if(!count($err_fields)){
			//check if exists
			$recordid=decodeString($reg_fields['text']['recordid'],$encryptKey);
			$language_id=$reg_fields['text']['language_id'];
			if(is_numeric($recordid) and $recordid and is_numeric($language_id) and $language_id){
				$prev_data = $qry->qry_assoc("select id from content_t where main_id=$recordid and language_id=".$reg_fields['text']['language_id']." ");
				if(count($prev_data)){$isNew=false;}else{$isNew=true;}
			}else{
				$msg="Invalid data request";
				$err_fields[]= array('name'=>'error','msg'=>$msg);
			}
		}
		
		//add service
		if(!count($err_fields)){			
			$datetime = date("Y-m-d H:i:s");		
			$sql = "title_t='".$reg_fields['text']['title_t']."',	
					description_t='".$reg_fields['text']['description_t']."',					
					active=".$reg_fields['text']['active'].",";
			if($isNew){
				$qry->insert("insert into content_t set main_id=$recordid,language_id=$language_id,$sql created_by=".$usersession->info()->id.",created_date='$datetime'");
			}else{
				$qry->update("update content_t set $sql last_updated_by=".$usersession->info()->id.",last_updated_date='$datetime' 
								where main_id=$recordid and language_id=$language_id limit 1");				
			}			
			//add to user log			
			adduserlog($_POST['cmd'],'id:'.$recordid.',lang:'.$language_id.($isNew?'|add':'|update'));
			$result = true;$msg=$layout_label->message->insert_success->icon.' '.$layout_label->message->insert_success->title;;
		}	
		return json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields,'refresh_listname'=>$refresh_listname));	
	}		
}	



?>