<?php
class events_list{
	public function data($input){
		$qry = new connectDb;global $usersession,$lang,$layout_label;
		$pageExist=false;
		
		$currenturl='/'.$lang->selected.$layout_label->menu->events_list->url;
		//pagination
		$item_per_page = 6;
		$page=(isset($_GET['page']) and $_GET['page']>0)?trim($_GET['page']):1;
				
		//check param
		$location=$location_sql=$txt=$txt_sql=$selected_cate=$cate_sql=$notexpired_sql='';$getyear=date("Y");$getmonth=0;$notexpired=0;
		if(isset($_GET['cate']) and $_GET['cate']<>''){$selected_cate=$_GET['cate'];$currenturl.="&cate=$selected_cate";}
		if(isset($_GET['loc']) and $_GET['loc']>0){$location=$_GET['loc'];$currenturl.="&loc=$location";}
		if(isset($_GET['notexpired']) and $_GET['notexpired']>0){$notexpired=$_GET['notexpired'];$currenturl.="&notexpired=$notexpired";}
		if(isset($_GET['txt']) and $_GET['txt']<>''){$txt=$_GET['txt'];$currenturl.="&txt=$txt";}
		
		if(isset($_GET['year']) and $_GET['year']>0){$getyear=$_GET['year'];$currenturl.="&year=$getyear";}
		if(isset($_GET['month']) and $_GET['month']>0){$getmonth=str_pad($_GET['month'], 2, 0, STR_PAD_LEFT);$currenturl.="&month=$getmonth";}
		
		//sql
		if($selected_cate<>''){$cate_sql="and cates.code='".$selected_cate."'";}
		if($location>0){$location_sql="and i.provincecity=".$location;}
		if($getmonth>0){$date_sql="and i.start_date like '%".$getyear.'-'.$getmonth."-%'";}else{$date_sql="and i.start_date like '%".$getyear."-%'";}
		if($notexpired>0){$notexpired_sql="and i.end_date >= CURDATE()";}
		if($txt<>''){$txt_sql="and i.title like '%".$txt."%'";}
		
		
		$allitem_sql="SELECT i.*,DATEDIFF(i.start_date, CURDATE()) days,(DATEDIFF(i.end_date,i.start_date)+1) totaldays,type.code typecode,type.title typename,it.title_t,it.address_t,it.description_t,IF('$lang->selected'='kh',c.name_kh,c.name_en) provincecity_name,GROUP_CONCAT(IFNULL(cates_t.title,cates.title) separator ' - ') cate_title,GROUP_CONCAT(cates.icon separator ' ') cate_icon FROM v_items i
										left join v_items_t it on it.main_id=i.id and it.language_id=$lang->id
										left join provincecity c on c.id=i.provincecity		
										left join layout_text_item type on type.id=i.type_id
										left join layout_text_item cates on CONCAT(',',i.cate_id,',') like CONCAT('%,',cates.id,',%')	
										left join layout_text_item_t cates_t on cates.id=cates_t.item_id and cates_t.language_id='$lang->id'					
										where type.code='events' and i.active=1 and i.approved=1 and i.active_by_user=1 $location_sql $cate_sql $txt_sql $date_sql $notexpired_sql
										GROUP BY i.id
										order by i.start_date asc";
		
		$listitem = $qry->qry_assoc("$allitem_sql limit ".($page>0?((($page-1)*$item_per_page).','):'')."$item_per_page");
				
		//event category		
		$caterow=$layout_label->listing->events->sub;
		//get locationlist
		$locationrow = $qry->qry_assoc("select *,IF('$lang->selected'='kh',name_kh,name_en) provincecity_name from provincecity where active=1");
		foreach($locationrow as $val){
			$val['selected'] = ($val['id']==$location)?true:false;
			$locationlist[] = $val;
		}
		//get year list
		$yearlist='';
		for($i=($getyear-2);$i<=($getyear+2);$i++){$yearlist.='<option value="'.$i.'" '.($i==$getyear?'selected':'').'>'.enNum_khNum($i).'</option>';}
		//get month list
		$monthlist='';$getmonthname=$getmonth?khMonth($getmonth):'';
		for($i=1;$i<13;$i++){
			$monthlist.='<option value="'.$i.'" '.($i==intval($getmonth)?'selected':'').'>'.khMonth($i).'</option>';
		}

		
		//pagination btn
		$total_rows = $qry->qry_count($allitem_sql);
		$totalpages = intval($total_rows/$item_per_page);
		if($totalpages<$total_rows/$item_per_page){$totalpages++;}
		$pagination=array('cpage'=>$page,'tpage'=>$totalpages,'currenturl'=>$currenturl);
		
		$breadcrumb[]='events_list';
		$breadcrumb[]=array('title'=>'test','url'=>'#');
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'caterow'=>$caterow,'selected_cate'=>$selected_cate,'listitem'=>$listitem,'searchtxt'=>$txt,'locationlist'=>$locationlist,'yearlist'=>$yearlist,'monthlist'=>$monthlist,'getyear'=>$getyear,'getmonthname'=>$getmonthname,'notexpired'=>$notexpired,'pagination'=>$pagination);
	}	
}
?>