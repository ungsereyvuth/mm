// JavaScript Document
$(function() {
	//------- start chosen
	var config = {
	  '.chosen-select'           : {},
	  '.chosen-select-deselect'  : {allow_single_deselect:true},
	  '.chosen-select-no-single' : {disable_search_threshold:10},
	  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
	  '.chosen-select-width'     : {width:"95%"}	  
	}
	for (var selector in config) {$(selector).chosen(config[selector]);}
	$(".chosen-select").chosen({
		disable_search_threshold: 10,
		no_results_text: "រកមិនឃើញ!",
		width: "100%"
	  });
	//------- end chosen	 
	//$( ".datepicker" ).datepicker(); 
	//$('.dtpicker').datetimepicker({pickTime: false,startDate: new Date()});	
	//$('.dtpicker_notstrick').datetimepicker({pickTime: false});	

	//$(".dtpicker input,.dtpicker_notstrick input").focus(function(){$(this).next('span').trigger('click');});
	$('.tooltips').tipsy({gravity: $.fn.tipsy.autoNS});		
	//smooth scrolling when click on anchor link
	$('a.smooth-scroll').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
		  var target = $(this.hash);
		  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
		  if (target.length) {$('html,body').animate({scrollTop: target.offset().top}, 1000);return false;}
		}
	  });	  
	  //---start scroll to top
	  //Check to see if the window is top if not then display button
		$(window).scroll(function(){if ($(this).scrollTop() > 100) {$('.scrollToTop').fadeIn();} else {$('.scrollToTop').fadeOut();}});		
		//Click event to scroll to top
		$('.scrollToTop').click(function(){$('html, body').animate({scrollTop : 0},800);return false;});
  	 //---end scroll to top	 
	 //---start pretty photo
	 $("a[rel^='prettyPhoto']").prettyPhoto({show_title: true,social_tools:''});
	 //---end pretty photo
	 //--- start rich text editor tinymce
	 tinymce.init({
		selector: ".richtext",
		relative_urls : false,
		remove_script_host : false,
		valid_elements : '*[*]',
		//document_base_url : "http://cambodiabesthospitality.org",
		plugins: [
			"advlist autolink lists link image charmap print preview anchor",
			"searchreplace visualblocks fullscreen",
			"insertdatetime media table contextmenu paste textcolor imagetools colorpicker emoticons"
		],
		toolbar: "undo redo | styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | emoticons ",
		style_formats: [
							{title: "Headers", items: [
								{title: "Header 1", format: "h1"},
								{title: "Header 2", format: "h2"},
								{title: "Header 3", format: "h3"},
								{title: "Header 4", format: "h4"},
								{title: "Header 5", format: "h5"},
								{title: "Header 6", format: "h6"}
							]},
							{title: "Blocks", items: [
								{title: "Paragraph", format: "p"},
								{title: "Blockquote", format: "blockquote"},
								{title: "Div", format: "div"},
								{title: "Pre", format: "pre"}
							]},
							{title: "Image Styles", items: [
								{
									title: 'Image Left',
									selector: 'img',
									styles: {
										'float': 'left', 
										'margin': '0 10px 0 10px'
									}
								 },
								 {
									 title: 'Image Right',
									 selector: 'img', 
									 styles: {
										 'float': 'right', 
										 'margin': '0 0 10px 10px'
									 }
								 },
								 {title: "Width", items: [
									 {title: 'Width 10%',selector: 'img',styles: {'width': '10%'}},
									{title: 'Width 20%',selector: 'img',styles: {'width': '20%'}},
									 {title: 'Width 30%',selector: 'img',styles: {'width': '30%'}},
									{ title: 'Width 40%',selector: 'img',styles: {'width': '40%'}},
									{ title: 'Width 50%',selector: 'img',styles: {'width': '50%'}},
									{ title: 'Width 60%',selector: 'img',styles: {'width': '60%'}},
									{ title: 'Width 70%',selector: 'img',styles: {'width': '70%'}},
									{ title: 'Width 80%',selector: 'img',styles: {'width': '80%'}},
									{ title: 'Width 90%',selector: 'img',styles: {'width': '90%'}},
									{ title: 'Width 100%',selector: 'img',styles: {'width': '100%'}}
								]}								
							]}
							
					]
	 });
	 function trigger_minRichText(){
	 	tinymce.init({
			selector: ".minRichText",
			relative_urls : false,
			remove_script_host : false,
			menubar:false,
			valid_elements : '*[*]',
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks fullscreen",
				"insertdatetime media table contextmenu paste textcolor imagetools colorpicker"
			],
			toolbar: "undo redo | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | link image",
			
		 });
	 }
	 trigger_minRichText();
	 function trigger_mathinput(){
	 	tinymce.init({
			selector: ".mathinput",
			relative_urls : false,
			remove_script_host : false,
			menubar:false,
			statusbar: false,
			valid_elements : '*[*]',
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks fullscreen",
				"insertdatetime media table contextmenu paste textcolor imagetools colorpicker emoticons"
			],
			external_plugins: {
			    tiny_mce_wiris: 'https://www.wiris.net/demo/plugins/tiny_mce/plugin.js'
			  },
			toolbar: "undo redo | tiny_mce_wiris_formulaEditor | tiny_mce_wiris_formulaEditorChemistry | link image | emoticons"
		 });
	 }
	 trigger_mathinput();
	 
	 //--- end rich text editor tinymce
});

function previewFile(input,target) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();            
            reader.onload = function (e) {$(target).attr('src', e.target.result);}            
            reader.readAsDataURL(input.files[0]);
        }
    }

function getLanguage(){
		var languagecode='';
		var path_parts = location.pathname.split("/");
		if(path_parts.length >=2){if(path_parts[1].length==2){languagecode=path_parts[1];}}
		return languagecode;
}

function hideSaveMsg(id){
	var eleName = $("#"+id+"_msg");
	eleName.animate({'opacity':0},500,function(){
		eleName.animate({'margin-bottom':0,'padding':'8px'},500,function(){
			eleName.removeClass('alert');
			eleName.removeClass('alert-warning');
			eleName.removeClass('alert-success');	
			eleName.removeClass('alert-danger');
			eleName.html('');	
		});
	});	
}

