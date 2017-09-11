<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php'  ;
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection2.php'  ;
require_once $ROOT_FOLDER_PATH.'/security/input-security.php'  ;
require_once 'utils/utils-blogpost.php';
require_once $ROOT_FOLDER_PATH.'/utils/image-utils-pdo.php'  ;






$BlogId = isSecure_isValidPositiveInteger(GetPostConst::Post, '__blog_id') ;
$NewBlogTitle = isSecure_IsValidText(GetPostConst::Post,'__new_blog_title' ) ;
$NewBlogDate = isSecure_isValidDate($_POST['__new_blog_date']) ;

$NewBlogContent = $_POST['__new_blog_content'] ;

$NewDisplayPic = $_FILES['__new_blog_display_image'] ;


$DBConnectionBackend = YOPDOSqlConnect() ;



try {

    $BlogInfoArray = getBlogInfo($DBConnectionBackend, $BlogId);
    $OldDisplayPic_Name = $BlogInfoArray['blog_display_image'];


    $ImageUpdater = new ImageUpdater($IMAGE_FOLDER_FILE_PATH, $OldDisplayPic_Name, $NewDisplayPic);
    $ImageUpdater->update();

    $InsertedDisplayPic_Name = $ImageUpdater->getInsertedImageName();
    $isNewImageInserted = $ImageUpdater->isNewImageInserted();




    $Query = "UPDATE `blogs_table`
                  SET `blog_creation_date` = :creation_date, `blog_title` = :blog_title,
                    `blog_display_image` = :blog_display_image, `blog_content` = :blog_content
                  WHERE `blog_id` = :blog_id  ";
    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute([
            'creation_date' => $NewBlogDate,
            'blog_title' => $NewBlogTitle,
            'blog_display_image' => $InsertedDisplayPic_Name,
            'blog_content' => $NewBlogContent,
            'blog_id' => $BlogId
        ]);

        echo "Successfully inserted the blog values ";


        try {
            $ImageUpdater->deleteOldImageIfNeeded();
        } catch (Exception $e2) {
            throw new Exception("Problem in deleting the old image :" . $e2);
        }


    } catch (Exception $e) {

        try {
            $ImageUpdater->revertBackChanges();
            echo "Reverted Changes";
        } catch (Exception $e) {
            throw new Exception("Problem in updating the database and also problem in reverting back the changes: " . $e->getMessage());
        }

        throw new Exception("Problem in updating the database, but reverted the changes");


    }




    //success message here
    echo "
        <div >
            <a href='all-blogpost.php'>
                Show All posts
            </a>
        </div>
        " ;


}catch(Exception $j){
    die($j) ;
}



















?>


