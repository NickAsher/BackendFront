<html>
<head>
    <title>HomeFlavor | Backend</title>
    <meta charset="utf-8">



    <link rel="stylesheet" href="../lib/reset/reset.css" >

    <link rel = "stylesheet" href="../lib/bootstrap4/bootstrap.min.css" >
    <link rel = "stylesheet" href="../lib/bootstrap4/bootstrap-grid.min.css" >
    <link rel = "stylesheet" href="../lib/bootstrap4/bootstrap-reboot.min.css" >
    <link rel = "stylesheet" href="../lib/bootstrap4/bootstrap_addon.css" >


    <link rel="stylesheet" href="../lib/font-awesome/css/font-awesome.css" >

    <link rel="stylesheet" href="../lib/t3/t3.css" />

    <?php
    require_once '../utils/constants.php';
    require_once $ROOT_FOLDER_PATH.'/sql/sqlconnection.php'  ;
    require_once 'paginator.php' ;


    $DBConnectionBackend = YOLOSqlConnect() ;


    ?>



</head>



<body>

<?php //require_once "includes/header.php" ?>

<section>
    <?php require_once $ROOT_FOLDER_PATH.'/frontend/common/includes/sidebar.php'; ?>
    <div class="container-fluid t3-push" id="mainContainer">
        <div class="row">
            <div id = "main_Content" class="col-md-12">



                <div id="space_below_header">
                    <br><br><br><br><br>
                </div>



                <?php



                $NoOfItemsPerPage = 8 ;
                $Query1 = "SELECT COUNT(*) AS `total` FROM `blogs_table` " ;
                $Queryresult1 = mysqli_query($DBConnectionBackend, $Query1) or die("Error fetch count <br>".mysqli_error($DBConnectionBackend)) ;
                $TotalNumOfItems = mysqli_fetch_assoc($Queryresult1)['total'] ;





                $PageNo = null ;
                if(isset($_GET['___page_no'])){
                    $PageNo = $_GET['___page_no'] ;
                } else {
                    $PageNo = 1 ;
                }

                $Pagintor = new Paginator($TotalNumOfItems, $NoOfItemsPerPage, $PageNo) ;
                $Offset = $Pagintor->getOffset() ;

                $PageNo = $Pagintor->getRealCurrentPageNo() ;
                $MaxPageNo = $Pagintor->getMaxPageNo() ;



                ?>
                <div>
                    <form method="get">
                        <select name="___page_no" >
                            <?php
                            $SelectString = null ;


                            for($i=1;$i<=$MaxPageNo;$i++){
                                if ($i == $PageNo){
                                    $SelectString = "selected" ;
                                }else {
                                    $SelectString = "" ;
                                }
                                echo "
                                <option value='$i' $SelectString>$i</option>
                                " ;
                            }
                            ?>
                </select>
                <input type="submit" value="Go">

                </form>
            </div>
            <?php






                echo "


                
                
                <br><br>
                <table  class='table table-bordered table-hover' >

                    <tr class='table-info'>
                        <th>Blog Id</th>
                        <th>Creation Date/Time</th>
                        <th>Last Modified Date/Time</th>
                        <th>Blog Title</th>
                        <th>Blog Display Image</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>                    
                    " ;



                    $Query = "SELECT * FROM `blogs_table` ORDER BY `blog_id` DESC LIMIT $NoOfItemsPerPage OFFSET $Offset " ;
                    $QueryResult = mysqli_query($DBConnectionBackend, $Query) ;
                    if($QueryResult){

                        foreach($QueryResult as $Record){
                            $BlogId= $Record['blog_id'] ;
                            $CreationTimeStamp = $Record['blog_creation_timestamp'] ;
                            $LastModifiedTimestamp = $Record['blog_last_modified_timestamp'] ;
                            $BlogTitle = $Record['blog_title'] ;
                            $BlogImageName = $Record['blog_display_image'] ;

                            $DetailPageLink = "show-blogpost.php?___blog_id=$BlogId" ;




                            echo "
                                <tr> 
                                    <td class='addon-link' data-href='$DetailPageLink'>  $BlogId </td>
                                    <td class='addon-link' data-href='$DetailPageLink'>  $CreationTimeStamp</td>
                                    <td class='addon-link' data-href='$DetailPageLink'>  $LastModifiedTimestamp </td>
                                    <td class='addon-link' data-href='$DetailPageLink'>  $BlogTitle  </td> 
                                    <td class='addon-link-link' data-href='$DetailPageLink'><img src='$IMAGE_FOLDER_LINK_PATH/$BlogImageName' class='img-fluid' width='90px' ></td>
                                    <td>
                                        <form action='edit-blogpost.php' method='get'>
                                            <input type='hidden' name='__blog_id' value='$BlogId'>
                                            <button type='submit' class='btn btn-info' ><span><i class='fa fa-edit'></i></span> Edit</button>
                                           
                                        </form>      
                                    </td>
                                    <td>
                                        <form action='confirm-delete-blogpost.php' method='post'>
                                            <input type='hidden' name='__blog_id' value='$BlogId'>
                                            <button type='submit' class='btn btn-danger' ><span><i class='fa fa-trash'></i></span> Delete</button>
                                        </form>  
                                    </td>
                                </tr>
                                " ;
                        }
                    }




                echo "</table>" ;



                $NextPage = $PageNo + 1 ;
                $PrevPage = $PageNo - 1 ;
                $FirstPageNo = 1 ;
                $LastPageNo = $Pagintor->getMaxPageNo() ;

                if( $PageNo == 1){

                    echo "
                    <div class='text-center'>
                        <div style='display:inline-block'>
                            <ul class='pagination' >
                                <li class='page-item active'><a class='page-link' href='demo.php?___page_no=1'>1</a></li>
                                <li class='page-item'><a class='page-link' href='demo.php?___page_no=$NextPage'>Next</a></li>
                            </ul>
                        </div>
                    </div>
                    " ;
                }

                else if($PageNo > 1 && $PageNo < $LastPageNo) {
                    echo "
                        <div class='text-center'>
                        <div style='display:inline-block'>
                            <ul class='pagination'>
                                <li class='page-item'><a class='page-link' href='demo.php?___page_no=$PrevPage'>Prev</a></li>
                                <li class='page-item active'><a class='page-link' href='demo.php?___page_no=$PageNo'>$PageNo</a></li>
                                <li class='page-item'><a class='page-link' href='demo.php?___page_no=$NextPage'>Next</a></li>
                            </ul>
                         </div>
                    </div>
                   
                    " ;
                }

                else if($PageNo == $LastPageNo){
                    echo "
                    <div class='text-center'>
                        <div style='display:inline-block'>
                            <ul class='pagination'>
                                <li class='page-item'><a class='page-link' href='demo.php?___page_no=$PrevPage'>Prev</a></li>
                                <li class='page-item active'><a class='page-link' href='demo.php?___page_no=$PageNo'>$PageNo</a></li>
                            </ul>
                         </div>
                    </div>
                    
                    " ;
                }

                ?>









                <br><br>
                <div class="row">
                    <div class="col-4"></div>
                    <a class="col-4 btn btn-outline-info" href="add-new-blogpost.php">
                        Add New Item
                    </a>
                    <div class="col-4"></div>
                </div>





                <div id="space_before_footer">
                    <br><br><br><br><br>
                </div>





            </div>
        </div>
    </div>
</section>



<?php //require_once "../common/includes/footer.php" ?>



</body>
<script type="text/javascript" src="../lib/jquery/jquery.js" ></script>
<script type="text/javascript" src="../lib/bootstrap4/bootstrap.min.js" ></script>
<script type="text/javascript" src="../lib/bootstrap4/bootstrap_addon.js" ></script>
<script type="text/javascript" src="../lib/t3/t3.js"></script>








</html>
