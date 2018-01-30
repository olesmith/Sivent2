<?php


trait MyMod_Search_CGI_Cookies
{
    //*
    //* function MyMod_Search_CGI_Vars_2_Cookies, Parameter list:
    //*
    //* Add search vars to list of cookies.
    //*

    function MyMod_Search_CGI_Vars_2_Cookies()
    {
        $cookies=preg_grep('/^ModuleName$/',$this->ApplicationObj->CookieVars,PREG_GREP_INVERT);
        $cookievals=$this->ApplicationObj->CookieValues;

        foreach ($this->MyMod_Items_Search_Vars() as $data)
        {
            if (
                  $this->ItemData[ $data ][ "Sql" ]=="ENUM"
                  ||
                  !empty($this->ItemData[ $data ][ "SqlClass" ])
                  ||
                  !empty($this->ItemData[ $data ][ "IsDate" ])
               )
            {
                array_push($cookies,$this->MyMod_Search_CGI_Name($data));
                $cookievals[ $data ]=$this->MyMod_Search_CGI_Value($data);
                if (!empty($this->ItemData[ $data ][ "SqlTextSearch" ]))
                {
                    array_push($cookies,$this->MyMod_Search_CGI_Text_Name($data));
                }
            }
        }

        array_push
        (
           $cookies,
           $this->ModuleName."_GroupName",
           $this->ModuleName."_SGroupName",
           $this->ModuleName."_Sort",
           $this->ModuleName."_Reverse",
           $this->ModuleName."_Page",
           $this->ModuleName."_NItemsPerPage",
           //15/01/2014 $this->ModuleName."_Edit",
           //28/04/2015$this->ModuleName."_IncludeAll",
           "NoHeads"
        );

        foreach ($this->GlobalGCVars as $key => $def)
        {
            array_push($cookies,$key);
        }

        $this->ApplicationObj->CookieVars=$cookies;
        $this->CookieVars=$cookies;
    }

}

?>