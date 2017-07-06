<?php


class SuccessErrorPage{

    static  $SUCCESS = 1 ;
    static $ERROR = 0 ;

    private $Type ;
    private $BackPageLink ;

    private $Message ;
    private $ErrorMessage ;


    function __construct($Type, $Message, $BackPageLink) {
        if($Type == SuccessErrorPage::$SUCCESS){
            $this->Type = SuccessErrorPage::$SUCCESS ;
        } else if($Type == SuccessErrorPage::$ERROR){
            $this->Type = SuccessErrorPage::$ERROR ;
        } else {
            $this->Type = "error" ;
        }

        $this->Message = $Message ;
        $this->BackPageLink = $BackPageLink ;

        return $this ;
    }



    function showPage(){
        if($this->Type == SuccessErrorPage::$SUCCESS){
            echo "
            
                
                <body style='background: #fafaff'>
                    <div>
                        <br><br><br>
                    </div>
                
                    <div>
                        <center>
                            <div id='circle' style='width:100px;height: 100px;border-radius: 50%;background: limegreen;'>
                                <br>
                                <span ><i class='fa fa-3x fa-check' style=' color: #FFF;'></i></span>
                            </div>
                            <div id='heading' style='font-weight: 900;font-size: 90px;color: #666;'>
                                Success !
                            </div>
                
                            <div id='explainText' class='text-center' style='font-weight: 100;font-size: 35px;color: #888;'>
                                $this->Message
                            </div>
                            <br>
                            <a  class='btn text-white' style='background: mediumpurple' href='$this->BackPageLink'>Go Back</a>
                
                        </center>
                    </div>
                
                
                
                
                
                
                
                
                <br><br>
                
                    <footer style='background: #333;'>
                
                            <div><br><br><br><br></div>
                
                            <div style='background-color: inherit;color: #ffffff;text-align: center;font-size: 16px ;'>
                                <h4 class='text-white'>Designed by Rafique Gagneja </h4>
                                <h5>&copy Gagneja  Inc. 2014-2017</h5>
                            </div>
                
                            <div><br><br></div>
                    </footer>
                </body>
            
            
            " ;
        } else if($this->Type == SuccessErrorPage::$ERROR){
            echo "
            
                
                <body style='background: #fafaff'>
                    <div>
                        <br><br><br>
                    </div>
                
                    <div>
                        <center>
                            <div id='circle' style='width:100px;height: 100px;border-radius: 50%;background: orangered;'>
                                <br>
                                <span ><i class='fa fa-3x fa-times' style=' color: #FFF;'></i></span>
                            </div>
                            <div id='heading' style='font-weight: 900;font-size: 90px;color: #666;'>
                                Error !
                            </div>
                
                            <div id='explainText' class='text-center' style='font-weight: 100;font-size: 35px;color: #888;'>
                                $this->Message
                            </div>
                            <br>
                            <a  class='btn text-white' style='background: mediumpurple' href='$this->BackPageLink'>Go Back</a>
                
                        </center>
                    </div>
                
                
                
                
                
                
                
                
                <br><br>
                
                    <footer style='background: #333;'>
                
                            <div><br><br><br><br></div>
                
                            <div style='background-color: inherit;color: #ffffff;text-align: center;font-size: 16px ;'>
                                <h4 class='text-white'>Designed by Rafique Gagneja </h4>
                                <h5>&copy Gagneja  Inc. 2014-2017</h5>
                            </div>
                
                            <div><br><br></div>
                    </footer>
                </body>
            
            
            " ;
        } else {
            echo "Some error" ;
        }
    }





}