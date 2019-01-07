<?php
class load_item_t{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$result=false;$msg='Data load failed';
		$codes=explode('_',decode($_POST['recordid']));
		
		$fromdata=array();
		if(count($codes)==2){
			$recordid=$codes[0];$langid=$codes[1];
			if(is_numeric($recordid) and $recordid>0 and is_numeric($langid) and $langid>0){
				$maindata = $qry->qry_assoc("select title from v_items where id=$recordid limit 1");
				$fromdata = $qry->qry_assoc("select it.*,i.title main_title from v_items i
											left join v_items_t it on i.id=it.main_id
											where it.main_id=$recordid and it.language_id=$langid limit 1");
				if(count($fromdata)){
					$fromdata = $fromdata[0];
					$fromdata['recordid'] = encode($recordid);	
					$result=true;$msg='Data loaded';
				}elseif(count($maindata)){
					$fromdata['recordid'] = encode($recordid);	
					$fromdata['language_id'] = $langid;	
					$fromdata['main_title'] = $maindata[0]['title'];	
					$result=true;$msg='Data not yet created. Please add now.';
				}
			}
		}
		echo json_encode(array('result'=>$result,'msg'=>$msg,'fromdata'=>$fromdata));
	}	
}	



?>