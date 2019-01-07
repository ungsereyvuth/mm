<?php
class page_controller_list{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		
		$qryData = (object) $_POST["qryData"];	
		$sql_condition = '';
		if(is_numeric($qryData->control_type)){$sql_condition.=" and c.is_backend=$qryData->control_type";}
		if($qryData->authentication<>''){
			if($qryData->authentication=='login'){$sql_condition.=" and c.required_login=1";}
			elseif($qryData->authentication=='logout'){$sql_condition.=" and c.required_logout=1";}			
		}
		if($qryData->page_type<>''){
			if($qryData->page_type=='both'){$sql_condition.=" and c.is_ajax=1 and c.is_webpage=1";}
			elseif($qryData->page_type=='ajax'){$sql_condition.=" and c.is_ajax=1";}		
			elseif($qryData->page_type=='page'){$sql_condition.=" and c.is_webpage=1";}			
		}
		if(is_numeric($qryData->is_menu)){$sql_condition.=" and c.is_menu=$qryData->is_menu";}
		if(is_numeric($qryData->status)){$sql_condition.=" and c.active=$qryData->status";}
		if($qryData->show_sub=='true'){$show_sub=true;}else{$show_sub=false;}
		if($qryData->txt_search<>''){$sql_condition.=" and (c.model like '%$qryData->txt_search%' or label.title like '%$qryData->txt_search%')";}
	
