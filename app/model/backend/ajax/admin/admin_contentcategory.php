<?php
class admin_contentcategory{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		
		$qryData = (object) $_POST["qryData"];	
		$sql_condition = '';$translate_lang_con=$lang_code='';
		if($qryData->date_from<>''){$sql_condition.=" and c.created_date>='$qryData->date_from 00:00:00'";}
		if($qryData->date_to<>''){$sql_condition.=" and c.created_date<='$qryData->date_to 23:59:59'";}
		if(is_numeric($qryData->status)){$sql_condition.=" and c.active=$qryData->status";}
		if($qryData->txt_search<>''){$sql_condition.=" and (c.title like '%$qryData->txt_search%' or c.code like '%$qryData->txt_search%')";}
	
		$sql_statement = "SELECT c.* from content_cate c
							where 1=1 $sql_condition 
							order by c.created_date desc";	
							
		$load_data_cmdid = "121";$load_data_cmd = array();
		//get command name
		$command = $qry->qry_assoc("select model from layout_page_controller where id IN ($load_data_cmdid) order by id asc");
		if(count($command)){$load_data_cmd['load_content'] = $command[0]['model'];}
		
		extract(generateList($language,intval(post("currentPage")),post("rowsPerPage"),post("navAction"),$sql_statement));
		$dataListString = '';$i=$startIndex+1;
		foreach($rowData as $key=>$value){	
			
			$dataListString .= '<tr>
									<td class="txtCenter">
										'.$i.'										
									</td>
									<td class="txtLeft">
										<div>
											<span class="tooltips" title="Category ID: '.$value['id'].'">'.$value['title'].'</span>	'.($value['active']?'':'<i class="fa fa-exclamation-triangle redcolor tooltips" title="Inactive"></i>').'
										</div>
										<div class="sub-info fs12">
											<span class="tooltips" title="Content Code"><i class="fa fa-hashtag"></i> <i class="greencolor">'.$value['code'].'</i></span> | 
											<span class="tooltips" title="Created Date"><i class="fa fa-clock"></i> <i class="greencolor">'.date('d/m/Y H:i',strtotime($value['created_date'])).'</i></span> 
										</div>
									</td>		
									<td class="txtCenter">
										<button class="load_form_btn btn btn-xs rounded btn-default v_mgn5" type="button" data-cmd="'.$load_data_cmd['load_content'].'" data-target_formid="newContentCategory" data-recordid="'.encodeString($value['id'],$encryptKey).'"><i class="fa fa-pencil"></i> Edit</button>
									</td>								
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