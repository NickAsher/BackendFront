<?php

class ImageUpdater{
    private $DBConnection ;
    private $ImageFolderFilePath ;
    private $OldImage_Name ;
    private $NewImageFile ;

    private $InsertedImage_Name ;
    private $isNewImageInserted_Boolean ;




    function __construct($DBConnection, $IMAGE_FOLDER_FILE_PATH, $OldImage_Name, $NewImageFile) {

        $this->OldImage_Name = $OldImage_Name ;
        $this->NewImageFile = $NewImageFile ;
        $this->DBConnection = $DBConnection ;
        $this->ImageFolderFilePath = $IMAGE_FOLDER_FILE_PATH ;


    }


    function update(){
        $isNewImageInserted_Boolean = null ;
        $InsertedImage_Name = null ;

        if($this->NewImageFile['size'] == 0 || $this->NewImageFile['error'] == 4){
            $isNewImageInserted_Boolean = false ;
            $InsertedImage_Name = $this->OldImage_Name ;
        } else{
            $isNewImageInserted_Boolean = true ;
            $NewDisplayPic_Name = null ;
            try{
                $NewDisplayPic_Name = $this->moveImageToImageFolder($this->DBConnection, $this->ImageFolderFilePath, $this->NewImageFile) ;
            } catch (Exception $e){
                throw new Exception($e) ;
            }
            $InsertedImage_Name = $NewDisplayPic_Name ;
        }


        $this->isNewImageInserted_Boolean = $isNewImageInserted_Boolean ;
        $this->InsertedImage_Name = $InsertedImage_Name ;


    }

    function isNewImageInserted(){
        return $this->isNewImageInserted_Boolean ;
    }

    function getInsertedImageName(){
        return $this->InsertedImage_Name ;
    }

    function deleteOldImageIfNeeded(){

        if($this->isNewImageInserted_Boolean == true){
            // since image inserted is new, so delete the old image
            try{
                $this->deleteImageFromImageFolder($this->ImageFolderFilePath, $this->OldImage_Name) ;
            } catch (Exception $e){
                throw new Exception($e) ;
            }
        }
    }


    function revertBackChanges(){
        /*
         * Now is the case when a image is updated (can be old, can be new, we don't know)
         * But there is a problem in updating the database, or old image deletion has failed
         * So now the transaction is rolled back, so we have to undo any changes to image
         *
         * So again we have two cases
         * if the inserted image is new, then we delete it
         * but if the inserted image was old, then do nothing
         */

        if($this->isNewImageInserted_Boolean == true){
            // since image inserted is new, so name of inserted image is $this->InsertedImage_Name
            try{
                $this->deleteImageFromImageFolder($this->ImageFolderFilePath, $this->InsertedImage_Name) ;
            } catch (Exception $e){
                throw new Exception($e) ;
            }
        }
    }









    private function isDirectoryWriteable($DirectoryPath){
        if(is_dir($DirectoryPath) && is_writable($DirectoryPath)){
            return true ;
        } else{
            return false ;
        }


    }


    private function isUploadedSuccessfully($ImageFileArrayVariable){
        if($ImageFileArrayVariable['error'] == 0){
    //        echo "Image is successfuly placed in temp on server <br> " ;
            return true ;
        } else {
            return false ;
        }

    }



    private function isJPEG($ImageFileArrayVariable){
        $FileVariable_Name = $ImageFileArrayVariable['name'] ;
        $Extension = explode(".", $FileVariable_Name)[1] ;

        if($Extension == 'jpg' ){
    //        echo "Image is a jpg file <br> ";
            return true ;
        } else {
            return false ;
        }

    }




    private function getLastInsertedImageId($DBConnection){
        $Query = "SELECT * FROM `images_table` ORDER BY `image_id` DESC LIMIT 1 " ;
        $QueryResult = mysqli_query($DBConnection, $Query) ;
        if($QueryResult){
            $ImageId = null ;
            foreach ($QueryResult as $Record){
                $ImageId = $Record['image_id'] ;
            }
    //        echo "The last inserted image id in images_table is $ImageId <br> ";
            return $ImageId ;
        } else {
            throw new Exception("Problem in retreiving the last inserted image id from images_table <br> ".mysqli_error($DBConnection)) ;
        }
    }



