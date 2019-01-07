<?php
class labelList{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		
		$qryData = (object) $_POST["qryData"];	
		$sql_condition = '';$translate_lang_con=$lang_code='';
		if(is_numeric($qryData->main_id) and $qryData->main_id>0){$sql_condition.=" and l.parent_id=$qryData->main_id";}else{$sql_condition.=" and l.parent_id is NULL";}
		if(is_numeric($qryData->type_id)){$sql_condition.=" and l.cate_id=$qryData->type_id";}
		if(is_numeric($qryData->lang_id)){$translate_lang_con=" and t.language_id=$qryData->lang_id";$get_lang = $layout->languagecode($qryData->lang_id);$lang_code=$get_lang['selected'];}
		if(is_numeric($qryData->for_page)){$sql_condition.=" and l.for_page=$qryData->for_page";}
		if(is_numeric($qryData->status)){$sql_condition.=" and l.active=$qryData->status";}
		if($qryData->txt_search<>''){$sql_condition.=" and (l.code like '%$qryData->txt_search%' or l.title like '%$qryData->txt_search%')";}
			
		$sql_statement = "SELECT l.*,c.title cate_title,t.title title_t,t.id t_id,t.active active_t from layout_text_item l 
							left join layout_text_cate c on c.id=l.cate_id 
							left join layout_text_item_t t on t.item_id=l.id $translate_lang_con 
							where 1=1 $sql_condition 
							order by l.created_date desc";	
							
		$load_data_cmdid = "88,89";$load_data_cmd = array();
		//get command name
		$command = $qry->qry_assoc("select model from layout_page_controller where id IN ($load_data_cmdid) order by id asc limit 2");
		if(count($command)==2){$load_data_cmd['load_label'] = $command[0]['model'];$load_data_cmd['load_translation'] = $command[1]['model'];}
						
		extract(generateList($language,intval(post("currentPage")),post("rowsPerPage"),post("navAction"),$sql_statement));
		$dataListString = '';$i=$startIndex+1;
		foreach($rowData as $key=>$value){	
			$translation_btn = $traslation_txt = '';
			if(is_numeric($qryData->lang_id)){
				$translation_btn = '<li><a href="javascript: void(0)" class="load_form_btn" type="button" data-cmd="'.$load_data_cmd['load_translation'].'" data-target_formid="newPageLabelTranslation" data-recordid="'.encode($value['id'].'_'.$qryData->lang_id).'"><i class="fa fa-language"></i> Translate</a></li>';
				$traslation_txt = '<div><img src="/assets/frontend/img/flags/'.$lang_code.'.png" width="20" /> <i class="fs11">'.$value['title_t'].'</i> '.($value['active_t']?'':'<i class="fa fa-exclamation-circle redcolor tooltips" title="Inactive"></i>').'</div>';
			}
			
			//get total sub
			$totalsub=$qry->qry_count("select id from layout_text_item where parent_id=".$value['id']);
			
			$sub_item_url = '<li><a class="load_form_btn" href="'.$layout_label->label->admin_languagemanagement->url.'/'.encode($value['id']).'"><i class="fa fa-list"></i> Sub Items</a></li>';
			$dataListString .= '<tr>
									<td class="txtCenter">
										'.$value['cate_title'].'										
									</td>
									<td class="txtLeft">
										<div>
											<span class="tooltips" title="Label ID: '.$value['id'].'">'.$value['title'].'</span>
											'.($value['url']<>''?'
												<span class="pull-right fs11 tooltips" title="Access URL"><i class="fa fa-link"></i> <i>'.$value['url'].'</i></span>
											':'').'
											
										</div>
										'.$traslation_txt.'
										<div class="sub-info">
											<span class="tooltips" title="Key Code"><i class="fa fa-hashtag"></i> <i class="greencolor">'.$value['code'].'</i></span> 
											<span class="tooltips" title="Sub Items"><i class="fa fa-th-list"></i> <i class="'.($totalsub?'greencolor':'redcolor').'">'.$totalsub.'</i></span> 
											'.($value['content_code']<>''?'
												<i class="fa fa-angle-right"></i> <span class="tooltips" title="Content Code"><i class="fa fa-file-o"></i> <i class="greencolor">'.$value['content_code'].'</i></span> 
											':'').'
											'.($value['icon']<>''?'
												<i class="fa fa-angle-right"></i> <span class="tooltips" title="Icon"><i class="greencolor">'.$value['icon'].'</i></span>
											':'').'
											'.($value['for_page']?' <i class="fa fa-angle-right"></i> <i class="fa fa-globe tooltips" title="For Webpage"></i>':'').'
											'.($value['data']<>''?'
												<i class="fa fa-angle-right"></i> <span class="tooltips" title="Additional Data"><i class="greencolor"><i class="fa fa-info-circle"></i> '.$value['data'].'</i></span>
											':'').'
											<span class="pull-right tooltips" title="Ordering Number">'.($value['priority']?'<i class="fa fa-list-ol"></i> '.$value['priority']:'').'</span>
										</div>
									</td>		
									<td class="txtCenter">
										<div class="btn-group">
											<button type="button" class="btn btn-xs rounded btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
												<i class="fa fa-ellipsis-v"></i> Actions
												<i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu fs12 v_pad0" role="menu">
												<li><a href="javascript: void(0)" class="load_form_btn" data-cmd="'.$load_data_cmd['load_label'].'" data-target_formid="newPageLabel" data-recordid="'.encodeString($value['id'],$encryptKey).'"><i class="fa fa-pencil"></i> Edit</a></li>
												'.$translation_btn.'
												'.$sub_item_url.'
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