<?php
class admin_userlist{
	public function data($input){
		$qry = new connectDb;global $usersession;
		$pageExist=false;
		
		$role_select_option=$role_options='';
		$item_row = $qry->qry_assoc("select * from user_role where active=1 order by auth_level");
		foreach($item_row as $value){
			$role_select_option.='<option value="'.$value['id'].'">'.$value['title'].'</option>';
			if($value['auth_level']>=$usersession->info()->auth_level){$role_options.='<option value="'.$value['id'].'">'.$value['title'].'</option>';}
		}	
		
		$date_from = '<div class="col-sm-6 col-md-3"><label>From Date</label>
							<div class="input-group">
								<input type="text" placeholder="Select a date" class="form-control input-sm datepicker searchinputs" data-dateformat="yy-mm-dd" id="date_from">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>';
		$date_to = '<div class="col-sm-6 col-md-3"><label>To Date</label>
						<div class="input-group">
								<input type="text" placeholder="Select a date" class="form-control input-sm datepicker searchinputs" data-dateformat="yy-mm-dd" id="date_to">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
					</div>';
		
		$role_select = '<div class="col-sm-6 col-md-3"><label>Page Type</label><select class="form-control input-sm searchinputs" id="role_id">
							<option value="">--- All ---</option>'.$role_select_option.'</select></div>';						
						
		$status = '<div class="col-sm-6 col-md-3"><label>Status</label><select class="form-control input-sm searchinputs" id="status">
							<option value="">--- All ---</option>
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select></div>';		
		$txt_search = '<div class="col-sm-6 col-md-3 v_pad5"><label>Keyword</label><div class="input-group input-group-sm"><input type="text" class="form-control searchinputs" id="txt_search" placeholder="Search keyword"><span class="input-group-btn btn_search"><button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button></span></div></div>';
		
		$search_inputs = '<div class="row">'.$date_from.$date_to.$role_select.$status.$txt_search.'</div>';
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'input'=>$input,'search_inputs'=>$search_inputs,'role_options'=>$role_options);
	}	
}
?>