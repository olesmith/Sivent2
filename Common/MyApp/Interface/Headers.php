<?php


trait MyApp_Interface_Headers
{   
    //*
    //* sub MyApp_Interface_Header, Parameter list:
    //*
    //* Sends the HTML header part.
    //*
    //*

    function MyApp_Interface_Headers_Send()
    {
        //Printed promptly!
        $this->MyApp_Interface_Headers_HTTP();
        
        //Send the cookies - also promptly
        $this->MyApp_Interface_Cookies();

        return array();
    }

    

    //*
    //* sub MyApp_Interface_Header_Send, Parameter list:
    //*
    //* Sends the HTML header .
    //*
    //*

    function MyApp_Interface_Headers_HTTP()
    {
        if ($this->HeadersSend!=0) { return; }
        
        header('Content-type: text/html;charset='.$this->HtmlSetupHash[ "CharSet"  ]);
        $this->HTML=TRUE;

        $this->HeadersSend=1;  
    }
        
    //*
    //* sub MyApp_Interface_Cookies, Parameter list:
    //*
    //* Returns before HTM tage comment.
    //*
    //*

    function MyApp_Interface_Cookies()
    {
        if ($this->Module)
        {
            $this->Module->MyMod_Search_CGI_Vars_2_Cookies();
            foreach ($this->Module->CookieVars as $cid => $cookievar)
            {
                array_push($this->CookieVars,$cookievar);
            }
        }
        
    }
       

}

?>