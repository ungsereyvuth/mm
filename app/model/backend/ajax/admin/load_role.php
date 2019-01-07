<?php
class load_role{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$result=false;$msg='Data load failed';
		$recordid=decodeString($_POST['recordid'],$encryptKey);
		$fromdata=array();
		if(is_numeric($recordid) and $recordid>0){
			$fromdata = $qry->qry_assoc("select * from user_role where id=$recordid");
			if(count($fromdata)){
				$fromdata = $fromdata[0];
				$fromdata['recordid'] = encodeString($fromdata['id'],$encryptKey);				
				$result=true;$msg='Data loaded';
			}
		}
		
		echo json_encode(array('result'=>$result,'msg'=>$msg,'fromdata'=>$fromdata));
	}	
}	



?>