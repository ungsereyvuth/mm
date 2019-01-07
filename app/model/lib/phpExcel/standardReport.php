<?php	
	/*include_once("app/model/db.php");
	include_once("app/model/functions.php");
	include_once("app/model/language.php");
	include_once("app/model/checksession.php");*/
	require_once 'phpexcel/PHPExcel.php';
	
	
class exportexcel{
	public function data(){
		global $encryptKey,$language,$usersession,$layout,$layout_label,$lang;
		$qry = new connectDb;
		if(isset($_POST['listName'])){	
		
		$listName= $_POST["listName"];	
		$stringSQL=decodeString($_POST["sql"],$encryptKey);	
		$validRequest=false;
		
/*------------start query list--------------*/	
	
	if($listName=='seminar_member_list'){	
		$selectedFields='ឈ្មោះស្ថាប័ន,ប្រភេទស្ថាប័ន,ប្រធានបទចូលរួម,ឈ្មោះទំនាក់ទំនង,តួនាទី,ទូរស័ព្ទ,អ៊ីម៉ែល,ថ្ងៃចុះឈ្មោះ';
		//$qryString=str_replace('*',$selectedFields,$stringSQL);	
		$tblHeader = $selectedFields;
		$columnName=explode(',',$selectedFields);	
		$listTitle="First National Conference on “Chinese Tourism Market and China Ready for Cambodia Tourism”";
		$sheetName=$listName;
		$fileName=$listName;	
		$validRequest=true;
	}elseif($listName=='chinese_speaking_candidate_list'){	
		$selectedFields='​រូបថត,រាជធានី/ខេត្ត,ឈ្មោះពេញ (ខ្មែរ),ឈ្មោះពេញ (ឡាតាំង),ជនជាតិ,សញ្ជាតិ,ភេទ,ថ្ងៃកំណើត,ទីកន្លែងកំណើត,អាសយដ្ឋានបច្ចុប្បន្ន,មុខរបរសព្វថ្ងៃ,កំរិតរប្បធម៌,ឯកទេស,ជំនាញផ្សេងៗ,ទូរស័ព្ទ,អ៊ីម៉េល,ភាសាបរទេស,ស្ថានភាពគ្រួសារ,ឪពុកឈ្មោះ,អាយុ,ជនជាតិ,មុខរបរ,ស្ថានភាព,ម្តាយឈ្មោះ,អាយុ,ជនជាតិ,មុខរបរ,ស្ថានភាព,ឯកសារភ្ជាប់,ថ្ងៃចុះឈ្មោះ';
		//$qryString=str_replace('*',$selectedFields,$stringSQL);	
		$tblHeader = $selectedFields;
		$columnName=explode(',',$selectedFields);	
		$listTitle="ការប្រឡងជ្រើសរើសអ្នកនិយាយភាសាចិនឆ្នើម ក្នុងវិស័យទេសចរណ៍ ប្រចាំឆ្នាំ២០១៦";
		$sheetName=$listName;
		$fileName=$listName;	
		$validRequest=true;
	}
	
	
	if(!$validRequest){echo 'Invalid Request!';exit;}
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();	
	$startRowIndex =3;
	$exportedDate = date("d-M-Y H:i:s A");
	$letters = range('A', 'Z');
	//add more column letters
	$stdLetter = $letters;
	foreach($stdLetter as $value){$letters[]='A'.$value;}
	
	$getSQLCondition = getStringBetween($stringSQL,'where','order');
	$borderStyle = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
	$cellHeadColor=array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'startcolor'=>array('rgb'=>'d4d4d4'));
	$bgRedColor=array('type'=>PHPExcel_Style_Fill::FILL_SOLID,'startcolor'=>array('rgb'=>'fe96a6'));
	
	// merge cell
	$objPHPExcel->getActiveSheet()->setCellValue("A1",$listTitle)->mergeCells("A1:".$letters[count($columnName)]."1");	//not use count()-1 bcoz we add No. column which is not in fieldlist			
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true)->setSize(15)->getColor()->setRGB('6F6F6F');	
	$objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	$objPHPExcel->getActiveSheet()->setCellValue('A2', 'No.');	
	$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($borderStyle);
	$objPHPExcel->getActiveSheet()->getStyle('A2')->getFill()->applyFromArray($cellHeadColor);	
	for($i=0;$i<=count($columnName)-1;$i++){
		$objPHPExcel->getActiveSheet()->setCellValue($letters[$i+1].'2', $columnName[$i]);
		$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getStyle($letters[$i+1].'2')->applyFromArray($borderStyle);
		$objPHPExcel->getActiveSheet()->getStyle($letters[$i+1].'2')->getFill()->applyFromArray($cellHeadColor);	
		$objPHPExcel->getActiveSheet()->getStyle($letters[$i+1].'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	}
		
	$autoNum=1;
	if($listName=='seminar_member_list'){
		$listData = $qry->qry_assoc($stringSQL);		
		foreach($listData as $key=>$value){					
			$rowdata = array(
								$value['company_name'],
								$value['company_type'],
								$value['join_topic'],
								$value['contact_name'],
								$value['contact_position'],
								$value['contact_mobile'],
								$value['contact_email'],
								date("d-m-Y",strtotime($value['created_date'])));
										
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$startRowIndex, $autoNum);		
			for($i=0;$i<=count($columnName)-1;$i++){
				$newData = $rowdata[$i];
				$objPHPExcel->getActiveSheet()->setCellValue($letters[$i+1].$startRowIndex, strip_tags($newData));		
			}		
			$objPHPExcel->getActiveSheet()->getStyle('A'.$startRowIndex.':'.$letters[count($columnName)].$startRowIndex)->applyFromArray($borderStyle);//not use count()-1 bcoz we add No. column which is not in fieldlist				
			$startRowIndex++;$autoNum++;
		}
	}elseif($listName=='chinese_speaking_candidate_list'){
		$listData = $qry->qry_assoc($stringSQL);
		$docPath = web_config('post_doc_path');	
		$fulldocpath = $layout_label->system_title->sys->url.$docPath;		
		foreach($listData as $key=>$value){		
			$rowdata = array(
								$fulldocpath.$value['photo'],
								$value['contest_location'],
								$value['fullname_kh'],
								$value['fullname_en'],
								$value['national'],
								$value['nationality'],
								$value['gender'],
								$value['dob'],
								$value['pob'],
								$value['current_address'],
								$value['current_job'],
								$value['degree'],
								$value['skill'],
								$value['other_skill'],
								$value['mobile'],
								$value['contact_email'],
								$value['language_skill'],
								$value['marital_status'],
								$value['father_name'],
								$value['father_age'],
								$value['father_national'],
								$value['father_job'],
								$value['father_status'],
								$value['mother_name'],
								$value['mother_age'],
								$value['mother_national'],
								$value['mother_job'],
								$value['mother_status'],
								$fulldocpath.$value['attached_document'],
								date("d-m-Y",strtotime($value['created_date'])));
										
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$startRowIndex, $autoNum);		
			for($i=0;$i<=count($columnName)-1;$i++){
				$newData = $rowdata[$i];
				$objPHPExcel->getActiveSheet()->setCellValue($letters[$i+1].$startRowIndex, strip_tags($newData));		
			}		
			$objPHPExcel->getActiveSheet()->getStyle('A'.$startRowIndex.':'.$letters[count($columnName)].$startRowIndex)->applyFromArray($borderStyle);//not use count()-1 bcoz we add No. column which is not in fieldlist				
			$startRowIndex++;$autoNum++;
			
			/*$gdImage = imagecreatefromjpeg($fulldocpath.$value['photo']);
			// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
			$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
			$objDrawing->setName('Sample image');$objDrawing->setDescription('Sample image');
			$objDrawing->setImageResource($gdImage);
			$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
			$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
			$objDrawing->setHeight(150);
			$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
			$objDrawing->setCoordinates('A3');*/
		}
	}
		
	//$objPHPExcel->getActiveSheet()->setCellValue('A'.($startRowIndex+1), 'Queried By: '.$getSQLCondition)->mergeCells('A'.($startRowIndex+1).':'.$letters[count($columnName)-1].($startRowIndex+1));
	$objPHPExcel->getActiveSheet()->setCellValue('A'.($startRowIndex+1), 'កាលបរិច្ឆេទបោះពុម្ភ៖ '.$exportedDate.' (UTC +07:00 ភ្នំពេញ)')->mergeCells('A'.($startRowIndex+1).':'.$letters[count($columnName)].($startRowIndex+1));
	//$objPHPExcel->getActiveSheet()->setCellValue('A'.($startRowIndex+3), 'Exported By: '.strtoupper(username))->mergeCells('A'.($startRowIndex+3).':'.$letters[count($columnName)-1].($startRowIndex+3));
	  
	$objPHPExcel->getActiveSheet()->setTitle($sheetName);
	$excelName = $fileName.".xlsx";
		
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('export/'.$excelName);	
	//header("Location:". $excelName);
	echo '/export/'.$excelName;
	
/*------------end query list--------------*/			
		
		}	
	}	
}	