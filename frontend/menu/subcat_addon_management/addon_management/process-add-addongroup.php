<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$DBConnectionBackend = YOPDOSqlConnect() ;

$CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id') ;
$AddonGroupDisplayName = isSecure_IsValidText(GetPostConst::Post, '__addongroup_name') ;
$AddonGroupType = isSecure_IsValidText(GetPostConst::Post, '__addongroup_type') ;
$AddonGroupIsActive = isSecure_IsYesNo(GetPostConst::Post, '__addongroup_is_active') ;






$Query = "INSERT INTO `menu_meta_addongroups_table` (`addon_group_sr_no`, `rel_id`, `category_id`, `addon_group_display_name`, `addon_group_type`, `addon_group_is_active` )
  SELECT COALESCE( (MAX( `addon_group_sr_no` ) + 1), 1), '', :category_id, :adngrp_displayname, :adngrp_type, :adngrp_isactive 
  FROM `menu_meta_addongroups_table` WHERE `category_id` = :category_id_02  " ;



try{

    $QueryResult = $DBConnectionBackend->prepare($Query) ;
    $QueryResult->execute([
        'category_id'=>$CategoryId,
        'adngrp_displayname'=>$AddonGroupDisplayName,
        'adngrp_type'=>$AddonGroupType,
        'adngrp_isactive'=>$AddonGroupIsActive,
        'category_id_02'=>$CategoryId

    ]) ;


    echo " 
        Addon-Group Successfully added
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    
    
    ";
} catch(Exception $e) {
    die( "unable to insert the new item  <br><br>".$e->getMessage()) ;
}





















?>