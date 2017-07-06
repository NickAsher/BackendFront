<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$DBConnectionBackend = YOPDOSqlConnect() ;

$CategoryCode = isSecure_IsValidItemCode(GetPostConst::Post, '__category_code') ;
$SizeId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__size_id') ;


$SizeName = isSecure_IsValidText(GetPostConst::Post, '__size_name') ;
$SizeNameAbbr = isSecure_IsValidText(GetPostConst::Post, '__size_name_abbr') ;
$SizeIsActive = isSecure_IsYesNo(GetPostConst::Post, '__size_is_active') ;




try{
    $DBConnectionBackend->beginTransaction() ;

    $Query = "UPDATE `menu_meta_size_table` 
        SET `size_name` = :size_name , `size_name_short` = :size_name_abbr, `size_is_active` = :size_is_active  
        WHERE `size_id` = :size_id   " ;
    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'size_name' => $SizeName,
            'size_name_abbr' => $SizeNameAbbr,
            'size_is_active' => $SizeIsActive,
            'size_id' => $SizeId
        ]);
    } catch (Exception $e) {
        throw new Exception("unable to update the new item : ".$e->getMessage() ) ;
    }





    $DBConnectionBackend->commit() ;


    echo " 
        Addon-Group Successfully added
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";

} catch (Exception $e){
    $DBConnectionBackend->rollBack() ;
    echo "Unable to edit the size variation: ".$e->getMessage() ;


}


























?>