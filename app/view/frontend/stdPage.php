<?php include('app/view/'.$dir.'layout/base.php');?>
<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
<head>
<?php include('app/view/'.$dir.'layout/meta.php');?>
<?php include('app/view/'.$dir.'layout/stylesheet.php');?>
<?=$pageData->page_style?>
</head>
<?php if($sn){?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=1061675323904210';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- Place this tag after the last share tag. -->
<script type="text/javascript">(function(){var po=document.createElement('script');po.type='text/javascript';po.async=true;po.src='https://apis.google.com/js/platform.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(po,s);})();</script>
<?php }?>

<body>
	
<?php if(isset($pageData->data->component->topinfo)) include('app/view/'.$dir.'layout/topinfo.php');?>
<?php if(isset($pageData->data->component->frontend_menu)) include('app/view/'.$dir.'layout/menu.php');?>

<?php if(isset($pageData->data->component->slider)) include('app/view/'.$dir.'layout/slider.php');?>	
<?php if(isset($pageData->data->component->breadcrumb)) include('app/view/'.$dir.'layout/breadcrumb.php');?>


<?php
	$col_sidebar=0;$user_menu=$sidebar=false;
	if(isset($pageData->data->component->user_menu)){$col_sidebar=3;$user_menu=true;}
	elseif(isset($pageData->data->component->sidebar)){$col_sidebar=3;$sidebar=true;}
?>

<?php include ('app/view/'.$dir.'content/'.$pageData->fileview.'.php');?> 

<?php if($user_menu) {include('app/view/'.$dir.'layout/user_menu.php');}?>
<?php if($sidebar) {include('app/view/'.$dir.'layout/sidebar.php');}?>        



<?php if(isset($pageData->data->component->footer_info)) include('app/view/'.$dir.'layout/footer_info.php');?>
<?php if(isset($pageData->data->component->footer)) include('app/view/'.$dir.'layout/footer.php');?>

	
<?php include('app/view/'.$dir.'layout/script.php');?>
<?=$pageData->page_script?>
<?=isset($late_script_file)?$late_script_file:''?>
<script>
	jQuery(document).ready(function() {
		<?php if(isset($late_script)){echo $late_script;} ?>
	});
</script>
</body>
</html>
