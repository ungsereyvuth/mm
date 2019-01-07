<?php
class admin_settings{
	public function data($input){
		$qry = new connectDb;global $encryptKey;
		$pageExist=false;
		
		$setting_cate=$settings='';
		//get setting data shown by category
		$setting_cate_row = $qry->qry_assoc("SELECT * FROM generalsetting_cate where active=1 order by priority asc");	
		foreach($setting_cate_row as $key=>$value){
			//get setting items
			$setting_cate.= '<li class="'.(!$key?'active':'').'"><a href="#setting_'.$key.'" data-toggle="tab">'.$value['icon'].' '.ucfirst($value['title']).'</a></li>';
			$setting_data = $qry->qry_assoc("SELECT * FROM generalsetting where cate_id =".$value['id']." and active=1 order by id asc");	
			$setting_input ='';
			foreach($setting_data as $skey=>$svalue){
				//check data type
				$settingval_input = '<input type="text" class="form-control" name="settingvalue" value="'.$svalue['settingValue'].'" />';
				if($svalue['is_bool']){
					$booleanval = array('No','Yes');
					$settingval_input = '<select name="settingvalue" class="form-control">';
					foreach($booleanval as $bkey=>$bvalue){
						$settingval_input .= '<option value="'.$bkey.'" '.($bkey==$svalue['settingValue']?'selected':'').'>'.$bvalue.'</option>';
					}
					$settingval_input .= '</select>';					
				}elseif($svalue['is_num']){
					$settingval_input = '<input type="number" class="form-control" name="settingvalue" value="'.$svalue['settingValue'].'" />';
				}
				
				$setting_input.= '<form class="ajaxfrm" role="form" id="'.$svalue['settingName'].'-form" data-func="submit_form" data-reset="0" action="" method="post">
								<div class="v_pad5 h_pad15 row_div btm_border_gray">
									<div class="row">
										<div class="col-md-6 lg-md-7">
											'.ucfirst($svalue['title']).' <code>'.$svalue['settingName'].'</code> <div class="graycolor fs12">'.ucfirst($svalue['description']).'</div>
										</div>
										<div class="col-sm-6 col-md-4 lg-md-5">
											'.$settingval_input.'
										</div>	
										<div class="col-sm-6 col-md-2 txtRight">
											<input type="hidden" name="settingname" value="'.encodeString($svalue['settingName'],$encryptKey).'">
											<input type="hidden" name="cmd" value="update_settings">
											<span class="setting_edit_btn"><button type="submit" class="btn-u btn-u-sm rounded btn-primary">Save</button></span>
										</div>
									</div>
								</div>                   
							</form>';
			}
			$settings.= '<div class="tab-pane fade in '.(!$key?'active':'').'" id="setting_'.$key.'">'.$setting_input.'</div>';
		}			
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'settings'=>$settings,'setting_cate'=>$setting_cate);
	}	
}
?>