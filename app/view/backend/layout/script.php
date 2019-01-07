<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script data-pace-options='{ "restartOnRequestAfter": true }' src="/assets/backend/js/plugin/pace/pace.min.js"></script>

<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
	if (!window.jQuery) {
		document.write('<script src="/assets/backend/js/libs/jquery-3.2.1.min.js"><\/script>');
	}
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
	if (!window.jQuery.ui) {
		//document.write('<script src="/assets/backend/js/libs/jquery-ui.min.js"><\/script>');
	}
</script>

<!-- IMPORTANT: APP CONFIG -->
<script src="/assets/backend/js/app.config.js"></script>

<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
<script src="/assets/backend/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 

<!-- BOOTSTRAP JS -->
<script src="/assets/backend/js/bootstrap/bootstrap.min.js"></script>

<!-- CUSTOM NOTIFICATION -->
<script src="/assets/backend/js/notification/SmartNotification.min.js"></script>

<!-- JARVIS WIDGETS -->
<script src="/assets/backend/js/smartwidgets/jarvis.widget.min.js"></script>

<!-- EASY PIE CHARTS -->
<script src="/assets/backend/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

<!-- SPARKLINES -->
<script src="/assets/backend/js/plugin/sparkline/jquery.sparkline.min.js"></script>

<!-- JQUERY VALIDATE -->
<script src="/assets/backend/js/plugin/jquery-validate/jquery.validate.min.js"></script>

<!-- JQUERY MASKED INPUT -->
<script src="/assets/backend/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

<!-- JQUERY SELECT2 INPUT -->
<script src="/assets/backend/js/plugin/select2/select2.min.js"></script>

<!-- JQUERY UI + Bootstrap Slider -->
<script src="/assets/backend/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

<!-- browser msie issue fix -->
<script src="/assets/backend/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

<!-- FastClick: For mobile devices -->
<script src="/assets/backend/js/plugin/fastclick/fastclick.min.js"></script>

<!--[if IE 8]>

<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

<![endif]-->

<!-- Demo purpose only -->
<script src="/assets/backend/js/demo.min.js"></script>

<!-- MAIN APP JS FILE -->
<script src="/assets/backend/js/app.min.js"></script>
	
<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
<!-- Voice command : plugin -->
<script src="/assets/backend/js/speech/voicecommand.min.js"></script>

<!-- SmartChat UI : plugin -->
<script src="/assets/backend/js/smart-chat-ui/smart.chat.ui.min.js"></script>
<script src="/assets/backend/js/smart-chat-ui/smart.chat.manager.min.js"></script>

<!-- //get some existing scripts from frontend-->
<script src="/assets/frontend/plugins/chosen/chosen.jquery.js"></script>
<!--<script src="/assets/frontend/plugins/datepicker/bootstrap-datetimepicker.min.js"></script>-->
<script src="/assets/backend/js/plugin/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>

<script src="/assets/frontend/plugins/tipsy-master/jquery.tipsy.js"></script>
<script src="/assets/frontend/plugins/prettyphoto/js/jquery.prettyPhoto.js"></script>
<!-- <script src="/assets/frontend/plugins/tinymce/tinymce.min.js"></script> -->
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=dp06kf21f73g4tv44g4xxou5ex4002laebvlhgouh5h5n4oc"></script>
<script>
	if (!window.tinymce) {
		document.write('<script src="/assets/frontend/plugins/tinymce/tinymce.min.js"><\/script>');
	}
</script>
<script src="/assets/frontend/plugins/printThis/printThis.js"></script>

<script src="/assets/backend/js/plugin/jquery-nestable/jquery.nestable.min.js"></script>

<!-- JS Customization -->
<script src="/assets/backend/js/custom.js"></script>



<script>

$(document).ready(function() {
	
	pageSetUp();
	
});

</script>
