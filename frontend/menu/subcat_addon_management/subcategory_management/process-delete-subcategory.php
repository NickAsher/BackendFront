<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__category_id') ;
$SubCategoryRelId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__subcategory_rel_id') ;


$DBConnectionBackend = YOPDOSqlConnect() ;

try{

    $DBConnectionBackend->beginTransaction() ;






    $Table1 = "menu_meta_subcategory_table" ;
    $Table2 = "menu_items_table" ;
    $Table3 = "menu_meta_rel_size_items_table" ;

    $Query2 = "DELETE `$Table1` , `$Table2` , `$Table3` 
      FROM `$Table1`   INNER JOIN `$Table2`  INNER JOIN `$Table3`  
      ON `$Table2`.`item_subcategory_rel_id` =  `$Table1`.`rel_id`  AND `$Table2`.`item_id` = `$Table3`.`item_id`
      WHERE `$Table1`.`rel_id` = :rel_id ";

    try {
        $QueryResult2 = $DBConnectionBackend->prepare($Query2);
        $QueryResult2->execute([
            'rel_id' => $SubCategoryRelId
        ]);
    } catch (Exception $e) {
        throw new Exception("Unable to delete the subcategory: ".$e->getMessage() ) ;
    }


    /* This is the case when there is no item in the menu_items_table but the subcategory is there

     * In that case
     * Query2 will delete 0 rows because of join ON condition . So this is done to just delete the subcategory
     */
    if($QueryResult2->rowCount() == 0) {
        $Query3 = "DELETE FROM `$Table1` WHERE `rel_id` = :rel_id   " ;
        try {
            $QueryResult3 = $DBConnectionBackend->prepare($Query3);
            $QueryResult3->execute([
                'rel_id' => $SubCategoryRelId
            ]);
        } catch (Exception $e) {
            throw new Exception("Unable to delete the subcategory: ".$e->getMessage() ) ;
        }


    }





    /*
     * This query is used to re-sort the Sr No of the subcategories
     */


    $ListOfAllSubcategories = getListOfAllSubCategory_InACategory_Array_PDO($DBConnectionBackend, $CategoryId) ;

    if(count($ListOfAllSubcategories) != 0) {

        $CaseValues = array() ;
        $CaseStatement = '';
        $RealSortNo = 1;
        foreach ($ListOfAllSubcategories as $Record4) {
            $ThisSubCategoryRelId = $Record4['rel_id'];
            $CaseStatement .= "WHEN `rel_id` = ? THEN '$RealSortNo' ";
            array_push($CaseValues, $ThisSubCategoryRelId) ;
            $RealSortNo++;
        }

        $Query5 = "UPDATE `$Table1` SET `subcategory_sr_no` = CASE $CaseStatement END WHERE `category_id` = ?  ";
        array_push($CaseValues, $CategoryId) ;


        try {
            $QueryResult5 = $DBConnectionBackend->prepare($Query5);
            $QueryResult5->execute($CaseValues);
        } catch (Exception $e) {
            throw new Exception("Error in sorting the new Subcategories: " . $e->getMessage());
        }

    }






    $DBConnectionBackend->commit() ;


    echo " 
 
        SubCategory  Successfully deleted
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";

} catch (Exception $e){
    echo $e->getMessage() ;
    echo " 
        <br><Br>
        SubCategory  Error Above
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";
    $DBConnectionBackend->rollBack() ;


}


















?>