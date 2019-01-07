<?php
class profile{
	public function data($input){
		$qry = new connectDb;global $usersession,$layout_label;
		$pageExist=false;
		
		$datainfo=array();$profile_url='';
		if(isset($input[0]) and is_numeric(decode($input[0])) and decode($input[0])){
			$data_id=decode($input[0]);
		}else{goto returnStatus;}
		
		//get data by template
		$datainfo = $qry->qry_assoc("select md.*,tp.name_kh certificate_name_kh,tp.name_en certificate_name_en,tp.name_cn certificate_name_cn,
											fd.title,fd.fieldname,dt.code,fd.position,d.value 
									from ec_maindata md 
									left join ec_data d on d.main_id=md.id
									left join ec_formdata fd on fd.id=d.formdata_id
									left join ec_datatype dt on dt.id=fd.fieldtype
									left join ec_template tp on tp.id=fd.template_id
									where md.id=$data_id and md.active=1 and d.active=1 and fd.active=1");
				
		if(!count($datainfo)){goto returnStatus;}
		
		$profile_url = $layout_label->system_title->sys->url.$layout_label->label->profile->url.'/'.$input[0];
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'datainfo'=>$datainfo,'profile_url'=>$profile_url);
	}	
}
?>