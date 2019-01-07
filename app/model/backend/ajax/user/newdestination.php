<?php
class newdestination{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$refresh_listname='user_destinationlist';
		$result = false;$msg=$layout_label->message->insert_failed->icon.' '.$layout_label->message->insert_failed->title;
		$uploaded_files=array();$tableName = 'v_items';
		//get post data
		$reg_fields = array('text'=>array(	'recordid'=>addslashes($_POST['recordid']),
											'cate_id'=>isset($_POST['cate_id'])?$_POST['cate_id']:'',
											'title'=>addslashes(trim($_POST['title'])),
											'address'=>addslashes(trim($_POST['address'])),
											'provincecity'=>isset($_POST['provincecity'])?$_POST['provincecity']:0,
											'description'=>addslashes(trim($_POST['description'])),
											'transportation_info'=>addslashes(trim($_POST['transportation_info'])),
											'contact_info'=>addslashes(trim($_POST['contact_info'])),
											'map_lat'=>addslashes($_POST['map_lat']),
											'map_lng'=>addslashes($_POST['map_lng']),
											'map_zoom'=>addslashes($_POST['map_zoom']),	
											'filename'=>addslashes($_POST['filename']),	
											'top_attraction'=>isset($_POST['top_attraction'])?1:0,
											'publish_now'=>isset($_POST['publish_now'])?1:0),
							'email'=>array(),
							'file'=>array());
		$isNew = (isset($_POST['recordid']) and $_POST['recordid']<>'')?false:true;
		$opt_fields = array('recordid','publish_now','top_attraction','filename','map_lat','map_lng','map_zoom','transportation_info','contact_info');
		$err_fields=validateForm($reg_fields,$opt_fields);		
		if(!count($err_fields)){			
			if(!$isNew){
				//check if exists
				$recordid=decodeString($reg_fields['text']['recordid'],$encryptKey);
				if(is_numeric($recordid) and $recordid>=0){
					$check_exist = $qry->qry_count("select id from $tableName where id=$recordid");
					if(!$check_exist){$msg='Data not exists';$err_fields[]= array('name'=>'error','msg'=>$msg);}
				}else{
					$msg='Invalid data request';
					$err_fields[]= array('name'=>'error','msg'=>$msg);
				}	
			}
			
			//check map
			if($reg_fields['text']['map_lat']=='' or $reg_fields['text']['map_lng']=='' or $reg_fields['text']['map_zoom']==''){
				$err_fields[]= array('name'=>'map','msg'=>'Please set location (Click on map to set location)');
			}else{
				$map = $reg_fields['text']['map_lat'].','.$reg_fields['text']['map_lng'].','.$reg_fields['text']['map_zoom'];
			}
			
			//check if code exists
			if(!count($err_fields)){
				$itemtype = 'destination';	
				$cate_id=$reg_fields['text']['cate_id'];
				if(is_array($cate_id)){sort($cate_id);$cate_id=implode(',',$cate_id);}
				$check_exist = $qry->qry_count("select i.id from $tableName i 
												left join layout_text_item type on type.id=i.type_id
												where type.code='$itemtype' and i.cate_id='$cate_id' and i.provincecity=".$reg_fields['text']['provincecity']." and i.title='".$reg_fields['text']['title']."' ".($isNew?"":"and i.id<>$recordid"));
				if($check_exist){$msg=$layout_label->message->data_exist->title;$err_fields[]= array('name'=>'title','msg'=>$msg);}
			}
		}
		
		//add service
		if(!count($err_fields)){
			$datetime = date("Y-m-d H:i:s");
			$filenames=array();
			$files = explode('|',$reg_fields['text']['filename']);
			foreach($files as $v){$filenames[]=array('filename'=>$v,'des'=>'');}
			
			if(isAdmin($usersession->info()->id)){
				$approval = ",approved=1,approved_by=".$usersession->info()->id.",approved_date='$datetime'";
			}elseif(!$require_review_post){$approval = ",approved=1";}				
			$sql = "title='".$reg_fields['text']['title']."',
					cate_id='$cate_id',
					address='".$reg_fields['text']['address']."',	
					provincecity=".$reg_fields['text']['provincecity'].",	
					description='".$reg_fields['text']['description']."',	
					transportation_info='".$reg_fields['text']['transportation_info']."',	
					contact_info='".$reg_fields['text']['contact_info']."',	
					map='$map',	
					filenames='".json_encode($filenames)."',
					active=".$reg_fields['text']['publish_now'].",";
			if($isNew){
				$typeid=$layout_label->listing->destination->id;
				$recordid=$qry->insert("insert into $tableName set $sql type_id=$typeid,created_by=".$usersession->info()->id.",created_date='$datetime' $approval");
			}else{
				$qry->update("update $tableName set $sql last_updated_by=".$usersession->info()->id.",last_updated_date='$datetime' where id=$recordid limit 1");				
			}			
			//add to user log			
			adduserlog($_POST['cmd'],$recordid.($isNew?'_add':'_update'));
			$result = true;$msg=$layout_label->message->insert_success->icon.' '.$layout_label->message->insert_success->title;;
		}	
		return json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields,'refresh_listname'=>$refresh_listname));	
	}		
}	



?>