<?php
class loademailtemplate{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		
		$result=0;$msg='Invalid request'.$_POST['recordid'];$fromdata=array();
		$recordid=decodeString(isset($_POST['recordid'])?$_POST['recordid']:0,$encryptKey);
		if($recordid>0){
			$getdata = $qry->qry_assoc("select * from email_template where id=$recordid limit 1");
			if(count($getdata)){
				$fromdata=$getdata[0];
				//encrypt id
				$fromdata['recordid']=encodeString($fromdata['id'],$encryptKey);
				$result=1;$msg='Data loaded';
			}else{$msg='Template not exists';}
		}
		echo json_encode(array('result'=>$result,'msg'=>$msg,'fromdata'=>$fromdata));
			
	}	
}	



?>