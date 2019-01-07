<?php
class home{
	public function data($input){
		$qry = new connectDb;global $usersession,$lang;
		$pageExist=false;
		
		//DESTINATIONS
		$destinations = $qry->qry_assoc("SELECT i.*,IFNULL(it.title_t,i.title) itemname,it.address_t,it.description_t,IF('$lang->selected'='kh',c.name_kh,c.name_en) provincecity_name FROM v_items i
										left join v_items_t it on it.main_id=i.id and it.language_id=$lang->id
										left join layout_text_item type on type.id=i.type_id
										left join provincecity c on c.id=i.provincecity										
										where type.code='destination' and i.active=1 and i.approved=1 and i.active_by_user=1
										order by i.top_attraction desc,i.id desc
										limit 10");
										
		//featured by locations
		$locations = $qry->qry_assoc("SELECT p.*,IF('$lang->selected'='kh',p.name_kh,p.name_en) provincename,type.code typecode,count(p.id) total,group_concat(i.filenames separator '{|}') photo from provincecity p
										left join v_items i on i.provincecity=p.id
										left join layout_text_item type on type.id=i.type_id
										where type.code IN ('destination') and i.active=1 and i.approved=1 and i.active_by_user=1 
										group by p.id
										limit 6");
		
		//eat and drink
		$eatstay = $qry->qry_assoc("SELECT i.*,IFNULL(it.title_t,i.title) itemname,it.title_t,it.address_t,it.description_t,IF('$lang->selected'='kh',c.name_kh,c.name_en) provincecity_name FROM v_items i
										left join v_items_t it on it.main_id=i.id and it.language_id=$lang->id
										left join provincecity c on c.id=i.provincecity		
										left join layout_text_item type on type.id=i.type_id								
										where type.code IN ('eatdrink','accommodations') and i.active=1 and i.approved=1 and i.active_by_user=1
										order by i.top_attraction desc,i.id desc
										limit 6");
		//location list
		$locationlist = $qry->qry_assoc("select *,IF('$lang->selected'='kh',name_kh,name_en) provincecity_name from provincecity where active=1");
		
		//type list
		/*$typelist = $qry->qry_assoc("select item.id,item.code,IFNULL(item_t.title,item.title) title from layout_text_item item
								 left join layout_text_item_t item_t on item.id=item_t.item_id and item_t.language_id='$lang->id'
								 left join layout_text_cate cate on cate.id=item.cate_id
								 where cate.title='listing' and item.code<>'events' and item.parent_id is NULL and cate.active=1 and item.active=1 order by item.priority");*/
		
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'destinations'=>$destinations,'locations'=>$locations,'eatstay'=>$eatstay,'locationlist'=>$locationlist);
	}	
}
?>