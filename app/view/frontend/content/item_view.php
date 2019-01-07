<?php
$nearby='';$item_gallery=$places='';
$web_config=web_config(array('resized_pic_path','thumbnail_path','no_pic'));
$pic_path = $web_config['resized_pic_path'];$thumbnail_path = $web_config['thumbnail_path'];$no_pic = $web_config['no_pic'];
$filenames = json_decode($pageData->data->content->item['filenames']);$secondImg=$feature_img;
$isEvent = $pageData->data->content->item['typename']=='events';
$all_nearby=$isEvent?$pageData->label->menu->events_list->url:$pageData->label->label->item_list->url;
foreach($filenames as $k=>$v){
	$secondImg=($k==1)?$thumbnail_path.$v->filename:$secondImg;
	$item_gallery.='<div class="col-3"><a class="thumbnail-light" href="'.$pic_path.$v->filename.'" data-lightgallery="item"><img class="thumbnail-light-image" src="'.$thumbnail_path.$v->filename.'" alt="" width="355" height="359"/></a></div>';
}
$from_des=explode(',',$pageData->data->content->item['map']);
foreach($pageData->data->content->nearby as $key=>$value){
	$item=$value;
	$filenames = json_decode($item['filenames']);
	$nearby_img = count($filenames)?$thumbnail_path.$filenames[0]->filename:$no_pic;
	$nearby_des = strip_tags($item['description']);
	$nearby_des = (mb_strlen($nearby_des,"utf-8")>50)?(mb_substr($nearby_des,0,50,"utf-8").'...'):$nearby_des;
	
	//get distance and time
	$to_des=explode(',',$value['map']);
	//$dist = GetDrivingDistance(10.574031, 10.636881, 103.303766, 103.535450);
	$dist = GetDrivingDistance($from_des[0], $to_des[0], $from_des[1], $to_des[1]);
   // echo 'Distance: <b>'.$dist['distance'].'</b><br>Travel time duration: <b>'.$dist['time'].'</b>';
   
   	//additional info
	if($isEvent){
	$ad_info='<div class="tour-classic-footer">
				<div class="tour-classic-footer-left">
				  <p class="tour-classic-rating">'.khmerDate($value['start_date']).'</p>
				</div>
				<div class="tour-classic-footer-right">
				  <div class="object-inline"><span class="icon mdi mdi-calendar-today text-gray-800"></span><span>'.$value['days'].' '.($value['days']>1?'days':'day').'</span></div>
				</div>
			  </div>';
	}else{$ad_info='';}
			
	$item_url = '/'.$pageData->lang->selected.$pageData->label->label->item_view->url.'/'.encode($value['id']);
	$nearby.='<div class="col-sm-6 col-lg-4">
				  <article class="tour-classic">
					<div class="tour-classic-media"><a class="tour-classic-figure" href="'.$item_url.'"><img class="tour-classic-image" src="'.$nearby_img.'" alt="" width="365" height="248"/></a>
					  <div class="tour-classic-pricing">
						<p class="tour-classic-price tour-classic-price-new" data-toggle="tooltip" data-placement="top" title="">'.$dist['distance'].' '.$dist['time'].'</p>
					  </div>
					</div>
					<div class="tour-classic-body">
					  <h4 class="tour-classic-title"><a href="'.$item_url.'">'.$value['title'].'</a></h4>
					  <p class="tour-classic-caption">'.$nearby_des.'</p>
					  '.$ad_info.'
					</div>
				  </article>
				</div>';
}
if(!count($pageData->data->content->nearby)){$nearby='<br /><div class="alert alert-info">'.$pageData->label->label->no_data->title.'</div>';}
else{$nearby='<div class="row row-30 row-xl-50 mt-md-60 mt-lg-80">'.$nearby.'</div>';}
//other nearby listing
foreach($pageData->data->content->places as $k=>$v){
	if(!count($v->item)){continue;}
	$places.='<h3>'.$v->title.'</h3><div class="row row-30">';
	foreach($v->item as $key=>$value){
		$item=$value;
		$filenames = json_decode($item['filenames']);
		$places_img = count($filenames)?$thumbnail_path.$filenames[0]->filename:$no_pic;
		$places_des = strip_tags($item['description']);
		$places_des = (mb_strlen($places_des,"utf-8")>50)?(mb_substr($places_des,0,50,"utf-8").'...'):$places_des;		
		$item_url = '/'.$pageData->lang->selected.$pageData->label->label->item_view->url.'/'.encode($value['id']);
		
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
		
		$places.=' <div class="col-sm-6 col-lg-4 mgn0">
					  <article class="tour-classic">
						<div class="tour-classic-media"><a class="tour-classic-figure" href="'.$item_url.'"><img class="tour-classic-image" src="'.$places_img.'" alt="" width="365" height="248"/></a>
						  <div class="tour-classic-pricing">
							<p class="tour-classic-price tour-classic-price-new" data-toggle="tooltip" data-placement="top" title="">'.$value['distance'].'</p>
						  </div>
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
	
	$all_list_url = $v->code=='events'?$pageData->label->menu->events_list->url.'&loc='.$pageData->data->content->item['provincecity']:$pageData->label->label->item_list->url.'&loc='.$pageData->data->content->item['provincecity'].'&type='.$v->code;
	
	$places.='</div><a class="button button-1 wow fadeIn v_mgn25" href="/'.$pageData->lang->selected.$all_list_url.'">'.$pageData->label->label->see_all->title.'</a> ';
}

?>

<section class="section">
        <!-- Bootstrap tabs -->
        <div class="tabs-custom tabs-complex" id="tabs-1">
          <button class="tabs-complex-nav-toggle" data-multitoggle="#tabs-complex-nav" data-isolate="#tabs-complex-nav"><span>Navigation</span><span class="icon mdi mdi-chevron-down"></span></button>
          <!-- Nav tabs-->
          <ul class="nav nav-tabs" id="tabs-complex-nav">
            <li class="nav-item" role="presentation"><a class="nav-link active" href="#tabs-1-1" data-toggle="tab"><span class="icon mdi mdi-information-outline"></span><span><?=$pageData->label->label->info->title?></span></a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tabs-1-2" data-toggle="tab"><span class="icon mdi mdi-map"></span><span><?=$pageData->label->label->nearby_places->title?></span></a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tabs-1-3" data-toggle="tab"><span class="icon mdi mdi-map-marker"></span><span><?=$pageData->label->label->location->title?></span></a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tabs-1-4" data-toggle="tab"><span class="icon mdi mdi-image-filter"></span><span><?=$pageData->label->label->gallery->title?></span></a></li>
          </ul>
          <!-- Tab panes-->
          <div class="tab-content">
          		<div class="tab-pane fade show active" id="tabs-1-1">
               		<div class="container">
                        <div class="row row-30 justify-content-center justify-content-md-left">
                          <div class="col-lg-12">
                          		<img class="img-responsive v_pad10 d-md-none" src="<?=$secondImg?>" />
                          	 	<img class="float-r pad10 d-none d-md-block" src="<?=$secondImg?>" width="50%" />
           						<?=$pageData->data->content->item['description']?>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-1-2">
                	<div class="container">
                    	<div class="row row-50">
                        	<div class="col-lg-12 txtCenter">
                            	<?=$places?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-1-3">
                	<div class="container">
                    	<div class="row row-30 justify-content-center justify-content-md-left flex-lg-row-reverse align-items-xl-center">
                            <div class="col-lg-12">
                              <h3><?=$pageData->label->label->transport->title?></h3>
                              <?=$pageData->data->content->item['transportation_info']?>
                            </div>
                        </div>
                        <div class="row row-30 justify-content-center justify-content-md-left flex-lg-row-reverse align-items-xl-center">
                            <div class="col-lg-4 col-xl-5">
                              <div class="inset-2">
                                <h3><?=$pageData->label->label->contact->title?></h3>
                                <?=$pageData->data->content->item['contact_info']?>
                              </div>
                            </div>
                            <div class="col-lg-8 col-xl-7">
                                <div id="map" style="width:100%; height:300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-1-4">
                	<div class="container">
                        <div class="row row-30 justify-content-center justify-content-md-left flex-lg-row-reverse align-items-xl-center">
                            <div class="col-lg-12">
                              <div class="row row-6 row-x-6" data-lightgallery="group">
                                <?=$item_gallery?>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
       </div>
</section>
  
  <section class="section section-xs bg-gray-100 text-center">
        <div class="container">
          <h3><?=$pageData->label->label->nearby->title?></h3>
          <?=$nearby?>
          </div><a class="button button-1 wow fadeIn v_mgn25" href="/<?=$pageData->lang->selected.$all_nearby?>"><?=$pageData->label->label->see_all->title?></a>
        </div>
      </section>
<?php
//$late_script_file='<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCk68AIicPkiiERUM-IOGRAh08dYznWz2s&callback=initMap"></script>';

echo '<script> 
				var map,markersArray = [],default_location=['.$pageData->data->content->item['map'].'];
				function initMap() 
				{
					var latlng = new google.maps.LatLng(default_location[0], default_location[1]);
					var myOptions = {
						zoom: default_location[2],
						center: latlng,				
						mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					map = new google.maps.Map(document.getElementById("map"), myOptions);
		
					// place a marker
					placeMarker(new google.maps.LatLng(default_location[0], default_location[1]));		
					  
				}
				function placeMarker(location) {
					// first remove all markers if there are any
					deleteOverlays();
		
					var marker = new google.maps.Marker({
						position: location, 
						draggable: false,
						animation: google.maps.Animation.DROP,
						map: map
					});
		
					// add marker in markers array
					markersArray.push(marker);
		
					//map.setCenter(location);
					
					google.maps.event.addListener(marker, "dragend", function(event){
						// display the lat/lng in your form\'s lat/lng fields
						document.getElementById("lat").value = event.latLng.lat();
						document.getElementById("lng").value = event.latLng.lng();
						document.getElementById("zoom").value = map.getZoom();
						//map.setCenter(event.latLng);
					});
				}
		
				// Deletes all markers in the array by removing references to them
				function deleteOverlays() {
					if (markersArray) {
						for (i in markersArray) {
							markersArray[i].setMap(null);
						}
					markersArray.length = 0;
					}
				}

</script> ';

?>
      