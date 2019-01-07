<?php		
	$web_config=web_config(array('thumbnail_path','no_pic'));
	$thumbnail_path = $web_config['thumbnail_path']; $default_img = $web_config['no_pic']; 
	$pop_item=$itembylocation=$eatstay=$locationoption=$typeoption=$whycambodia=$tour_count='';
	foreach($pageData->data->content->destinations as $key=>$value){					
		$encrypted_id = encode($value['id']);					
		$filenames = json_decode($value['filenames']);
		$pic = count($filenames)?$thumbnail_path.$filenames[0]->filename:$default_img;
		$url='/'.$pageData->lang->selected.$pageData->label->label->item_view->url.'/'.$encrypted_id;
		$pop_item.= '<div class="owl-item-inner"><a class="destination-1 context-dark" href="'.$url.'">
				<figure class="destination-1-figure">
				  <div class="destination-1-image bg-image" style="background-image: url('.$pic.');"></div>
				</figure>
				<div class="destination-1-caption">
				  <p class="destination-1-decoration-title">'.$value['itemname'].'</p>
				  <p class="heading-3 destination-1-title">'.$value['itemname'].'</p>
				  <div class="destination-1-comment"><span>'.$value['provincecity_name'].'</span></div>
				</div></a>
			</div>';
	}
	//by locations
	foreach($pageData->data->content->locations as $key=>$value){
		$allphoto=array();$rndpic=$default_img;$allfilenames = explode('{|}',$value['photo']);
		foreach($allfilenames as $pval){$allphoto = array_merge(json_decode($pval),$allphoto);}
		if(count($allphoto)){$rndpic=$thumbnail_path.$allphoto[rand(0,(count($allphoto)-1))]->filename;}		
		//url
		$list_url = '/'.$pageData->lang->selected.$pageData->label->label->item_list->url.'&type[]='.$value['typecode'].'&loc='.$value['id'];		
		$itembylocation.= '<div class="col-sm-6 col-lg-4 wow fadeIn">
							  <article class="tour-classic">
								<div class="tour-classic-media"><a class="tour-classic-figure" href="'.$list_url.'"><img class="tour-classic-image" src="'.$rndpic.'" alt="" width="365" height="248"/></a>
								  <div class="tour-classic-pricing">
									<p class="tour-classic-price tour-classic-price-new">'.enNum_khNum($value['total']).' '.$pageData->label->label->place->title.'</p>
								  </div>
								</div>
								<div class="tour-classic-body">
								  <h4 class="tour-classic-title"><a href="'.$list_url.'">'.$value['provincename'].'</a></h4>
								</div>
							  </article>
							</div>';
	}
	//eat and stay
	foreach($pageData->data->content->eatstay as $key=>$value){				
		$encrypted_id = encode($value['id']);					
		$filenames = json_decode($value['filenames']);
		$pic = count($filenames)?$thumbnail_path.$filenames[0]->filename:$default_img;
		$url='/'.$pageData->lang->selected.$pageData->label->label->item_view->url.'/'.$encrypted_id;
		$eatstay.= '<article class="tour-2"><a class="tour-2-media" href="'.$url.'"><img class="tour-2-image" src="'.$pic.'" alt="" width="498" height="305"/>
                        <div class="tour-2-badge">'.$value['provincecity_name'].'</div></a>
                      <div class="tour-2-caption context-light">
                        <p class="tour-2-title"><a href="'.$url.'">'.$value['itemname'].'</a></p>
                        <div class="tour-2-pricing">
                          <p class="tour-2-price tour-2-price-new">'.$pageData->label->label->from->title.' $'.enNum_khNum($value['price_from']).'</p>
                        </div>
                      </div>
                    </article>';
	}
	//type list
	foreach($pageData->label->listing as $key=>$value){	
		if($key<>'events'){
			$typeoption.= '<option value="'.$value->id.'">'.$value->title.'</option>';
		}
	}
	//location list
	foreach($pageData->data->content->locationlist as $key=>$value){					
		$locationoption.= '<option value="'.$value['id'].'">'.$value['provincecity_name'].'</option>';
	}
	
	//item for why cambodia
	$contentcode=array();
	foreach($pageData->label->menu->experience->sub as $key=>$value){$contentcode[]=$value->content_code;}
	$contentcode[]='tourism_site';$contentcode[]='eat_stay';
	$whycam=content($contentcode);
	foreach($pageData->label->menu->experience->sub as $key=>$value){	
		$_des = strip_tags($whycam[$value->content_code]['description']);
		$_des = (mb_strlen($_des,"utf-8")>80)?(mb_substr($_des,0,80,"utf-8").'...'):$_des;
		$article_url = '/'.$pageData->lang->selected.$pageData->label->label->article_view->url.'/'.$value->content_code;
		$whycambodia.= '<div class="owl-item active" style="width: 270px; margin-right: 30px;">
							<article class="lg-1-item wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
							  <div class="icon lg-1-item-icon '.$value->icon.'"></div>
							  <div class="lg-1-item-main">
								<h4 class="lg-1-item-title">'.$value->title.'</h4>
								'.$_des.' <a href="'.$article_url.'">'.$pageData->label->label->read_more->title.'</a>
							  </div>
							</article>
						</div>';
	}
	
	foreach($pageData->label->tour_count as $key=>$value){	
		$tour_count.='<div class="col-6 col-sm-3 wow fadeIn">
						  <article class="counter-classic">
							<div class="counter-classic-main"><span>'.$value->data.'</span></div>
							<h5 class="counter-classic-title">'.$value->title.'</h5>
						  </article>
						</div>';
	}
	
