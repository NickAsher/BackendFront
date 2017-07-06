<?php
require_once '../../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

$DBConnectionBackend = YOPDOSqlConnect() ;

$CategoryCode = isSecure_IsValidItemCode(GetPostConst::Post, '__category_code') ;
$AddonGroupDisplayName = isSecure_IsValidText(GetPostConst::Post, '__addongroup_name') ;
$AddonGroupType = isSecure_IsValidText(GetPostConst::Post, '__addongroup_type') ;
$AddonGroupNoOfItems = 0 ;
$AddonGroupIsActive = isSecure_IsYesNo(GetPostConst::Post, '__addongroup_is_active') ;






$Query = "INSERT INTO `menu_meta_rel_category-addon_table` (`addon_group_sr_no`, `rel_id`, `category_code`, `addon_group_display_name`, `addon_group_type`, `addon_group_no_of_items`, `addon_group_is_active` )
  SELECT COALESCE( (MAX( `addon_group_sr_no` ) + 1), 1), '', :category_code, :adngrp_displayname, :adngrp_type, :adngrp_noitems, :adngrp_isactive 
  FROM `menu_meta_rel_category-addon_table` WHERE `category_code` = :category_code_02  " ;



try{

    $QueryResult = $DBConnectionBackend->prepare($Query) ;
    $QueryResult->execute([
        'category_code'=>$CategoryCode,
        'adngrp_displayname'=>$AddonGroupDisplayName,
        'adngrp_type'=>$AddonGroupType,
        'adngrp_noitems'=>$AddonGroupNoOfItems,
        'adngrp_isactive'=>$AddonGroupIsActive,
        'category_code_02'=>$CategoryCode

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