<?php
    function getUserId_PDO($DBConnectionBackend, $email, $password){
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


    function getUserProfileInformation_PDO($DBConnectionBackend, $UserId){
        $Query = "SELECT * FROM `users_profile_table` WHERE `user_id` = :user_id " ;

        try {
            $QueryResult = $DBConnectionBackend->prepare($Query);
            $QueryResult->execute(['user_id' => $UserId]);
            return $QueryResult->fetch(PDO::FETCH_ASSOC) ;
        } catch (Exception $e) {
            throw new Exception("Error in fetching the user info from users table: ".$e) ;
        }
    }


















?>