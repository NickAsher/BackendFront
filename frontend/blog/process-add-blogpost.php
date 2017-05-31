<?php
require_once '../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php'  ;
require_once 'utils/utils-blogpost.php';
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;





if(isset($_POST['__blog_title']) ){
    if(!empty($_POST['__blog_title'])){


        $DBConnectionBackend = YOLOSqlConnect() ;

        $CreationTimeStamp = date("Y-m-d H:i:s") ;
        $ModifiedTimeStamp = date("Y-m-d H:i:s") ;
        $BlogTitle = $_POST['__blog_title'] ;
        $BlogDisplayImageArrayVariable = $_FILES['__blog_display_image'] ;
        $BlogContent = $_POST['__blog_content'] ;
        $BlogContent = mysqli_real_escape_string($DBConnectionBackend, $BlogContent) ;



        $BlogDisplayImage_Name = moveImageToImageFolder($DBConnectionBackend, $IMAGE_FOLDER_FILE_PATH, $BlogDisplayImageArrayVariable) ;
        if($BlogDisplayImage_Name == -1){
            die("Problem in moving the uploaded files") ;

        }

        $Query = "INSERT INTO `blogs_table` VALUES ('', '$CreationTimeStamp', '$ModifiedTimeStamp',
          '$BlogTitle', '$BlogDisplayImage_Name', '$BlogContent')  " ;

        $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
        if($QueryResult){
            echo "Successfully inserted the blog values " ;

        } else {
            deleteImageFromImageFolder($IMAGE_FOLDER_FILE_PATH, $BlogDisplayImage_Name) ;
            echo "Problem in inserting the blog values into the table <br> ".mysqli_error($DBConnectionBackend) ;

        }

    }
}







?>
<div>
    <a href="all-blogpost.php">
        Show All Blogposts
    </a>
</div>
