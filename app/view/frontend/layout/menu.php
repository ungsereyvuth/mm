<!-- Navbar -->
<?php
	$brandlogo = $pageData->label->system_title->sys->icon;
	$menu=$pageData->data->component->frontend_menu;	
	$lang_menu = isset($pageData->data->component->language_switch)?('<h4 class="font-weight-sbold">'.$pageData->label->label->lang->title.'</h4>
					<div class="mt-10">'.$pageData->data->component->language_switch.'</div>'):'';	
	$contact = isset($pageData->data->component->footer->footer_contact)?('<h4 class="font-weight-sbold">'.$pageData->label->label->contact->title.'</h4><div class="blackcolor">'.$pageData->data->component->footer->footer_contact.'</div>'):'';	
?>


<header class="section page-header <?=isset($pageData->data->component->slider)?'':'page-header-1 context-dark'?>">
		
        <?php
			if(!isset($pageData->data->component->slider)){
				$filenames=array();$item_video=$item_gallery=$feature_img=$feature_des='';				
				if(isset($pageData->data->content->item)){
					$web_config=web_config(array('resized_pic_path','thumbnail_path'));
					$pic_path = $web_config['resized_pic_path'];$thumbnail_path = $web_config['thumbnail_path'];
					$item=$pageData->data->content->item;
					//$map = explode(',',$item['map']); $map=count($map)?$map:array(0,0,0);
					$filenames = $item['filenames']<>''?json_decode($item['filenames']):array();
					$feature_img = count($filenames)?$pic_path.$filenames[rand(0,(count($filenames)-1))]->filename:'';
					$feature_des = strip_tags($item['description']);
					$feature_des = (mb_strlen($feature_des,"utf-8")>100)?(mb_substr($feature_des,0,100,"utf-8").'...'):$feature_des;
				}
				foreach($filenames as $key=>$value){
					$item_gallery.='<a href="'.$pic_path.$value->filename.'" data-lightgallery="item">
										<img src="'.$pic_path.$value->filename.'" alt="" width="225" height="300"/>
									</a>';
				}
				
				$pic = (isset($feature_img) and $feature_img<>'')?$feature_img:'https://www.songsaa.com/uploads/images/default.jpg';
				echo '<div class="page-header-1-figure m-parallax">
					  <div class="page-header-1-image m-parallax-image" style="background-image: url('.$pic.');"></div>
					</div>';
			}		
		?>
		

        <!-- RD Navbar-->
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-lg-stick-up-offset="1px" data-xl-stick-up-offset="1px" data-xxl-stick-up-offset="1px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-main-outer">
              <div class="rd-navbar-main">
                <!-- RD Navbar Panel-->
                <div class="rd-navbar-panel">
                  <!-- RD Navbar Toggle-->
                  <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                  <!-- RD Navbar Brand-->
                  <div class="rd-navbar-brand"><a class="brand" href="/"><img class="brand-logo-dark" src="<?=$brandlogo?>" height="10" srcset="<?=$brandlogo?> 2x"/><img class="brand-logo-light" src="<?=$brandlogo?>" alt="" width="146" height="30" srcset="<?=$brandlogo?> 2x"/></a>
                  </div>
                </div>
                <div class="rd-navbar-nav-wrap">
                  <!-- RD Navbar Nav-->
                  <ul class="rd-navbar-nav">
                    <?=$menu?>
                  </ul>
                </div>
                <div class="rd-navbar-collapse-outer context-light">
                  <button class="rd-navbar-collapse-toggle" data-multitoggle="#rd-navbar-collapse, #toggle-inner"><span class="rd-navbar-collapse-toggle-element" id="toggle-inner"><span></span></span><span class="rd-navbar-collapse-toggle-text khmerNormal"><?=$pageData->lang->selected=='kh'?'Account<br/>Language':'គណនី<br >ជ្រើសភាសា'?></span></button>
                  <div class="rd-navbar-collapse" id="rd-navbar-collapse">
                    <button class="rd-navbar-collapse-close" data-multitoggle="#rd-navbar-collapse"><span class="rd-navbar-collapse-toggle-element active"><span></span></span></button>
                    
                    <div class="group group-sm group-middle ">
                    <?php if($usersession->isLogin()){ ?>
						<a href="/<?=$pageData->lang->selected.$usersession->info()->homepage?>" class="button button-sm button-icon button-icon-left btn-info button-gallery " data-lightgallery="group"><?=$pageData->label->label->dashboard->icon?> </span><?=$pageData->label->label->dashboard->title?></a>
                      	<a href="/<?=$pageData->lang->selected.$pageData->label->label->logout->url?>" class="button button-sm button-icon button-icon-left btn-info button-gallery " data-lightgallery="group"><?=$pageData->label->label->logout->icon?> </span><?=$pageData->label->label->logout->title?></a>
					<?php }else{ ?>
                      	<a href="/<?=$pageData->lang->selected.$pageData->label->label->register->url?>" class="button button-sm button-icon button-icon-left btn-info button-gallery " data-lightgallery="group"><?=$pageData->label->label->register->icon?> </span><?=$pageData->label->label->register->title?></a>
                      	<a href="/<?=$pageData->lang->selected.$pageData->label->label->login->url?>" class="button button-sm button-icon button-icon-left btn-info button-gallery " data-lightgallery="group"><?=$pageData->label->label->login->icon?> </span><?=$pageData->label->label->login->title?></a>
                    <?php } ?>
                    </div>
					
					<?=$lang_menu?>                    
                    <?=$contact?>
                    <!-- Owl Carousel-->
                    <div class="owl-carousel owl-carousel-tour-minimal" data-items="1" data-dots="true" data-nav="false" data-auto-width="true" data-loop="true" data-margin="0" data-autoplay="true" data-mouse-drag="false">
                      <div class="owl-item-inner">
                        <article class="tour-minimal context-dark">
                          <div class="tour-minimal-inner" style="background-image: url(https://livedemo00.template-help.com/wt_prod-19282/images/tour-1-258x273.jpg);">
                            <div class="tour-minimal-header">
                            </div>
                            <div class="tour-minimal-main">
                              <h4 class="tour-minimal-title"><a href="single-tour.html">Adventures in Maldives</a></h4>
                              <div class="tour-minimal-pricing">
                                <p class="tour-minimal-price tour-minimal-price-new">$756</p>
                              </div>
                              <p class="tour-minimal-comment">Price per person</p>
                            </div>
                            <div class="tour-minimal-caption">
                              <p>Explore unrivaled luxury of Maldives.</p>
                            </div>
                          </div>
                        </article>
                      </div>
                      <div class="owl-item-inner">
                        <article class="tour-minimal context-dark">
                          <div class="tour-minimal-inner" style="background-image: url(https://livedemo00.template-help.com/wt_prod-19282/images/tour-2-258x273.jpg);">
                            <div class="tour-minimal-header">
                              <div class="tour-minimal-badge">-20%</div>
                            </div>
                            <div class="tour-minimal-main">
                              <h4 class="tour-minimal-title"><a href="single-tour.html">Discover Costa Rica</a></h4>
                              <div class="tour-minimal-pricing">
                                <p class="tour-minimal-price tour-minimal-price-old">$1000</p>
                                <p class="tour-minimal-price tour-minimal-price-new">$756</p>
                              </div>
                              <p class="tour-minimal-comment">Price per person</p>
                            </div>
                            <div class="tour-minimal-caption">
                              <p>Experience your best vacation on Costa Rica.</p>
                            </div>
                          </div>
                        </article>
                      </div>
                      <div class="owl-item-inner">
                        <article class="tour-minimal context-dark">
                          <div class="tour-minimal-inner" style="background-image: url(https://livedemo00.template-help.com/wt_prod-19282/images/tour-3-258x273.jpg);">
                            <div class="tour-minimal-header">
                            </div>
                            <div class="tour-minimal-main">
                              <h4 class="tour-minimal-title"><a href="single-tour.html">Peyto Lake Tour</a></h4>
                              <div class="tour-minimal-pricing">
                                <p class="tour-minimal-price tour-minimal-price-new">$856</p>
                              </div>
                              <p class="tour-minimal-comment">Price per person</p>
                            </div>
                            <div class="tour-minimal-caption">
                              <p>A perfect choice for an autumn family trip.</p>
                            </div>
                          </div>
                        </article>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="rd-navbar-placeholder"></div>
          </nav>
        </div>
        
        <?php
			if(!isset($pageData->data->component->slider)){
				
				echo '<section class="breadcrumbs-custom">
					  <div class="breadcrumbs-custom-inner" style="padding: 35px 0 40px;">
						<div class="container">
						  <div class="breadcrumbs-custom-main m-parallax-content">
							<svg class="breadcrumbs-custom-line" width="70" height="8" viewBox="0 0 70 8" fill="none">
							  <path d="M0 1C5 1 5 7 9.92 7C14.84 7 14.92 1 19.85 1C24.78 1 24.85 7 29.77 7C34.69 7 34.77 1 39.71 1C44.65 1 44.71 7 49.63 7C54.55 7 54.63 1 59.57 1C64.51 1 64.57 7 69.5 7" stroke-width="1.98" stroke-miterlimit="10"></path>
							</svg>
							<h2 class="breadcrumbs-custom-title">'.$pagetitle.'</h2>
							<div class="group group-sm group-middle '.(($item_video=='' and $item_gallery=='')?'d-none':'').'">
								<a class="button button-sm button-icon button-icon-left button-light '.($item_video==''?'d-none':'').'" data-lightgallery="item" href="https://www.youtube.com/watch?v=I5FlP07kdvM"><span class="icon mdi mdi-play"></span>Video Preview</a>
							  <div class="button button-sm button-icon button-icon-left button-light button-gallery '.($item_gallery==''?'d-none':'').'" data-lightgallery="group"><span class="icon mdi mdi-image-filter"></span>'.$pageData->label->label->gallery->title.'
								<div class="button-gallery-inner">
									'.$item_gallery.'
								</div>
							  </div>
							</div>
							
							
							
						  </div>
						</div>
					  </div>
					</section>';
			}		
		?>
        
        

      </header>