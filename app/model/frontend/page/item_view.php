<?php
class item_view{
	public function data($input){
		$qry = new connectDb;global $usersession,$lang,$layout_label;
		$pageExist=false;$item=$nearby=$places=$breadcrumb=array();
		
		if(isset($input[0]) and is_numeric(decode($input[0])) and decode($input[0])){
			$item_id=decode($input[0]);
		}else{goto returnStatus;}
		
		$item = $qry->qry_assoc("SELECT i.*,IFNULL(it.title_t, i.title ) title,IFNULL(it.description_t, i.description) description,type.code typecode,IFNULL(type_t.title, type.title ) typename from v_items i 
								left join v_items_t it on it.main_id=i.id and it.language_id=$lang->id
								left join layout_text_item as type on type.id=i.type_id
								left join layout_text_item_t type_t on type_t.item_id=type.id
								where i.id=$item_id and i.active=1 and i.approved=1 and i.active_by_user=1 limit 1");
		if(!count($item)){goto returnStatus;}
		$item=$item[0];
		
		//get nearby item
		$more_sql="";
		if($item['typecode']=='events'){$more_sql="and (i.end_date>=CURDATE())";}
		$nearbyrow = $qry->qry_assoc("SELECT i.*,(datediff(i.end_date,i.start_date)+1) days,IFNULL(it.title_t, i.title ) title,IFNULL(it.description_t, i.description) description from v_items i 
									left join v_items_t it on it.main_id=i.id and it.language_id=$lang->id
									where i.type_id=".$item['type_id']." $more_sql and i.id<>$item_id and i.active=1 and i.approved=1 and i.active_by_user=1 
									GROUP BY i.id");		
		$nearby=nearestDistance($nearbyrow,$item['map'],3);
				
		//other nearby listing
		$places_origin=$places=$listing=array();
		foreach($layout_label->listing as $k=>$v){
			if($k<>$item['typecode']){$listing[]=$v->id;}
		}
		$places_row = $qry->qry_assoc("SELECT i.*,type.code,(datediff(i.end_date,i.start_date)+1) days,IFNULL(it.title_t, i.title ) title,IFNULL(it.description_t, i.description) description from v_items i 
									left join v_items_t it on it.main_id=i.id and it.language_id=$lang->id
									left join layout_text_item as type on type.id=i.type_id
									left join layout_text_item_t type_t on type_t.item_id=type.id
									where i.type_id in (".implode(',',$listing).") and (i.end_date>=CURDATE() or i.end_date is NULL) and i.active=1 and i.approved=1 and i.active_by_user=1");
		foreach($places_row as $k=>$v){
			if(!isset($places_origin[$v['code']])){$places_origin[$v['code']]=$layout_label->listing->$v['code'];}
			$places_origin[$v['code']]->item[] = $v;
		}		
		//order by distance
		foreach($places_origin as $k=>$v){
			$places[$k]=$v;
			$places[$k]->item=nearestDistance($v->item,$item['map'],3);
		}
		
		
		$breadcrumb[]='item_view';
		$breadcrumb[]=array('title'=>$item['title'],'url'=>'#');
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'breadcrumb'=>$breadcrumb,'item'=>$item,'nearby'=>$nearby,'places'=>$places);
	}	
}
?>