<?php
class admin_emailtemplate{
	public function data($input){
		global $encryptKey;
		$pageExist=false;
		$qry = new connectDb;
		$template_list='';
		$templates = $qry->qry_assoc("select * from email_template where active=1");
		foreach($templates as $key=>$value){
			$template_id = encodeString($value['id'],$encryptKey);
			$template_list.='<div class="v_item bg-blacklight pad10 v_mgn5">
								<i class="fa fa-angle-double-right"></i> '.$value['title'].' <i class="redcolor">['.$value['code'].']</i>
								<button class="load_form_btn btn btn-xs rounded btn-default pull-right" type="button" data-cmd="loademailtemplate" data-target_formid="updateemailtemplate" data-recordid="'.$template_id.'"><i class="fa fa-pencil"></i> Edit</button>
							</div>';
		}
		

		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'input'=>$input,'template_list'=>$template_list);
	}	
}

?>