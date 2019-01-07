<?php
class item_list{
	public function data($input){
		$qry = new connectDb;global $usersession,$lang,$layout_label;
		$pageExist=false;$listitem=$locationlist=$typelist=$catelist=$pagination=$breadcrumb=array();
		$currenturl='/'.$lang->selected.$layout_label->label->item_list->url;
		//pagination
		$item_per_page = 6;
		$page=(isset($_GET['page']) and $_GET['page']>0)?trim($_GET['page']):1;
		
		//check param
		$type=$cate=array();
		$type_sql=$location=$location_sql=$cate_sql=$txt=$txt_sql='';
		if(isset($_GET['type']) and $_GET['type']<>''){
			$type= is_array($_GET['type'])?$_GET['type']:array($_GET['type']);
			foreach($type as $val){$currenturl.="&type[]=$val";}
		}
		if(isset($_GET['cate']) and $_GET['cate']<>''){
			$cate= is_array($_GET['cate'])?$_GET['cate']:array($_GET['cate']);
			foreach($cate as $val){$currenturl.="&cate[]=$val";}
		}
		if(isset($_GET['loc']) and $_GET['loc']>0){$location=$_GET['loc'];$currenturl.="&loc=$location";}
		if(isset($_GET['txt']) and $_GET['txt']<>''){$txt=$_GET['txt'];$currenturl.="&txt=$txt";}
		
		//sql
		if(count($type)){$type_sql= "and type.code IN ('".str_replace(",","','",implode(",",$type))."')";}
		if(count($cate)){$cate_sql= "and cates.code IN ('".str_replace(",","','",implode(",",$cate))."')";}
		if($location>0){$location_sql="and c.id=".$location;}
		if($txt<>''){$txt_sql="and i.title like '%".$txt."%'";}
		
		$allitem_sql="SELECT i.*,IFNULL(it.title_t,i.title) itemname,type.code typecode,IFNULL(type_t.title,type.title) typename,it.title_t,it.address_t,it.description_t,IF('$lang->selected'='kh',c.name_kh,c.name_en) provincecity_name,GROUP_CONCAT(IFNULL(cates_t.title,cates.title) separator ' - ') cate_title,GROUP_CONCAT(cates.icon separator ' ') cate_icon FROM v_items i
										left join v_items_t it on it.main_id=i.id and it.language_id=$lang->id
										left join provincecity c on c.id=i.provincecity		
										left join layout_text_item type on type.id=i.type_id
										left join layout_text_item_t type_t on type.id=type_t.item_id and type_t.language_id='$lang->id'
										left join layout_text_item cates on CONCAT(',',i.cate_id,',') like CONCAT('%,',cates.id,',%')	
										left join layout_text_item_t cates_t on cates.id=cates_t.item_id and cates_t.language_id='$lang->id'					
										where i.active=1 and i.approved=1 and i.active_by_user=1 $type_sql $location_sql $cate_sql $txt_sql
										GROUP BY i.id
										order by i.top_attraction desc,i.id desc";
		
		$listitem = $qry->qry_assoc("$allitem_sql limit ".($page>0?((($page-1)*$item_per_page).','):'')."$item_per_page");
		
		$title=$layout_label->label->item_list->title;
		if(count($listitem)){
			if(count($type) and $location==''){$title=$listitem[0]['typename'];
			}elseif(count($type) and $location<>''){$title=$listitem[0]['typename'].' → '.$listitem[0]['provincecity_name'];}
			elseif(!count($type) and $location<>''){$title=$listitem[0]['provincecity_name'];}		
		}
		
		//get filter item list
		$locationrow = $qry->qry_assoc("select *,IF('$lang->selected'='kh',name_kh,name_en) provincecity_name from provincecity where active=1");
		foreach($locationrow as $val){
			$val['selected'] = ($val['id']==$location)?true:false;
			$locationlist[] = $val;
		}
		//type list
		$typerow=$layout_label->listing;		
		foreach($typerow as $k=>$val){
			if($k<>'events'){
				$val->selected = (in_array($val->code,$type))?true:false;
				$typelist[] = $val;
			}
		}
		//category list
		/*if(count($type)){
		$caterow = $qry->qry_assoc("select cates.id,cates.parent_id,cates.code,IFNULL(cates_t.title,cates.title) title,IFNULL(type_t.title,type.title) typename from layout_text_item cates
								 left join layout_text_item_t cates_t on cates.id=cates_t.item_id and cates_t.language_id='$lang->id'
								 left join layout_text_item type on type.id=cates.parent_id
								 left join layout_text_item_t type_t on type.id=type_t.item_id and type_t.language_id='$lang->id'
								 where cates.parent_id is NOT NULL $type_sql and type.active=1 and cates.active=1");
		}*/
		$caterow=$layout_label->listing;	
		foreach($caterow as $k=>$v){
			if(in_array($k,$type)){
				foreach($v->sub as $val){
					$val->selected = (in_array($val->code,$cate))?true:false;
					$catelist[$val->parent_id]['typename']=$v->title;
					$catelist[$val->parent_id]['item'][] = $val;
				}
			}			
		}
		
		//pagination btn
		$total_rows = $qry->qry_count($allitem_sql);
		$totalpages = intval($total_rows/$item_per_page);
		if($totalpages<$total_rows/$item_per_page){$totalpages++;}
		$pagination=array('cpage'=>$page,'tpage'=>$totalpages,'currenturl'=>$currenturl);
		
		$breadcrumb[]='item_list';
		$breadcrumb[]=array('title'=>$title,'url'=>'#');
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'breadcrumb'=>$breadcrumb,'listitem'=>$listitem,'searchtxt'=>$txt,'locationlist'=>$locationlist,'typelist'=>$typelist,'catelist'=>$catelist,'pagination'=>$pagination);
	}	
}
?>