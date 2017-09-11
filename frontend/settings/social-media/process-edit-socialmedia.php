<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once $ROOT_FOLDER_PATH.'/utils/updater-utils.php';


$DBConnectionBackend = YOPDOSqlConnect() ;



$Query = "SELECT * FROM `info_social_media_table`  " ;
try{
    $QueryResult = $DBConnectionBackend->query($Query) ;
    $TempArray = $QueryResult->fetchAll() ;
}catch (Exception $e){
    die("Error in getting the Social Media ids: ".$e->getMessage()) ;
}







$CaseStatement = '' ;
$LinkValuesArray = array() ;

foreach ($TempArray as $Record){
    $SocialMedia_Id = $Record['socialmedia_id'] ;
    $CaseStatement .= "WHEN `socialmedia_id` = '$SocialMedia_Id' THEN ? " ;
    $LinkValuesArray[] = isSecure_checkPostInput("__socialmedia_$SocialMedia_Id") ;

}





$Query2 = "UPDATE `info_social_media_table` SET `socialmedia_link` = CASE $CaseStatement END  " ;
try{
    $QueryResult2 = $DBConnectionBackend->prepare($Query2) ;
    $QueryResult2->execute($LinkValuesArray) ;
}catch (Exception $e){
    die("Error in updating the valuese: ".$e->getMessage()) ;
}


echo "
    Successfully updated values
    <a href='read-socialmedia.php'>Go Back</a>
" ;









?>