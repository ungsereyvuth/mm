<?php
class user_accommodationlist{
	public function data($input){
		$qry = new connectDb;global $usersession,$lang,$layout_label;
		$pageExist=false;
		
		//langauge option
		$lang_options='';
		foreach($lang->getlist as $val){
			if(!$val['default']){
				$lang_options='<option value="'.$val['id'].'">'.$val['title'].'</option>';
			}
		}
		
		
		//location
		$locationopt='';
		$locationrow = $qry->qry_assoc("select *,IF('$lang->selected'='kh',name_kh,name_en) provincecity_name from provincecity where active=1");
		foreach($locationrow as $val){
			$locationopt.='<option value="'.$val['id'].'">'.$val['provincecity_name'].'</option>';
		}
		$cateopt='';
		foreach($layout_label->listing->accommodations->sub as $val){
			$cateopt.='<option value="'.$val->id.'">'.$val->title.'</option>';
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
		
		$location = '<div class="col-sm-6 col-md-3"><label>'.$layout_label->label->provincecity->title.'</label><select class="form-control input-sm searchinputs" id="location">
							<option value="">--- All ---</option>
							'.$locationopt.'
						</select></div>';				
		$status = '<div class="col-sm-6 col-md-3"><label>Status</label><select class="form-control input-sm searchinputs" id="status">
							<option value="">--- All ---</option>
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select></div>';		
		$txt_search = '<div class="col-sm-6 col-md-3"><label>Keyword</label><div class="input-group input-group-sm"><input type="text" class="form-control searchinputs" id="txt_search" placeholder="Search keyword"><span class="input-group-btn btn_search"><button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button></span></div></div>';
		
		$search_inputs = '<div class="row">'.$date_from.$date_to.$location.$status.$txt_search.'</div>';
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'input'=>$input,'search_inputs'=>$search_inputs,'locationopt'=>$locationopt,'cateopt'=>$cateopt,'lang_options'=>$lang_options);
	}	
}
?>