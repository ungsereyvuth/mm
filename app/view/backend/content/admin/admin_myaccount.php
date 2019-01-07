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
	                                	<label><?=$pageData->label->label->fullname->title?> (<?=$pageData->label->label->kh->title?>)</label>
	                                    <input type="text" name="fullname_kh" placeholder="First name" class="form-control" value="<?=$pageData->data->content->userinfo->fullname_kh?>">
	                            </div>
	                            <div class="col-sm-6">
	                                	<label><?=$pageData->label->label->fullname->title?> (<?=$pageData->label->label->en->title?>)</label>
	                                    <input type="text" name="fullname_en" placeholder="Last name" class="form-control" value="<?=$pageData->data->content->userinfo->fullname_en?>">
	                            </div>
	                        </div>
	                        <div class="row margin-bottom-10">
	                            <div class="col-sm-6">
	                                	<label><?=$pageData->label->label->gender->title?></label>
	                                    <select class="form-control" name="gender">
	                                    	<option value="m" <?=$pageData->data->content->userinfo->gender=='m'?'selected':''?>><?=$pageData->label->label->m->title?></option>
	                                    	<option value="f" <?=$pageData->data->content->userinfo->gender=='f'?'selected':''?>><?=$pageData->label->label->f->title?></option>
	                                    </select>
	                            </div>
	                            <div class="col-sm-6">
	                                	<label><?=$pageData->label->label->account_type->title?></label>
	                                    <input type="text" placeholder="Account type" class="form-control" value="<?=$pageData->data->content->userinfo->role_name?>" disabled>
	                            </div>
	                        </div>
	                        <div class="row margin-bottom-10">
	                            <div class="col-sm-6">
	                                	<label><?=$pageData->label->label->dob->title?></label>
	                                    <div class="input-append input-group dtpicker_notstrick">
											<input data-format="yyyy-MM-dd" name="dob" type="text" placeholder="YY-MM-DD" class="form-control" value="<?=$pageData->data->content->userinfo->dob?>">
											<span class="input-group-addon add-on"><i data-time-icon="fa fa-clock-o" data-date-icon="fa fa-calendar" class="fa fa-calendar"></i></span>
										</div>
                                        <div id="dob_msg"></div>
	                            </div>	                       
	                        </div>
	                        <div class="row margin-bottom-10">	                            
	                            <div class="col-sm-6">
	                                	<label><?=$pageData->label->label->mobile->title?></label>
	                                    <input type="text" name="mobile" placeholder="Mobile" class="form-control" value="<?=$pageData->data->content->userinfo->mobile?>">
	                            </div>
                                <div class="col-sm-6">
	                                	<label><?=$pageData->label->label->email->title?></label>
	                                    <input type="text" name="email" placeholder="Email" class="form-control" value="<?=$pageData->data->content->userinfo->email?>">
	                            </div>	                            
	                        </div>
	                        <div class="row margin-bottom-10">
	                            <div class="col-sm-6">
	                                	<label><?=$pageData->label->label->address->title?></label>
	                                    <input type="text" name="address" placeholder="Address" class="form-control" value="<?=$pageData->data->content->userinfo->address?>">
	                            </div>
	                            <div class="col-sm-6">
	                                	<label><?=$pageData->label->label->provincecity->title?></label>
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
            	<div class="clearfix">
                    <div class="col-sm-6">
                            <div class="headline">
                                <h4>Login Information</h4>
                            </div>
                            <form class="ajaxfrm" role="form" id="useraccount_update-form" data-func="submit_form" data-reset="0" action="" method="post">
                                <div class="margin-bottom-10">
                                    <label>Username</label>
                                    <input type="text" name="username" placeholder="Username" class="form-control" value="<?=$pageData->data->content->userinfo->username?>">
                                </div>
                                <div class="margin-bottom-10">
                                    <label>Currently Password</label>
                                    <input type="password" name="cpwd" placeholder="Currently Password" class="form-control">                               
                                </div>
                                <div class="margin-bottom-10">
                                    <label>New Password</label>
                                   <input type="password" name="npwd" placeholder="New Password" class="form-control">                               
                                </div>
                                <div class="margin-bottom-10">
                                    <label>Repeat New Password</label>
                                    <input type="password" name="rpwd" placeholder="Repeat New Password" class="form-control">                            
                                </div>
                                <div class="">
                                    <input type="hidden" name="recordid" value="<?=encodeString($pageData->data->content->userinfo->id,$encryptKey);?>" />
                                    <input type="hidden" name="cmd" value="useraccount_update" />
                                    <button class="btn-u btn-u-sea-shop margin-bottom-10" type="submit">Save</button>
                                    <div id="useraccount_update_msg" data-loadtxt='<?=$pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title?>'></div>
                                </div>	                        
                         </form>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-profile">
                            <div class="panel-heading overflow-h bg-gold">
                                <h2 class="heading-sm pull-left"><i class="fa fa-building-o"></i> Account Information</h2>
                            </div>
                            <div class="panel-body profile-edit">
                                <dl class="dl-horizontal">
                                	<?php
									$isApprovalUser=$pageData->data->content->userinfo->isApprovalUser;
									
									$responsible_license='';
									foreach($pageData->data->content->userinfo->responsible_license as $key => $value){
										 $responsible_license .= '<div>'.enNum_khNum($key+1).'. '.$value['catename'].'</div>';
									 }
									?>
                                
                                    <dt><strong>Approval Officer</strong></dt>
                                    <dd>
                                        <?=$isApprovalUser?'Yes':'No'?>                      
                                    </dd>
                                    <hr class="v_mgn10">
                                    <dt><strong>Approval Department</strong></dt>
                                    <dd>
                                         <?=$isApprovalUser?$pageData->data->content->userinfo->dep_title:'N/A'?> 
                                    </dd>
                                    <hr class="v_mgn10">
                                    <dt><strong>Approval Level</strong></dt>
                                    <dd>
                                        <?=$isApprovalUser?$pageData->data->content->userinfo->approval_level_title:'N/A'?> 
                                    </dd>
                                    <hr class="v_mgn10">
                                    <dt><strong>Responsible Licenses</strong></dt>
                                    <dd>
                                         <?=$responsible_license?>
                                    </dd>
                                </dl>
                            </div>
                        </div>

                    </div>
                </div>
			</div>
			<div class="tab-pane fade in" id="activity">
				activities
			</div>
			<div class="tab-pane fade in" id="setting">
				settings
			</div>
		</div>
	</div>
	<!-- End Tab v1 -->
</div>