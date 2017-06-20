<?php
    function getUserId($DBConnectionBackend, $email, $password){
        $Query = "SELECT * FROM `users_identity_table` WHERE `user_email` = '".$email."' AND `user_password` = '".$password."'    " ;
        $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
        if(mysqli_num_rows($QueryResult) == 1){
            $TempArray = '' ;
            foreach($QueryResult as $Record){
                $TempArray = $Record ;
            }

            $UserId = $TempArray['user_id'] ;
            echo "<br> Successfully retrieved UserId" ;
            return $UserId ;
        } else {
            echo "<br> Problem in retrieving UserId" ;
            return -1 ;
        }
    }


    function getUserInformation($DBConnectionBackend, $UserId){
        $Query = "SELECT * FROM `users_profile_table` WHERE `user_id` = '".$UserId."' " ;
        $QueryReult = mysqli_query($DBConnectionBackend, $Query) ;
        if(mysqli_num_rows($QueryReult) != 1){
            echo "<br> Problem in retreiving" ;
            echo "<br>".mysqli_error($DBConnectionBackend) ;
            return -1 ;
        } else{
            $UserInformation = '' ;
            foreach($QueryReult as $Record) {
                $UserInformation = $Record ;
            }
            return $UserInformation ;
        }
    }

function getUserProfileInformation($DBConnectionBackend, $UserId){
    $Query = "SELECT * FROM `users_profile_table` WHERE `user_id` = '".$UserId."' " ;
    $QueryReult = mysqli_query($DBConnectionBackend, $Query) ;
    if(mysqli_num_rows($QueryReult) != 1){
        echo "<br> Problem in retreiving" ;
        echo "<br>".mysqli_error($DBConnectionBackend) ;
        return -1 ;
    } else{
        $UserInformation = '' ;
        foreach($QueryReult as $Record) {
            $UserInformation = $Record ;
        }
        return $UserInformation ;
    }
}






    function getItemInformation($DBConnectionBackend, $ItemId){
        /*
         * This function returns the details of an item
         * it is basically a select statement in the items_table
         */

        $Query = "SELECT * FROM `menu_items_table` WHERE `item_id` = '$ItemId'   " ;
        $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
        $ItemInformation = '' ;
        if($QueryResult){
            foreach($QueryResult as $Record){
                $ItemInformation = $Record ;
            }
            return $ItemInformation ;
        } else {
            echo "Problem in fetching the item information for item id : $ItemId <br>" .mysqli_error($DBConnectionBackend) ;
            return -1 ;
        }




    }


function getToppingInformation($DBConnectionBackend, $ItemId){
    /*
     * This function returns the details of an item
     * it is basically a select statement in the items_table
     */

    $Query = "SELECT * FROM `items_addon_table` WHERE `item_id` = '".$ItemId."'   " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    $ItemInformation = '' ;
    foreach($QueryResult as $Record){
        $ItemInformation = $Record ;
    }
    return $ItemInformation ;


}


function getSizeInformation($DBConnectionBackend, $ItemCategoryCode, $SizeCode){
    $Query = "SELECT * FROM `menu_meta_size_table` WHERE `size_category_code` = '$ItemCategoryCode' AND `size_code` = '$SizeCode' " ;
    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
    $SizeInformation = '' ;
    foreach($QueryResult as $Record){
        $SizeInformation = $Record ;
    }
    return $SizeInformation ;
}









function getItemCategory($ItemId){
    $CategoryType = '' ;
    switch($ItemId){
        case 40001:
            $CategoryType = 'Sides' ;
            break ;
        case 40002:
            $CategoryType = 'Sides' ;
            break ;
        case 40003:
            $CategoryType = 'Main' ;
            break ;
        case 40004:
            $CategoryType = 'Main' ;
            break ;
        case 40005:
            $CategoryType = 'Main' ;
            break ;
        case 40006:
            $CategoryType = 'Main' ;
            break ;
        case 40007:
            $CategoryType = 'Main' ;
            break ;
        case 40008:
            $CategoryType = 'Sides' ;
            break ;
        case 40009:
            $CategoryType = 'Sides' ;
            break ;

    }
    return $CategoryType ;
}

?>