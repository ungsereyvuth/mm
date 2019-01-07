<?php
class admin_user_activity{
	public function data($input){
		$qry = new connectDb;global $usersession;
		$pageExist=false;
		
		$action_options='';
		$item_row = $qry->qry_assoc("select log.*,act.id action_id,act.model action_name from user_activity log
										left join layout_page_controller act on act.id=log.action_id
										 where log.active=1 and act.id IS NOT NULL
										 group by log.action_id
										 order by act.model");
		foreach($item_row as $value){
			$action_options.='<option value="'.$value['action_id'].'">'.$value['action_name'].'</option>';
		}
		
		$date_from = '<div class="col-sm-6 col-md-3"><label>From Date</label><div class="input-append input-group input-group-sm dtpicker_notstrick">
											<input data-format="yyyy-MM-dd" id="date_from" type="text" placeholder="YY-MM-DD" class="form-control searchinputs">
											<span class="input-group-addon add-on"><i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar" class="fa fa-calendar"></i></span>
										</div></div>';
		$date_to = '<div class="col-sm-6 col-md-3"><label>To Date</label><div class="input-append input-group input-group-sm dtpicker_notstrick">
											<input data-format="yyyy-MM-dd" id="date_to" type="text" placeholder="YY-MM-DD" class="form-control searchinputs">
											<span class="input-group-addon add-on"><i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar" class="fa fa-calendar"></i></span>
										</div></div>';
		
		$action_select = '<div class="col-sm-6 col-md-3"><label>Activity Type</label><select class="form-control input-sm searchinputs" id="action_id">
							<option value="">--- All ---</option>'.$action_options.'</select></div>';						
						
		$status = '<div class="col-sm-6 col-md-3"><label>Status</label><select class="form-control input-sm searchinputs" id="status">
							<option value="">--- All ---</option>
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select></div>';		
		$txt_search = '<div class="col-sm-6 col-md-3"><label>Keyword</label><div class="input-group input-group-sm"><input type="text" class="form-control searchinputs" id="txt_search" placeholder="Search keyword"><span class="input-group-btn btn_search"><button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button></span></div></div>';
		
		$search_inputs = '<div class="row">'.$date_from.$date_to.$action_select.$status.$txt_search.'</div>';
		
		//get traffic graph data
		$fromDate = date('Y-m-01', strtotime('previous month'));
		$toDate = date('Y-m-t');
		$log_data = $qry->qry_assoc("select count(log.id) totalByDay,DATE(log.datetime) traffic_date from user_activity log
									 where log.active=1 and (log.datetime >='$fromDate 00:00:00' and log.datetime<='$toDate 23:59:59')
									 group by traffic_date
									 order by traffic_date asc");	
		$dateBetween= date('d/m/Y',strtotime($fromDate)).' - '.date('d/m/Y',strtotime($toDate));
		$daysRange = date_range_array($fromDate,$toDate);
		$graph_data=array();
		foreach($daysRange as $key=>$value){
			$getvalue=array();
			foreach($log_data as $lkey=>$lvalue){
				if($lvalue['traffic_date']==$value){$getvalue=$lvalue;break;}
			}
			if(count($getvalue)){$graph_data[]=$getvalue;}else{$graph_data[]=array('totalByDay'=>0,'traffic_date'=>$value);}
		}
		//var_dump($graph_data);
		
		//total count by activity type for bar chart
		$logByType = $qry->qry_assoc("select count(log.id) totalByType,cmd.model cmdName from user_activity log
										left join layout_page_controller cmd on cmd.id=log.action_id
										 where log.active=1 and model not in ('login','logout') and (log.datetime >='$fromDate 00:00:00' and log.datetime<='$toDate 23:59:59')
										 group by log.action_id
										 order by log.action_id");
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'input'=>$input,'search_inputs'=>$search_inputs,'graph_data'=>$graph_data,'dateBetween'=>$dateBetween,'logByType'=>$logByType);
	}	
}
?>