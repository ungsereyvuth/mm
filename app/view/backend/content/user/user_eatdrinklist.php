<?php
$listname='user_eatdrinklist';
$formkey='neweatdrink';
$formkey2='neweatdrinktranslate';
?>

<section id="widget-grid" class="">
    <!-- row -->
    <div class="row">
    	<article class="col-sm-6 col-lg-7">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="<?=$listname?>_wid" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false">
                <header>
                    <h2 class="khmerNormal"><?=$pageData->label->label->user_destinationlist->title?></h2>   
                    <div class="widget-toolbar">
                        <div class="btn-group">
                            <button class="btn btn-xs btn-default switch_list_filters" data-list="<?=$listname?>">
                               <i class="fa fa-search"></i> Filter
                            </button>                            
                        </div>
                    </div> 
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <div class="widget-body">                        
                        <div class="datalist txtLeft pad10" id="<?=$listname?>">
							<div class="list_filters hidden">
                            <?=$pageData->data->content->search_inputs?>
                            </div>
                            <?php include("app/view/frontend/layout/pagination_info.php"); ?>
                            <table width="100%" class="mytable" >
                                <thead>
                                    <tr><th style="width:50px;" class="txtCenter">No.</th><th>Title</th><th style="width:70px;" class="txtCenter">Tools</th></tr>
                                </thead>
                                <tbody></tbody>
                            </table> 
                            <?php include("app/view/frontend/layout/listPagination.php");?>  
                        </div> 	
                    </div>
                </div>
            </div>
        </article>
        <article class="col-sm-6 col-lg-5">
        	<div class="jarviswidget" id="<?=$formkey2?>_wid" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false">
                <header>
                    <h2 class="khmerNormal"><i class="fa fa-language"></i> <?=$pageData->label->label->translate->title?></h2>   
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <div class="widget-body">
                    	  <form class="ajaxfrm smart-form hidden" role="form" id="<?=$formkey2?>-form" data-func="submit_form" data-reset="1" data-removable="1" action="" method="post">
                            	<fieldset>
                                        <div class="row">
                                            <section class="col col-md-6">
                                            	<label class="label">Language</label>                                       
                                                <label class="select">
                                                    <select name="language_id">
                                                        <option value="" disabled>--- Language ---</option>
                                                    	<?=$pageData->data->content->lang_options?>
                                                    </select>
                                                </label>                                                
                                            </section> 
                                            <section class="col col-md-6">
                                            	<div class="btm_border_gray">
                                                    <label class="toggle">
                                                        <input type="checkbox" name="active" checked>
                                                        <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Active
                                                    </label>
                                                </div>
                                                <div id="active_msg"></div>
                                            </section>
                                        </div>                 
                                        <div class="row">
                                            <section class="col col-md-12">                                       
                                                <label class="input">
                                                    <input type="text" name="main_title" placeholder="Title" readonly>
                                                </label>
                                            </section>                            
                                        </div>                 	
                                        <div class="row">
                                            <section class="col col-md-6">                                     
                                                <label class="input">
                                                    <input type="text" name="title_t" placeholder="Translated Title">
                                                </label>
                                            </section>  
                                            <section class="col col-md-6">                                       
                                                <label class="input">
                                                    <input type="text" name="address_t" placeholder="<?=$pageData->label->label->address->title?>">
                                                </label>
                                            </section>                            
                                        </div>                 	
                                        <div class="row">
                                            <section class="col col-md-12">
                                                <textarea class="richtext" name="description_t" placeholder="<?=$pageData->label->label->description->title?>"></textarea>
                                            </section>                            
                                        </div>
                                        <div class="row">
                                            <section class="col col-md-12">
                                                <textarea class="minRichText" name="transportation_info_t" placeholder="<?=$pageData->label->label->transport->title?>"></textarea>
                                            </section>                            
                                        </div>
                                        <div class="row">
                                            <section class="col col-md-12">
                                                <textarea class="minRichText" name="contact_info_t" placeholder="<?=$pageData->label->label->contact->title?>"></textarea>
                                            </section>                            
                                        </div> 
                               </fieldset>     
                               <footer>      
                                    <input class="removable" type="hidden" name="recordid" value="" />
                                    <input type="hidden" name="cmd" value="<?=$formkey2?>" />
                                    <button class="btn btn-primary btn-sm" type="submit">Save</button>
                                    <button class="btn btn-default btn-sm reset_btn" type="reset">Cancel</button>
                                </footer>
                                <fieldset>
                                     <div class="row">
                                        <section class="col col-md-12">
                                            <div id="<?=$formkey2?>_msg" data-loadtxt='<?=htmlspecialchars($pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title)?>'></div>
                                        </section>
                                    </div>
                                </fieldset> 
                        </form>
                    </div>
                </div>
            </div> 
            
        	<div class="jarviswidget" id="<?=$formkey?>_wid" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false">
                <header>
                    <h2 class="khmerNormal"><i class="fa fa-user-plus"></i> New/Update <?=$pageData->label->listing->eatdrink->title?> (<?=$pageData->lang->defaultName?>)</h2>   
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->
                    </div>
                    <div class="widget-body">
                    	  <form class="ajaxfrm smart-form realtime-upload" role="form" id="<?=$formkey?>-form" data-func="submit_form" data-reset="1" data-removable="0" action="" method="post">
                            	<fieldset>
                                    <div class="row">
                                        <section class="col col-sm-6">   
                                        	<label class="label"><?=$pageData->label->label->des_name->title?></label>                                      
                                            <label class="input">
                                                <input type="text" name="title" placeholder="<?=$pageData->label->label->des_name->title?>">
                                            </label>
                                        </section>
                                        <section class="col col-sm-6">
                                        	<label class="label"><?=$pageData->label->label->type->title?></label>  
                                        	<label class="select">
                                                <select class="chosen-select" name="cate_id[]" data-placeholder="<?=$pageData->label->label->type->title?>" multiple>
                                                    <?=$pageData->data->content->cateopt?>
                                                </select>
                                            </label> 
                                            <div id="cate_id_msg"></div>                                          
                                        </section>
                                    </div>  
                                    <div class="row">
                                        <section class="col col-sm-6"> 
                                        	<label class="label"><?=$pageData->label->label->address->title?></label>                                        
                                            <label class="input">
                                                <input type="text" name="address" placeholder="<?=$pageData->label->label->address->title?>">
                                            </label>
                                        </section>
                                        <section class="col col-sm-6">
                                        	<label class="label"><?=$pageData->label->label->provincecity->title?></label>  
                                            <label class="select">
                                                <select name="provincecity">
                                                    <option value="0"><?=$pageData->label->label->select_option->title?></option>
                                                    <?=$pageData->data->content->locationopt?>
                                                </select><i></i>
                                            </label>
                                        </section>
                                    </div>  
                                    <div class="row">
                                        <section class="col col-sm-6"> 
                                        	<label class="label"><?=$pageData->label->label->price->title?> (<?=$pageData->label->label->min->title.' - '.$pageData->label->label->in_usd->title?>)</label>                                        
                                            <label class="input">
                                                <input type="number" name="price_from" placeholder="<?=$pageData->label->label->price->title?>">
                                            </label>
                                        </section>
                                        <section class="col col-sm-6"> 
                                        	<label class="label"><?=$pageData->label->label->price->title?> (<?=$pageData->label->label->max->title.' - '.$pageData->label->label->in_usd->title?>)</label>                                        
                                            <label class="input">
                                                <input type="number" name="price_to" placeholder="<?=$pageData->label->label->price->title?>">
                                            </label>
                                        </section>
                                    </div>  
                                    <div class="row">
                                        <section class="col col-xs-12">    
                                        	<label class="label"><?=$pageData->label->label->description->title?></label>                    
                                            <label class="textarea textarea-resizable">								
                                                <textarea rows="3" class="richtext" name="description" placeholder="<?=$pageData->label->label->description->title?>"></textarea> 
                                            </label>  
                                        </section>
                                    </div>
                                    <div class="row">
                                        <section class="col col-xs-12">      
                                        	<label class="label"><?=$pageData->label->label->transport->title?></label>                  
                                            <label class="textarea textarea-resizable"> 										
                                                <textarea rows="3" class="minRichText" name="transportation_info" placeholder="<?=$pageData->label->label->transport->title?>"></textarea> 
                                            </label>  
                                        </section>
                                    </div> 
                                    <div class="row">
                                        <section class="col col-xs-12"> 
                                        	<label class="label"><?=$pageData->label->label->contact->title?></label>                       
                                            <label class="textarea textarea-resizable"> 										
                                                <textarea rows="3" class="minRichText" name="contact_info" placeholder="<?=$pageData->label->label->contact->title?>"></textarea> 
                                            </label>  
                                        </section>
                                    </div> 
                                    <div class="row">
                                        <section class="col col-xs-12">                              
                                            <div id="map" style="height: 350px;width:100%;margin: 20px 0;"></div>  
                                            <div><input type="hidden" id="lat" name="map_lat"><input type="hidden" id="lng" name="map_lng"><input type="hidden" id="zoom" name="map_zoom"></div> 
                                        	<div id="map_msg"></div>
                                        </section>                                        
                                    </div>              
                                    <div class="row">
                                        <section class="col col-sm-6">
                                            <div class="btm_border_gray">
                                                <label class="toggle">
                                                    <input type="checkbox" name="top_attraction">
                                                    <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Top Attraction
                                                </label>
                                            </div>
                                            <div id="top_attraction_msg"></div>
                                        </section>
                                        <section class="col col-sm-6">
                                            <div class="btm_border_gray">
                                                <label class="toggle">
                                                    <input type="checkbox" name="publish_now" checked>
                                                    <i data-swchon-text="ON" data-swchoff-text="OFF"></i>Publish Now
                                                </label>
                                            </div>
                                            <div id="publish_now_msg"></div>
                                        </section>
                                    </div>                 	
                               </fieldset>  
                               <label>Attachments</label>
                              <fieldset>                                            
                                    <div class="row">       
                                        <section class="col col-xs-12">                                
                                            <div class="input input-file">
                                                <span class="button"><input type="file" id="attachment" class="realtime-upload-btn" name="attachment" onchange="this.parentNode.nextSibling.value = this.value">Add Picture</span>
                                                
                                                <input type="text" readonly placeholder="You can select only allowed file types">
                                                <input type="hidden" id="allfiles_attachment" name="filename" class="realtime-upload-allfiles">
                                                
                                            </div>
                                            <div id="selectedFile_attachment" class="thumbnail realtime-upload-selectedfile" style="display:none; margin-top:10px;"></div>
                                            <div id="filenames_msg"></div>
                                        </section>
                                        
                                    </div>                
                             </fieldset>     
                               <footer>      
                                    <input class="removable" type="hidden" name="recordid" value="" />
                        			<input type="hidden" name="cmd" value="<?=$formkey?>" />
                                    <button class="btn btn-primary btn-sm" type="submit">Save</button>
                                    <button class="btn btn-default btn-sm reset_btn" type="reset">Cancel</button>
                                </footer>
                                <fieldset>
                                     <div class="row">
                                        <section class="col col-md-12">
                                            <div id="<?=$formkey?>_msg" data-loadtxt='<?=htmlspecialchars($pageData->label->label->processing->icon.' '.$pageData->label->label->processing->title)?>'></div>
                                        </section>
                                    </div>
                                </fieldset> 
                        </form>
                    </div>
                </div>
            </div> 
        </article>
    </div>
