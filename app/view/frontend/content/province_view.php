<?php
$places='';$item_gallery='';
$web_config=web_config(array('resized_pic_path','thumbnail_path','no_pic'));
$pic_path = $web_config['resized_pic_path'];$thumbnail_path = $web_config['thumbnail_path'];$no_pic = $web_config['no_pic'];
$filenames = $pageData->data->content->item['filenames']<>''?json_decode($pageData->data->content->item['filenames']):array();$secondImg=$feature_img;
foreach($filenames as $k=>$v){
	$secondImg=($k==1)?$thumbnail_path.$v->filename:$secondImg;
	$item_gallery.='<div class="col-3"><a class="thumbnail-light" href="'.$pic_path.$v->filename.'" data-lightgallery="item"><img class="thumbnail-light-image" src="'.$thumbnail_path.$v->filename.'" alt="" width="355" height="359"/></a></div>';
}
foreach($pageData->data->content->places as $k=>$v){
	if(!count($v->item)){continue;}
	$places.='<h3>'.$v->title.'</h3><div class="row row-30">';
	foreach($v->item as $key=>$value){
		$item=$value;
		$filenames = json_decode($item['filenames']);
		$places_img = count($filenames)?$thumbnail_path.$filenames[0]->filename:$no_pic;
		$places_des = strip_tags($item['description']);
		$places_des = (mb_strlen($places_des,"utf-8")>50)?(mb_substr($places_des,0,50,"utf-8").'...'):$places_des;
		
		//additional info
		if($k=='events'){
		$ad_info='<div class="tour-classic-footer">
					<div class="tour-classic-footer-left">
					  <p class="tour-classic-rating">'.khmerDate($value['start_date']).'</p>
					</div>
					<div class="tour-classic-footer-right">
					  <div class="object-inline"><span class="icon mdi mdi-calendar-today text-gray-800"></span><span>'.enNum_khNum($value['days']).' '.$pageData->label->label->day->title.'</span></div>
					</div>
				  </div>';
		}else{$ad_info='';}
		
		$item_url = '/'.$pageData->lang->selected.$pageData->label->label->item_view->url.'/'.encode($value['id']);
		$places.=' <div class="col-sm-6 col-lg-4 mgn0">
					  <article class="tour-classic">
						<div class="tour-classic-media"><a class="tour-classic-figure" href="'.$item_url.'"><img class="tour-classic-image" src="'.$places_img.'" alt="" width="365" height="248"/></a>
						</div>
						<div class="tour-classic-body">
						  <h4 class="tour-classic-title"><a href="'.$item_url.'">'.$value['title'].'</a></h4>
						  <p class="tour-classic-caption">'.$places_des.'</p>
						  '.$ad_info.'
						</div>
					  </article>
					</div>
				';
	}
	$places.='</div><a class="button button-1 wow fadeIn v_mgn25" href="/'.$pageData->lang->selected.$pageData->label->label->item_list->url.'&loc='.$pageData->data->content->item['id'].'&type='.$v->code.'">'.$pageData->label->label->see_all->title.'</a> ';
}

?>

<section class="section">
        <!-- Bootstrap tabs -->
        <div class="tabs-custom tabs-complex" id="tabs-1">
          <button class="tabs-complex-nav-toggle" data-multitoggle="#tabs-complex-nav" data-isolate="#tabs-complex-nav"><span>Navigation</span><span class="icon mdi mdi-chevron-down"></span></button>
          <!-- Nav tabs-->
          <ul class="nav nav-tabs" id="tabs-complex-nav">
            <li class="nav-item" role="presentation"><a class="nav-link active" href="#tabs-1-1" data-toggle="tab"><span class="icon mdi mdi-information-outline"></span><span><?=$pageData->label->label->info->title?></span></a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tabs-1-2" data-toggle="tab"><span class="icon mdi mdi-map"></span><span><?=$pageData->label->label->visiting_place->title?></span></a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tabs-1-3" data-toggle="tab"><span class="icon mdi mdi-map-marker"></span><span><?=$pageData->label->label->location->title?></span></a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tabs-1-4" data-toggle="tab"><span class="icon mdi mdi-image-filter"></span><span><?=$pageData->label->label->gallery->title?></span></a></li>
          </ul>
          <!-- Tab panes-->
          <div class="tab-content">
          		<div class="tab-pane fade show active" id="tabs-1-1">
               		<div class="container">
                        <div class="row row-30 justify-content-center justify-content-md-left">
                          <div class="col-lg-12">
           						<?=$pageData->data->content->item['description']?>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-1-2">
                	<div class="container">
                    	<div class="row row-50">
                        	<div class="col-lg-12">
                            	  <section class="section section-xs bg-gray-100 text-center">
                                    <div class="container">         
                                        <?=$places?>
                                    </div>
                                  </section>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-1-3">
                	<div class="container">
                    	<div class="row row-30 justify-content-center justify-content-md-left flex-lg-row-reverse align-items-xl-center">
                            <div class="col-lg-12">
                              <?=$pageData->data->content->item['map']?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-1-4">
                	<div class="container">
                        <div class="row row-30 justify-content-center justify-content-md-left flex-lg-row-reverse align-items-xl-center">
                            <div class="col-lg-12">
                              <h3>Photo Gallery</h3>
                              <div class="row row-6 row-x-6" data-lightgallery="group">
                                <?=$item_gallery?>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-1-5">
                tabs-1-5
                </div>
          </div>
       </div>
</section>
      