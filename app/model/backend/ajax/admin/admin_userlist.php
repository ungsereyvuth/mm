	<?php
class admin_userlist{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		
		$qryData = (object) $_POST["qryData"];	
		$sql_condition = '';$translate_lang_con=$lang_code='';
		if($qryData->date_from<>''){$sql_condition.=" and u.created_date>='$qryData->date_from 00:00:00'";}
		if($qryData->date_to<>''){$sql_condition.=" and u.created_date<='$qryData->date_to 23:59:59'";}
		if(is_numeric($qryData->role_id)){$sql_condition.=" and u.role_id=$qryData->role_id";}		
		if(is_numeric($qryData->status)){$sql_condition.=" and u.active=$qryData->status";}
		if($qryData->txt_search<>''){$sql_condition.=" and (u.fullname like '%$qryData->txt_search%' or u.email like '%$qryData->txt_search%' or u.username like '%$qryData->txt_search%')";}
			
		$sql_statement = "SELECT u.*,role.title role_title from users u 
							left join user_role role on role.id=u.role_id
							where 1=1 $sql_condition 
							order by u.created_date desc";	
							
		extract(generateList($language,intval(post("currentPage")),post("rowsPerPage"),post("navAction"),$sql_statement));
		$dataListString = '';$i=$startIndex+1;
		foreach($rowData as $key=>$value){	
			//edit url
			$edit_user_url = '/'.$lang->selected.$layout_label->label->admin_user->url.'/'.encodeString($value['id'],$encryptKey);
			
			//status
			$status=$value['pending']?'<span class="redcolor"><i class="fa fa-exclamation-triangle"></i> Pending</span>':(!$value['active']?'<span class="redcolor"><i class="fa fa-exclamation-triangle"></i> Inactive</span>':'');
			
			$dataListString .= '<tr>
									<td class="txtCenter">
										'.$i.'										
									</td>
									<td class="txtLeft">
										<div>
											<span class="tooltips" title="User ID: '.$value['id'].'">'.$value['fullname'].' '.$status.'</span>											
										</div>
										<div class="sub-info fs12">
											<span class="tooltips" title="User Role"><i class="fa fa-sitemap"></i> <i class="greencolor">'.$value['role_title'].'</i></span> | 
											<span class="tooltips" title="Username"><i class="fa fa-user-circle-o"></i> <i class="greencolor">'.$value['username'].'</i></span> | 
											<span class="tooltips" title="Email"><i class="fa fa-envelope-o"></i> <i class="greencolor">'.$value['email'].'</i></span> | 
											<span class="tooltips" title="Register Date"><i class="fa fa-calendar"></i> <i class="greencolor">'.khmerDate($value['created_date']).'</i></span> 
										</div>
									</td>		
									<td class="txtCenter">
										<a class="btn btn-xs rounded btn-default v_mgn5" href="'.$edit_user_url.'"><i class="fa fa-pencil"></i> Edit</a>
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