</section>
<div id='confirmbox'></div>
<?php
echo '<script> 
		var map,markersArray = [],default_location=[11.558407583155011,104.9081039428711,12];
        function initMap(latlng,zoom)
        {
			if (latlng === undefined || latlng === null) {
				  var latlng = new google.maps.LatLng(default_location[0], default_location[1]);
			}
			if (zoom === undefined || zoom === null) {
				  var zoom=default_location[2];
			}
			           
            var myOptions = {
                zoom: zoom,
                center: latlng,				
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map"), myOptions);

            // add a click event handler to the map object
            google.maps.event.addListener(map, "click", function(event)
            {
                // place a marker
                placeMarker(event.latLng);
                // display the lat/lng in your form\'s lat/lng fields

                document.getElementById("lat").value = event.latLng.lat();
                document.getElementById("lng").value = event.latLng.lng();
				document.getElementById("zoom").value = map.getZoom();
            });
			
			map.addListener("zoom_changed", function() {
				 document.getElementById("zoom").value = map.getZoom();
			  });	
			
        }
        function placeMarker(location) {
            // first remove all markers if there are any
            deleteOverlays();

            var marker = new google.maps.Marker({
                position: location, 
				draggable: true,
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
		
		function loadmapmarker(){
			initMap(new google.maps.LatLng($("#lat").val(),$("#lng").val()),parseInt($("#zoom").val()));
			placeMarker(new google.maps.LatLng($("#lat").val(),$("#lng").val()));
		}
		
</script> 
';
$late_script_file='<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCk68AIicPkiiERUM-IOGRAh08dYznWz2s&callback=initMap"></script>';
$late_script='
		
';
?>