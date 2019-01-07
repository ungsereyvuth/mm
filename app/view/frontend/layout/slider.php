<?php
$web_config=web_config(array('resized_pic_path','no_pic'));
$resized_path = $web_config['resized_pic_path']; $default_img = $web_config['no_pic']; 
$slideritem=$slidernav='';
foreach($pageData->data->component->slider->item as $key=>$value){					
	$encrypted_id = encode($value['id']);					
	$filenames = json_decode($value['filenames']);
	$pic = count($filenames)?$resized_path.$filenames[0]->filename:$default_img;
	$des = strip_tags($value['item_des']);
	$des = (mb_strlen($des,"utf-8")>100)?(mb_substr($des,0,100,"utf-8").'...'):$des;
	$url='/'.$pageData->lang->selected.$pageData->label->label->item_view->url.'/'.$encrypted_id;
	$slideritem.= '<article class="tour-1 bg-image context-dark" style="background-image: url('.$pic.');">
                    <p class="tour-1-title"><a href="'.$url.'">'.$value['item_tile'].'</a></p>
                    <p class="tour-1-caption heading-4">'.$value['provincecity_name'].'</p><a class="button-to-bottom" href="#section-1" data-waypoint-to="#section-1" data-waypoint-relative-to=".rd-navbar-placeholder">
                      <svg width="16" height="20" viewBox="0 0 16 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.1,11.3c0.4-0.4,0.4-1,0-1.4s-1-0.4-1.4,0L10,15.6L4.3,9.9c-0.4-0.4-1-0.4-1.4,0c-0.4,0.4-0.4,1,0,1.4l6.4,6.4		c0.4,0.4,1,0.4,1.4,0L17.1,11.3z M9-2v19h2V-2H9z"></path>
                      </svg></a>
                  </article>';
	
	$slidernav.='<button class="wow fadeIn text-left" data-owl-item="'.$key.'" '.($key?('data-wow-delay=".'.$key.'s"'):'').'>'.$value['item_tile'].'</button>';
}
?>
<section class="section jumbotron-1">
        <div class="container container-wide">
          <div class="jumbotron-1-inner">
            <div class="owl-group-1 jumbotron-1-main">
              <div class="owl-group-1-main">
                <!-- Owl Carousel-->
                <div class="owl-carousel" data-items="1" data-dots-custom="#owl-dots-1" data-stage-padding="0" data-loop="false" data-margin="30" data-animation-in="fadeIn" data-animation-out="fadeOut" data-mouse-drag="false">
                  <?=$slideritem?>
                </div>
              </div>
              <div class="owl-dots-nav" id="owl-dots-1">
                <?=$slidernav?>
              </div>
            </div>
            <div class="jumbotron-1-aside">
              <div class="jumbotron-1-group">
                <div class="jumbotron-1-group-item focus-toggle-parent wow fadeIn">
                  <button class="jumbotron-1-group-item-toggle"><span class="icon mdi mdi-phone"></span></button>
                  <div class="jumbotron-1-group-item-content focus-toggle"><a href="tel:#">Phone</a></div>
                </div>
                <div class="jumbotron-1-group-item focus-toggle-parent wow fadeIn" data-wow-delay=".1s">
                  <button class="jumbotron-1-group-item-toggle"><span class="icon mdi mdi-email-outline"></span></button>
                  <div class="jumbotron-1-group-item-content focus-toggle"><a href="mailto:#">E-mail</a></div>
                </div>
                <div class="jumbotron-1-group-item focus-toggle-parent wow fadeIn" data-wow-delay=".2s">
                  <button class="jumbotron-1-group-item-toggle"><span class="icon mdi mdi-share-variant"></span></button>
                  <div class="jumbotron-1-group-item-content focus-toggle"><a href="#">Share</a></div>
                </div>
                <div class="jumbotron-1-group-item focus-toggle-parent wow fadeIn" data-wow-delay=".3s">
                  <button class="jumbotron-1-group-item-toggle"><span class="jumbotron-1-group-item-toggle-text">En</span></button>
                  <div class="jumbotron-1-group-item-content focus-toggle"><a href="#">English</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
		<div id="section-1"></div>
      </section>