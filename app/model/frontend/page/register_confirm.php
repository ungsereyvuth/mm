<?php
class register_confirm{
	public function data($input){
		$qry = new connectDb;global $usersession,$lang,$layout_label;
		$pageExist=false;
		
		if(isset($input[0]) and $input[0]=='done'){
			$msg = '<div class="alert alert-success txtCenter">
						<div>
							<div class="icon lg-1-item-icon fa-check greencolor"></div>
						</div>
						You have successfully registered and your account is now activated. <a href="/'.$lang->selected.$layout_label->label->login->url.'">Click here</a> to link login.
					</div>';
			$pageTitle ='Your account is ready';
		}else{
			$msg = '<div class="alert alert-info txtCenter">
						<div>
							<div class="icon lg-1-item-icon fa-envelope greencolor"></div>
						</div>
						You have successfully registered. To activate your account, please check your email <span class="text-highlights text-highlights-red rounded-2x">inbox/spam/junk</span> folder and follow the instruction.
					</div>';
			$pageTitle ='Account confirmation';
		}
		
		$breadcrumb = array('register',array('title'=>$pageTitle,'url'=>'#'));
		
		$pageExist=true;
		returnStatus:
		return array('pageExist'=>$pageExist,'breadcrumb'=>$breadcrumb,'msg'=>$msg);
	}	
}
?>