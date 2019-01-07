<?php
class admin_contentlist{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		
		$qryData = (object) $_POST["qryData"];	
		$sql_condition = '';$translate_lang_con=$lang_code='';
		if($qryData->date_from<>''){$sql_condition.=" and c.created_date>='$qryData->date_from 00:00:00'";}
		if($qryData->date_to<>''){$sql_condition.=" and c.created_date<='$qryData->date_to 23:59:59'";}
		if(is_numeric($qryData->cate_id)){$sql_condition.=" and c.cate_id=$qryData->cate_id";}		
		if(is_numeric($qryData->status)){$sql_condition.=" and c.active=$qryData->status";}
		if($qryData->txt_search<>''){$sql_condition.=" and (c.title like '%$qryData->txt_search%' or c.description like '%$qryData->txt_search%')";}
		
		//get language list
		$item_row = $qry->qry_assoc("select * from language where active=1 and set_default=0");	
			
		$sql_statement = "SELECT c.*,cate.title cate_title from content c
							left join content_cate cate on cate.id=c.cate_id
							where 1=1 $sql_condition 
							order by c.created_date desc";	
							
		$load_data_cmdid = "116,117";$load_data_cmd = array();
		//get command name
		$command = $qry->qry_assoc("select model from layout_page_controller where id IN ($load_data_cmdid) order by id asc");
		if(count($command)){$load_data_cmd['load_content'] = $command[0]['model'];$load_data_cmd['load_translation'] = $command[1]['model'];}
		
		extract(generateList($language,intval(post("currentPage")),post("rowsPerPage"),post("navAction"),$sql_statement));
		$dataListString = '';$i=$startIndex+1;
		foreach($rowData as $key=>$value){	
			//edit url
			$edit_user_url = '/'.$lang->selected.$layout_label->label->admin_user->url.'/'.encodeString($value['id'],$encryptKey);
			$translation_btn='';
			foreach($item_row as $lvalue){
				$translation_btn .= '<li><a class="load_form_btn" href="#" data-cmd="'.$load_data_cmd['load_translation'].'" data-target_formid="newContentTranslation" data-recordid="'.encodeString($value['id'].'_'.$lvalue['id'],$encryptKey).'"><img src="/assets/frontend/img/flags/'.$lvalue['code'].'.png" height="15"> '.$lvalue['title'].'</a></li>';
			}
			
			$dataListString .= '<tr>
									<td class="txtCenter">
										'.$i.'										
									</td>
									<td class="txtLeft">
										<div>
											<span class="tooltips" title="Content ID: '.$value['id'].'">'.$value['title'].'</span> 
											'.($value['active']?'':'<i class="fa fa-minus-circle redcolor tooltips" title="Inactive"></i>').' 										
										</div>
										<div class="sub-info fs12">
											<span class="tooltips" title="Content Code"><i class="fa fa-hashtag"></i> <i class="greencolor">'.$value['code'].'</i></span> | 
											<span class="tooltips" title="Content category"><i class="greencolor">'.$value['cate_title'].'</i></span> | 
											<span class="tooltips" title="Created Date"><i class="fa fa-clock"></i> <i class="greencolor">'.date('d/m/Y H:i',strtotime($value['created_date'])).'</i></span> 
										</div>
									</td>		
									<td class="txtCenter">
										<button class="load_form_btn btn btn-xs rounded btn-default v_mgn5" type="button" data-cmd="'.$load_data_cmd['load_content'].'" data-target_formid="newContent" data-recordid="'.encodeString($value['id'],$encryptKey).'"><i class="fa fa-pencil"></i> Edit</button>
										<div class="btn-group">
											<button type="button" class="btn btn-xs rounded btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
												<i class="fa fa-language"></i> Translate
												<i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu fs12" role="menu">
												'.$translation_btn.'
											</ul>
										</div>
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