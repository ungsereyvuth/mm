<?php
class admin_pagemanagement{
	public function data($input){
		global $encryptKey;
		$pageExist=false;
		$qry = new connectDb;
		
		$control_type = '<div class="col-sm-6 col-md-3"><label>Control Type</label><select class="form-control input-sm searchinputs" id="control_type">
							<option value="">--- All ---</option>
							<option value="0">Front-End</option>
							<option value="1">Back-End</option>
						</select></div>';
		$authentication = '<div class="col-sm-6 col-md-3"><label>Authentication</label><select class="form-control input-sm searchinputs" id="authentication">
							<option value="">--- All ---</option>
							<option value="login">Login</option>
							<option value="logout">Logout</option>
						</select></div>';
		$page_type = '<div class="col-sm-6 col-md-3"><label>Page Type</label><select class="form-control input-sm searchinputs" id="page_type">
							<option value="">--- All ---</option>
							<option value="both">Ajax + Page</option>
							<option value="ajax">Ajax</option>
							<option value="page">Page</option>
						</select></div>';
		$is_menu = '<div class="col-sm-6 col-md-3"><label>Is Menu</label><select class="form-control input-sm searchinputs" id="is_menu">
							<option value="">--- All ---</option>
							<option value="1">Menu</option>
							<option value="0">Not Menu</option>
						</select></div>';
		$status = '<div class="col-sm-6 col-md-3"><label>Status</label><select class="form-control input-sm searchinputs" id="status">
							<option value="">--- All ---</option>
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select></div>';
		$showhide_sub = '<div class="col-sm-6 col-md-3">
							<label>Sub Item</label>
							<div class="btm_border_gray smart-form">
								<label class="toggle">
                                    <input type="checkbox" id="show_sub" class="searchinputs" checked="checked">
                                    <i data-swchon-text="ON" data-swchoff-text="OFF"></i>show/hide
                                </label>
                            </div>
						</div>';
		
		$txt_search = '<div class="col-sm-6 col-md-3"><label>Keyword</label><div class="input-group input-group-sm"><input type="text" class="form-control searchinputs" id="txt_search" placeholder="Search keyword"><span class="input-group-btn btn_search"><button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button></span></div></div>';
		
		$search_inputs = '<div class="row">'.$control_type.$is_menu.$authentication.$page_type.$status.$txt_search.$showhide_sub.'</div>';
		
		//label page list
		$page_labels='<option value="">--- Select ---</option>';
		$page_label_row = $qry->qry_assoc("select t.* from layout_text_item t 
											left join layout_page_controller c on c.page_id = t.id
											where t.for_page=1 and c.id IS NULL and t.active=1 order by t.id desc");
		foreach($page_label_row as $value){
			$page_labels.='<option value="'.$value['id'].'" data-model_name="'.$value['code'].'">'.$value['title'].'</option>';
		}
		//page control list (for parent select)
		$page_contorls='<option value="">--- Select ---</option>';
		$page_contorl_row = $qry->qry_assoc("select * from layout_page_controller where parent_id IS NULL and is_menu=1 order by id desc");
		foreach($page_contorl_row as $value){
			$page_contorls.='<option value="'.$value['id'].'">'.$value['model'].'</option>';
		}
		
		//component items
		$page_components=array();
		$page_component_row = $qry->qry_assoc("select * from layout_page_component where active=1 order by component_name");
		foreach($page_component_row as $value){
			$page_components[]=$value;
		}

		//inner directoy
		$dirs = "<option value=''>default</option><option value='user/'>User</option><option value='admin/'>Admin</option>";
		
		//user previledge for this model
		$user_roles=array();
		$user_role_row = $qry->qry_assoc("select * from user_role where active=1 order by auth_level");
		foreach($user_role_row as $value){
			$user_roles[]=$value;
		}
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'input'=>$input,'search_inputs'=>$search_inputs,'page_labels'=>$page_labels,'page_contorls'=>$page_contorls,'page_components'=>$page_components,'user_roles'=>$user_roles,'dirs'=>$dirs);
	}	
}

?>