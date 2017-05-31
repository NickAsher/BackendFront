<?php
require_once '../../../utils/constants.php';
require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php' ;
require_once $ROOT_FOLDER_PATH.'/utils/image-utils.php' ;
$DBConnectionBackend = YOLOSqlConnect() ;



if(!isset($_FILES['__newimage_imageFile']) || empty($_FILES['__newimage_imageFile'])){
    die("The post data sent is empty") ;
}

$ImageFileArrayVariable = $_FILES['__newimage_imageFile'] ;
$NewImageName = moveImageToImageFolder($DBConnectionBackend, $IMAGE_FOLDER_FILE_PATH, $ImageFileArrayVariable);
if($NewImageName == -1){
    die("error in image uoloading") ;
}



$Query = "INSERT INTO `opening_screen_image_table` VALUES ('', '$NewImageName')  " ;
$QueryResult = mysqli_query($DBConnectionBackend, $Query) ;

if($QueryResult){
    echo "Item Successfully added" ;

    echo "



        <div>
            <a href='all-openscr-images.php'>Go Back </a>
        </div>
        
    
        
        
        
        
        
    " ;

} else {
    echo "unable to insert the new item  <br><br>".mysqli_error($DBConnectionBackend) ;
}





















?>