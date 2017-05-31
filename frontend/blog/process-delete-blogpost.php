<?php
require_once '../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;

require_once 'utils/utils-blogpost.php';


$BlogId = isSecure_checkPostInput('__blog_id') ;





$DBConnectionBackend = YOLOSqlConnect() ;
$Query = "SELECT * FROM `blogs_table` WHERE `blog_id` = '$BlogId'  " ;
$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
$BlogInfoArray = '' ;
if($QueryResult) {
    foreach ($QueryResult as $Record) {
        $BlogInfoArray = $Record;
    }

} else{
    die("Problem in getting the blogpost from blogs_table <br> ".mysqli_error($DBConnectionBackend)) ;

}


$BlogDisplayPic_Name = $BlogInfoArray['blog_display_image'] ;


$Del1 = deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $BlogDisplayPic_Name) ;


if($Del1 == -1 ) {
    die("Unable to delete the image from the image folder so can't delete the item ") ;
}


$Query = "DELETE FROM `blogs_table` WHERE `blog_id` = '$BlogId'  " ;
$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
if($QueryResult){
    echo "Succesfully deleted the item " ;
} else {
    echo "unable to delete the blog post, but image is now deleted <br> ".mysqli_error($DBConnectionBackend) ;
}







?>

<div >
    <a href='all-blogpost.php'>
        Show All posts
    </a>
</div>
