<?php
require_once '../../../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/menu-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;


$CategoryCode = isSecure_IsValidItemCode(GetPostConst::Post, '__category_code');
$SizeId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__size_id');

if(!isset($_POST['__is_delete'])){
    die("The delete action is not set") ;
}


$DBConnectionBackend = YOPDOSqlConnect() ;



try{
    $DBConnectionBackend->beginTransaction() ;


    $Table1 = "menu_meta_size_table" ;
    $Table2 = "menu_meta_rel_size-items_table" ;
    $Table3 = "menu_meta_rel_size-addons_table" ;


    $Query1 = "DELETE `$Table1` , `$Table2` , `$Table3` 
      FROM `$Table1`   INNER JOIN `$Table2`  INNER JOIN `$Table3`  
      ON `$Table1`.`size_id` =  `$Table2`.`size_id`  AND `$Table1`.`size_id` = `$Table3`.`size_id` 
        AND `$Table1`.`size_category_code` =  `$Table2`.`item_category_code`  AND `$Table1`.`size_category_code` = `$Table3`.`category_code`
      WHERE `$Table1`.`size_category_code` = :category_code AND `$Table1`.`size_id` = :size_id  ";

    try {
        $QueryResult1 = $DBConnectionBackend->prepare($Query1);
        $QueryResult1->execute([
            'category_code' => $CategoryCode,
            'size_id' => $SizeId
        ]);
    } catch (Exception $e) {
        throw new Exception("Problem in the delete query for size table ".$e->getMessage()) ;

    }



    /*
     * This is the case when there is not a single menu item and not a sngle addon item
     * Then the Query1  will delete 0 rows. So in that case we just have to delete the size from menu_meta_size_table
     */
    if($QueryResult1->rowCount() == 0){
        $Query2 = "DELETE FROM $Table1 WHERE `size_id` = :size_id  " ;
        try {
            $QueryResult2 = $DBConnectionBackend->prepare($Query2);
            $QueryResult2->execute([
                'size_id' => $SizeId
            ]);
        } catch (Exception $e) {
            throw new Exception("Unable to delete the item from size table: ".$e->getMessage()) ;
        }
    }







    /*
     * This query is used to re-sort the Sr No of the Sizes
     */
    $AllSizesInThisCategory = getListOfAllSizesInCategory_PDO($DBConnectionBackend, $CategoryCode) ;
    if(count($AllSizesInThisCategory) != 0) {

        $CaseStatement = '';
        $RealSortNo = 1;
        foreach ($AllSizesInThisCategory as $Record2) {
            $ThisSize_SizeId = $Record2['size_id'];
            $CaseStatement .= "WHEN `size_id` = '$ThisSize_SizeId' THEN '$RealSortNo' ";
            $RealSortNo++;
        }

        $Query3 = "UPDATE `$Table1` SET `size_sr_no` = CASE $CaseStatement END WHERE `size_category_code` = :category_code  ";
        try {
            $QueryResult3 = $DBConnectionBackend->prepare($Query3);
            $QueryResult3->execute(['category_code' => $CategoryCode]);
        } catch (Exception $e) {
            throw new Exception("Error in sorting the new Subcategories: " . $e->getMessage() );
        }

    }





    $DBConnectionBackend->commit() ;


    echo " 
        Size Variration Successfully deleted, 
        <br><br>
        <a href='../all-subcat.php'>Go Back</a>
    ";

} catch (Exception $e){
    echo "Unable to delete the size variation: ".$e->getMessage() ;
    $DBConnectionBackend->rollBack() ;


}











?>