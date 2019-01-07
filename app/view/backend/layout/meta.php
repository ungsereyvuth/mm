<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="<?=$pagetitle?> - <?=$pageData->label->system_title->sys->title?>" />
<meta name="description" content="<?=$pagetitle?> - <?=$pageData->label->system_title->sys->title?>" />
<meta name="author" content="<?=$pageData->label->system_title->sys->title?>">    

<!--Facebook Meta-->

<meta property="og:site_name" content="<?=$pageData->label->system_title->sys->title?>"/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="<?='http://'.$_SERVER['HTTP_HOST'].$feature_img?>"/>
<meta property="og:title" content="<?=$pagetitle?> - <?=$pageData->label->system_title->sys->title?>"/>
<meta property="og:url" content="<?="http://$_SERVER[HTTP_HOST]".strtok($_SERVER["REQUEST_URI"],'?')?>"/>
<meta property="og:description" content="<?=$feature_des?>"/>
<!--End of Facebook Meta-->    

<!-- Favicon -->
<title><?=$pagetitle?> - <?=$pageData->label->system_title->sys->title?></title>