function iniDisplaySaveMsg(id){	
	$("#pageLoadingStatus").removeClass('isHiden');	

	var eleName = $("#"+id+"_msg");
	eleName.removeClass('alert-warning');
	eleName.removeClass('alert-success');	
	eleName.removeClass('alert-danger');
	
	eleName.css({'margin-bottom':0});
	eleName.animate({'opacity':1},500);
	eleName.addClass('alert alert-info');
	eleName.html('<span><span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;&nbsp;Processing...</span>');
}

function displaySaveMsg(id,msgType,text){
	$("#pageLoadingStatus").addClass('isHiden');	

	var eleName = $("#"+id+"_msg");
	var msgImg = '';
	//if(msgType=='info' || msgType=='warning'){msgImg = 'notice-info.png';}else if(msgType=='success'){msgImg = 'notice-success.png';}else if(msgType=='danger'){msgImg = 'notice-error.png';}
	var msgicon = {'info':'<span class="glyphicon glyphicon-info-sign"></span>','warning':'<span class="glyphicon glyphicon-warning-sign"></span>','success':'<span class="glyphicon glyphicon-check"></span>','danger':'<span class="glyphicon glyphicon-alert"></span>'}
	eleName.removeClass('alert-info');
	eleName.addClass('alert-'+msgType+' alert-dismissable v_pad5');
	eleName.html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><span>'+msgicon[msgType]+'&nbsp;&nbsp;&nbsp;'+text+'</span>');
}

(function ($) {
	
var ajaxRequest = {},runResult = {},lang_url=getLanguage()!=''?('/'+getLanguage()):'';
var siteSetting = {language:getLanguage(),ajaxurl:lang_url+'/admin/ajax_request',loginurl:lang_url+'/login/start',exportexcel:lang_url+'/admin/ajax_exportexcel',ajaxrealtimeupload:lang_url+'/admin/ajax_realtimeupload'};

//--- start modal ----
var confirmDialog_timeout = 0,dialog_wait=0;
function confirmDialog(modal,headerTxt,bodyTxt,mainBtnName,data,funcName){
	clearTimeout(confirmDialog_timeout);		
	confirmDialog_timeout = setTimeout(function(){		
		$("#"+modal+"_modalLabel").html(headerTxt);
		$("#"+modal+"_modalLabelBodyText").html(bodyTxt);
		$("#"+modal+"_actionBtn").html(mainBtnName).prop('disabled',false);
		$("#"+modal+"_confirmData").val(data);	
		$( "#"+modal+"_btn" ).trigger( "click" );
	},dialog_wait);
	
	if(data==null){$("#"+modal+"_actionBtn").hide();}else{
		$("#"+modal+"_actionBtn").unbind('click');
		$("#"+modal+"_actionBtn").click(function(){ajaxRequest[funcName](data);});
	}
}

function popupMsg(modal,headerTxt,bodyTxt){
	$("#"+modal+"_modalLabel").html(headerTxt);
	$("#"+modal+"_modalLabelBodyText").html(bodyTxt);
	$("#"+modal+"_actionBtn").hide();
	$( "#"+modal+"_btn" ).trigger( "click" );
}	 
//--- end modal ---

function setbtn_event(element,list){
	$(element).unbind('click');
	$(element).on('click',(function(e){		
		var text = $(this).data('text'),recordid = $(this).attr('data-recordid')?$(this).data('recordid'):null,func = $(this).data('func');
		var setcmd = $(this).data('cmd');
		var data = (recordid==null)?null:[recordid,list,setcmd];
		confirmDialog("yesno",'<i class="fa fa-info-circle"></i> Confirmation',text,'OK',data,func);
	}));
}

ajaxRequest.listNav = function(cmd,data,action){
	action = (action !== undefined) ? action : '';
	//check query data
	if($("#"+cmd+" .searchinputs").length){$( "#"+cmd+" .searchinputs" ).each(function() {
		if($( this ).is(':checkbox')){
			data[$( this ).attr('id')] = $(this).prop('checked');
		}else{
			data[$( this ).attr('id')] = $(this).val();
		}
	});}
	
	//--- start navigation btn
	$("#"+cmd+" .nav_first").unbind('click').click(function(e){ajaxRequest.showList('first',cmd,data);});
	$("#"+cmd+" .nav_prev").unbind('click').click(function(e){ajaxRequest.showList('prev',cmd,data);});
	$("#"+cmd+" .nav_next").unbind('click').click(function(e){ajaxRequest.showList('next',cmd,data);});
	$("#"+cmd+" .nav_last").unbind('click').click(function(e){ajaxRequest.showList('last',cmd,data);});
	$("#"+cmd+" .nav_rowsPerPage").unbind('change').change(function(e){ajaxRequest.showList('',cmd,data);});
	$("#"+cmd+" .nav_currentPage").unbind('change').change(function(e){ajaxRequest.showList('goto',cmd,data);});
	//--- end navigation btn	

	ajaxRequest.showList(action,cmd,data);
}

ajaxRequest.exportexcel= function(listName,sql){
		$.post(siteSetting.exportexcel,{listName:listName,sql:sql} ,function(data){
			window.location.href=data;
			//console.log(data);	
		});		
};

function isJSON(str) {
    if ( str === undefined || str === null || /^\s*$/.test(str) ) {return false;}
    str = str.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, '@');
    str = str.replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']');
    str = str.replace(/(?:^|:|,)(?:\s*\[)+/g, '');
    return (/^[\],:{}\s]*$/).test(str);
}

