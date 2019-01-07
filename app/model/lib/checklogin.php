<?php

//include_once("app/model/db.php");

//include_once("app/model/functions.php");

//include_once("app/model/language.php");



class login_start{

	public function data(){		

		global $layout,$layout_label,$lang,$language;	

		$qry = new connectDb;

		$result = 0; global $encryptKey;		


		$msg = $layout_label->label->invalid_acc->title; $url = '/'.$lang->selected;
		if(isset($_POST['username']) and isset($_POST['password'])){ 

			if($_POST['username']<>'' and $_POST['password']<>''){

				$username = post('username');

				$password = post('password');				

				$encriptedpass = encodeString($password,$encryptKey);

				$conn = $qry->connect();

				if ($stmt = mysqli_prepare($conn, "SELECT id,email FROM users WHERE BINARY username=? AND password=? AND pending=? AND active=? LIMIT 1")) { //create a prepared statement

					$pending = 0; $active = 1;

					mysqli_stmt_bind_param($stmt, "ssii", $username,$encriptedpass,$pending,$active);

					mysqli_stmt_execute($stmt);			

					mysqli_stmt_store_result($stmt);

					$count = mysqli_stmt_num_rows($stmt);

					if($count==1){ 

						if (!is_session_started()) session_start();

						mysqli_stmt_bind_result($stmt, $get_userid, $get_username);      

						while(mysqli_stmt_fetch($stmt)){
							if((role_allowed($get_userid) and web_config('enable_login')) or isTesting()){
								//set login session
								$_SESSION['userid']=$get_userid;
								$_SESSION['username']= $get_username;		
								$_SESSION['token']= encodeString($get_userid,$encryptKey);
								//add to user log
								adduserlog('login',$get_userid);								
	
								$userinfo = userinfo($get_userid);
	
								$roleinfo = roleinfo($userinfo['role_id']);			
	
								$result = 1;$msg=$layout_label->label->valid_acc->icon.' '.$layout_label->label->valid_acc->title;
	
								if(isset($_POST['nexturl']) and $_POST['nexturl']<>''){$url = $_POST['nexturl'];}//check if have redirect url from login form
								elseif(isset($_SESSION['nexturl'])){$url = '/'.$_SESSION['nexturl'];}//check if have redirect url	
								elseif($roleinfo['homepage']<>''){$url = $roleinfo['homepage'];} //check for default homepage of user role	
								unset($_SESSION['nexturl'],$_SESSION['guest_id']);
	
							 }else{session_destroy();}
						}
					}

					mysqli_stmt_close($stmt);

					mysqli_close($conn);

				}	

				

			}

		}

		$data = array('result'=>$result,'msg'=>$msg,'url'=>$url);

		echo json_encode($data);

	}	

}







?>