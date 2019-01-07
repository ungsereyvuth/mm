<?php
class admin_user_activity{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		
		$qryData = (object) $_POST["qryData"];	
		$sql_condition = '';
		if($qryData->date_from<>''){$sql_condition.=" and log.datetime>='$qryData->date_from 00:00:00'";}
		if($qryData->date_to<>''){$sql_condition.=" and log.datetime<='$qryData->date_to 23:59:59'";}
		if(is_numeric($qryData->action_id)){$sql_condition.=" and log.action_id=$qryData->action_id";}
		if(is_numeric($qryData->status)){$sql_condition.=" and log.active=$qryData->status";}
		if($qryData->txt_search<>''){$sql_condition.=" and (log.action_data like '%$qryData->txt_search%' or log.ip like '%$qryData->txt_search%' or log.isp like '%$qryData->txt_search%' or log.browser_info like '%$qryData->txt_search%' or act.model like '%$qryData->txt_search%')";}
			
		$sql_statement = "SELECT log.*,act.model model_name,u.fullname,role.title role_name from user_activity log
							left join layout_page_controller act on act.id=log.action_id
							left join users u on u.id=log.user_id
							left join user_role role on role.id=u.role_id
							where 1=1 $sql_condition
							order by datetime desc";						
		extract(generateList($language,intval(post("currentPage")),post("rowsPerPage"),post("navAction"),$sql_statement));
		$dataListString = '';$i=$startIndex+1;
		foreach($rowData as $key=>$value){			
			$deviceInfo = json_decode($value['browser_info'],true);
			$userAgent_parts = explode(" ",$deviceInfo['userAgent']);	
			$profile_url='';
			$dataListString .= '<tr>
									<td class="txtCenter">'.enNum_khNum($i).'</td>
									<td><a href="'.$profile_url.'"><span class="tooltips" title="'.$value['role_name'].'">'.$value['fullname'].'</span></a></td>
									<td>'.$value['model_name'].'</td>
									<td>'.$value['action_data'].'</td>
									<td class="txtCenter"><span class="tooltips" title="'.$value['isp'].'">'.$value['ip'].'</span></td>
									<td class="txtCenter"><span class="tooltips" title="'.$deviceInfo['userAgent'].'">'.str_replace(array('(',';'),"",(isset($userAgent_parts[1])?$userAgent_parts[1]:'N/A')).'</span></td>								
									<td class="txtCenter"><span class="tooltips fs12" title="'.$value['datetime'].'">'.khmerDate($value['datetime']).'</span></td></tr>';
			
			$i++;
		}
		$no_data = $layout_label->label->no_data->icon.' '.$layout_label->label->no_data->title;
		if($dataListString == ''){$dataListString = '<tr><td colspan="'.$qryData->col.'" style="text-align:center; color:#c0434d;">'.$no_data.'</td></tr>';}
		$data = array('list'=>$dataListString,'listNavInfo'=>($totalPages>0?$list_nav_info:$no_data),'targetPage'=>$targetPage,'totalPages'=>$totalPages,'totalRow'=>$totalRow,'gotoSelectNum'=>$gotoSelectNum,'nav_btn_disable'=>$nav_btn_disable);	
		echo json_encode($data);	
	}	
}	



?>