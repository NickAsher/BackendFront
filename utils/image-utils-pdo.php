<?php

function isDirectoryWriteable($DirectoryPath){
    if(is_dir($DirectoryPath) && is_writable($DirectoryPath)){
        return true ;
    } else{
        return false ;
    }


}


function isUploadedSuccessfully($ImageFileArrayVariable){
    if($ImageFileArrayVariable['error'] == 0 && $ImageFileArrayVariable['size'] > 0){
//        echo "Image is successfuly placed in temp on server <br> " ;
        return true ;
    } else {
        return false ;
    }

}


function isValidJpgPng($ImageFileArrayVariable){

    $Extension = end(explode(".", $ImageFileArrayVariable['name'])) ;

    if($Extension == 'jpg' || $Extension =='png'){
        return $Extension ;
    } else {
        throw new Exception("Image is not a valid jpg or png") ;
    }

}



function moveImageToImageFolder($ImageFolderPath_WithoutSlash, $ImageFileArrayVariable){

    if( !isDirectoryWriteable($ImageFolderPath_WithoutSlash.'/') ){
            throw new Exception("<br>The image upload directory is either not a directory or not writeable<br>") ;
    }

    if(!isUploadedSuccessfully($ImageFileArrayVariable)){
        throw new Exception("<br> error in uploading the image to the tmp folder <br> ") ;
    }


    $Extension = isValidJpgPng($ImageFileArrayVariable) ;

    $ImageFile_TmpLocation = $ImageFileArrayVariable['tmp_name'] ;
    $NewImageName = date('Ymd')."_".time()."_.$Extension" ;


    $ResultOfMoving = move_uploaded_file($ImageFile_TmpLocation, $ImageFolderPath_WithoutSlash.'/'.$NewImageName) ;
    if(!$ResultOfMoving){
        throw new Exception("error in moving the file in move_uploaded_files <br>".$ImageFileArrayVariable['name'] ) ;
    }


    return $NewImageName ;



}




function deleteImageFromImageFolder($ImageFolderPath_WithoutSlash, $ImageName){

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




class ImageUpdater{
    private $ImageFolderFilePath ;
    private $OldImage_Name ;
    private $NewImageFile ;

    private $InsertedImage_Name ;
    private $isNewImageInserted_Boolean ;




    function __construct( $IMAGE_FOLDER_FILE_PATH, $OldImage_Name, $NewImageFile) {

        $this->OldImage_Name = $OldImage_Name ;
        $this->NewImageFile = $NewImageFile ;

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
                $NewDisplayPic_Name = $this->moveImageToImageFolder($this->ImageFolderFilePath, $this->NewImageFile) ;
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
        /*
         * The case here is that if a new image is inserted then we have to delete the old image
         */

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
         * But there is a problem in updating the database, or after inserting the new image, the old image is not deleted
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
        if($ImageFileArrayVariable['error'] == 0 && $ImageFileArrayVariable['size'] > 0){
//        echo "Image is successfuly placed in temp on server <br> " ;
            return true ;
        } else {
            return false ;
        }

    }



    private function isValidJpgPng($ImageFileArrayVariable){

        $Extension = end(explode(".", $ImageFileArrayVariable['name'])) ;

        if($Extension == 'jpg' || $Extension =='png'){
            return $Extension ;
        } else {
            throw new Exception("Image is not a valid jpg or png") ;
        }

    }








    private function moveImageToImageFolder($ImageFolderPath_WithoutSlash, $ImageFileArrayVariable){

        /*
        *   It has 6 steps
        *      1. Check whether the directory is writeable or not
        *      2. Check for successful upload of file to tmp folder
        *      3. Check whether the file has  .jpg or png extension or not
        *      4. AMake The new Image Name
        *      5. Move the image with the new imagename to the specified image folder
        *      6. Return the imageName back.
        *
        *  If any of the steps fail, then an exception is thrown.
        *
        */


        if( !$this->isDirectoryWriteable($ImageFolderPath_WithoutSlash.'/') ){
            throw new Exception("<br>The image upload directory is either not a directory or not writeable<br>") ;
        }

        if(!$this->isUploadedSuccessfully($ImageFileArrayVariable)){
            throw new Exception("<br> error in uploading the image to the tmp folder <br> ") ;
        }


        $Extension = $this->isValidJpgPng($ImageFileArrayVariable) ;

        $ImageFile_TmpLocation = $ImageFileArrayVariable['tmp_name'] ;
        $NewImageName = date('Ymd')."_".time()."_.$Extension" ;


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







