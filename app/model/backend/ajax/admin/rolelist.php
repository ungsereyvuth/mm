<?php
class rolelist{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		
		$qryData = (object) $_POST["qryData"];	
		$sql_condition = '';$translate_lang_con=$lang_code='';	
		if($qryData->date_from<>''){$sql_condition.=" and role.created_date>='$qryData->date_from 00:00:00'";}
		if($qryData->date_to<>''){$sql_condition.=" and role.created_date<='$qryData->date_to 23:59:59'";}
		if(is_numeric($qryData->status)){$sql_condition.=" and role.active=$qryData->status";}
		if($qryData->txt_search<>''){$sql_condition.=" and (role.title like '%$qryData->txt_search%' or role.title_kh like '%$qryData->txt_search%')";}
			
		$sql_statement = "SELECT role.*,count(if(u.id is NULL,NULL,1)) total_users from user_role role 
							left join users u on u.role_id=role.id
							where 1=1 $sql_condition 
							group by role.id
							order by role.auth_level";	
							
		$load_data_cmdid = "108";$load_data_cmd = array();
		//get command name
		$command = $qry->qry_assoc("select model from layout_page_controller where id IN ($load_data_cmdid) order by id asc limit ".count(explode(',',$load_data_cmdid)));
		if(count($command)==count(explode(',',$load_data_cmdid))){$load_data_cmd['load_role'] = $command[0]['model'];}
						
		extract(generateList($language,intval(post("currentPage")),post("rowsPerPage"),post("navAction"),$sql_statement));
		$dataListString = '';$i=$startIndex+1;
		foreach($rowData as $key=>$value){	
			//edit privilege url
			$edit_privilege_url = '/'.$lang->selected.$layout_label->label->admin_role_privilege->url.'/'.encodeString($value['id'].'_'.time(),$encryptKey);
			$created_date = $value['created_date']<>''?date('d/m/Y',strtotime($value['created_date'])):'N/A';
			$dataListString .= '<tr>
									<td class="txtCenter">
										'.$i.'										
									</td>
									<td class="txtLeft">
										<div>
											<span class="tooltips" title="Role ID: '.$value['id'].'">'.$value['title'].'</span>											
										</div>
										<div class="sub-info fs12">
											<span class="tooltips" title="Role Code"><i class="fa fa-hashtag"></i> <i class="greencolor">'.$value['code'].'</i></span> | 
											<span class="tooltips" title="Authentication"><i class="fa fa-list-ol"></i> <i class="greencolor">'.$value['auth_level'].'</i></span> | 
											<span class="tooltips" title="Total Users"><i class="fa fa-user"></i> <i class="greencolor">'.$value['total_users'].'</i></span>
											'.(!$value['active']?' | <span class="redcolor tooltips" title="Status">Inactive</span>':'').' | 
											<span class="tooltips" title="Created Date"><i class="fa fa-clock"></i> <i class="greencolor">'.$created_date.'</i></span>
										</div>
									</td>		
									<td class="txtCenter">
										<button class="load_form_btn btn btn-xs rounded btn-default v_mgn3" type="button" data-cmd="'.$load_data_cmd['load_role'].'" data-target_formid="newRole" data-recordid="'.encodeString($value['id'],$encryptKey).'"><i class="fa fa-pencil"></i> Edit</button>
										<a class="btn btn-xs rounded btn-default" href="'.$edit_privilege_url.'"><i class="fa fa-tasks"></i> Privileges</button>
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