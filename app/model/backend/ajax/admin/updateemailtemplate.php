<?php
class updateemailtemplate{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		
		$result = false;$msg=$layout_label->message->update_failed->icon.' '.$layout_label->message->update_failed->title;
		$err_fields=array();$uploaded_files=array();$goto_url='';$datetime = date("Y-m-d H:i:s");
		$refresh_listname='admin_newsletterlist';
		//get post data
		$reg_fields = array('text'=>array('recordid'=>decodeString(addslashes($_POST['recordid']),$encryptKey),'title'=>addslashes($_POST['title']),'subject'=>addslashes($_POST['subject']),'content'=>addslashes(htmlspecialchars_decode($_POST['content']))),
							'email'=>array(),
							'file'=>array());
		
		$opt_fields = array('publish');
		$temp_fields=array();
		foreach($reg_fields as $value){foreach($value as $sub_key=>$sub_value){$temp_fields[]=$sub_key;}}		
		$required_fields = array_diff($temp_fields,$opt_fields);
		$required_val = array();
		foreach($required_fields as $value){$required_val[$value]=array_key_exists($value,$reg_fields['file'])?$_FILES[$value]:$_POST[$value];}		
		if(in_array('',$required_val)){	
			foreach($required_val as $key=>$value){
				if($value==''){$err_fields[]= array('name'=>$key,'msg'=>$layout_label->message->blank_data->title);}
				if(array_key_exists($key,$reg_fields['file'])){if($reg_fields['file'][$key]['type']==''){$err_fields[]= array('name'=>$key,'msg'=>$layout_label->message->no_file->title);}}
			}	
		}else{
			//check valid id
			$recordid=$reg_fields['text']['recordid'];
			if(!is_numeric($recordid) or $recordid==0){
				$err_fields[]= array('name'=>'error','msg'=>$layout_label->message->invalid_data->title);
				$msg=$layout_label->message->invalid_data->title;
			}else{
				$exist = $qry->qry_count("select id from email_template where id=$recordid limit 1");
				if(!$exist){
					$err_fields[]= array('name'=>'error','msg'=>$layout_label->message->invalid_data->title);
					$msg=$layout_label->message->invalid_data->title;
				}
			}
		}
		
		//add service
		if(!count($err_fields)){	
			$qry->insert("update email_template set									
							title='".$reg_fields['text']['title']."',
							subject='".$reg_fields['text']['subject']."',
							content='".$reg_fields['text']['content']."',
							last_updated_by=".$usersession->info()->id.",
							last_updated_date='$datetime'
							where id=$recordid limit 1");
				
			//add to user log			
			adduserlog($_POST['cmd'],$recordid);
			$result = true;$msg=$layout_label->message->update_success->icon.' '.$layout_label->message->update_success->title;
		}	
		echo json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields));
			
	}	
}	



?>