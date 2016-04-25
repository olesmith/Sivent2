<?php

class SearchCookies extends SearchCGI
{
    //*
    //* function AddSearchVars2Cookies, Parameter list:
    //*
    //* Add search vars to list of cookies.
    //*

    function AddSearchVars2Cookies()
    {
        $cookies=preg_grep('/^ModuleName$/',$this->ApplicationObj->CookieVars,PREG_GREP_INVERT);
        $cookievals=$this->ApplicationObj->CookieValues;

        foreach ($this->GetSearchVars() as $data)
        {
            if (
                  $this->ItemData[ $data ][ "Sql" ]=="ENUM"
                  ||
                  !empty($this->ItemData[ $data ][ "SqlClass" ])
                  ||
                  !empty($this->ItemData[ $data ][ "IsDate" ])
               )
            {
                array_push($cookies,$this->GetSearchVarCGIName($data));
                $cookievals[ $data ]=$this->GetSearchVarCGIValue($data);
                if (!empty($this->ItemData[ $data ][ "SqlTextSearch" ]))
                {
                    array_push($cookies,$this->GetTextSearchVarCGIName($data));
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