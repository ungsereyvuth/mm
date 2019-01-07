<?php
class newpagecontrol{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$refresh_listname='page_controller_list';
		$result = false;$msg=$layout_label->message->insert_failed->icon.' '.$layout_label->message->insert_failed->title;
		$uploaded_files=array();
		//get post data
		$reg_fields = array('text'=>array(	'recordid'=>addslashes($_POST['recordid']),
											'label_id'=>isset($_POST['label_id'])?$_POST['label_id']:'',
											'parent_id'=>addslashes($_POST['parent_id']==''?'NULL':$_POST['parent_id']),
											'inherited'=>addslashes($_POST['inherited']),	
											'model'=>addslashes(str_replace(' ','_',$_POST['model'])),	
											'dir'=>addslashes($_POST['dir']),										
											'required_login'=>isset($_POST['required_login'])?1:0,
											'required_logout'=>isset($_POST['required_logout'])?1:0,
											'required_layout'=>isset($_POST['required_layout'])?1:0,
											'is_menu'=>isset($_POST['is_menu'])?1:0,
											'is_ajax'=>isset($_POST['is_ajax'])?1:0,
											'is_webpage'=>isset($_POST['is_webpage'])?1:0,
											'is_backend'=>isset($_POST['is_backend'])?1:0,
											'has_shortcut'=>isset($_POST['has_shortcut'])?1:0,
											'ordering'=>addslashes($_POST['ordering']<>''?$_POST['ordering']:'NULL'),	
											'active'=>isset($_POST['active'])?1:0,
											'components'=>isset($_POST['components'])?$_POST['components']:array(),
											'user_roles'=>isset($_POST['user_roles'])?$_POST['user_roles']:array()),
							'email'=>array(),
							'file'=>array());
		$isNew = (isset($_POST['recordid']) and $_POST['recordid']<>'')?false:true;
		$opt_fields = array('recordid','components','user_roles','inherited','model','parent_id','required_login','required_logout','required_layout','is_menu','is_ajax','is_webpage','is_backend','has_shortcut','active','ordering','dir');
		if(!$isNew){$opt_fields[]='label_id';}
		//make page id optional if contorl for ajax, make model_name required
		if($reg_fields['text']['is_ajax']){$opt_fields[] = 'label_id';$opt_fields=array_diff($opt_fields, array('model'));}

		$err_fields=validateForm($reg_fields,$opt_fields);
		
		if(!count($err_fields)){
			//if select user role but forget check login
			if(count($reg_fields['text']['user_roles']) and !$reg_fields['text']['required_login']){
				$err_fields[]= array('name'=>'required_login','msg'=>'This settings requires login');
			}
	
			if(!$isNew){
				//check if exists
				$recordid=decodeString($reg_fields['text']['recordid'],$encryptKey);
				if(is_numeric($recordid) and $recordid>=0){
					$prev_data = $qry->qry_assoc("select id,model from layout_page_controller where id=$recordid");
					if(!count($prev_data)){$msg='Data not exists';$err_fields[]= array('name'=>'error','msg'=>$msg);}
				}else{
					$msg='Invalid data request';
					$err_fields[]= array('name'=>'error','msg'=>$msg);
				}	
			}			
			
			//get model name
			if(in_array('label_id',$opt_fields)){$model_name=$reg_fields['text']['model'];}
			else{
				$label_data = $qry->qry_assoc("select code from layout_text_item where id=".$reg_fields['text']['label_id']);
				if(count($label_data)){$model_name=$label_data[0]['code'];}
				else{$msg='no label found!';$err_fields[]= array('name'=>'error','msg'=>$msg);}
			}
			
			//check if exist model name
			if(!count($err_fields)){
				$check_exist = $qry->qry_count("select id from layout_page_controller where model='$model_name' ".($isNew?"":"and id<>$recordid"));
				if($check_exist){$msg='Duplicate label/model';$err_fields[]= array('name'=>'error','msg'=>$msg);}
			}
		}
		
		//add service
		if(!count($err_fields)){
			$datetime = date("Y-m-d H:i:s");$page_id_sql='';	
			if($isNew){$page_id_sql="page_id=".($reg_fields['text']['label_id']==''?'NULL':$reg_fields['text']['label_id']).",";}	
			$sql = "parent_id=".$reg_fields['text']['parent_id'].",
					model='$model_name',
					dir='".$reg_fields['text']['dir']."',
					inherited='".$reg_fields['text']['inherited']."',
					$page_id_sql
					required_login=".$reg_fields['text']['required_login'].",
					required_logout=".$reg_fields['text']['required_logout'].",
					required_layout=".$reg_fields['text']['required_layout'].",
					components='".implode(',',$reg_fields['text']['components'])."',
					is_menu=".$reg_fields['text']['is_menu'].",
					is_ajax=".$reg_fields['text']['is_ajax'].",
					is_webpage=".$reg_fields['text']['is_webpage'].",
					is_backend=".$reg_fields['text']['is_backend'].",
					has_shortcut=".$reg_fields['text']['has_shortcut'].",
					ordering=".$reg_fields['text']['ordering'].",
					active=".$reg_fields['text']['active'].",";
			if($isNew){
				$recordid=$qry->insert("insert into layout_page_controller set $sql created_by=".$usersession->info()->id.",created_date='$datetime'");
				//create app file
				if($reg_fields['text']['is_ajax'] or $reg_fields['text']['is_webpage']){
					create_app_file($reg_fields['text']['is_backend'],$reg_fields['text']['is_ajax'],$reg_fields['text']['is_webpage'],$model_name,'',$reg_fields['text']['dir']);
				}
			}else{
				$qry->update("update layout_page_controller set $sql last_updated_by=".$usersession->info()->id.",last_updated_date='$datetime' where id=$recordid limit 1");
				//update app file
				$prev_model_name = $prev_data[0]['model'];
				if($prev_model_name<>$model_name and ($reg_fields['text']['is_ajax'] or $reg_fields['text']['is_webpage'])){
					create_app_file($reg_fields['text']['is_backend'],$reg_fields['text']['is_ajax'],$reg_fields['text']['is_webpage'],$model_name,$prev_model_name,$reg_fields['text']['dir']);
				}
			}
			
			if($reg_fields['text']['required_login']){
				$user_role_data = $qry->qry_assoc("select id,privileges from user_role where active=1");
				$assigned_roles=$reg_fields['text']['user_roles'];
				foreach($user_role_data as $key=>$value){
					$privileges=$prev_privileges= explode(',',$value['privileges']);
					$role_id = $value['id'];
					if(in_array($role_id,$assigned_roles)){
						if(!in_array($recordid,$privileges)){
							$privileges[] = $recordid;
						}
					}else{
						$privileges = array_diff($privileges,array($recordid));
					}
					
					if($privileges<>$prev_privileges){
						$privileges_str = implode(',',$privileges);
						$qry->update("update user_role set privileges='$privileges_str' where id=$role_id limit 1");
					}
				}
			}
			
			//add to user log			
			adduserlog($_POST['cmd'],$recordid.($isNew?'_add':'_update'));
			$result = true;$msg=$layout_label->message->insert_success->icon.' '.$layout_label->message->insert_success->title;;
		}	
		return json_encode(array('result'=>$result,'msg'=>$msg,'err_fields'=>$err_fields,'refresh_listname'=>$refresh_listname));			
	}	
}	



?>