ajaxRequest.showList= function(navAction,cmd,qryData){	
		var get_time=$.now();
		$("<div id='overlay_"+get_time+"'></div>").addClass("myoverlay").appendTo($("#"+cmd+" .mytable").css("position", "relative"));	
		if($("#"+cmd+" .nav_info").length){$("#"+cmd+" .nav_info").html('<span>'+$("#"+cmd+" .nav_info").data('loadtxt')+'</span>');}
		var loadMode = $("#"+cmd).attr('data-loadmode')?$("#"+cmd).attr('data-loadmode'):'list'; //default loadmode is list
		var customNumItem = $("#"+cmd).attr('data-rowsPerPage')?$("#"+cmd).attr('data-rowsPerPage'):0;
		if(loadMode=='loadmore'){$("#"+cmd+" .nav_next").html('<img src="/assets/frontend/img/loading.gif" />Loading...')}
		var currentPage = $("#"+cmd+" .nav_currentPage").val();
		var rowsPerPage = customNumItem?customNumItem:($("#"+cmd+" .nav_rowsPerPage").length?$("#"+cmd+" .nav_rowsPerPage").val():10);
		$.post(siteSetting.ajaxurl,{cmd:cmd,qryData:qryData,currentPage:currentPage,rowsPerPage:rowsPerPage,navAction:navAction} ,function(data){
				//console.log(data);
				var errmsg = 'Access Denied! please login again.';
				if(!isJSON(data) || !("list" in JSON.parse(data))){$("#"+cmd+" tbody").html("<tr><td colspan='"+qryData['col']+"' class='txtCenter'><span class='redcolor'>"+(data==errmsg?errmsg:(("msg" in JSON.parse(data))?JSON.parse(data).msg:'Technical Error'))+"</span></td></tr>");$("#"+cmd+" .nav_info").html('');$("#overlay_"+get_time).remove();return false;}	
				var data = JSON.parse(data);
				
				if(loadMode=='loadmore'){
					$("#"+cmd+" .loaded_data").append(data.list);
					$("#"+cmd+" .nav_currentPage").val(data.targetPage);					
					if($("#"+cmd+" .totalLoadedRows").length){
						if(data.totalRow){
							$("#"+cmd+" .totalLoadedRows").html(data.totalLoadedRows+' of '+data.totalRow+' '+$("#"+cmd+" .totalLoadedRows").attr('data-unit')).removeClass('hidden');
						}else{$("#"+cmd+" .totalLoadedRows").addClass('hidden');}
					}
					if(!data.nav_btn_disable.nav_next){$("#"+cmd+" .nav_next").addClass('hidden').unbind("click");}
					else{$("#"+cmd+" .nav_next").html('<i class="fa fa-angle-double-down"></i> Load More').unbind("click").bind("click",function(){ajaxRequest.showList('next',cmd,qryData)});}
				}else{
					//hide list nav if row <= item per page
					if(data.totalRow>rowsPerPage){$("#"+cmd+" .listnav").removeClass("hidden");}
					//set sql for excel export	
					if($("#"+cmd+" #fullexport").length){
						$("#"+cmd+" #fullexport").unbind('click').click(function(){ajaxRequest.exportexcel(cmd,data.fullsql)});
						$("#"+cmd+" #partexport").unbind('click').click(function(){ajaxRequest.exportexcel(cmd,data.partsql)});
					}				
					$("#"+cmd+" tbody").html(data.list);				
					if($("#"+cmd+" .confirm-btn").length){setbtn_event("#"+cmd+" .confirm-btn",cmd)}				
					$("#"+cmd+" .nav_currentPage").val(data.targetPage);
					if(navAction=='refresh' || navAction==''){$("#"+cmd+" .nav_currentPage").empty();$.each(data.gotoSelectNum, function(key, value) {$("#"+cmd+" .nav_currentPage").append($("<option></option>").attr("value",key).text(value));});}
					$("#"+cmd+" .nav_info").html(data.listNavInfo);
					$.each(data.nav_btn_disable, function (key, jdata) {if(jdata==1){$("#"+cmd+" ."+key).removeClass('disabled').unbind("click").bind("click",function(){ajaxRequest.showList(key.split("_")[1],cmd,qryData)});}else{$("#"+cmd+" ."+key).addClass('disabled').unbind("click");}})				
					//re-run tooltip plugin
					$('.tooltips').tipsy({gravity: $.fn.tipsy.autoNS});		
					//reset load data btn		
					load_formdata();
					//reset confirm btn
					setevent_confirmbtn();
					//assign edit btn
					if($("#"+cmd+" .btn_edit").length){
						$("#"+cmd+" .btn_edit").unbind('click').click(function(){
							var edit_id = $(this).data('recordid');
							$("#"+cmd+" .data_edit_"+edit_id).each(function() { 
								var input_name = $(this).data('name'),input_value = $(this).val();
								$("#"+cmd+" .btn_edit").val();
								$('#'+cmd+' input[name="'+input_name+'"]').val(input_value);
								$('#'+cmd+' select[name="'+input_name+'"]').val(input_value);
								$('#'+cmd+" .input_action").val('Update');
								if(!$("#"+cmd+" table tfoot").is(":visible")){
									$("#"+cmd+" .btn_insert").trigger('click');								
								}				
								
							});
						});
					}	
				}
				//remove pre-loading overlay
				$("#overlay_"+get_time).remove();
		});
};

ajaxRequest.login= function(frm){
		var formName = 'login';
		$("#"+formName+"_msg").html('<div class="alert alert-info">'+$("#"+formName+"_msg").data('loadtxt')+'</div>');
		var username=$("#email").val(),password = $("#password").val(),nexturl = $("#nexturl").length?$("#nexturl").val():'';
		$.post(siteSetting.loginurl,{username:username,password:password,nexturl:nexturl} ,function(data){ console.log(data);
				var data = JSON.parse(data);
				$("#login_btn_icon").html('<i class="fa fa-key fa-fw"></i>');
				if(data.result){		
					$("#"+formName+"_msg").html('<div class="alert alert-success">'+data.msg+'</div>');
					window.location.href=data.url;
				}else{
					$("#"+formName+"_msg").html('<div class="alert alert-danger">'+data.msg+'</div>');
					frm.find(':submit').prop("disabled",false);
				}
				
		});
};

