<?php
class newPageLabel{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$refresh_listname='labelList';
		$result = false;$msg=$layout_label->message->insert_failed->icon.' '.$layout_label->message->insert_failed->title;
		$uploaded_files=array();
		//get post data
		$reg_fields = array('text'=>array(	'recordid'=>addslashes($_POST['recordid']),
											'main_id'=>addslashes($_POST['main_id']),
											'cate_id'=>addslashes($_POST['cate_id']),
											'title'=>addslashes($_POST['title']),	
											'content_code'=>addslashes(cleanstr(strtolower($_POST['content_code']))),	
											'code'=>addslashes(cleanstr(strtolower($_POST['code']))),	
											'url'=>addslashes($_POST['url']),		
											'icon'=>addslashes($_POST['icon']),		
											'data'=>addslashes($_POST['data']),			
											'priority'=>addslashes($_POST['priority']),									
											'for_page'=>isset($_POST['for_page'])?1:0,
											'active'=>isset($_POST['active'])?1:0),
							'email'=>array(),
							'file'=>array());
		$isNew = (isset($_POST['recordid']) and $_POST['recordid']<>'')?false:true;
		$opt_fields = array('recordid','main_id','content_code','url','icon','data','priority','for_page','active');
		$err_fields=validateForm($reg_fields,$opt_fields);		
		if(!count($err_fields)){
			if(!$isNew){
				//check if exists
				$recordid=decode($reg_fields['text']['recordid']);
				if(is_numeric($recordid) and $recordid>=0){
					$prev_data = $qry->qry_assoc("select id,code from layout_text_item where id=$recordid");
					if(!count($prev_data)){$msg='Data not exists';$err_fields[]= array('name'=>'error','msg'=>$msg);}
				}else{
					$msg='Invalid data request';$err_fields[]= array('name'=>'error','msg'=>$msg);
				}	
			}
			
			//check if have main id
			$main_id_code=$reg_fields['text']['main_id'];$main_id=0;
			if($main_id_code<>''){
				$main_id=decode($main_id_code);
				if(is_numeric($main_id) and $main_id>0){
					$main_id_valid = $qry->qry_count("select id from layout_text_item where id=$main_id limit 1");
					if(!$main_id_valid){$msg='Invalid parent id';$err_fields[]= array('name'=>'error','msg'=>$msg);}
				}else{$msg='Invalid parent id';$err_fields[]= array('name'=>'error','msg'=>$msg);}
			}
			
			//check if code exists
			if(!count($err_fields)){
				$check_exist = $qry->qry_count("select id from layout_text_item where code='".$reg_fields['text']['code']."' ".($isNew?"":"and id<>$recordid"));
				if($check_exist){$msg='Duplicate label code';$err_fields[]= array('name'=>'error','msg'=>$msg);}
			}
		}
		
		//add service
		if(!count($err_fields)){
			$datetime = date("Y-m-d H:i:s");
			if($main_id){$parent="parent_id=$main_id,";}else{$parent="";}		
			$sql = "code='".$reg_fields['text']['code']."',
					cate_id=".$reg_fields['text']['cate_id'].",
					$parent
					title='".$reg_fields['text']['title']."',
					content_code='".$reg_fields['text']['content_code']."',
					url='".$reg_fields['text']['url']."',
					icon='".$reg_fields['text']['icon']."',
					data='".$reg_fields['text']['data']."',
					priority='".$reg_fields['text']['priority']."',
					for_page=".$reg_fields['text']['for_page'].",
					active=".$reg_fields['text']['active'].",";
			if($isNew){
				$recordid=$qry->insert("insert into layout_text_item set $sql created_by=".$usersession->info()->id.",created_date='$datetime'");
			}else{
				$qry->update("update layout_text_item set $sql last_updated_by=".$usersession->info()->id.",last_updated_date='$datetime' where id=$recordid limit 1");				
			}			
			//add to user log			
			adduserlog($_POST['cmd'],$recordid.($isNew?'_add':'_update'));
			$result = true;$msg=$layout_label->message->insert_success->icon.' '.$layout_label->message->insert_success->title;;
		}	
		return json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields,'refresh_listname'=>$refresh_listname));	
	}	
}	



?>