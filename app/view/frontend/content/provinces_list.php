<?php
$web_config=web_config(array('thumbnail_path','no_pic'));
$thumbnail_path = $web_config['thumbnail_path']; $default_img = $web_config['no_pic']; 
$typename = $pageData->data->content->typename;
//by locations
$locations='';
foreach($pageData->data->content->locations as $key=>$value){
	$allphoto=array();$rndpic=$default_img;
	$allfilenames = explode('{|}',$value['photo']);
	foreach($allfilenames as $pval){		
		$allphoto = array_merge(json_decode($pval),$allphoto);
	}
	if(count($allphoto)){$rndpic=$thumbnail_path.$allphoto[rand(0,(count($allphoto)-1))]->filename;}
	$item_des = strip_tags($value['description']);
	$item_des = (mb_strlen($item_des,"utf-8")>100)?(mb_substr($item_des,0,100,"utf-8").'...'):$item_des;
	
	//url
	if($typename<>''){
		$list_url = '/'.$pageData->lang->selected.$pageData->label->label->item_list->url.'&type[]='.$value['typecode'].'&loc='.$value['id'];
	}else{
		$list_url = '/'.$pageData->lang->selected.$pageData->label->label->province_view->url.'/'.encode($value['id']);
	}
	
	$locations.= '<div class="col-xs-3 col-sm-3 wow fadeIn">
					<article class="tour-minimal context-dark">
					  <div class="tour-minimal-inner" style="background-image: url('.$rndpic.');">
						<div class="tour-minimal-header">
						  <div class="tour-minimal-badge">'.enNum_khNum($value['total']).' '.$pageData->label->label->place->title.'</div>
						</div>
						<div class="tour-minimal-main">
						  <h4 class="tour-minimal-title"><a href="'.$list_url.'">'.$value['provincecity_name'].'</a></h4>
						</div>
						<div class="tour-minimal-caption fs12 pad10">
						  '.$item_des.'
						</div>
					  </div>
					</article>
				  </div>';
}

?>
<section class="section section-md bg-default">    
    <div class="container">
      <div class="row row-30 justify-content-center justify-content-md-left">
        <div class="col-lg-12 col-xl-12">
            <div class="row row-30 mt-xl-60">
              <?=$locations?>
            </div>
            
        </div>        
      </div>
    </div>
</section>