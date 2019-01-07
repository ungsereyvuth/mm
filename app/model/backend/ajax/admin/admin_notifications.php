<?php
class admin_notifications{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		
		$qryData = (object) $_POST["qryData"];	
		$sql_condition = '';$translate_lang_con=$lang_code='';
		if($qryData->date_from<>''){$sql_condition.=" and n.created_date>='$qryData->date_from 00:00:00'";}
		if($qryData->date_to<>''){$sql_condition.=" and n.created_date<='$qryData->date_to 23:59:59'";}
		if($qryData->txt_search<>''){$sql_condition.=" and (u.fullname_kh like '%$qryData->txt_search%' or u.fullname_en like '%$qryData->txt_search%')";}
					
		
		$sql_statement = "SELECT n.*,if('$lang->selected'='kh',u.fullname_kh,u.fullname_en) bo_name 
							from license_notification n
							left join users u on u.id=l.user_id
							where n.public=1 and u.active=1 and l.active=1 $sql_condition
							order by n.created_date desc";	
		
		extract(generateList($language,intval(post("currentPage")),post("rowsPerPage"),post("navAction"),$sql_statement));
		$dataListString = '';$i=$startIndex+1;
		foreach($rowData as $key=>$value){				
			//url
			$license_id_code = encodeString($value['license_id'].'_'.time(),$encryptKey);
			$form_id_code = encodeString($value['form_id'].'_'.time(),$encryptKey);
			$view_url = '/'.$lang->selected.$layout_label->label->admin_licenseview->url.'/'.$license_id_code.'&formid='.$form_id_code;
			
			$dataListString .= '<tr>
									<td>
										<div class="profile-event">
											<div class="date-formats tooltips v_mgn0" title="'.enNum_khNUm(date('h:i A',strtotime($value['created_date']))).'">
												<span class="fs18">'.enNum_khNUm(date('d',strtotime($value['created_date']))).'</span>
												<small>'.enNum_khNUm(date('m, Y',strtotime($value['created_date']))).'</small>
											</div>
											<div>
												<div>
													<a href="'.$view_url.'">'.($value['license_cate_id']==2?$value['bo_name']:$value['biz_name']).'</a> 
													<code><i class="fa fa-calendar"></i> '.date('d/m/Y',strtotime($value['license_start_date'])).'-'.date('d/m/Y',strtotime($value['license_end_date'])).' | <i class="fa fa-user"></i> '.$value['bo_name'].'</code>
													<span class="fs11 pull-right text-highlights text-highlights-red rounded-2x">'.$value['cate_name'].'</span>										
												</div>
												<hr class="devider devider-dashed v_mgn3">
												<div class="fs13">
													'.strip_tags($value['msg']).'							
												</div>
												
											</div>
										</div>
										
									</td>							
								</tr>';
		}
		$no_data = $layout_label->label->no_data->icon.' '.$layout_label->label->no_data->title;
		if($dataListString == ''){$dataListString = '<tr><td><div class="profile-event txtCenter redcolor">'.$no_data.'</div></td></tr>';}
		$data = array('list'=>$dataListString,'listNavInfo'=>($totalPages>0?$list_nav_info:$no_data),'targetPage'=>$targetPage,'totalPages'=>$totalPages,'gotoSelectNum'=>$gotoSelectNum,'nav_btn_disable'=>$nav_btn_disable,'totalRow'=>$totalRow);	
		echo json_encode($data);	
	}	
}	



?>