<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php'  ;
require_once 'utils/utils-blogpost.php';
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php'  ;


if(  !isset($_POST['__new_blog_title']) || empty($_POST['__new_blog_title']) ) {
    die("Blog data is not set");
}





        $BlogId = $_POST['__blog_id'] ;

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

        $OldDisplayPic_Name = $BlogInfoArray['blog_display_image'] ;

        $NewBlogTitle = $_POST['__new_blog_title'] ;
        $NewBlogContent = $_POST['__new_blog_content'] ;



        $NewDisplayPic = $_FILES['__new_blog_display_image'] ;

        /*
             * This is the logic which checkes whether a new image is uploaded or not
             * If a new image has been uploaded, then it update the image with the new image
             * Otherwise it will update the old image with the old image, i.e. update will occur, either new or old
             *
             * If an image is not uploaded then it's size is 0 and we have an error value of 4
             * So we check for this. If indeed the image is not uploaded, then we set the NewImage_Boolean to false
             * which indicates that a new image is not uploaded and in that case we use the already exisiting Old image
             *
             * If the Boolean is true, meaning that a new image is there, then we move that image to images folder
             * Then after that we set the inserted image to be new image
             */

        $InsertedDisplayPic_Name = null;

        if($NewDisplayPic['size'] == 0 || $NewDisplayPic['error'] == 4){
            $NewDisplayPic_Boolean = false ;
            $InsertedDisplayPic_Name = $OldDisplayPic_Name ;
        } else{
            $NewDisplayPic_Boolean = true ;
            $NewDisplayPic_Name = moveImageToImageFolder($DBConnectionBackend, $IMAGE_FOLDER_FILE_PATH, $NewDisplayPic) ;
            if($NewDisplayPic_Name == -1){
                die("Problem in uploading the new image") ;
            }
            $InsertedDisplayPic_Name = $NewDisplayPic_Name ;
        }




        $NewLastModifiedTimeStamp = date("Y-m-d H:i:s") ;
        $Query = "UPDATE `blogs_table`
                  SET `blog_last_modified_timestamp` = '$NewLastModifiedTimeStamp', `blog_title` = '$NewBlogTitle',
                    `blog_display_image` = '$InsertedDisplayPic_Name', `blog_content` = '$NewBlogContent'
                  WHERE `blog_id` = '$BlogId'  " ;

        $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
        if($QueryResult){
            echo "Successfully inserted the blog values " ;


            /*
            * Delete Old Image Files
            */


            /*
             * Now the case here is that an image in updated(can be old, can be new, we don't know)
             * And there is a successfull update in the database.
             * So now there are two cases that arise
             * The inserted image is new(new image was inserted) or the inserted image is old(old image was inserted)
             *
             * If the inserted image is new, then we have to delete the old one
             * If the inserted image is old, then we don't have to do anything
             */

            if($NewDisplayPic_Boolean == true){

                // Inserted Pic is new so delete the old one
                deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $OldDisplayPic_Name) ;
                echo "Old Display Image is deleted" ;
            }else{
                // Inserted Image is old so delete nothing
            }


        }


        else {
            echo "Problem in inserting the blog values into the table <br> ".mysqli_error($DBConnectionBackend) ;

            /*
             * Now is the case when a image is update (can be old, can be new, we don't know)
             * But there is a problem in updating the database.
             * So what we have to do is just like a transaction, we roll back any changes
             *
             * So if the inserted image is new, then we delete it
             * but if the inserted image was old, then do nothing
             *
             */

            if($NewDisplayPic_Boolean == true){
                // inserted image is new, delete it
                deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $NewDisplayPic_Name) ;
                echo "New Display Image is deleted" ;

            }else{
                // image uploaded is old so delete nothing
            }



        }

























?>

<div >
    <a href='all-blogpost.php'>
        Show All posts
    </a>
</div>
