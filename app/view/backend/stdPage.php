<?php include('app/view/'.$dir.'layout/base.php');?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
<?php include('app/view/'.$dir.'layout/meta.php');?>
<?php include('app/view/'.$dir.'layout/stylesheet.php');?>
</head>
<?php if($sn){?>
<div id="fb-root"></div>
<script>(function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id))return;js=d.createElement(s);js.id=id;js.src="//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=238252776219787&version=v2.0";fjs.parentNode.insertBefore(js,fjs);}(document,'script','facebook-jssdk'));</script>
<!-- Place this tag after the last share tag. -->
<script type="text/javascript">(function(){var po=document.createElement('script');po.type='text/javascript';po.async=true;po.src='https://apis.google.com/js/platform.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(po,s);})();</script>
<?php }?>

<body>


<body class="">
<?php if(isset($pageData->data->component->topinfo)) include('app/view/'.$dir.'layout/topinfo.php');?>
<?php $col_sidebar_sm=3;$col_sidebar_md=2;include('app/view/'.$dir.'layout/user_menu.php');?>

<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php include('app/view/'.$dir.'layout/breadcrumb.php');?>
	<!-- MAIN CONTENT -->
	<div id="content">
		<?php include ('app/view/'.$dir.'content/'.$more_dir.$pageData->fileview.'.php');?>
	</div>
</div>

<?php include('app/view/'.$dir.'layout/copyright.php');?>
<?php include('app/view/'.$dir.'layout/script.php');?>
<?=isset($late_script_file)?$late_script_file:''?>
<script>
	jQuery(document).ready(function() {
		<?php if(isset($late_script)){echo $late_script;} ?>
	});
</script>

</body>
</html>