?>  
<?php if(!$usersession->isLogin()){ ?>
<section class="section section-xs text-center">
	<div class="group group-sm group-middle ">
        <a style="background-image: url(/assets/frontend/img/bg_pattern1.png);" href="/<?=$pageData->lang->selected.$pageData->label->label->register->url?>" class="button button-default-outline" data-lightgallery="group"><?=$pageData->label->label->register->icon?> </span><?=$pageData->label->label->register->title?></a>
        <a style="background-image: url(/assets/frontend/img/bg_pattern1.png);" href="/<?=$pageData->lang->selected.$pageData->label->label->login->url?>" class="button button-default-outline" data-lightgallery="group"><?=$pageData->label->label->login->icon?> </span><?=$pageData->label->label->login->title?></a>    
	</div>
</section>
<?php } ?>
<section class="section context-dark bg-color-gray-800" style="background-image: url(/assets/frontend/img/bg_pattern1.png);">
        <div class="container container-wide">
          <!-- RD Mailform-->
          <form class="rd-form form-lg form-1" action="/<?=$pageData->lang->selected.$pageData->label->label->item_list->url?>">
            <div class="form-wrap-outer wow fadeIn">
              <div class="form-wrap form-wrap-icon">
                <label class="form-label form-label-outside" for="form-1-destination"><?=$pageData->label->label->search_name->title?></label>
                <input class="form-input" id="form-1-destination" type="text" name="txt" data-constraints="@Required">
                <div class="icon form-icon mdi fa-search"></div>
              </div>
            </div>
            <div class="form-wrap-outer wow fadeIn" data-wow-delay=".025s">
              
              <div class="form-wrap form-wrap-icon">
                <select class="form-input" name="type"><option value=""><?=$pageData->label->label->select_option->title?></option><?=$typeoption?></select>
                <div class="icon form-icon mdi fa-tag"></div>
              </div>
            </div>
            <div class="form-wrap-outer wow fadeIn" data-wow-delay=".05s">
              <div class="form-wrap form-wrap-icon">
				<select class="form-input" name="loc"><option value=""><?=str_replace(' ---',' '.$pageData->label->label->provincecity->title.' ---',$pageData->label->label->select_option->title)?></option><?=$locationoption?></select>
                <div class="icon form-icon mdi mdi-map-marker"></div>
              </div>
            </div>
            <div class="form-button wow fadeIn" data-wow-delay=".075s"><button class="button button-lg button-icon button-icon-left button-primary" type="submit"><span class="icon mdi mdi-magnify"></span><?=$pageData->label->label->search->title?></button></div>
          </form>
        </div>
      </section>
      <!-- Destinations-->
      <!--style="background: url(/assets/frontend/img/wallpapers/black_bg.png) center no-repeat;background-size: cover;"-->
      <section class="section section-1 bg-gray-800 context-dark">
        <div class="container container-wide">
          <div class="layout-2">
            <h4 class="wow fadeIn"><?=$pageData->label->label->pop_des->title?></h4>
            <div class="layout-2-item wow fadeIn" data-wow-delay=".1s">
              <div class="group group-2 group-middle">
                <div class="owl-nav-1 button button-sm button-light" id="owl-nav-1">
                  <button class="owl-arrow owl-arrow-prev" aria-label="Prev">
                    <svg width="20" height="16" viewBox="0 0 20 16" xmlns="http://www.w3.org/2000/svg">
                      <path d="M6.7,15.1c0.4,0.4,1,0.4,1.4,0c0.4-0.4,0.4-1,0-1.4L2.4,8l5.7-5.7c0.4-0.4,0.4-1,0-1.4c-0.4-0.4-1-0.4-1.4,0L0.3,7.3										c-0.4,0.4-0.4,1,0,1.4L6.7,15.1z M20,7H1v2h19V7z"></path>
                    </svg>
                  </button>
                  <button class="owl-arrow owl-arrow-next" aria-label="Next">
                    <svg width="20" height="16" viewBox="0 0 20 16" xmlns="http://www.w3.org/2000/svg">
                      <path d="M19.7071 8.70711C20.0976 8.31658 20.0976 7.68342 19.7071 7.29289L13.3431 0.928932C12.9526 0.538408 12.3195 0.538408 11.9289 0.928932C11.5384 1.31946 11.5384 1.95262 11.9289 2.34315L17.5858 8L11.9289 13.6569C11.5384 14.0474 11.5384 14.6805 11.9289 15.0711C12.3195 15.4616 12.9526 15.4616 13.3431 15.0711L19.7071 8.70711ZM0 9H19V7L0 7L0 9Z"></path>
                    </svg>
                  </button>
                </div><a class="button button-sm button-light" href="/<?=$pageData->lang->selected.$pageData->label->label->item_list->url?>&type[]=destination"><?=$pageData->label->label->see_all->title?></a>
              </div>
            </div>
          </div>
          <!-- Owl Carousel-->
          <div class="owl-carousel owl-3 grid-wing-right wow fadeIn" data-wow-delay=".1s" data-items="1" data-sm-items="2" data-lg-items="3" data-xl-items="4" data-xxl-items="5" data-dots="false" data-nav="false" data-nav-custom="#owl-nav-1" data-stage-padding="0" data-loop="true" data-margin="30" data-mouse-drag="false" data-autoplay="true" data-autoplay-speed="4000">
            <?=$pop_item?>            
          </div>
        </div>
      </section>
