<?php
$tel=$email='';
if(@json_decode($pageData->label->system_title->sys->data)){
	$contact = (object) json_decode($pageData->label->system_title->sys->data);
	$tel=$contact->tel;
	$email=$contact->email;
}
?>


<div class="ie-panel"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="https://livedemo00.template-help.com/wt_prod-19282/images/ie8-panel/warning_bar_0000_us.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <div class="preloader">
      <div class="preloader-inner">
        <div class="preloader-top">
          <div class="preloader-top-sun">
            <div class="preloader-top-sun-bg"></div>
            <div class="preloader-top-sun-line preloader-top-sun-line-0"></div>
            <div class="preloader-top-sun-line preloader-top-sun-line-45"></div>
            <div class="preloader-top-sun-line preloader-top-sun-line-90"></div>
            <div class="preloader-top-sun-line preloader-top-sun-line-135"></div>
            <div class="preloader-top-sun-line preloader-top-sun-line-180"></div>
            <div class="preloader-top-sun-line preloader-top-sun-line-225"></div>
            <div class="preloader-top-sun-line preloader-top-sun-line-270"></div>
            <div class="preloader-top-sun-line preloader-top-sun-line-315"></div>
          </div>
        </div>
        <div class="preloader-bottom">
          <div class="preloader-bottom-line preloader-bottom-line-lg"></div>
          <div class="preloader-bottom-line preloader-bottom-line-md"></div>
          <div class="preloader-bottom-line preloader-bottom-line-sm"></div>
          <div class="preloader-bottom-line preloader-bottom-line-xs"></div>
        </div>
      </div>
      
   </div>