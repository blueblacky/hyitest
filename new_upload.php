<?php
header('Access-Control-Allow-Origin: *');
$cnt = count($_FILES['file']['tmp_name']);
for($i=0;$i<$cnt;$i++){
	if(isset($_FILES["file"]["type"][$i])) {
	$validextensions = array("jpeg", "jpg", "png", "doc", "docx", "pdf");
	$temporary = explode(".", $_FILES["file"]["name"][$i]);
	$file_extension = end($temporary);
		if ((($_FILES["file"]["type"][$i] == "image/png") || ($_FILES["file"]["type"][$i] == "image/jpg") || ($_FILES["file"]["type"][$i] == "image/jpeg") || ($_FILES["file"]["type"][$i] == "application/pdf") || ($_FILES["file"]["type"][$i] == "application/msword")) && ($_FILES["file"]["size"][$i] < 1000000)//Approx. 100kb files can be uploaded.
		&& in_array($file_extension, $validextensions)) {
			if ($_FILES["file"]["error"][$i] > 0) {
			echo "Return Code: " . $_FILES["file"]["error"][$i] . "<br/><br/>";
			}
			else {
				if (file_exists("../uploaded_files/" . $_FILES["file"]["name"][$i])) {
				echo $_FILES["file"]["name"][$i] . " <span id='invalid'><b>already exists.</b></span> ";
				}
				else
				{
				$sourcePath = $_FILES['file']['tmp_name'][$i]; // Storing source path of the file in a variable
				$targetPath = "../uploaded_files/".$_FILES['file']['name'][$i]; // Target path where file is to be stored
				move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
				
				$file_name = $_FILES['file']['tmp_name'][$i];
				$file_item_type = explode(".", $_FILES["file"]["name"][$i]);
				$file_type = end($file_item_type);
				//$new_name = date('YmdHisu').$file_name;
				$new_name = date('YmdH').".".$file_type;
				rename("../uploaded_files/".$_FILES['file']['name'][$i]."", "../uploaded_files/".$new_name."");
				/*include('open_db.php');		
				$result = "INSERT INTO investor_advance_doc(investor_id,file_type,file_path,status) VALUES('1','".$file_type."','".$new_name."','Active')";
				$exe_query = mysql_query($result);*/
				$flag = 1;
				}
			}
		}
		else{
			echo "<span id='invalid'>***Invalid file Size or Type***<span>";
			$flag=0;
		}
	}
}
/*if ($exe_query!=false){
	echo "1";
} else {
	echo "0";
}*/
if ($flag == 1){
	echo "1";
} else {
	echo "0";
}
?>