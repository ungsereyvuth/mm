<?php
class province_view{
	public function data($input){
		$qry = new connectDb;global $usersession,$layout_label,$lang;
		$pageExist=false;$item=$nearby=$breadcrumb=array();
		
		if(isset($input[0]) and is_numeric(decode($input[0])) and decode($input[0])){
			$item_id=decode($input[0]);
		}else{goto returnStatus;}
		
		$item = $qry->qry_assoc("SELECT p.*,c.description,c.filenames from provincecity p
								left join content c on c.code=p.content_code
								where p.id=$item_id and p.active=1 limit 1");
		if(!count($item)){goto returnStatus;}
		$item=$item[0];
		
		//get listing type
		/*$listing = $qry->qry_assoc("SELECT item.id,IFNULL(item_t.title,item.title) title,item.code from layout_text_item item
									left join layout_text_item_t item_t on item.id=item_t.item_id and item_t.language_id='$lang->id'
									left join layout_text_cate cate on cate.id=item.cate_id
									where cate.title='listing' and item.parent_id is NULL and item.active=1
									order by item.priority");*/
		
		//where to visit in this province
		$places=array();
		foreach($layout_label->listing as $v){
			if($v->code=='events'){$more_sql = "and i.start_date>=CURDATE() order by i.start_date";}else{$more_sql='';}
			
			if(!isset($places[$v->code])){$places[$v->code]=$v;}
			$places[$v->code]->item = $qry->qry_assoc("SELECT i.*,(datediff(i.end_date,i.start_date)+1) days,IFNULL(it.title_t, i.title ) title,IFNULL(it.description_t, i.description) description from v_items i 
									left join v_items_t it on it.main_id=i.id and it.language_id=$lang->id
									left join layout_text_item type on type.id=i.type_id
									left join layout_text_item_t type_t on type_t.item_id=type.id
									where i.type_id=".$v->id." and i.provincecity=$item_id and i.active=1 and i.approved=1 and i.active_by_user=1 $more_sql									
									limit 3");
		}
		
		
		$breadcrumb[]='province_view';
		$breadcrumb[]=array('title'=>$item['name_en'],'url'=>'#');
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'breadcrumb'=>$breadcrumb,'item'=>$item,'places'=>$places);
	}	
}
?>