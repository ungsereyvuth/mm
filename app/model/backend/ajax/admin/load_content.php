<?php
class load_content{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$result=false;$msg='Data load failed';
		$recordid=decodeString($_POST['recordid'],$encryptKey);
		$fromdata=array();
		if(is_numeric($recordid) and $recordid>0){
			$fromdata = $qry->qry_assoc("select * from content where id=$recordid");
			if(count($fromdata)){
				$fromdata = $fromdata[0];
				$fromdata['recordid'] = encodeString($fromdata['id'],$encryptKey);	
				//prepare uploaded img preview
				$files = $fromdata['filenames']<>''?json_decode($fromdata['filenames']):array();
				$file_preview = array();$thumbnail_path=web_config('thumbnail_path');$resized_path = web_config('resized_pic_path');
				$file_input_id = 'attachment';
				foreach($files as $key=>$f){
					$value=$f->filename;
					if(trim($value)<>''){
						$file_detail = file_detail($value);
						if($file_detail['name_en']=='Picture'){$show_preview_file = $thumbnail_path.$value;$isPic=true;}else{$show_preview_file = '/assets/frontend/img/no_preview.png';$isPic=false;}
						$preview_id = time().'_'.$key; 
						$file_preview[] = array('preview_id'=>$preview_id,'preview_item'=>'<div id="file_'.$preview_id.'" class="col-xs-6 col-sm-4 col-md-3 img_preview" style="padding-bottom: 5px; margin-bottom: 5px; border-bottom: 1px solid rgb(233, 233, 233); color: green;"><a id="link_'.$preview_id.'" href="'.$resized_path.$value.'" rel="prettyPhoto"><img src="/assets/frontend/img/blank_img_square.png" id="preview_'.$file_input_id.'_loaded_'.$key.'" class="img-responsive bg_pic_contain fullwidth tooltips" title="'.$f->des.'" style="background-image: url(&quot;'.$show_preview_file.'&quot;);"></a><div class="txtCenter v_pad10 loading_upload"></div><div class="txtCenter"><div>1.87 MB '.$file_detail['icon'].'</div><div><span data-eleid="file_'.$preview_id.'" class="delFile_txt" id="delFile_'.$file_input_id.'_'.$preview_id.'" data-filename="'.$value.'"><i class="fa fa-times"></i> លុប</span></div></div></div>');
					}
				}	
				$fromdata['file_preview'] = $file_preview;	
				$result=true;$msg='Data loaded';
			}
		}
		
		echo json_encode(array('result'=>$result,'msg'=>$msg,'fromdata'=>$fromdata));
	}	
}	



?>