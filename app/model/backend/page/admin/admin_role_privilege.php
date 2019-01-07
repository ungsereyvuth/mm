<?php
class admin_role_privilege{
	public function data($input){
		$qry = new connectDb;global $encryptKey;
		$pageExist=false;
		
		$date_from = '<div class="col-sm-6 col-md-3"><label>From Date</label><div class="input-append input-group input-group-sm dtpicker_notstrick">
											<input data-format="yyyy-MM-dd" id="date_from" type="text" placeholder="YY-MM-DD" class="form-control searchinputs">
											<span class="input-group-addon add-on"><i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar" class="fa fa-calendar"></i></span>
										</div></div>';
		$date_to = '<div class="col-sm-6 col-md-3"><label>To Date</label><div class="input-append input-group input-group-sm dtpicker_notstrick">
											<input data-format="yyyy-MM-dd" id="date_to" type="text" placeholder="YY-MM-DD" class="form-control searchinputs">
											<span class="input-group-addon add-on"><i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar" class="fa fa-calendar"></i></span>
										</div></div>';
										
		$status = '<div class="col-sm-6 col-md-3"><label>Status</label><select class="form-control input-sm searchinputs" id="status">
							<option value="">--- All ---</option>
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select></div>';	
						
		$txt_search = '<div class="col-sm-6 col-md-3"><label>Keyword</label><div class="input-group input-group-sm"><input type="text" class="form-control searchinputs" id="txt_search" placeholder="Search keyword"><span class="input-group-btn btn_search"><button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button></span></div></div>';
		
		$search_inputs = '<div class="row">'.$date_from.$date_to.$status.$txt_search.'</div>';
		
		
		$role_code = $webpage_control = $ajax_control = $roleinfo = array();$role_id=0; $edit_title='';
		if(isset($input[0]) and $input[0]<>''){$role_code = explode('_',decodeString($input[0],$encryptKey));}//input[0] => roleid_time
		if(count($role_code)==2 and is_numeric($role_code[0]) and is_numeric($role_code[1])){
			if(time()-$role_code[1]<=7200){$role_id=$role_code[0];}//allow within 2 hours
		}
		
		//page control items
		if($role_id){
			$roleinfo = (object) roleinfo($role_id);	
			$edit_title=' For <code>'.$roleinfo->title.'</code>';		
			$webpage_control = pageControlItems('','',1,'','',1); //---- webpage
			$ajax_control = pageControlItems('','',1,'',1,''); //---- ajax
		}
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'search_inputs'=>$search_inputs,'ajax_control'=>$ajax_control,'webpage_control'=>$webpage_control,'roleinfo'=>$roleinfo,'role_code'=>$role_code,'edit_title'=>$edit_title);
	}	
}
?>