<?php

$web_config=web_config(array('thumbnail_path','no_pic'));
$thumbnail_path = $web_config['thumbnail_path']; $default_img = $web_config['no_pic']; 
$listitem='';
foreach($pageData->data->content->listitem as $key=>$value){					
	$encrypted_id = encode($value['id']);					
	$filenames = json_decode($value['filenames']);
	$pic = count($filenames)?$thumbnail_path.$filenames[0]->filename:$default_img;
	$des = strip_tags($value['description_t']==''?$value['description']:$value['description_t']);
	$des = (mb_strlen($des,"utf-8")>100)?(mb_substr($des,0,100,"utf-8").'...'):$des;
	$url='/'.$pageData->lang->selected.$pageData->label->label->item_view->url.'/'.$encrypted_id;
	$loc_url='/'.$pageData->lang->selected.$pageData->label->label->item_list->url.'&loc='.$value['provincecity'];
	$type_url='/'.$pageData->lang->selected.$pageData->label->label->item_list->url.'&type='.$value['typecode'];
	$listitem.= '<article class="tour-modern">
					<div class="tour-modern-media"><a class="tour-modern-figure" href="'.$url.'"><img class="tour-modern-image" src="'.$pic.'" alt="" width="358" height="450"/></a>
					  
					</div>
					<div class="tour-modern-main">
					  <h4 class="tour-modern-title"><a href="'.$url.'">'.$value['itemname'].'</a></h4>
					  <div class="tour-modern-info">
						<p class="tour-modern-rating">'.$value['cate_title'].'</p>
					  </div>
					  '.$des.'
					  <ul class="tour-modern-meta">
						<li><a href="'.$loc_url.'"><span class="icon mdi mdi-map-marker"></span> <span>'.$value['provincecity_name'].'</span></a></li>
						<li><a href="'.$type_url.'"><span class="icon mdi fa-tags"></span> <span>'.$value['typename'].'</span></a></li>
					  </ul>
					</div>
				  </article>';  
}

$typefilter=$typeselect='';
foreach($pageData->data->content->typelist as $value){
	$typefilter_url = '/'.$pageData->lang->selected.$pageData->label->label->item_list->url.'&type='.$value->code;
	$typefilter.='<li><a class="'.($value->selected?'active':'').'" href="'.$typefilter_url.'">'.$value->icon.'<span>'.$value->title.'</span></a></li>';
	
	$typeselect.= '<li><label class="checkbox-inline">
										<input type="checkbox" name="type[]"  value="'.$value->code.'" '.($value->selected?'checked':'').'>'.$value->title.'
									  </label></li>';
}


?>
<section class="section filters">
    <button class="filters-toggle button" data-multitoggle="#filters" data-scope=".filters-toggle">Filter</button>
    <ul class="filters-list" id="filters">
      <?=$typefilter?>
    </ul>
</section>



