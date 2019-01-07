<?php
class admin_contentcategory{
	public function data($input){
		$qry = new connectDb;global $usersession,$lang;
		$pageExist=false;
		
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
						
		$status = '<div class="col-sm-6 col-md-3"><label>Status</label><select class="form-control input-sm searchinputs" id="status">
							<option value="">--- All ---</option>
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select></div>';		
		$txt_search = '<div class="col-sm-6 col-md-3"><label>Keyword</label><div class="input-group input-group-sm"><input type="text" class="form-control searchinputs" id="txt_search" placeholder="Search keyword"><span class="input-group-btn btn_search"><button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button></span></div></div>';
		
		$search_inputs = '<div class="row">'.$date_from.$date_to.$status.$txt_search.'</div>';
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'input'=>$input,'search_inputs'=>$search_inputs);
	}	
}
?>