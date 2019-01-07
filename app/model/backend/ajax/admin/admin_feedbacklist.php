<?php
class admin_feedbacklist{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		
		$qryData = (object) $_POST["qryData"];	
		$sql_condition = '';$translate_lang_con=$lang_code='';
		if($qryData->date_from<>''){$sql_condition.=" and c.created_date>='$qryData->date_from 00:00:00'";}
		if($qryData->date_to<>''){$sql_condition.=" and c.created_date<='$qryData->date_to 23:59:59'";}
		if(is_numeric($qryData->isUser)){$sql_condition.=" and u.id is ".($qryData->isUser?'not':'')." NULL";}
		if($qryData->txt_search<>''){$sql_condition.=" and (c.name like '%$qryData->txt_search%' or c.email like '%$qryData->txt_search%' or c.subject like '%$qryData->txt_search%' or c.description like '%$qryData->txt_search%')";}
					
		$sql_statement = "SELECT c.*,if(u.id is NULL,0,1) isUser,u.username from feedback c
							left join users u on u.email=c.email
							where 1=1 $sql_condition 
							order by c.created_date desc";	
		
		extract(generateList($language,intval(post("currentPage")),post("rowsPerPage"),post("navAction"),$sql_statement));
		$dataListString = '';$i=$startIndex+1;
		foreach($rowData as $key=>$value){	
			
			$dataListString .= '<tr>
									<td class="txtCenter">
										'.$i.'										
									</td>
									<td class="txtLeft">'.$value['name'].' '.($value['isUser']?('<i class="fa fa-user-circle bluecolor tooltips" title="System User: '.$value['username'].'"></i>'):'').'</td>	
									<td class="txtLeft">'.$value['email'].'</td>
									<td class="txtLeft">'.$value['subject'].'</td>	
									<td class="txtLeft">'.$value['description'].'</td>
									<td class="txtLeft tooltips" title="'.khmerDate($value['created_date'],'full_dt').'">'.khmerDate($value['created_date']).'</td>									
								</tr>';
			
			$i++;
		}
		$no_data = $layout_label->label->no_data->icon.' '.$layout_label->label->no_data->title;
		if($dataListString == ''){$dataListString = '<tr><td colspan="'.$qryData->col.'" style="text-align:center; color:#c0434d;">'.$no_data.'</td></tr>';}
		$data = array('list'=>$dataListString,'listNavInfo'=>($totalPages>0?$list_nav_info:$no_data),'targetPage'=>$targetPage,'totalPages'=>$totalPages,'gotoSelectNum'=>$gotoSelectNum,'nav_btn_disable'=>$nav_btn_disable,'totalRow'=>$totalRow);	
		echo json_encode($data);	
	}	
}	



?>