<?php
class user_eatdrinklist{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		
		$qryData = (object) $_POST["qryData"];	
		$sql_condition = '';$translate_lang_con=$lang_code='';
		if($qryData->date_from<>''){$sql_condition.=" and i.created_date>='$qryData->date_from 00:00:00'";}
		if($qryData->date_to<>''){$sql_condition.=" and i.created_date<='$qryData->date_to 23:59:59'";}
		if(is_numeric($qryData->status)){$sql_condition.=" and i.active=$qryData->status";}
		if($qryData->txt_search<>''){$sql_condition.=" and (i.title like '%$qryData->txt_search%' or i.description like '%$qryData->txt_search%' or i.transportation_info like '%$qryData->txt_search%' or i.contact_info like '%$qryData->txt_search%')";}
		
		//get language list
		$item_row = $qry->qry_assoc("select * from language where active=1 and set_default=0");	
		
		$sql_statement = "SELECT i.*,IFNULL(IFNULL(u.company_name,fullname),'N/A') company_name,role.title rolename,IFNULL(it.title_t,i.title) itemname,IF('$lang->selected'='kh',c.name_kh,c.name_en) provincecity_name,GROUP_CONCAT(IFNULL(cates_t.title,cates.title) separator ' - ') cate_title from v_items i
							left join v_items_t it on it.main_id=i.id and it.language_id=$lang->id
							left join layout_text_item type on type.id=i.type_id
							left join layout_text_item cates on CONCAT(',',i.cate_id,',') like CONCAT('%,',cates.id,',%')	
							left join layout_text_item_t cates_t on cates.id=cates_t.item_id and cates_t.language_id='$lang->id'
							left join provincecity c on c.id=i.provincecity	
							left join users u on u.id=i.created_by
							left join user_role role on role.id=u.role_id
							where type.code='eatdrink' $sql_condition 
							GROUP BY i.id
							order by i.created_date desc";	
							
		$load_data_cmdid = "246,247";$load_data_cmd = array();
		//get command name
		$command = $qry->qry_assoc("select model from layout_page_controller where id IN ($load_data_cmdid) order by id asc");
		if(count($command)){$load_data_cmd['load_item'] = $command[0]['model'];$load_data_cmd['load_item_t'] = $command[1]['model'];}
		
		extract(generateList($language,intval(post("currentPage")),post("rowsPerPage"),post("navAction"),$sql_statement));
		$dataListString = '';$i=$startIndex+1;
				
		$web_config=web_config(array('thumbnail_path','no_pic'));
		$thumbnail_path = $web_config['thumbnail_path']; $default_img = $web_config['no_pic']; 
		foreach($rowData as $key=>$value){	
			$load_content= isset($load_data_cmd['load_item'])?$load_data_cmd['load_item']:'';
			$filenames = json_decode($value['filenames']);$totalpic=count($filenames);
			$pic = $totalpic?$thumbnail_path.$filenames[0]->filename:$default_img;
			$translation_btn='';$map = explode(',',$value['map']);
			foreach($item_row as $lvalue){
				$translation_btn .= '<li><a class="load_form_btn" href="#" data-cmd="'.$load_data_cmd['load_item_t'].'" data-target_formid="neweatdrinktranslate" data-recordid="'.encodeString($value['id'].'_'.$lvalue['id'],$encryptKey).'"><img src="/assets/frontend/img/flags/'.$lvalue['code'].'.png" height="15"> '.$lvalue['title'].'</a></li>';
			}
			$inactive=(!$value['active'] or !$value['approved'] or !$value['active_by_user'])?'bg-red-gd-l':'';
			$dataListString .= '<tr class="'.$inactive.'">
									<td class="txtCenter" style="background:url('.$pic.') center center; background-size:cover;"></td>
									<td class="txtLeft">
										<div>
											<span class="tooltips" title="Item ID: '.$value['id'].'">'.$value['itemname'].'</span>	
											'.($value['active']?'':'<i class="fa fa-minus-circle redcolor tooltips" title="Inactive"></i>').' 
											'.($value['approved']?'':'<i class="fa fa-times-circle redcolor tooltips" title="Not Approved"></i>').' 
											'.($value['active_by_user']?'':'<i class="fa fa-user-times redcolor tooltips" title="Inactive by user"></i>').'
											'.($value['approved_by']?'':'<span class="label label-success pull-right"><i class="fa fa-refresh fa-spin yellowcolor tooltips" title="Not yet review"></i></span>').'
										</div>
										<div class="sub-info fs12">
											<span class="tooltips" title="Created by: '.$value['rolename'].'"><i class="fa fa-user"></i> <span class="greencolor">'.$value['company_name'].'</span></span> | 
											<span class="tooltips" title="Location"><i class="fa fa-map-marker"></i> <span class="greencolor">'.$value['provincecity_name'].'</span></span> | 
											<span class="tooltips" title="Uploaded Photo"><i class="fa fa-picture-o"></i> <span class="greencolor">'.enNum_khNum($totalpic).'</span></span> | 
											<span class="tooltips" title="Created Date"><i class="fa fa-clock"></i> <span class="greencolor">'.khmerDate($value['created_date']).'</span></span> | 
											<span class="tooltips" title="Category"><i class="fa fa-tag"></i> <span class="greencolor">'.$value['cate_title'].'</span></span>
										</div>
									</td>		
									<td class="txtCenter">
										<div class="btn-group margin-bottom-5 fullwidth">
											<button type="button" class="btn btn-info btn-xs btn-block rounded btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
												<i class="fa fa-cog"></i> Actions
												<i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu fs12" role="menu">
												<li><a href="javascript: void(0)" class="load_form_btn" data-cmd="'.$load_content.'" data-target_formid="neweatdrink" data-recordid="'.encode($value['id']).'" data-callback="loadmapmarker"><i class="fa fa-pencil"></i> Edit</a></li>
												<li><a href="javascript: void(0)" class="confirmbtn" data-cmd="approveitem" data-data="'.encode($value['id'].'|user_eatdrinklist').'" data-title="<i class=\'fa fa-exclamation-triangle\'></i> Item Approval" data-description="'.($value['approved']?'Disapprove':'Approve').' <code class=\'khmerNormal\'>'.($value['itemname']).'</code> now?" data-yesbtn="Yes" data-nobtn="Cancel"><i class="fa fa-magic"></i> '.($value['approved']?'Disapprove':'Approve').'</a></li>
												<li><a href="javascript: void(0)" class="confirmbtn" data-cmd="activateitem" data-data="'.encode($value['id'].'|user_eatdrinklist').'" data-title="<i class=\'fa fa-exclamation-triangle\'></i> Item Activation" data-description="'.($value['active']?'Desactivate':'Activate').' <code class=\'khmerNormal\'>'.($value['itemname']).'</code> now?" data-yesbtn="Yes" data-nobtn="Cancel"><i class="fa fa-exclamation-triangle"></i> '.($value['active']?'Desactivate':'Activate').'</a></li>
											</ul>
										</div>
										<div class="btn-group fullwidth">
											<button type="button" class="btn btn-xs btn-block rounded btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
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