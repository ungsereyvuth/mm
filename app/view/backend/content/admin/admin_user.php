<?php
$picPath = web_config('profile_pic_path');$docPath = web_config('post_doc_path');$no_pic = web_config('no_pic');
//profile photo
$photo=$picPath.$pageData->data->content->userinfo->photo;
if($photo<>$picPath){$photo = !file_exists($_SERVER['DOCUMENT_ROOT'].$photo)?$no_pic:$photo;}else{$photo =$no_pic;}


?>
<div class="page_content">
	<!-- Tab v1 -->
	<div class="tab-v2">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
			<li><a href="#account" data-toggle="tab">Account</a></li>
			<li><a href="#activity" data-toggle="tab">Activity</a></li>
			<li><a href="#setting" data-toggle="tab">Setting</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="profile">
				<form class="ajaxfrm" role="form" id="userprofile_update-form" data-func="submit_form" data-reset="0" action="" method="post">
					<div class="row">
		                <div class="col-xs-12 col-sm-5 pull-right">
		                    <div class="profile-pic">
	                            <div class="uploadpic_title txtCenter">Logo ឬ រូបភាព</div>                      
	                            <a href="<?=$photo?>" rel="prettyPhoto"><img id="photo_pre" width="100%" src="<?=$photo?>"></a>
	                            <div class="uploadpic txtCenter">
	                                <input type="file" name="photo" data-pretarget="#photo_pre" class="form-control file-to-preview">
	                            </div>
	                        </div>
		                </div>
		                <div class="col-xs-12 col-sm-7">		                    
	                    	<div class="row margin-bottom-10">
	                            <div class="col-sm-6">
	                                	<label>Fullname</label>
	                                    <input type="text" name="fullname" placeholder="Fullname (KH)" class="form-control" value="<?=$pageData->data->content->userinfo->fullname?>">
	                            </div>
	                        </div>
	                        <div class="row margin-bottom-10">
	                            <div class="col-sm-6">
	                                	<label>Gender</label>
	                                    <select class="form-control" name="gender">
	                                    	<option value="m" <?=$pageData->data->content->userinfo->gender=='m'?'selected':''?>>Male</option>
	                                    	<option value="f" <?=$pageData->data->content->userinfo->gender=='f'?'selected':''?>>Female</option>
	                                    </select>
	                            </div>
	                            <div class="col-sm-6">
	                                	<label>Account Type</label>
	                                    <input type="text" placeholder="Account type" class="form-control" value="<?=$pageData->data->content->userinfo->role_name?>" disabled>
	                            </div>
	                        </div>
	                        <div class="row margin-bottom-10">	                            
                                <div class="col-sm-6">
	                                	<label>Email</label>
	                                    <input type="email" name="email" placeholder="Email" class="form-control" value="<?=$pageData->data->content->userinfo->email?>">
	                            </div>
	                            <div class="col-sm-6">
	                                	<label>Mobile</label>
	                                    <input type="text" name="mobile" placeholder="Mobile" class="form-control" value="<?=$pageData->data->content->userinfo->mobile?>">
	                            </div>	                            
	                        </div>
	                        <div class="row margin-bottom-10">
	                            <div class="col-sm-6">
	                                	<label>Address</label>
	                                    <input type="text" name="address" placeholder="Address" class="form-control" value="<?=$pageData->data->content->userinfo->address?>">
	                            </div>
	                            <div class="col-sm-6">
	                                	<label>Province/City</label>
	                                	<select class="form-control" name="provincecity">
	                                    <?=$pageData->data->content->userinfo->provincecity_select?>
	                                	</select>
	                            </div>
	                        </div>
	                        <div class="row">
	                        	<div class="col-xs-12">
	                        		<input type="hidden" name="recordid" value="<?=encodeString($pageData->data->content->userinfo->id,$encryptKey);?>" />
	                        		<input type="hidden" name="cmd" value="userprofile_update" />
				                    <button class="btn-u btn-u-sea-shop margin-bottom-10" type="submit">Save</button>
				                    <div id="userprofile_update_msg" data-loadtxt='<?=$pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title?>'></div>
	                        	</div>
	                        </div>	
		                </div>	                
		            </div>
	            </form>
			</div>
			<div class="tab-pane fade in" id="account">
				<form class="ajaxfrm" role="form" id="useraccount_update-form" data-func="submit_form" data-reset="0" action="" method="post">
                	<div class="row margin-bottom-10">
                        <div class="col-sm-6">
                            	<label>Username</label>
                                <input type="text" name="username" placeholder="Username" class="form-control" value="<?=$pageData->data->content->userinfo->username?>">
                        </div>
                    </div>
                	<div class="row margin-bottom-10">
                        <div class="col-sm-6">
                            	<label>Currently Password</label>
                                <input type="password" name="cpwd" placeholder="Currently Password" class="form-control">
                        </div>
                    </div>
                    <div class="row margin-bottom-10">
                        <div class="col-sm-6">
                            	<label>New Password</label>
                               <input type="password" name="npwd" placeholder="New Password" class="form-control">
                        </div>
                    </div>
                    <div class="row margin-bottom-10">
                        <div class="col-sm-6">
                            	<label>Repeat New Password</label>
                                <input type="password" name="rpwd" placeholder="Repeat New	 Password" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                    	<div class="col-xs-12">
                    		<input type="hidden" name="recordid" value="<?=encodeString($pageData->data->content->userinfo->id,$encryptKey);?>" />
                    		<input type="hidden" name="cmd" value="useraccount_update" />
		                    <button class="btn-u btn-u-sea-shop margin-bottom-10" type="submit">Save</button>
		                    <div id="useraccount_update_msg" data-loadtxt='<?=$pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title?>'></div>
                    	</div>
                    </div>	                        
                </form>
			</div>
			<div class="tab-pane fade in" id="activity">
				activities
			</div>
			<div class="tab-pane fade in" id="setting">
				<form class="ajaxfrm sky-form pad10" role="form" id="usersettings_update-form" data-func="submit_form" data-reset="0" action="" method="post">
                	<div class="form-group">
                        <div class="row">
                        	 <div class="col-sm-6">
                                    <div class="btm_border_gray h_pad10">
                                    	<strong>Account is activated</strong>
                                    	<label class="toggle label pull-right"><input type="checkbox" name="pending" <?=!$pageData->data->content->userinfo->pending?'checked':''?>><i></i></label>
                                         <div class="fs11"><i>Account need to be actived after the registration by going the user email inbox for the activation link.</i></div>
                                    </div>
                                    <div id="pending_msg"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                    <div class="btm_border_gray h_pad10">
                                    	<strong>Account Status</strong>
                                    	<label class="toggle label pull-right">
                                    	<input type="checkbox" name="active" <?=$pageData->data->content->userinfo->active?'checked':''?>><i></i></label>
                                        <div class="fs11"><i>Account main status (Active or Inactive)</i></div>
                                    </div>
                                        
                                    <div id="active_msg"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="recordid" value="<?=encodeString($pageData->data->content->userinfo->id,$encryptKey);?>" />
                        <input type="hidden" name="cmd" value="usersettings_update" />
                        <button class="btn-u btn-u-sea-shop margin-bottom-10" type="submit">Save</button>
                        <div id="usersettings_update_msg" data-loadtxt='<?=$pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title?>'></div>   
                    </div>                  
                </form>
			</div>
		</div>
	</div>
	<!-- End Tab v1 -->
</div>