		$sql_statement = "SELECT c.*,c.id sub_id,if(c.is_ajax=1 and c.is_webpage=1,'Ajax + Page',if(c.is_ajax=1,'Ajax',if(c.is_webpage=1,'Page',''))) type,c.is_menu,label.title page_title,label.url,label.icon,c.required_login,c.required_logout from 
							( 
								(SELECT *,id main_id FROM layout_page_controller where parent_id IS NULL) 
								UNION 
								(SELECT c.*,p.id main_id FROM layout_page_controller p 
								left join layout_page_controller c on c.parent_id=p.id where c.id IS NOT NULL order by p.id)							
							) c 
							left join layout_text_item label on label.id=c.page_id 
							where 1=1 $sql_condition 
							order by c.main_id,c.parent_id";	
		$color = 'bg-white';$load_data_cmdid = 82;$load_data_cmd = '';
		//get command name
		$command = $qry->qry_assoc("select model from layout_page_controller where id=$load_data_cmdid limit 1");
		if(count($command)){$load_data_cmd = $command[0]['model'];}
		extract(generateList($language,intval(post("currentPage")),post("rowsPerPage"),post("navAction"),$sql_statement,'c.main_id'));
		$dataListString = '';$i=$startIndex+1;
		foreach($rowData as $key=>$value){		
				
			$sub_control = '';
			foreach($value['child'] as $skey=>$svalue){
				$sub_control .= '<tr class="'.($show_sub?'':'hidden').'">
									'.(!isset($value['id'])?'<td class="txtCenter">'.$i.'</td>':'').'
									<td class="txtLeft" style="border-left:3px solid #5bc0de;">
										<span class="tooltips" title="Label ID: '.$svalue['page_id'].'">'.$svalue['page_title'].'</span> '.($svalue['active']?'':'<i class="fa fa-exclamation-triangle redcolor tooltips" title="Inactive"></i>').'
										'.($svalue['url']<>''?'
											<span class="pull-right fs11 tooltips" title="Access URL"><i class="fa fa-link"></i> <i>'.$svalue['url'].'</i></span>
										':'').'

										<div class="sub-info fs12">
											<span class="tooltips" title="Model ID: '.$svalue['id'].'"><i class="fa fa-hashtag"></i> '.$svalue['model'].'</span>
											 | <span>'.($svalue['is_backend']?'Back-End':'Front-End').'</span>
											'.($svalue['icon']<>''?'
												| <span class="tooltips" title="Icon"><span class="greencolor">'.$svalue['icon'].'</span></span> 
											':'').'
											'.($svalue['is_menu']?'
												 | <span class="tooltips" title="Is Menu"><span class="greencolor">Menu</span></span> 
											':'').'
											'.($svalue['type']<>''?'
												| <span class="tooltips" title="Type"><span class="greencolor">'.$svalue['type'].'</span></span> 
											':'').'
											'.($svalue['required_login']?'
												 | <span class="tooltips" title="Authentication"><span class="greencolor">Login</span></span> 
											':($svalue['required_logout']?'| <span class="tooltips" title="Authentication"><span class="greencolor">Logout</span></span> ':'')).'
											'.($svalue['inherited']<>''?'
												| <span class="tooltips" title="Inherited"><span class="greencolor">'.$svalue['inherited'].'</span></span> 
											':'').'
											<span class="pull-right tooltips" title="Ordering Number">'.(((isset($svalue['ordering']) and isset($value['ordering'])) and ($svalue['ordering'] and $value['ordering']))?('<i class="fa fa-list-ol"></i> '.$value['ordering'].' <i class="fa fa-angle-right"></i> '.$svalue['ordering']):'').'</span>
										</div>
									</td>	
									<td class="txtCenter">
										<button class="load_form_btn btn btn-xs rounded btn-default" type="button" data-cmd="'.$load_data_cmd.'" data-target_formid="newpagecontrol" data-recordid="'.encodeString($svalue['id'],$encryptKey).'"><i class="fa fa-pencil"></i> Edit</button>
									</td>					
								</tr>';
			}
			//check if query return childs only, so childs display as parent		
			if(!isset($value['id'])){$dataListString .=$sub_control;}else{
				$dataListString .= '<tr>
										<td class="txtCenter" rowspan="'.($show_sub?(count($value['child'])+1):'').'">
											'.$i.'
										</td>
										<td class="txtLeft">
											<span class="tooltips" title="Label ID: '.$value['page_id'].'">'.$value['page_title'].'</span> '.($value['active']?'':'<i class="fa fa-exclamation-triangle redcolor tooltips" title="Inactive"></i>').'
											'.($value['url']<>''?'
												<span class="pull-right fs11 tooltips" title="Access URL"><i class="fa fa-link"></i> <i>'.$value['url'].'</i></span>
											':'').'
	
											<div class="sub-info fs12">
												<span class="tooltips" title="Model ID: '.$value['id'].'"><i class="fa fa-hashtag"></i> '.$value['model'].'</span>
												 | <span>'.($value['is_backend']?'Back-End':'Front-End').'</span>
												'.($value['icon']<>''?'
													| <span class="tooltips" title="Icon"><span class="greencolor">'.$value['icon'].'</span></span> 
												':'').'
												'.($value['is_menu']?'
													 | <span class="tooltips" title="Is Menu"><span class="greencolor">Menu</span></span> 
												':'').'
												'.($value['type']<>''?'
													| <span class="tooltips" title="Type"><span class="greencolor">'.$value['type'].'</span></span> 
												':'').'
												'.($value['required_login']?'
													 | <span class="tooltips" title="Authentication"><span class="greencolor">Login</span></span> 
												':($value['required_logout']?'| <span class="tooltips" title="Authentication"><span class="greencolor">Logout</span></span> ':'')).'
												'.($value['inherited']<>''?'
													| <span class="tooltips" title="Inherited"><span class="greencolor">'.$value['inherited'].'</span></span> 
												':'').'
												<span class="pull-right tooltips" title="Ordering Number">'.($value['ordering']?'<i class="fa fa-list-ol"></i> '.$value['ordering']:'').'</span>
											</div>
										</td>
										<td class="txtCenter">
											<button class="load_form_btn btn btn-xs rounded btn-default" type="button" data-cmd="'.$load_data_cmd.'" data-target_formid="newpagecontrol" data-recordid="'.encodeString($value['id'],$encryptKey).'"><i class="fa fa-pencil"></i> Edit</button>
										</td>								
									</tr>'.$sub_control;
				}
				
			$i++;
		}
		$no_data = $layout_label->label->no_data->icon.' '.$layout_label->label->no_data->title;
		if($dataListString == ''){$dataListString = '<tr><td colspan="'.$qryData->col.'" style="text-align:center; color:#c0434d;">'.$no_data.'</td></tr>';}
		$data = array('list'=>$dataListString,'listNavInfo'=>($totalPages>0?$list_nav_info:$no_data),'targetPage'=>$targetPage,'totalPages'=>$totalPages,'gotoSelectNum'=>$gotoSelectNum,'nav_btn_disable'=>$nav_btn_disable,'totalRow'=>$totalRow);	
		echo json_encode($data);			
	}	
}	



?>