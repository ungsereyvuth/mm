<?php
class admin_ajax_request{
	public function data($input){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang,$docroot;
		$qry = new connectDb;
		if(isset($_POST['cmd'])){
			$_POST=trim_arr($_POST);
			//check if command is granted
			$isGranted = isGranted($_POST['cmd']);
			if(!$isGranted->result){	
				echo 'Access Denied!';
			}else{
				// if inherit set, use inherited class
				$ajax_command=$isGranted->inherited<>''?$isGranted->inherited:$_POST['cmd'];
				//call ajax class
				if (file_exists($docroot."/app/model/".$input['dir']."ajax/".$isGranted->dir.$ajax_command.".php")) { 
					include_once("app/model/".$input['dir']."ajax/".$isGranted->dir.$ajax_command.".php");
				}
				//check ajax class
				if(!class_exists($ajax_command)){echo 'Invalid request';exit;}
				//calling ajax class
				$ajax_call = new $ajax_command;	
				//return ajax output
				echo $ajax_call->data($_POST);
			}			
		}	
	}	
}

class admin_ajax_realtimeupload {
	public function data($input){
		//global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		//$qry = new connectDb;
		$uploadpath = web_config('post_doc_path');
		$newfile= 'upload';$upload_data=array();
		$formatConfig = isset($_POST['cmd'])?$_POST['cmd']:'';

		$upload_data = upload($uploadpath,$_FILES[$input[0]],$newfile,false,$formatConfig);

		echo json_encode($upload_data);

	}		
}



?>