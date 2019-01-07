<?php
class loadCommune{
	public function data($data){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb; $_POST=$data;
		$id = $_POST['id']?$_POST['id']:-1;$commune='<option selected value="">--- All ---</option>';
	
		//get car model
		$datarow = $qry->qry_assoc("select id,if('$lang->selected'='kh',title_kh,title_en) title from address_commune where district_id=$id and active=1");
		foreach($datarow as $key=>$value){$commune.='<option value="'.$value['id'].'">'.$value['title'].'</option>';}
		
		$returnData = array();
		if(isset($_POST['targets']) and is_array($_POST['targets'])){
			foreach($_POST['targets'] as $key => $value){
				$returnData[$value]=$commune;
			}
		}		
		echo json_encode($returnData);
	}	
}	



?>