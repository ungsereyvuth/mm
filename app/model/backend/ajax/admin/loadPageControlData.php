<?php
class loadPageControlData{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$result=false;$msg='Data load failed';
		$recordid=decodeString($_POST['recordid'],$encryptKey);
		$fromdata=array();
		if(is_numeric($recordid) and $recordid>0){
			$fromdata = $qry->qry_assoc("select *,page_id label_id from layout_page_controller where id=$recordid");
			if(count($fromdata)){
				$fromdata = $fromdata[0];
				$fromdata['recordid'] = encodeString($fromdata['id'],$encryptKey);
				$fromdata['page_style'] = htmlspecialchars($fromdata['page_style']);
				$fromdata['page_script'] = htmlspecialchars($fromdata['page_script']);
				$components = explode(',',$fromdata['components']);
				foreach($components as $key=>$value){$fromdata["components[$value]"]=1;}
				//check for allowed user roles
				$roles = $qry->qry_assoc("select id from user_role where concat(',',privileges,',') like '%,".$fromdata['id'].",%'");
				foreach($roles as $key=>$value){$fromdata["user_roles[".$value['id']."]"]=1;}
				
				$result=true;$msg='Data loaded';
			}
		}
		
		echo json_encode(array('result'=>$result,'msg'=>$msg,'fromdata'=>$fromdata));
	}	
}	


?>