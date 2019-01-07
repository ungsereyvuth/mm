<?php

class slider{
	public function data(){	
		global $lang;
		$qry = new connectDb;	
		$item = $qry->qry_assoc("SELECT i.*,IFNULL(it.title_t,i.title) item_tile,IFNULL(it.address_t,i.address) item_address,IFNULL(it.description_t,i.description) item_des,IF('$lang->selected'='kh',c.name_kh,c.name_en) provincecity_name FROM v_items i
										left join v_items_t it on it.main_id=i.id and it.language_id=$lang->id
										left join provincecity c on c.id=i.provincecity		
										left join layout_text_item type on type.id=i.type_id				
										where type.code='destination' and i.active=1 and i.approved=1 and i.active_by_user=1
										order by RAND()
										limit 4");
		
		return (object) array('item'=>$item);
	}	
}
class frontend_menu{
	public function data($input){
		global $usersession,$layout_label,$lang;
		$qry = new connectDb;
		$menu='';
		$dataurl = implode('/',$input['data']);
		$activeurl = '/'.str_replace('_','/',$input['page']).($dataurl<>''?'/':'').$dataurl;
		foreach($layout_label->menu as $value){
			if($value->active){
				$url=(in_array($value->url,array('#','')))?'javascript:void(0);':'/'.$lang->selected.$value->url;
				$active=$value->url==$activeurl?'active':'';
				if(count((array)$value->sub)){	
					$submenu = '';
					foreach($value->sub as $subvalue){
						if($subvalue->active and $subvalue->code <> $value->code){
							$active=$subvalue->url==$activeurl?'active':$active;
							$submenu .= '<li class="rd-dropdown-item"><a class="rd-dropdown-link" href="/'.$lang->selected.$subvalue->url.'">'.$subvalue->title.'</a></li>';
						}
					}
					if($submenu<>''){
						$menu.='<li class="rd-nav-item '.$active.'"><a class="rd-nav-link" href="'.$url.'">'.$value->title.'</a><ul class="rd-menu rd-navbar-dropdown">'.$submenu.'</ul></li>';
					}else{
						$menu.='<li class="rd-nav-item '.$active.'"><a class="rd-nav-link" href="'.$url.'">'.$value->title.'</a>';
					}
				}else{
					$menu.='<li class="rd-nav-item '.$active.'"><a class="rd-nav-link" href="'.$url.'">'.$value->title.'</a>';
				}
			}
			
		}	
		

		return $menu;
	}	
}
class topinfo{
	public function data(){	
		global $usersession;	
		$qry = new connectDb;
		
		//get footer content
		//$contents = content(array('footer_contact','powered_by'));
		
		return (object) array();
	}	
}

class breadcrumb{
	public function data(){	
		
		return array('info'=>'topinfo');
	}	
}

class sidebar{
	public function data(){	
		global $usersession,$lang;
		$qry = new connectDb;
		$doc = $qry->qry_assoc("SELECT * from documents where active=1 order by created_date desc limit 15 ");
		
		$user_menu='';
		if($usersession->isLogin()){
			$user_menu =pageControlItems($usersession->info()->privileges,'',1,1);
		}
		
		//get license category list
		$license_cate = $qry->qry_assoc("SELECT id,if('$lang->selected'='kh',title_kh,title_en) title from license_category where active=1 order by id");
		
		//note		 
		$content = content(array('security_maintenance'));
		$security_maintenance = $content['security_maintenance'];
		
		return (object) array('doc'=>$doc,'license_cate'=>$license_cate,'user_menu'=>$user_menu,'note'=>(object) $security_maintenance);
	}	
}

class user_menu{
	public function data($input){	
		global $usersession;		
		return pageControlItems($usersession->info()->privileges,1,1,1);
	}	
}

class language_switch{
	public function data(){
		global $usersession,$layout_label,$lang;
		$qry = new connectDb;
		
		$language_btn= '';
		foreach($lang->getlist as $key=>$value){			
			if($value['selected']){
				$language_btn.= '<div class="flag_icon flag_active"><img src="/assets/frontend/img/flags/'.$value['code'].'.png" height="15" title="'.$value['title'].'" /></div>';
			}else{
				$language_btn.= '<div class="flag_icon"><a href="/'.$value['code'].(orginUrl()==''?'':'/'.orginUrl()).'"><img src="/assets/frontend/img/flags/'.$value['code'].'.png" height="15" title="'.$value['title'].'" /></a></div>';	
			}
		}
		
		return $language_btn;
	}	
}

class footer_info{
	public function data(){	
		
		//$content = content(array('footer_contact'));
		
		return (object) array('footer_contact'=>'footer_contact');
	}	
}

class footer{
	public function data(){	
		
		$content = content(array('footer_contact'));
		
		return (object) array('footer_contact'=>$content['footer_contact']['description']);
	}	
}


?>