var totalfiles=0,filesuploaded=0;
ajaxRequest.realtime_upload = function (frm,e,frmData,file){
		e.preventDefault();
		frm.find(':submit').prop("disabled",true);
		var jfile = $(file);
		var fileid = $.now();		
		var filepath = jfile.val();
		var criteriaid = jfile.attr("name");	
		var preview_id = 'preview_'+criteriaid+'_'+totalfiles;	
		$("#selectedFile_"+criteriaid).show();
		$("#selectedFile_"+criteriaid).prepend('<div id="file_'+fileid+'" class="col-xs-6 col-sm-4 col-md-3 img_preview" style="'+($("#selectedFile_criteria_"+criteriaid).html()==''?'':'padding-bottom:5px; margin-bottom:5px; border-bottom:1px solid #e9e9e9;')+'"><a id="link_'+fileid+'" href="#" rel="prettyPhoto"><img src="/assets/frontend/img/blank_img_square.png" id="'+preview_id+'" class="img-responsive bg_pic_contain fullwidth" /></a><div class="txtCenter v_pad10 loading_upload"><img id="load_'+fileid+'" src="/assets/frontend/img/loading.gif" /></div></div>');
		
		//show preview photo
		//previewFile(file,"#"+preview_id);
		
		jfile.val('');		
		totalfiles++;
		$.ajax({
			url: siteSetting.ajaxrealtimeupload+'/'+criteriaid, // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			dataType: 'json',
			data: frmData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{ 
				//console.log(data);var data = JSON.parse(data);								
				if(data.result==1){		
					$("#allfiles_"+criteriaid).val($("#allfiles_"+criteriaid).val()+($("#allfiles_"+criteriaid).val()==''?'':'|')+data.newfilename);
					$("#link_"+fileid).attr('href',data.filePath+data.newfilename);
					if(data.isPic){
						var pre_pic = data.thumbnail_path+data.newfilename;
					}else{
						var pre_pic = "/assets/frontend/img/no_preview.png";
					}
					$("#"+preview_id).css({'background-image':'url('+pre_pic+')'});
					$("#file_"+fileid).append('<div class="txtCenter"><div>'+ data.filesize + ' '+data.file_detail.icon+'</div><div><span data-eleid="file_'+fileid+'" class="delFile_txt" id="delFile_'+criteriaid+'_'+fileid+'" data-filename="'+data.newfilename+'"><i class="fa fa-times"></i> លុប</span></div></div>').css('color','green');
					
					//reset prettyphoto
					$("a[rel^='prettyPhoto']").prettyPhoto({show_title: true,social_tools:''});
				}else{
					$("#"+preview_id).attr('src',"/assets/frontend/img/no_preview.png")
					$("#file_"+fileid).append('<div class="txtCenter"><div>'+data.msg+'</div><div><span data-eleid="file_'+fileid+'" class="delFile_txt" id="delFile_'+criteriaid+'_'+fileid+'"><i class="fa fa-times"></i> លុប</span></div></div>').css('color','red');
				}
				//register click event for delete file button
				$("#delFile_"+criteriaid+'_'+fileid).click(function(e){ajaxRequest.delFile($(this).data('eleid'),$(this).data('filename'),criteriaid,data.result)});	
				$("#load_"+fileid).remove();
				
				filesuploaded++;
				if(filesuploaded==totalfiles){frm.find(':submit').prop("disabled",false);totalfiles=0;filesuploaded=0;}
			},
			error: function (responseData, textStatus, errorThrown) {
				//alert('POST failed.');
				$("#"+preview_id).attr('src',"/assets/frontend/img/no_preview.png")
				$("#file_"+fileid).append('<div><i class="fa fa-times fa-fw"></i> : Error | <span class="error_file delFile_txt">លុបចោល</span></div>').css('color','red');
				$("#load_"+fileid).remove();
				
				$(".error_file").unbind('click').click(function(e){
					$("#file_"+fileid).remove();frm.find(':submit').prop("disabled",false);
					if($("#selectedFile_"+criteriaid).html()==''){$("#selectedFile_"+criteriaid).hide();}
					filesuploaded++;
				});	
			}
		});
}

ajaxRequest.delFile = function (eleid,filename,criteriaid,no_err){	
	//js confirm
	var r = confirm("Doing this will delete file permanently, are you sure?");
	if (r == false) {
		return false;
	}

	$("#"+eleid).remove();	
	if($("#selectedFile_"+criteriaid).html()==''){$("#selectedFile_"+criteriaid).hide();}
	if(!no_err){return false;}
	//remove filename from input
	var curFile = $("#allfiles_"+criteriaid).val().split("|");
	curFile.splice($.inArray(filename, curFile),1);
	$("#allfiles_"+criteriaid).val(curFile.join("|"));		
	$.post(siteSetting.ajaxurl,{cmd:'delFile',filename:filename} ,function(data){});
}

