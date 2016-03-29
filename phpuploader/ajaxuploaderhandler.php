<?php require_once "include_phpuploader.php" ?>
<?php

//set_time_limit(3600);


$uploader=new PhpUploader();

$uploader->PreProcessRequest();



$mvcfile=$uploader->GetValidatingFile();


if($mvcfile->FileName=="thisisanotvalidfile")
{
	$uploader->WriteValidationError("My custom error : Invalid file name. ");
	exit(200);
}

// $uploader->SaveDirectory = "savefiles/";
// $uploader->AllowedFileExtensions = 'true';

if( $uploader->SaveDirectory )
{
	if(!$uploader->AllowedFileExtensions)
	{
		$uploader->WriteValidationError("When using SaveDirectory property, you must specify AllowedFileExtensions for security purpose.");
		exit(200);
	}

	$cwd=getcwd();
	chdir( dirname($uploader->_SourceFileName) );
	if( ! is_dir($uploader->SaveDirectory) )
	{
		$uploader->WriteValidationError("Invalid SaveDirectory ! not exists.".$uploader->SaveDirectory);
		exit(200);
	}
	chdir( $uploader->SaveDirectory );
	$wd=getcwd();
	chdir($cwd);

	$targetfilepath=  "$wd/" .$_COOKIE["set_name_img"]. $mvcfile->FileName;
	if( file_exists ($targetfilepath) )
		unlink($targetfilepath); // edit

	$mvcfile->CopyTo( $targetfilepath );

	echo $HTTP_COOKIE_VARS["strName"];


}

$uploader->WriteValidationOK("");

?>