<!-- Featured Tours-->
      <section class="section section-sm bg-gray-100 text-center">
        <div class="container">
          <h2 class="wow fadeIn"><?=$pageData->label->label->des_by_loc->title?></h2>
          <div class="row row-30 row-xl-40 mt-lg-60 mt-xl-80">
            <?=$itembylocation?>
          </div><a class="button button-1 mt-md-35 mt-lg-50 wow fadeIn" href="/<?=$pageData->lang->selected.$pageData->label->label->provinces_list->url?>&type=destination"><?=$pageData->label->label->see_all->title?></a> 
        </div>
      </section>
      
      <!-- Last Minute Offer-->
      <section class="parallax-container section-sm bg-overlay-2 context-dark" data-parallax-img="https://static.arocdn.com/Sites/50/songsaa/uploads/images/Gallery/nosize29/island_from_above.jpg">
        <div class="parallax-content">
          <div class="container">
            <div class="row row-30 flex-lg-row-reverse align-items-center justify-content-xl-between">
              <div class="col-sm-10 col-lg-6">
                <div class="block-5 block-centered">
                  <div class="group group-3 group-middle wow fadeIn" data-wow-delay=".025s">
                    <h2 class="block-5-title"><?=$pageData->label->label->check_out->title?></h2>
                    <p class="text-1 dt-1"><?=$whycam['eat_stay']['title']?></p>
                  </div>
                  <h4 class="mt-20 mt-xl-40 wow fadeIn" data-wow-delay=".05s" style="line-height: 1.7;"><?=strip_tags($whycam['eat_stay']['description'])?></h4> <a class="button button-lg button-icon button-icon-left button-primary wow fadeIn" href="/<?=$pageData->lang->selected.$pageData->label->label->item_list->url?>&type[]=eatdrink&type[]=accommodations" data-wow-delay=".025s"><?=$pageData->label->label->see_all->title?></a>
                </div>
              </div>
              <div class="col-lg-6 col-xl-6 wow fadeIn clearfix">
                <article class="owl-group-2">
                  <div class="owl-nav" id="owl-nav-2">
                    <button class="owl-arrow owl-arrow-next" aria-label="Next">
                      <svg width="20" height="16" viewBox="0 0 20 16" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.7071 8.70711C20.0976 8.31658 20.0976 7.68342 19.7071 7.29289L13.3431 0.928932C12.9526 0.538408 12.3195 0.538408 11.9289 0.928932C11.5384 1.31946 11.5384 1.95262 11.9289 2.34315L17.5858 8L11.9289 13.6569C11.5384 14.0474 11.5384 14.6805 11.9289 15.0711C12.3195 15.4616 12.9526 15.4616 13.3431 15.0711L19.7071 8.70711ZM0 9H19V7L0 7L0 9Z"></path>
                      </svg>
                    </button>
                    <button class="owl-arrow owl-arrow-prev" aria-label="Prev">
                      <svg width="20" height="16" viewBox="0 0 20 16" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.7,15.1c0.4,0.4,1,0.4,1.4,0c0.4-0.4,0.4-1,0-1.4L2.4,8l5.7-5.7c0.4-0.4,0.4-1,0-1.4c-0.4-0.4-1-0.4-1.4,0L0.3,7.3										c-0.4,0.4-0.4,1,0,1.4L6.7,15.1z M20,7H1v2h19V7z"></path>
                      </svg>
                    </button>
                  </div>
                  <!-- Owl Carousel-->
                  <div class="owl-carousel" data-items="1" data-sm-items="2" data-lg-items="1" data-xl-items="2" data-dots="false" data-nav="false" data-stage-padding="0" data-nav-custom="#owl-nav-2" data-loop="true" data-margin="20" data-md-margin="30" data-xxl-margin="40" data-mouse-drag="false" data-autoplay="true">
                    <?=$eatstay?>
                  </div>
                </article>
              </div>
            </div>
          </div>
        </div>
      </section>
      
      <!-- Counters-->
      <section class="section section-sm bg-default section-decoration-1">
        <div class="container relative z-1">
          <h2 class="block-4 wow fadeIn"><?=$whycam['tourism_site']['title']?></h2>
          <div class="row row-30 justify-content-lg-between mt-15 mt-md-30">
            <div class="col-md-8 col-xl-7 text-gray-800">
              <p class="wow fadeIn" data-wow-delay=".025s"><?=$whycam['tourism_site']['description']?></p>
            </div>
            <div class="col-md-4 col-xl-3 text-md-center"><a class="button button-lg button-icon button-icon-left button-primary wow fadeIn" href="/<?=$pageData->lang->selected.$pageData->label->label->item_list->url?>" data-wow-delay=".025s"><span class="icon mdi mdi-magnify"></span><?=$pageData->label->label->search->title?></a></div>
          </div>
        </div>
        <div class="container section-decoration-1-figure mt-40">
          <div class="row row-30">
            <?=$tour_count?>
          </div><img class="section-decoration-1-image" src="https://livedemo00.template-help.com/wt_prod-19282/images/world-map-728x385.png" alt="" width="728" height="385"/>
        </div>
      </section>
      
      <section class="section bg-color-gray-100">
        <div class="range"> 
          <div class="cell-lg-7 cell-xl-8 cell-xxl-9">
            <div class="cell-inner section-lg text-center text-sm-left">
              <h3 class="wow fadeIn" style="visibility: visible; animation-name: fadeIn;"><?=$pageData->label->label->why_cam->title?></h3>
              <!-- Owl Carousel-->
              <div class="owl-carousel owl-1 list-group-1 mt-lg-50 owl-loaded" data-items="1" data-sm-items="2" data-md-items="3" data-lg-items="2" data-xl-items="3" data-dots="true" data-nav="false" data-stage-padding="0" data-loop="false" data-margin="30" data-mouse-drag="false" style="">                
              <div class="owl-stage-outer">
              <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 900px;">
                    <?=$whycambodia?>
                </div></div>
                <div class="owl-nav disabled"><button type="button" role="presentation" class="owl-prev"></button><button type="button" role="presentation" class="owl-next"></button></div><div class="owl-dots disabled"><button role="button" class="owl-dot active"><span></span></button></div></div>
            </div>
          </div>
          <div class="cell-lg-5 cell-xl-4 cell-xxl-3 height-fill">
            <div class="box-3 bg-image" style="background-image: url(/assets/frontend/img/wallpapers/vid_bg.jpg);"><a class="box-3-play" data-lightgallery="item" href="https://www.youtube.com/watch?v=NJyCKj8pCiY"><span class="icon mdi mdi-play"></span></a></div>
          </div>
        </div>
      </section>
      
      
      
      <!-- CTA-->
      <section class="parallax-container section-md bg-overlay-2 context-dark d-none" data-parallax-img="http://www.visitcambodia.org/sites/default/files/2018-09/russian-market.jpg">
        <div class="parallax-content">
          <div class="container">
            <div class="row justify-content-center justify-content-md-end">
              <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 text-center">
                <h3 class="wow fadeIn">Find Your</h3>
                <p class="text-1 wow fadeIn" data-wow-delay=".025s">Favorite Stuffs</p>
                <h4 class="wow fadeIn" data-wow-delay=".05s">On our website, you can find popular shopping places.</h4><a class="button button-lg shadow-1 button-icon button-icon-left button-primary mt-md-35 mt-xl-50 wow fadeIn" href="/<?=$pageData->lang->selected.$pageData->label->label->item_list->url?>&type[]=shops" data-wow-delay=".075s"><span class="icon mdi mdi-magnify"></span><?=$pageData->label->label->search->title?></a>
              </div>
            </div>
          </div>
        </div>
      </section>