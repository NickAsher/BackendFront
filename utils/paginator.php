<?php


class Paginator{
    private $TotalNoOfItems ;
    private $NoOfItemsPerPage ;

    private $MaxPageNo ;
    private $CurrentPageNo ;

    /*Offset is the no of items after which a Limit(NoOfItemsPerPage) of items should be diplayed
     * So let's say limit = 10
     * For page 1, we want items 0-10 , so offset is 0
     * For page 2, we want items 10-20 , so offset is 10
     * For page 5, we want items 40-50, so offset is 40 i.e. (PageNo-1)* NoOfItemsPerPage
     */
    private $offset ;


    function __construct($TotalNoOfItems, $NoOfItemsPerPage, $CurrentPageNo) {
        $this->TotalNoOfItems = $TotalNoOfItems ;
        $this->NoOfItemsPerPage = $NoOfItemsPerPage ;


        // Calculating the MaxPageNo
        if($TotalNoOfItems == 0){
            $this->MaxPageNo = 1 ;
        }else{
            if($TotalNoOfItems%$NoOfItemsPerPage == 0){
                $this->MaxPageNo = $TotalNoOfItems/$NoOfItemsPerPage ;
            } else {
                $this->MaxPageNo = intval($TotalNoOfItems/$NoOfItemsPerPage) + 1 ;
            }
        }




        //calculating the real Page No
        if($CurrentPageNo < 1) {
            $this->CurrentPageNo = 1;
        } else if ($CurrentPageNo >= $this->MaxPageNo){
            $this->CurrentPageNo = $this->MaxPageNo ;
        }else {
            $this->CurrentPageNo = $CurrentPageNo ;
        }



        //Calculating the offset
        $Offset = ($this->CurrentPageNo-1) * $NoOfItemsPerPage ;
        $this->offset = $Offset ;

    }


    function getOffset(){
        return $this->offset ;
    }

    function getMaxPageNo(){
        return $this->MaxPageNo ;
    }


    function getRealCurrentPageNo(){
        return $this->CurrentPageNo ;
    }




}