<section class="section section-sm bg-gray-100">
    <div class="container">
      <div class="row row-30 row-xl-50 flex-lg-row-reverse">
        <div class="col-lg-4">
          <div class="block-custom-centered">
            <div class="box-4-outer">
              <button class="box-4-toggle" data-multitoggle="#box-4" data-scope=".box-4-outer" aria-label="Filter Toggle"><span><?=$pageData->label->label->search->title?></span><span class="icon mdi mdi-magnify"></span></button>
              <article class="box-4" id="box-4">
                <div class="box-4-inner">
                  <h4><?=$pageData->label->label->search->title?></h4>
                  <!-- RD Mailform-->
                  <form class="rd-form form-lg" action="/<?=$pageData->lang->selected.$pageData->label->label->item_list->url?>">
                    <div class="form-wrap form-wrap-icon">
                      <label class="form-label form-label-outside" for="form-txt"><?=$pageData->label->label->search_name->title?></label>
                      <input class="form-input" id="form-txt" type="text" name="txt" value="<?=$pageData->data->content->searchtxt?>">
                      <div class="icon form-icon mdi mdi-magnify"></div>
                    </div>
                    <div class="form-wrap form-wrap-icon">
                      <select class="form-input" id="form-loc" type="text" name="loc">
                      	<option value=""><?=$pageData->label->label->select_option->title?></option>
                        <?php
							foreach($pageData->data->content->locationlist as $value){
								echo '<option value="'.$value['id'].'" '.($value['selected']?'selected':'').'>'.$value['provincecity_name'].'</option>';
							}
						?>
                      </select>
                      <div class="icon form-icon mdi mdi-map-marker"></div>
                    </div>
                    <h5>Type</h5>
                    <div class="form-wrap mt-md-30">
                      <ul class="list-sm">
                      	<?=$typeselect?>
                      </ul>
                    </div>
                    <h5 class="<?=(!count($pageData->data->content->catelist)?'d-none':'')?>">Category</h5>
                    <div class="form-wrap mt-md-30">
                      <ul class="list-sm">
                        <?php
                            foreach($pageData->data->content->catelist as $value){
								echo '<li>'.$value['typename'].'</li>';
								foreach($value['item'] as $v){
									echo '<li><label class="checkbox-inline">
											<input type="checkbox" name="cate[]"  value="'.$v->code.'" '.($v->selected?'checked':'').'>'.$v->title.'
										  </label></li>';
								}
                            }
                        ?>
                      </ul>
                    </div>
                    <div class="form-wrap mt-xl-55">
                      <button class="button button-lg button-primary button-block" type="submit"><?=$pageData->label->label->search->title?></button>
                    </div>
                  </form>
                </div>
              </article>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <?=($listitem<>''?$listitem:'<div class="rd-search-results"><div class="search-list"><div class="txtCenter">No results found <span class="'.($pageData->data->content->searchtxt==''?'d-none':'').'">for "<span class="search">'.$pageData->data->content->searchtxt.'</span>"</span><div></div></div></div></div>')?>
          <nav class="pagination-outer text-center">
            <ul class="pagination">
            	<?php
					$pagination='';$numpage=2;
					$cpage=$pageData->data->content->pagination['cpage'];
					$tpage=$pageData->data->content->pagination['tpage'];
					$currenturl=$pageData->data->content->pagination['currenturl'];
					
					//$tpage=1;$cpage=1;
				
					$pagepadfrom=($cpage-$numpage>1)?($cpage-$numpage):2;
					$pagepadto=($cpage+$numpage<$tpage)?($cpage+$numpage):($tpage-1);
					//if($tpage>(($numpage*2)+2)){
						if($pagepadfrom>2){$pagination.='<li class="page-item ">...</li>';}
						for($i=$pagepadfrom;$i<=$pagepadto;$i++){$pagination.='<li class="page-item '.($cpage==$i?'active':'').'"><a class="page-link '.($cpage==$i?'disabled':'').'" href="'.($cpage==$i?'javascript:void(0)':$currenturl."&page=$i").'">'.enNum_khNum($i).'</a></li>';}
						if($pagepadto<($tpage-1)){$pagination.='<li class="page-item ">...</li>';}
					//}					
				?>
              <li class="page-item <?=($cpage==1?'active':'')?> <?=($tpage==0?'d-none':'')?>"><a class="page-link <?=($cpage==1?'disabled':'')?>" href="<?=($cpage==1?'javascript:void(0)':$currenturl."&page=1")?>"><?=enNum_khNum(1)?></a></li>
              <?=$pagination?>
              <li class="page-item <?=($cpage==$tpage?'active':'')?> <?=($tpage>1?'':'d-none')?>"><a class="page-link <?=($cpage==$tpage?'disabled':'')?>" href="<?=($cpage==$tpage?'javascript:void(0)':$currenturl."&page=$tpage")?>"><?=enNum_khNum($tpage)?></a></li>
            </ul>
          </nav>
        </div>
      </div>
</section>
