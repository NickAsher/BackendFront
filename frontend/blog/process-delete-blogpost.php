<?php
require_once '../../utils/constants.php';

require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils-pdo.php' ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'utils/utils-blogpost.php' ;

require_once 'utils/utils-blogpost.php';


$BlogId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__blog_id') ;


$DBConnectionBackend = YOPDOSqlConnect() ;



try{

    $BlogInfoArray = getBlogInfo($DBConnectionBackend,$BlogId) ;
    $BlogDisplayPic_Name = $BlogInfoArray['blog_display_image'] ;


    deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $BlogDisplayPic_Name) ;



    $Query = "DELETE FROM `blogs_table` WHERE `blog_id` = :blog_id  " ;
    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'blog_id' => $BlogId
        ]);
    } catch (Exception $e) {
        throw new Exception("Unable to delete the blog post, but image is now deleted: ".$e) ;
    }


    echo "
        <div >
            Succesfully deleted the item
            <a href='all-blogpost.php'>
                Show All posts
            </a>
        </div>
    " ;


} catch (Exception $j) {
    die($j) ;
}




?>


