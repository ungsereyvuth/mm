<?php

class slider{
	public function data(){	
		
		return array('info'=>'slider');
	}	
}
class frontend_menu{
	public function data(){		
		global $usersession;	
		$qry = new connectDb;
		
		return (object) array();
	}	
}
class topinfo{
	public function data(){	
		global $usersession;	
		$qry = new connectDb;
		
		//get footer content
		$contents = content(array('footer_contact','powered_by'));
		
		return (object) array('total_unread'=>isset($total_unread)?$total_unread:0,'contents'=>(object) $contents);
	}	
}

class breadcrumb{
	public function data(){	
		
		return array('info'=>'topinfo');
	}	
}

class sidebar{
	public function data(){	
		
		return array('info'=>'topinfo');
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
			if($value['selected']){$activelang='<img src="/assets/frontend/img/flags/'.$value['code'].'.png" class="flag" alt="'.$value['title'].'"> <span> '.$value['title'].' </span>';}
			$language_btn.= '<li '.($value['selected']?'class="active"':'').'><a href="/'.$value['code'].(orginUrl()==''?'':'/'.orginUrl()).'"><img src="/assets/frontend/img/flags/'.$value['code'].'.png" class="flag" alt="'.$value['title'].'"> '.$value['title'].'</a></li>';	
		}
		
		$language_btn  = '<ul class="header-dropdown-list hidden-xs">
								<li>
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"> '.$activelang.' <i class="fa fa-angle-down"></i> </a>
									<ul class="dropdown-menu pull-right">
										'.$language_btn.'	
									</ul>
								</li>
							</ul>';
		
		return $language_btn;
	}	
}


?>