<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;

require_once $ROOT_FOLDER_PATH.'/utils/image-utils-pdo.php' ;

$DBConnectionBackend = YOPDOSqlConnect() ;

$CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id') ;
$SizeId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__size_id') ;
$SizeName = isSecure_IsValidText(GetPostConst::Post, '__size_name') ;
$SizeNameAbbr = isSecure_IsValidText(GetPostConst::Post, '__size_name_abbr') ;
$SizeIsActive = isSecure_IsYesNo(GetPostConst::Post, '__size_is_active') ;

$SizeDescription = isSecure_checkPostInput('__size_description') ;





$ImageUpdater = new ImageUpdater($IMAGE_FOLDER_FILE_PATH, getSingleSizeInfoArray_PDO($DBConnectionBackend, $SizeId)['size_image'], $_FILES['__size_image']) ;
try{
    $ImageUpdater->update() ;
}catch (Exception $e){
    die($e->getMessage()) ;
}



try{
    $DBConnectionBackend->beginTransaction() ;

    $Query = "UPDATE `menu_meta_size_table` 
        SET `size_name` = :size_name , `size_name_short` = :size_name_abbr, `size_is_active` = :size_is_active , `size_image`= :size_image , `size_description` = :size_description
        WHERE `size_id` = :size_id   " ;
    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'size_name' => $SizeName,
            'size_name_abbr' => $SizeNameAbbr,
            'size_is_active' => $SizeIsActive,
            'size_id' => $SizeId,
            'size_image'=>$ImageUpdater->getInsertedImageName(),
            'size_description'=>$SizeDescription
        ]);


        try{
            $ImageUpdater->deleteOldImageIfNeeded() ;
        }catch (Exception $e){
            throw new Exception("Problem in deleting the old image :".$e->getMessage()) ;
        }



    } catch (Exception $e) {
        throw new Exception("unable to update the new item : ".$e->getMessage() ) ;
    }





    $DBConnectionBackend->commit() ;


    echo " 
        Size Successfull Updated added
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";

} catch (Exception $e){
    $DBConnectionBackend->rollBack() ;
    echo "Unable to edit the size variation: ".$e->getMessage() ;

    try{
        $ImageUpdater->revertBackChanges() ;
        echo "Reverted Changes" ;
    }catch (Exception $e){
        die("Problem in reverting back the changes: ".$e->getMessage()) ;
    }

}


























?>