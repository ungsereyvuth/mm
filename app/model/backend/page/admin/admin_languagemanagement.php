<?php
class admin_languagemanagement{
	public function data($input){
		$qry = new connectDb;global $usersession;
		$pageExist=false;$main_id=0;$search_inputs=$cate_options=$language_options='';
		
		if(!isset($input[0])){$main_id=0;
		}elseif(isset($input[0]) and is_numeric(decode($input[0]))){$main_id=decode($input[0]);}
		
		//check if main id exist
		$cate_id=0;$main_item_title='';
		if($main_id){
			$check = $qry->qry_assoc("select id,title,cate_id from layout_text_item where id=$main_id limit 1");	
			if(count($check)){$cate_id=$check[0]['cate_id'];$main_item_title=$check[0]['title'];}else{goto returnStatus;}
		}
		
		$cate_options='';
		$item_row = $qry->qry_assoc("select * from layout_text_cate where active=1 order by title");
		foreach($item_row as $value){
			$cate_options.='<option value="'.$value['id'].'" '.($cate_id==$value['id']?'selected':'').'>'.$value['title'].'</option>';
		}
		
		$language_options='';
		$item_row = $qry->qry_assoc("select * from language where active=1 and code<>'en' order by priority");
		foreach($item_row as $value){
			$language_options.='<option value="'.$value['id'].'">'.$value['title'].'</option>';
		}	
		
		$language_input = '<div class="col-sm-6 col-md-3"><label>Langauge</label><select class="form-control input-sm searchinputs" id="lang_id">
							<option value="">--- All ---</option>'.$language_options.'</select></div>';		
		
		$type_input = '<div class="col-sm-6 col-md-3"><label>Page Type</label><select class="form-control input-sm searchinputs" id="type_id">
							<option value="">--- All ---</option>'.$cate_options.'</select></div>';						
							
		$forPage = '<div class="col-sm-6 col-md-3"><label>For Page</label><select class="form-control input-sm searchinputs" id="for_page">
							<option value="">--- All ---</option>
							<option value="1">For Page</option>
							<option value="0">Not For Page</option>
						</select></div>';		
		$status = '<div class="col-sm-6 col-md-3"><label>Status</label><select class="form-control input-sm searchinputs" id="status">
							<option value="">--- All ---</option>
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select></div>';		
		$txt_search = '<div class="col-sm-6 col-md-3"><label>Keyword</label><div class="input-group input-group-sm"><input type="text" class="form-control searchinputs" id="txt_search" placeholder="Search keyword"><span class="input-group-btn btn_search"><button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button></span></div></div>
		
						<input type="hidden" id="main_id" class="searchinputs" value="'.$main_id.'" />
						';
		
		$search_inputs = '<div class="row">'.$type_input.$language_input.$forPage.$status.$txt_search.'</div>';
		
		//set breadcrumb
		$breadcrumb[]='admin_languagemanagement';
		if($main_item_title<>''){
			$breadcrumb[]=array('title'=>$main_item_title,'url'=>'#');
		}
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'breadcrumb'=>$breadcrumb,'input'=>$input,'search_inputs'=>$search_inputs,'cate_options'=>$cate_options,'language_options'=>$language_options,'main_id'=>$main_id);
	}	
}
?>