    private function insertImageIntoImageDatabase($DBConnection, $NewImageId, $OldImageName){
        $Query = "INSERT INTO `images_table` VALUES ('$NewImageId', '$OldImageName') " ;
        $QueryResult = mysqli_query($DBConnection, $Query) ;
        if($QueryResult){
    //        echo "Image inserted into image database <br> " ;
            return true ;
        } else {
            throw  new Exception("problem in inserting the New image_id into the image database table <br>".mysqli_error($DBConnection)) ;

        }
    }






    private function moveImageToImageFolder($DBConnection, $ImageFolderPath_WithoutSlash, $ImageFileArrayVariable){
        /*
         * This function moves the image to the image folder
         * It performs the following checks
         *      1. Check whether the directory is writeable or not
         *      2. Check Whether the image is uploaded Successfully or not
         *      3. Check whether the uploaded file has an .jpg extension or not.
         *
         *  It has 10 steps
         *      0. Check whether the directory is writeable or not
         *      1. Check for successful upload of file to tmp folder
         *      2. Check whether the file has  .jpg extension or not
         *
         *      3. Get the Last Inserted Image's Id
         *      4. Add One to it, to make the New ImageId
         *      5. Pad 0's to the image Id
         *      6. Add the image with just the image id into the images database
         *      7. Add The date in front of the image id to make the new imagename
         *      8. Move the image with the new imagename to the specified image folder
         *      9. Return the imageName back.
         *
         *  If any of the steps fail, then a -1 is returned.
         *
         */

//        if(!$this->isDirectoryWriteable($ImageFolderPath_WithoutSlash.'/')){
//            throw new Exception("<br>The image upload directory is either not a directory or not writeable<br>") ;
//        }

        if(!$this->isUploadedSuccessfully($ImageFileArrayVariable)){
            throw new Exception("<br> error in uploading the image to the tmp folder <br> ") ;
        }


        if(!$this->isJPEG($ImageFileArrayVariable)){
            throw new Exception("<br> File Uploaded is not a valid Jpg Image File <br> ") ;
        }

        $LastInsertedImageId = null ;
        try {
            $LastInsertedImageId = $this->getLastInsertedImageId($DBConnection);
        }catch (Exception $e){
            throw new Exception($e->getMessage()) ;
        }


        $NextInsertImageId_Int = intval($LastInsertedImageId) + 1 ;
        $NextInsertImageId = str_pad("$NextInsertImageId_Int", 10, "0", STR_PAD_LEFT) ;

        try{
            $this->insertImageIntoImageDatabase($DBConnection, $NextInsertImageId, $ImageFileArrayVariable['name']) ;
        } catch (Exception $e){
            throw new Exception($e->getMessage()) ;
        }


        $NewImageName = date('Ymd')."_".$NextInsertImageId."_.jpg" ;
        $ImageFile_TmpLocation = $ImageFileArrayVariable['tmp_name'] ;


        $ResultOfMoving = move_uploaded_file($ImageFile_TmpLocation, $ImageFolderPath_WithoutSlash.'/'.$NewImageName) ;
        if(!$ResultOfMoving){
            throw new Exception("error in moving the file <br>".$ImageFileArrayVariable['name'] ) ;
        }

        return $NewImageName ;
    }






    private function deleteImageFromImageFolder($ImageFolderPath_WithoutSlash, $ImageName){

        if($ImageName == null || empty($ImageName)){
            throw new Exception("No image to delete, image $ImageName is empty <br> ") ;

        }

        if(!is_file($ImageFolderPath_WithoutSlash.'/'.$ImageName)) {
            throw new Exception("The given path is not a file: $ImageFolderPath_WithoutSlash/$ImageName <br>") ;
        }


        if(!file_exists($ImageFolderPath_WithoutSlash.'/'.$ImageName)) {
            throw new Exception("The given file does not exist: $ImageFolderPath_WithoutSlash/$ImageName <br>") ;
        }


        if(unlink($ImageFolderPath_WithoutSlash.'/'.$ImageName)){
            return true ;
        } else {
            throw new Exception("The unlink function failed due to some reason") ;
        }




    }















}




