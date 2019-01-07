<?php
$content=content(array('footer_contact'));
?>

<section class="section section-sm bg-gray-100">
    <div class="container">
      <div class="row row-30 row-xl-50">        
        <div class="col-lg-8">
        	<h3><?=$pageData->label->label->leave_message->title?></h3>
        	<form class="rd-form form-lg ajaxfrm" id="contact-form" data-func="submit_form" data-reset="1" method="post" novalidate="novalidate">
                <div class="row row-30">
                  <div class="col-lg-6">
                    <div class="form-wrap form-wrap-icon">
                      <input class="form-input " id="contact-name" type="text" name="feedback_name"><span class="form-validation"></span>
                      <label class="form-label rd-input-label" for="contact-name"><?=$pageData->label->label->fullname->title?></label>
                      <div class="icon form-icon mdi mdi-account-outline text-primary"></div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-wrap form-wrap-icon">
                      <input class="form-input " id="contact-email" type="email" name="feedback_email"><span class="form-validation"></span>
                      <label class="form-label rd-input-label" for="contact-email"><?=$pageData->label->label->email->title?></label>
                      <div class="icon form-icon mdi mdi-email-outline text-primary"></div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-wrap form-wrap-icon">
                      <input class="form-input " id="contact-subject" type="text" name="feedback_subject"><span class="form-validation"></span>
                      <label class="form-label rd-input-label" for="contact-subject"><?=$pageData->label->label->subject->title?></label>
                      <div class="icon form-icon mdi fa-file-text-o text-primary"></div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-wrap form-wrap-icon">
                      <select class="form-input" id="form-loc" type="text" name="feedback_type">
                      	<option value="">--- ជ្រើសរើស ---</option>
                        <?php
						foreach($pageData->data->content->m_cate as $v){
							echo '<option value="'.$v['id'].'">'.$v['title'].'</option>';
						}
						?>
                      </select>
                      <div class="icon form-icon mdi fa-tag text-primary"></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-wrap form-wrap-icon has-error">
                      <label class="form-label rd-input-label" for="contact-message"><?=$pageData->label->label->message->title?></label>
                      <textarea class="form-input " id="contact-message" name="feedback_des"></textarea>
                      <div class="icon form-icon mdi mdi-message-outline text-primary"></div>
                    </div>
                  </div>
                  <div class="col-12">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="sent_copy" class="checkbox-custom"><?=$pageData->label->label->send_copy->title?>
                      </label>
                  </div>
                  <div class="col-12">
                    <div class="row">                        
                        <div class="col-xs-6 col-sm-4 col-md-3">
                            <div class="form-wrap form-wrap-icon">
                              <input class="form-input " id="contact-captcha" type="text" name="captcha" data-constraints="@Required"><span class="form-validation"></span>
                              <label class="form-label rd-input-label" for="contact-captcha"><?=$pageData->label->label->code->title?></label>
                              <div class="icon form-icon mdi fa-exclamation-circle text-primary"></div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-3">                                    
                            <div class="input-group captchabox">
                                <div class="input-group-prepend">
                                  <div class="input-group-text renew_captcha click"><span class="fa fa-refresh"></span></div>
                                </div>
                                <div id="captcha_img" class="form-control"></div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                
                <div class="form-wrap form-wrap-button">
                	<input type="hidden" name="cmd" value="contact">
                  	<button class="button button-lg button-primary" type="submit"><?=$pageData->label->label->send->icon.' '.$pageData->label->label->send->title?></button>
                </div>
                <div class="v_pad15">
                	<div id="contact_msg" data-loadtxt='<?=$pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title?>'></div>
                </div>
              </form>
        </div>
        <div class="col-lg-4">
        	<div class="v_pad20"><?=$content['footer_contact']['description']?></div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3286.899726657719!2d104.91053010998412!3d11.565865406806763!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3109516b4b83e617%3A0xc464b23f83b4309a!2sMinistry+of+Tourism!5e0!3m2!1sen!2skh!4v1544082071151" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
      </div>
</section>