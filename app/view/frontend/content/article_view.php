<?php
$item = $pageData->data->content->item;$related='';
foreach($pageData->data->content->related as $key=>$value){
	$item=$value;
	$filenames = json_decode($item['filenames']);
	$related_img = count($filenames)?$thumbnail_path.$filenames[0]->filename:$no_pic;
	$related_des = strip_tags($item['description']);
	$related_des = (mb_strlen($related_des,"utf-8")>50)?(mb_substr($related_des,0,50,"utf-8").'...'):$related_des;
		
	$item_url = '/'.$pageData->lang->selected.$pageData->label->label->article_view->url.'/'.$value['code'];
	$related.='<div class="col-sm-6 col-lg-4">
				  <article class="tour-classic">
					<div class="tour-classic-media"><a class="tour-classic-figure" href="'.$item_url.'"><img class="tour-classic-image" src="'.$related_img.'" alt="" width="365" height="248"/></a>
					</div>
					<div class="tour-classic-body">
					  <h4 class="tour-classic-title"><a href="'.$item_url.'">'.$value['article_title'].'</a></h4>
					  <p class="tour-classic-caption">'.$related_des.'</p>
					</div>
				  </article>
				</div>';
}
if(!count($pageData->data->content->related)){$related='<div class="col-lg-12 txtCenter"><div class="alert alert-info">'.$pageData->label->label->no_data->title.'</div></div>';}


?>

<section class="section section-md bg-default">    
    <div class="container">
      <div class="row row-30 justify-content-center justify-content-md-left">
        <div class="col-lg-12 col-xl-12">
            <?=$item['description']?>
        </div>        
      </div>
    </div>
</section>

 <section class="section section-xs bg-gray-100 text-center">
    <div class="container">
      <h3><?=$pageData->label->label->related_article->title?></h3>
      <div class="row row-30 row-xl-50 mt-md-60 mt-lg-80">          
            <?=$related?>
      </div>
    </div>
 </section>