ajaxRequest.saveData = function(frm){
		var frmid =frm.attr('id').split('-');
		var formName = frmid[0];tinyMCE.triggerSave();
		$("#"+formName+"_msg").html('<div class="alert-info pad5">'+$("#"+formName+"_msg").data('loadtxt')+'</div>');
		$('#'+frm.attr('id')+' input,#'+frm.attr('id')+' select,#'+frm.attr('id')+' textarea').css({border:'1px solid #5ccf65'});
		if($(".file_msg").length){$('.file_msg').remove();}		
		if($(".uploadpic").length){$(".uploadpic").css({border:'0px solid red'});}
		$.ajax({
			xhr: function() {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function(evt) {
					if (evt.lengthComputable) {
						var percentComplete = parseInt((evt.loaded / evt.total)*100);  
						//Do something with upload progress here
						if(!frm.attr("data-noprogressbar")){
							$("#"+frm.attr('id')+" #"+formName+"_msg").html('<div class="progress progress-striped active"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: '+percentComplete+'%;">Completed '+percentComplete+'% Please wait...</div></div>');		
						}
						
					}
			   }, false);
		
			   xhr.addEventListener("progress", function(evt) {
				   if (evt.lengthComputable) {
					   var percentComplete = evt.loaded / evt.total;
					   //Do something with download progress
					   //console.log('Download: '+percentComplete);
				   }
			   }, false);
		
			   return xhr;
			},
			url: siteSetting.ajaxurl, // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			dataType: 'html',
			timeout: 600000,
			data: new FormData($("#"+frm.attr('id'))[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{ 
				if(!isJSON(data)){// check ajax return valid json/error
					$("#"+formName+"_msg").html('<div class="alert-danger pad5"><span class="glyphicon glyphicon-warning-sign"></span> Error: '+(data=='Access Denied!'?'Access Denied!':'Technical Error')+'</div>');
					frm.find(':submit').prop("disabled",false);return false;
				}	
				
				var data = JSON.parse(data);
				if(frm.attr("data-func")){formName = frm.attr("data-func");}
				runResult[formName](frm,data);
			},
			error: function (responseData, textStatus, errorThrown) {
				$("#"+formName+"_msg").html('<div class="alert-danger pad5"><span class="glyphicon glyphicon-warning-sign"></span> Error: '+textStatus+'</div>');
				frm.find(':submit').prop("disabled",false);
			}
		});
};

runResult.subscription= function(frm,data){
		var frmid =frm.attr('id').split('-');var formName = frmid[0];
		if(data.result){
			popupMsg('yesno',data.pop_title,data.msg);
			$('.file_msg').remove();
			frm.trigger('reset');		
		}else{
			var err_msg = '<ul style="list-style:none;">';
			$.each(data.err_fields,function(index,value){
				err_msg += '<li>- '+value.msg+'</li>';
				$("input[name='"+value.name+"']").css({border:'1px solid red'});
			});
			err_msg += '</ul>';
			popupMsg('yesno',data.pop_title,err_msg);			
		}
		frm.find(':submit').prop("disabled",false);
};

runResult.unsubscribe= function(frm,data){
		var frmid =frm.attr('id').split('-');var formName = frmid[0];
		if(data.result){
			$("#"+formName+"_msg").html('<div class="alert alert-success">'+data.msg+'</div>');
		}else{
			$("#"+formName+"_msg").html('<div class="alert alert-success">'+data.msg+'</div>');		
		}
};

runResult.submit_form= function(frm,data){
		var frmid =frm.attr('id').split('-'),frmreset=frm.attr('data-reset'),removable=frm.attr('data-removable');var formName = frmid[0];
		frm.find(':submit').prop("disabled",false);
		if(data.result){
			$("#"+formName+"_msg").html('<div class="alert-success pad5">'+data.msg+'</div>');
			$('.file_msg').remove();			
			if(frmreset==1){frm.trigger('reset');remove_input_value(frm);}
			if(removable==1){setTimeout(function(){frm.addClass('hidden');},2000);}
			if('url' in data){setTimeout(function(){window.location.href=data.url;},2000);} //ajaxRequest.showList('goto',data.refresh_listname,totalcol(formName));
			if('refresh_listname' in data){setTimeout(function(){ajaxRequest.listNav(data.refresh_listname,totalcol(formName),'goto');},500);}
			//clear form value to blank
			$("#"+frm.attr('id')+" .recordid").val('');
			//remove all image preview if exist
			if($("#"+frm.attr('id')+" .img_preview")){$("#"+frm.attr('id')+" .realtime-upload-selectedfile").hide();$("#"+frm.attr('id')+" .img_preview").remove();}
		}else{
			$.each(data.err_fields,function(index,value){
				if($("#"+frm.attr('id')+" #"+value.name.replace('[','_').replace(']','')+"_msg").length){
					$("#"+frm.attr('id')+" #"+value.name.replace('[','_').replace(']','')+"_msg").html('<div class="file_msg alert alert-danger v_mgn3 pad5">'+value.msg+'</div>');
				}else{
					//for select
					$("#"+frm.attr('id')+" select[name='"+value.name+"']").css({border:'1px solid red'});
					$("#"+frm.attr('id')+" select[name='"+value.name+"']").after('<div class="file_msg alert alert-danger v_mgn3 pad5">'+value.msg+'</div>');
					//for input					
					$("#"+frm.attr('id')+" input[name='"+value.name+"']").css({border:'1px solid red'});
					$("#"+frm.attr('id')+" input[name='"+value.name+"']").after('<div class="file_msg alert alert-danger v_mgn3 pad5">'+value.msg+'</div>');
					//for multiple input file				
					if($("#"+frm.attr('id')+" .multi_inputfile").length){
						$( "#"+frm.attr('id')+" .multi_inputfile" ).each(function(index) {
							if(value.name=='add_attachment_'+index){
								$(this).css({border:'1px solid red'});
								$(this).after('<div class="file_msg alert alert-danger v_mgn3 pad5">'+value.msg+'</div>');
							}
						});
					}	
					//for textarea
					$("#"+frm.attr('id')+" textarea[name='"+value.name+"']").css({border:'1px solid red'});
					$("#"+frm.attr('id')+" textarea[name='"+value.name+"']").after('<div class="file_msg alert alert-danger v_mgn3 pad5">'+value.msg+'</div>');		
					//for photo box
					if($("#"+frm.attr('id')+" .uploadpic").length){
						$("#"+frm.attr('id')+" input[name='"+value.name+"']").parent('.uploadpic').css({border:'1px solid red'});
						$("#"+frm.attr('id')+" input[name='"+value.name+"']").parent('.uploadpic').after('<div class="file_msg alert alert-danger v_mgn3 pad5">'+value.msg+'</div>');
					}		
				}
			});
			$("#"+frm.attr('id')+" #"+formName+"_msg").html('<div class="alert-danger pad5">'+data.msg+'</div>');
		}
};

ajaxRequest.switch_status= function(getData){//[0]:recordid,[1]:list,[2]:cmd
	var element = 'yesno';
	iniDisplaySaveMsg(element);
	$("#"+element+"_actionBtn").prop('disabled',true);
	$.post(siteSetting.ajaxurl,{cmd:getData[2],recordid:getData[0]} ,function(data){
			//alert(data);	
			if(!isJSON(data)){displaySaveMsg(element,'danger',data=='Access Denied!'?data:'Technical Error');$("#"+element+"_actionBtn").prop('disabled',false);return false;}
			var data = JSON.parse(data);
			if(data.result){
				displaySaveMsg(element,'success',data.msg);
				setTimeout(function(){$("#"+element+"_modalCloseBtn").trigger("click");hideSaveMsg(element);},1000);
				if(getData[1]!=''){
					ajaxRequest.listNav(getData[1],totalcol(getData[1]));
				}else{location.reload();}
			}else{
				displaySaveMsg(element,'danger',data.msg);
				$("#"+element+"_actionBtn").prop('disabled',false);
			}
			
	});
}

ajaxRequest.notif= function(){	
	$.post(siteSetting.ajaxurl,{cmd:'notif'} ,function(data){
			if(!isJSON(data)){console.log(data=='Access Denied!'?data:'Technical Error');return false;}
			var data = JSON.parse(data);
			//console.log(data);
			//show unread msg
			if(data.total_unread_msg){$(".total_unread_msg,#menu_admin_messagebox,#menu_admin_messageinbox").html(' <span class="badge badge-red rounded-x">'+data.total_unread_msg+'</span>');}
			if(data.total_scheduled_bookings){$(".total_scheduled_bookings").html(' <span class="badge badge-red rounded-x">'+data.total_scheduled_bookings+'</span>');}
			if(data.total_requesting_bookings){$(".total_requesting_bookings,#menu_admin_bookingmanagement,#menu_admin_reviewingbooking").html(' <span class="badge badge-red rounded-x">'+data.total_requesting_bookings+'</span>');}
			if(data.total_requested_routes){$("#menu_admin_requestedroutes,#menu_admin_drivermanagement,.total_requestingroutes").html(' <span class="badge badge-red rounded-x">'+data.total_requested_routes+'</span>');}
			setTimeout(ajaxRequest.notif,5000)
			
	});
}
//ajaxRequest.notif();
ajaxRequest.form_select= function(element){ 
	element.submit(function(e){$(this).find(':submit').prop("disabled",true);});
	var targets = element.attr('data-targets').split(",");
	$.each(targets, function(key, value) {$("select[name="+value+"],#"+value+"").html('<option>Loading...</option>');});
	$.post(siteSetting.ajaxurl,{cmd:element.attr('data-cmd'),id:element.val(),targets:targets} ,function(data){
		//console.log(data);	
		if(!isJSON(data)){// check ajax return valid json/error			
			$.each(targets, function(key, value) {
				$("select[name="+value+"],#"+value+"").html("<option>"+(data=='Access Denied!'?'Access Denied!':'Technical Error')+"</option>");
			});return false
		}
		var data = JSON.parse(data);		
		$.each(targets, function(key, value) {
			$("select[name="+value+"],#"+value+"").html(data[value]);
		});	
		
	});
}

if($(".ajax_form_select").length){		
	$(".ajax_form_select").change(function(){
		ajaxRequest.form_select($( this ));
	});
}

ajaxRequest.load_formdata= function(element){ 
	var target_formid = element.attr('data-target_formid'),recordid = element.attr('data-recordid'),callback = element.attr('data-callback');
	$.post(siteSetting.ajaxurl,{cmd:element.attr('data-cmd'),recordid:recordid} ,function(data){
		element.prop("disabled",false);
		$("#"+target_formid+"_msg").html('');
		//console.log(data);	
		if(!isJSON(data)){// check ajax return valid json/error			
			$("#"+target_formid+"_msg").html('<div class="alert-danger pad5"><span class="glyphicon glyphicon-warning-sign"></span> Error: '+(data=='Access Denied!'?'Access Denied!':'Technical Error')+'</div>');
			return false
		}
		var data = JSON.parse(data);	
		$("#"+target_formid+"-form").removeClass("hidden");$("#"+target_formid+"-form").trigger('reset');
		//remove all image preview if exist
		if($("#"+target_formid+"-form .img_preview")){$("#"+target_formid+"-form .realtime-upload-selectedfile").hide();$("#"+target_formid+"-form .img_preview").remove();}
		if(data.result){
			$("#"+target_formid+"-form input[type=checkbox]").prop('checked', false);
			$.each(data.fromdata,function(index,value){
				if($("#"+target_formid+"-form input[name='"+index+"']").length){
					if($("#"+target_formid+"-form input[name='"+index+"']").is(':checkbox')){
						$("#"+target_formid+"-form input[name='"+index+"']").prop('checked', value==1?true:false);
					}else{
						$("#"+target_formid+"-form input[name='"+index+"']").val(value);
					}
				}else if($("#"+target_formid+"-form textarea[name='"+index+"']").length){
					$("#"+target_formid+"-form textarea[name='"+index+"']").html(value);
					for (editorId in tinyMCE.editors) {
					  //var orig_element = $(tinyMCE.get(editorId).getElement());
					  var name = tinyMCE.DOM.getAttrib(editorId,'name')
					  if (name === index) {
						  tinyMCE.get(editorId).setContent(value);
						// do your stuff here
					  }
					}
				}else if($("#"+target_formid+"-form select[name='"+index+"']").length){
					var selectval=[];
					if(isJSON(value)){selectval=JSON.parse(value);}else{selectval=value;}$("#"+target_formid+"-form select[name='"+index+"']").val(selectval);
				}
				if(index=='file_preview' && value.length){	
					var criteriaid = $("#"+target_formid+"-form .realtime-upload-btn").attr("id");
					$("#"+target_formid+"-form #selectedFile_"+criteriaid).html('');
					$.each(value,function(findex,fvalue){						
						$("#"+target_formid+"-form #selectedFile_"+criteriaid).show();						
						$("#"+target_formid+"-form #selectedFile_"+criteriaid).prepend(fvalue.preview_item);
						
						//register click event for delete file button
						$("#delFile_"+criteriaid+'_'+fvalue.preview_id).click(function(e){ajaxRequest.delFile($(this).data('eleid'),$(this).data('filename'),criteriaid,true);});	
					});
				}
			});
			//reset prettyphoto
			$("a[rel^='prettyPhoto']").prettyPhoto({show_title: true,social_tools:''});
			//re-run tooltip plugin
			$('.tooltips').tipsy({gravity: $.fn.tipsy.autoNS});	
			$(".chosen-select").trigger("chosen:updated");	
			$("#"+target_formid+"_msg").html('<div class="alert-success pad5">'+data.msg+'</div>');	
			
			if(callback !== undefined && callback !== null && callback !== ''){
				window[callback]();
			}
			
		}else{$("#"+target_formid+"_msg").html('<div class="alert-danger pad5">'+data.msg+'</div>');	}			
	});
}
function load_formdata(){
	if($(".load_form_btn").length){
		$(".load_form_btn").unbind('click').click(function(){
			var target_formid = $(this).attr('data-target_formid');
			$(this).prop("disabled",true);
			$("#"+target_formid+"_msg").html('<div class="alert-info pad5"><i class="fa fa-refresh"></i> Loading... </div>');			
			ajaxRequest.load_formdata($( this ));
		});
	}
}
load_formdata();

runResult.renew_captcha= function(){
	var bg_img=['noise1.jpg','noise2.jpg','noise3.jpg','noise4.png','noise5.png','noise6.png','noise7.jpg','noise8.png','noise9.png','noise10.jpg'],rndkey=Math.floor((Math.random() * 9) + 0);
	$(".captchabox").css({'background-image':'url(/assets/frontend/img/noise/'+bg_img[rndkey]+')'});
	$("#captcha_img").css({'background-image':'url(/kh/captcha/pic/'+Math.floor((Math.random() * 100) + 1)+')','background-repeat': 'no-repeat','background-color': 'transparent'});
		
}

function totalcol(tblid){var totalcol = $("#"+tblid+" > table > thead").find("> tr:first > th").length;		return {col:totalcol};}
//assign event to form submit
if($(".ajaxfrm").length){
	$( ".ajaxfrm" ).each(function() {
		var id_parts = $( this ).attr('id');
		$( this ).submit(function(e){$(this).find(':submit').prop("disabled",true);
		var msg_ele = $("#"+id_parts+"_msg");
		msg_ele.html('<div class="alert alert-info">'+msg_ele.data('loadtxt')+'</div>');
		if(id_parts=='login'){ajaxRequest.login($( this ));}else{ajaxRequest.saveData($( this ));}
		e.preventDefault();
	});});
}
//assign event to table
if($(".datalist").length){
	$( ".datalist" ).each(function() {
		var tblid = $( this ).attr('id');
		var qryData = totalcol(tblid);
		if($("#"+tblid+" .searchinputs").length){
			$( "#"+tblid+" .searchinputs" ).each(function() {$( this ).change(function(e){ajaxRequest.listNav(tblid,qryData);});});
			$( "#"+tblid+" .btn_search" ).each(function() {$( this ).click(function(e){ajaxRequest.listNav(tblid,qryData);});});
		}
		//show/hide insert block
		if($("#"+tblid+" .btn_insert").length){
			$("#"+tblid+" .btn_insert").click(function(){
				if($("#"+tblid+" table tfoot").is(":visible")){
					$("#"+tblid+" table tfoot").addClass('hidden');									
					$("#"+tblid+" .btn_insert").html('<i class="fa fa-plus-square"></i>');
				}else{
					$("#"+tblid+" table tfoot").removeClass('hidden');
					$("#"+tblid+" .btn_insert").html('<i class="fa fa-minus-square"></i>');
				}
				$("#"+tblid+" .ajaxfrm_msg").html('');					
				$("#"+tblid+" .file_msg").remove();	
			});			
		}
		//reset inset/edit form
		if($("#"+tblid+" .cancel_edit").length){
			$("#"+tblid+" .cancel_edit").click(function(){
				$("#"+tblid+" .ajaxfrm").trigger('reset');
				$("#"+tblid+" .recordid").val('');
			});			
		}
		ajaxRequest.listNav(tblid,qryData);
	});
}

//assign event to button out of ajax
if($(".confirm-btn").length){setbtn_event(".confirm-btn",'')}	

if($(".popup_moreinfo").length){
	$( ".popup_moreinfo" ).each(function() { 	
		var text = $(this).data('text'),htitle = $(this).data('htitle');
		$(this).click(function(e){confirmDialog("yesno",htitle,text,null,null,null); e.preventDefault()});	
	});
}

//show preview file
$(".file-to-preview").change(function(){
	previewFile(this,$(this).attr('data-pretarget'))
});

//add more input file dynamically
if($(".more_file_input").length){
	$( ".more_file_input" ).each(function() {		
		$(this).click(function(){
			var target_id = $( this ).attr('data-target'),get_time=$.now();
			$("#"+target_id).append('<div class="row" id="input_'+get_time+'"><div class="col-xs-10 col-md-11"><input type="file" name="add_attachment[]" class="form-control multi_inputfile v_mgn3"></div><div class="col-xs-2 col-md-1 h_pad0"><button type="button" class="btn btn-danger remove_file_input" data-target="input_'+get_time+'"><span class="glyphicon glyphicon-remove"></span></button></div></div>');
			//assign function to remove input
			$(".remove_file_input").unbind('click').click(function(){var remove_id = $( this ).attr('data-target');$("#"+remove_id).remove();});
		});			
	});
	$(".remove_file_input").unbind('click').click(function(){var remove_id = $( this ).attr('data-target');$("#"+remove_id).remove();});
}

//add more input text dynamically
if($(".more_text_input").length){
	$( ".more_text_input" ).each(function() {		
		$(this).click(function(){
			var target_id = $( this ).attr('data-target'),get_time=$.now();
			$("#"+target_id).append('<div class="row" id="input_'+get_time+'"><div class="col-xs-2 col-md-1"><input type="hidden" name="item_id[]" value=""><input type="text" name="text1[]" class="form-control multi_text_input v_mgn3 h_pad3 txtCenter"></div><div class="col-xs-6 col-md-9"><input type="text" name="text2[]" class="form-control multi_text_input v_mgn3 h_pad3"></div><div class="col-xs-2 col-md-1"><input type="text" name="text3[]" class="form-control multi_text_input v_mgn3 h_pad3 txtCenter"></div><div class="col-xs-2 col-md-1 h_pad0"><button type="button" class="btn btn-danger remove_text_input h_pad10 v_pad5" data-target="input_'+get_time+'"><span class="glyphicon glyphicon-remove"></span></button></div></div>');
			//assign function to remove input
			$(".remove_text_input").unbind('click').click(function(){var remove_id = $( this ).attr('data-target');$("#"+remove_id).remove();});;
		});			
	});
	$(".remove_text_input").unbind('click').click(function(){var remove_id = $( this ).attr('data-target');$("#"+remove_id).remove();});
}

//renew captcha
if($(".renew_captcha").length){$(".renew_captcha").click(function(){runResult.renew_captcha();});runResult.renew_captcha();}

//realtime upload button
if($(".realtime-upload-btn").length){
	$(".realtime-upload-btn").on('change',(function(e) {
		//$("#newLesson_btn").prop('disabled',true);
		//$("#active_file_id").val($(this).attr("id"));				
		ajaxRequest.realtime_upload($(".realtime-upload"),e,new FormData($(".realtime-upload")[0]),this);
	}));
}

//detect file-del btn document load
if($(".file-del-btn").length){
	$( ".file-del-btn" ).each(function() {		
		$(this).click(function(e){ajaxRequest.delFile($(this).data('eleid'),$(this).data('filename'),$(this).attr('id'),true)});
	});
}

//clear all form value
function remove_input_value(formElement){ 
	var frm = formElement.closest("form"); var frmid = frm.attr("id");
	var removable = frm.attr("data-removable");
	if(removable==1){frm.addClass("hidden");}
	frm.find(".removable").val('');
	//remove all image preview if exist
	if($("#"+frmid+" .img_preview")){$("#"+frmid+" .realtime-upload-selectedfile").hide();$("#"+frmid+" .img_preview").remove();}
	$("#"+frmid+" .chosen-select").val('').trigger("chosen:updated");	
}
function assign_reset_btn(){
	if($(".reset_btn").length){
		$( ".reset_btn" ).click(function() {
			remove_input_value($(this));
		});
	}
}
assign_reset_btn();

//auto item code generator
function autocode(element){
	var rndkey=Math.floor((Math.random() * 100000) + 0)
	var autostr = rndkey+'_'+$.now();
	$("#"+element).val(autostr);
}
if($(".auto_code_btn").length){
	$( ".auto_code_btn" ).each(function() {		
		$(this).click(function(e){autocode($(this).data('targetid'));});
	});
}

//show/hide list filter tools
if($(".switch_list_filters").length){
	$( ".switch_list_filters" ).each(function() {	
		var list = $(this).data('list');		
		$(this).click(function(e){
			var list_filters = $("#"+list+" .list_filters");
			if(list_filters.hasClass("hidden")){
				list_filters.removeClass("hidden");
				list_filters.fadeIn( "slow", function() {
					// Animation complete
				  });
			}else{				
				list_filters.fadeOut( "slow", function() {
					list_filters.addClass("hidden");
				  });
			}
		});
	});
}

//new confirm popup box
//CONVERT DIALOG TITLE TO HTML
$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
	_title : function(title) {
		if (!this.options.title) {
			title.html("&#160;");
		} else {
			title.html(this.options.title);
		}
	}
}));


