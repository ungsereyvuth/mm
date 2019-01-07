<?php
$cmd='register';
?>
<section class="section section-xs bg-default">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-6 h_pad30" style="border-left: 1px dashed #e2e2e2;border-right: 1px dashed #e2e2e2;">
          <!-- RD Mailform-->
          <form class="rd-form ajaxfrm" role="form" id="<?=$cmd?>-form" data-func="submit_form" data-reset="0" action="" method="post">
          	
            <div class="row row-30">
            	<div class="col-lg-12">
                	<h5><u><?=$pageData->label->label->biz_info->title?></u></h5>
                </div>
            	<div class="col-lg-12">
                	<div class="form-wrap form-wrap-icon">
                      <input class="form-input" id="company_name" type="text" name="company_name">
                      <label class="form-label" for="company_name"><?=$pageData->label->label->company_name->title?> <span class="redStar">*</span></label>
                      <?=$pageData->label->label->company_name->icon?>
                    </div>
                </div>
                <div class="col-sm-6">
                	<div class="form-wrap form-wrap-icon">
                      <input class="form-input" id="company_phone" type="text" name="company_phone">
                      <label class="form-label" for="company_phone"><?=$pageData->label->label->mobile->title?> <span class="redStar">*</span></label>
                      <?=$pageData->label->label->mobile->icon?>
                    </div>
                </div>
                <div class="col-sm-6">
                	<div class="form-wrap form-wrap-icon">
                      <input class="form-input" id="email" type="email" name="email">
                      <label class="form-label" for="email"><?=$pageData->label->label->email->title?> <span class="redStar">*</span></label>
                      <?=$pageData->label->label->email->icon?>
                    </div>
                </div>
                <div class="col-sm-6">
                	<div class="form-wrap form-wrap-icon">
                      <input class="form-input" id="company_address" type="text" name="company_address">
                      <label class="form-label" for="company_address"><?=$pageData->label->label->address->title?></label>
                      <?=$pageData->label->label->address->icon?>
                    </div>
                </div>
                <div class="col-sm-6">
                	<div class="form-wrap form-wrap-icon">              
                      <select class="form-input" id="company_provincecity" type="text" name="company_provincecity">
                        <option value=""><?=$pageData->label->label->provincecity->title?> <span class="redStar">*</span></option>
                        <?php
                        foreach($pageData->data->content->provincecity as $v){
							echo '<option value="'.$v['id'].'">'.$v['provincecity_name'].'</optio>';
						}
						?>
                      </select>
                      <?=$pageData->label->label->provincecity->icon?>
                    </div>
                </div>
            </div>        
            <div class="row row-30">
            	<div class="col-lg-12">
                	<h5><u><?=$pageData->label->label->login_info->title?></u></h5>
                </div>
            	<div class="col-lg-12">
                	<div class="form-wrap form-wrap-icon">
                      <input class="form-input" id="username" type="text" name="username">
                      <label class="form-label" for="username"><?=$pageData->label->label->username->title?> <span class="redStar">*</span></label>
                      <div class="icon form-icon mdi mdi-account-outline"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                	<div class="form-wrap form-wrap-icon">
                      <input class="form-input" id="password" type="password" name="password">
                      <label class="form-label" for="password"><?=$pageData->label->label->password->title?> <span class="redStar">*</span></label>
                      <div class="icon form-icon mdi mdi-key"></div>
                    </div>
                </div>
                <div class="col-sm-6">
                	<div class="form-wrap form-wrap-icon">
                      <input class="form-input" id="confirm_password" type="password" name="confirm_password">
                      <label class="form-label" for="confirm_password"><?=$pageData->label->label->retype->title?> <span class="redStar">*</span></label>
                      <div class="icon form-icon mdi mdi-key"></div>
                    </div>
                </div>            
            </div>  
            <div class="row row-30">                        
                <div class="col-xs-6 col-sm-6">
                    <div class="form-wrap form-wrap-icon">
                      <input class="form-input " id="captcha" type="text" name="captcha">
                      <label class="form-label rd-input-label" for="captcha"><?=$pageData->label->label->code->title?> <span class="redStar">*</span></label>
                      <div class="icon form-icon mdi fa-exclamation-circle text-warning"></div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-4">                                    
                    <div class="input-group captchabox">
                        <div class="input-group-prepend">
                          <div class="input-group-text renew_captcha click"><span class="fa fa-refresh"></span></div>
                        </div>
                        <div id="captcha_img" class="form-control"></div>
                    </div>
                </div>
            </div>            
            <div class="form-wrap form-wrap-checkbox">
              <?=$pageData->label->label->alr_have_acc->title?> <a href="/<?=$pageData->lang->selected.$pageData->label->label->login->url?>"><?=$pageData->label->label->login->icon.' '.$pageData->label->label->login->title?></a>
            </div>
            <div class="form-wrap form-wrap-group group-1">
            	<input type="hidden" name="cmd" value="<?=$cmd?>" />
              	<button class="button button-lg button-primary" type="submit"><?=$pageData->label->label->register->icon.' '.$pageData->label->label->register->title?> </button>	
            </div>
            <div id="<?=$cmd?>_msg" class="v_pad10" data-loadtxt='<?=$pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title?>'></div>
          </form>
        </div>
      </div>
    </div>
  </section>