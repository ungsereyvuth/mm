<?php
class delFile{
	public function data($data){
		$filename = $_POST["filename"];
		$paths = web_config(array('post_doc_path','thumbnail_path','resized_pic_path'));
		foreach($paths as $key=>$value){unlink($_SERVER['DOCUMENT_ROOT'].$value.$filename);}
	}		
}	



?>