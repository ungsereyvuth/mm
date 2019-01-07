<?php
class load_cotent_translation{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$result=false;$msg='Data load failed';
		$arr_data=explode('_',decodeString($_POST['recordid'],$encryptKey));//mainid_langid
		$recordid=$arr_data[0];$language_id=$arr_data[1];
		$fromdata=array(); $orignal_table = 'content'; $tralsated_table = 'content_t';
		if(is_numeric($recordid) and $recordid>0 and is_numeric($language_id) and $language_id>0){
			$fromdata = $qry->qry_assoc("select *,language_id language_title from $tralsated_table where main_id=$recordid and language_id=$language_id limit 1");
			$main_data = $qry->qry_assoc("select title from $orignal_table where id=$recordid limit 1");
			if(count($main_data)){
				$main_data=$main_data[0];
				if(count($fromdata)){
					$fromdata = $fromdata[0];
					$fromdata['recordid'] = encodeString($recordid,$encryptKey);	
					$fromdata['main_title']=$main_data['title'];	
					$msg='Data loaded';
				}else{
					$fromdata['language_id'] =$fromdata['language_title'] = $language_id;	
					$fromdata['recordid'] = encodeString($recordid,$encryptKey);	
					$fromdata['main_title']=$main_data['title'];
					$fromdata['title_t']=$fromdata['description_t']='';		
					$fromdata['active']=1;	
					$msg='Data not yet created. Fill and create now!';
				}
				$result=true;
			}else{
				$msg='Main data missing!';
			}
			
		}
		
		echo json_encode(array('result'=>$result,'msg'=>$msg,'fromdata'=>$fromdata));
	}		
}	



?>