<?php
$data = $pageData->data->content->datainfo;
$certificatename_kh=$data[0]['certificate_name_kh'];
$certificatename_en=$data[0]['certificate_name_en'];
$certificatename_cn=$data[0]['certificate_name_cn'];
$datastr = '';
foreach($data as $value){	
	$val = $value['value'];
	if($value['code']=='date_kh'){$val = khmerDate($value['value']);}
	$datastr .= '<div style="border-bottom:1px solid #eaeaea;" class="v_pad5"><u class="bluecolor bold">'.$value['title'].'</u> '.$val.'</div>';
}

?>
<div class="container content-sm">
<div class="log-reg-v3">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="page_content">
                	<div class="txtCenter">
                    	<img src="/assets/frontend/img/logo/logo_mot.png" width="100" />
                        <h3 class="khmerTitle txtCenter blackcolor"><?=$certificatename_kh?></h3>
                        <span class="txtCenter fs17"><?=($certificatename_en<>''?$certificatename_en:$certificatename_cn)?></span>
                    </div>
                    <div class="txtCenter v_pad10"><img src="/assets/frontend/img/divider_vector.png" width="200" /></div>
                    <div class="h_pad10">
                    	<?=$datastr?>                    
                    </div>
                    <br />
                    <div class="txtCenter">
                    	<img style="width:150px; height:150px;" src="http://chart.apis.google.com/chart?chs=250x250&cht=qr&chld=L|0&chl=<?=$pageData->data->content->profile_url?>" />                    </div>
                </div>
           	 </div>
        </div><!--/end row-->
</div>
<!--=== End Login ===-->
</div>