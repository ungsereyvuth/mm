<?php
class article_view{
	public function data($input){
		$qry = new connectDb;global $usersession,$lang;
		$pageExist=false;$item=$related=$breadcrumb=array();
		
		if(isset($input[0]) and $input[0]<>''){
			$item_code=$input[0];
		}else{goto returnStatus;}
		
		$item = $qry->qry_assoc("SELECT c.id,c.cate_id,c.filenames,IFNULL(ct.title_t, c.title) article_title,IFNULL(ct.description_t, c.description) description,IFNULL(ct.created_date, c.created_date) article_date from content c
								left join content_t ct on ct.main_id=c.id and ct.language_id=$lang->id
								where c.code='$item_code' and c.active=1 limit 1");
		if(!count($item)){goto returnStatus;}
		$item=$item[0];
		
		//get related item
		$related = $qry->qry_assoc("SELECT c.id,c.code,c.filenames,IFNULL(ct.title_t, c.title) article_title,IFNULL(ct.description_t, c.description) description from content c 
									left join content_t ct on ct.main_id=c.id and ct.language_id=$lang->id
									where IFNULL(ct.title_t, c.title) like '%".addslashes($item['article_title'])."%' and c.code<>'$item_code' and c.active=1 and c.cate_id=".$item['cate_id']."
									limit 3");
		
		$breadcrumb[]='article_view';
		$breadcrumb[]=array('title'=>$item['article_title'],'url'=>'#');
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'breadcrumb'=>$breadcrumb,'item'=>$item,'related'=>$related);
	}	
}
?>