// Dialog click
function setevent_confirmbtn(){
	if($(".confirmbtn").length){
		$( ".confirmbtn" ).each(function() {
			$(this).click(function() {
				confirmbox($(this).data("cmd"),$(this).data("data"),$(this).data("title"),$(this).data("description"),$(this).data("yesbtn"),$(this).data("nobtn"));
				return false;	
			});	
		});
	}
}
setevent_confirmbtn();
function confirmbox(cmd,data,title,description,yesbtn,nobtn){
	//var dialog =  "<div id=\'confirmbox\'>" + description + "</div>";
	//$("body").append(dialog);
	
	$("#confirmbox").html(description).dialog({
		autoOpen : false,
		width : 400,
		resizable : false,
		modal : true,
		title : title,
		buttons : [{
			html : yesbtn,
			"class" : "btn btn-danger confirm_yesbtn",
			click : function() {
				confirmcmd(cmd,data);
				//$(this).dialog("close");
			}
		}, {
			html : nobtn,
			"class" : "btn btn-default",
			click : function() {
				$(this).dialog("close");
			}
		}]
	});
	$(".confirm_msg").remove();$("#confirmbox").dialog("open");
}

function confirmcmd(cmd,data){
	var element = "confirm";$(".confirm_msg").remove();
	$(".ui-dialog-buttonpane").prepend("<div class=\'pull-left confirm_msg\' id=\'confirm_msg\'></div>");
	iniDisplaySaveMsg(element);
	$("#"+element+"_yesbtn").prop("disabled",true);
	$.post(siteSetting.ajaxurl,{cmd:cmd,recordid:data} ,function(data){
			//alert(data);	
			if(!isJSON(data)){displaySaveMsg(element,"danger",data=="Access Denied!"?data:"Technical Error");$("#"+element+"_yesbtn").prop("disabled",false);return false;}
			var data = JSON.parse(data);
			if(data.result){
				displaySaveMsg(element,"success",data.msg);
				setTimeout(function(){$("#confirmbox").dialog("close");hideSaveMsg(element);},1000);
				if('refresh_listname' in data){setTimeout(function(){ajaxRequest.listNav(data.refresh_listname,totalcol(data.refresh_listname),'goto');},500);}
				//if(getData[1]!=""){
					//ajaxRequest.listNav(getData[1],totalcol(getData[1]));
				//}else{location.reload();}
			}else{
				displaySaveMsg(element,"danger",data.msg);
				$("#"+element+"_yesbtn").prop("disabled",false);
			}
			
	});
}

//custom function for website------------------------------------



//show model name
if($("#label_id").length && $("#model_name").length){
	$("#label_id").change(function(){
		var selected = $(this).find('option:selected');
       	var model_name = selected.data('model_name');
		$("#model_name").val(model_name);
	});
}


}(jQuery));