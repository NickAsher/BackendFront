<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php' ;
require_once 'utils/utils-blogpost.php';
require_once $ROOT_FOLDER_PATH.'/utils/image-utils-pdo.php' ;



$BlogTitle = isSecure_IsValidText(GetPostConst::Post, '__blog_title') ;
$BlogDisplayImageArrayVariable = $_FILES['__blog_display_image'] ;
$BlogContent = isSecure_checkPostInput_String('__blog_content') ;
$CreationTimeStamp = date("Y-m-d H:i:s") ;


$DBConnectionBackend = YOPDOSqlConnect() ;


try {

    // this will throw an exception if unsuccessfull and page will not move any further
    $BlogDisplayImage_Name = moveImageToImageFolder($IMAGE_FOLDER_FILE_PATH, $BlogDisplayImageArrayVariable);



    $Query = "INSERT INTO `blogs_table` VALUES ('', :creation_timestamp, :blog_title, :blog_image_name, :blog_content)  ";

    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'creation_timestamp' => $CreationTimeStamp,
            'blog_title' => $BlogTitle,
            'blog_image_name' => $BlogDisplayImage_Name,
            'blog_content' => $BlogContent
        ]);
    } catch (Exception $e) {

        try {
            deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $BlogDisplayImage_Name);
        } catch (Exception $e) {
            throw new Exception("There is an error and so blog is not inserted and an error has arised in deleting the inserted image: ".$e) ;
        }
        throw new Exception("Problem in inserting the blog values into the table, but deleted the image " . $e);
    }



    echo "
        <div>
            <a href='all-blogpost.php'>
                Show All Blogposts
            </a>
        </div>
        
    " ;




}catch(Exception $j){
    die($j) ;
}




?>

