<?php
require_once '../../../utils/constants.php' ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once '../utils/menu-utils.php';


$DBConnectionBackend = YOLOSqlConnect() ;


$ItemCategory = isSecure_checkPostInput('__item_category') ;
$ItemSubCategory = isSecure_checkPostInput('__item_subcategory') ;
$ItemName = isSecure_checkPostInput('__item_name') ;
$ItemPriceSize1 = isSecure_checkPostInput('__item_price_size1') ;
$ItemPriceSize2 = isSecure_checkPostInput('__item_price_size2') ;
$ItemPriceSize3 = isSecure_checkPostInput('__item_price_size3') ;
$ItemDescription = isSecure_checkPostInput('__item_description') ;

$CategoryInfoArray = getSingleCategoryInfoArray($DBConnectionBackend, $ItemCategory) ;
$NoOfSizeVariations = $CategoryInfoArray['category_no_of_size_variations'] ;

    $ImageFileArrayVariable = $_FILES['__item_image'] ;
    $Item_ImageName = moveImageToImageFolder($DBConnectionBackend, "$IMAGE_FOLDER_FILE_PATH/", $ImageFileArrayVariable);
    if($Item_ImageName == -1){
        die("error in image uoloading") ;
    }


    $Query = "INSERT INTO `menu_items_table` 
      VALUES ('', '$ItemName', '$ItemDescription', '$Item_ImageName', '$ItemCategory', '$ItemSubCategory',
       '$NoOfSizeVariations', $ItemPriceSize1, $ItemPriceSize2, $ItemPriceSize3 )  " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;

    if($QueryResult){
        echo "
        Item Successfully added
        <br><br>
        <a href='all-menuitems.php' >Go Back</a>
    " ;
    } else {
        $Del1 = deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $Item_ImageName) ;
        if($Del1){
            echo "unable to insert the new item , so deleted the image  <br><br>".mysqli_error($DBConnectionBackend) ;
        }
        echo "unable to insert the new item and image deletion also failed <br><br>".mysqli_error($DBConnectionBackend) ;

    }





















?>