<?php












/*
 * Easy Database functions
 */

function getBlogInfo($DBConnectionBackend, $BlogId){
    $Query = "SELECT * FROM `blogs_table` WHERE `blog_id` = :blog_id  " ;
    try {
        $QueryResult = $DBConnectionBackend->prepare($Query);
        $QueryResult->execute(['blog_id' => $BlogId]);
        $BlogInfoArray = $QueryResult->fetch(PDO::FETCH_ASSOC);
        return $BlogInfoArray ;
    } catch (Exception $e) {
        die("Unable to fetch the blog from the blog_table: ".$e) ;
    }





}


?>