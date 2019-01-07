<?php
class provinces_list{
	public function data($input){
		$qry = new connectDb;global $usersession,$lang,$layout_label;
		$pageExist=false;$breadcrumb=array();
		
		$type=$type_sql='';
		if(isset($_GET['type']) and $_GET['type']<>''){
			$type= $_GET['type'];
			$type_sql= "and type.code='".$type."'";
		}
		
		//featured by locations
		$locations = $qry->qry_assoc("SELECT p.*,IF('$lang->selected'='kh',p.name_kh,p.name_en) provincecity_name,c.description,type.code typecode,count(p.id) total,group_concat(i.filenames separator '{|}') photo from provincecity p
										left join content c on c.code=p.content_code
										left join v_items i on i.provincecity=p.id
										left join layout_text_item type on type.id=i.type_id
										where i.active=1 and i.approved=1 and i.active_by_user=1 $type_sql
										group by p.id");
										
		//get typename
		$typename='';	
		if(isset($layout_label->listing->$type)){$typename=$layout_label->listing->$type->title;}
		
		$breadcrumb[]='provinces_list';
		if($typename<>''){$breadcrumb[]=array('title'=>$typename.' by Provinces','url'=>'#');}
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'breadcrumb'=>$breadcrumb,'locations'=>$locations,'typename'=>$typename);
	}	
}
?>