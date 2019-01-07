<?php
class admin_paymenthistory{
	public function data($input){
		$qry = new connectDb;global $usersession,$lang;
		$pageExist=false;
		
		$cate_options='';
		$item_row = $qry->qry_assoc("select * from content_cate where active=1");
		foreach($item_row as $value){
			$cate_options.='<option value="'.$value['id'].'">'.$value['title'].'</option>';
		}	
		$lang_options='';
		$item_row = $qry->qry_assoc("select * from language where active=1");
		foreach($item_row as $value){
			$lang_options.='<option value="'.$value['id'].'">'.$value['title'].'</option>';
		}
		
		$date_from = '<div class="col-sm-4 col-md-2"><label>From Date</label><div class="input-append input-group input-group-sm dtpicker_notstrick">
											<input data-format="yyyy-MM-dd" id="date_from" type="text" placeholder="YY-MM-DD" class="form-control searchinputs">
											<span class="input-group-addon add-on"><i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar" class="fa fa-calendar"></i></span>
										</div></div>';
		$date_to = '<div class="col-sm-4 col-md-2"><label>To Date</label><div class="input-append input-group input-group-sm dtpicker_notstrick">
											<input data-format="yyyy-MM-dd" id="date_to" type="text" placeholder="YY-MM-DD" class="form-control searchinputs">
											<span class="input-group-addon add-on"><i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar" class="fa fa-calendar"></i></span>
										</div></div>';					
		
		$payMethod = '<div class="col-sm-4 col-md-2"><label>Payment Method</label><select class="form-control input-sm searchinputs" id="payMethod">
						<option value="">--- All ---</option>
						<option value="0">Added by Admin</option>';
		$item_row = $qry->qry_assoc("select * from license_payment_method where active=1");
		foreach($item_row as $value){
			$payMethod.='<option value="'.$value['id'].'">'.$value['title'].'</option>';
		}		
		$payMethod .= '</select></div>';	
		
		$isSkipped = '<div class="col-sm-4 col-md-2"><label>Allow Payment</label><select class="form-control input-sm searchinputs" id="isSkipped">
							<option value="">--- All ---</option>
							<option value="1">Skipped</option>
							<option value="0">Not Skipped</option>
						</select></div>';
		$t_status = '<div class="col-sm-4 col-md-2"><label>Transaction Status</label><select class="form-control input-sm searchinputs" id="t_status">
							<option value="">--- All ---</option>
							<option value="1">Success</option>
							<option value="0">Failed</option>
						</select></div>';
								
		$txt_search = '<div class="col-sm-4 col-md-2"><label>Keyword</label><div class="input-group input-group-sm"><input type="text" class="form-control searchinputs" id="txt_search" placeholder="Search keyword"><span class="input-group-btn btn_search"><button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button></span></div></div>';
		
		$search_inputs = '<div class="row">'.$date_from.$date_to.$payMethod.$isSkipped.$t_status.$txt_search.'</div>';
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'input'=>$input,'search_inputs'=>$search_inputs,'cate_options'=>$cate_options,'lang_options'=>$lang_options);
	}		
}
?>