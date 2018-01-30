<?php


trait MyMod_Search_CGI_IncludeAll
{
    //*
    //* function MyMod_Search_CGI_Include_All_Name, Parameter list: 
    //*
    //* Name of include all items cgi field.
    //*

    function MyMod_Search_CGI_Include_All_Name()
    {
        return $this->ModuleName."_IncludeAll";
    }
    
    //*
    //* function MyMod_Search_CGI_Include_All_Default, Parameter list: 
    //*
    //* Default of include all items cgi field.
    //*

    function MyMod_Search_CGI_Include_All_Default()
    {
        $default=1;
        if ($this->IncludeAllDefault) { $default=2; }

        if (!$this->MyMod_Search_CGI_Pressed() && $this->IncludeAll) { $default=2; }
        
        return $default;
    }
    
    //*
    //* function MyMod_Search_CGI_Include_All_Value, Parameter list: 
    //*
    //* Value of include all items cgi field.
    //*

    function MyMod_Search_CGI_Include_All_Value()
    {
        $val=$this->CGI_GETOrPOSTint($this->MyMod_Search_CGI_Include_All_Name());
        if (empty($val)) { $val=$this->MyMod_Search_CGI_Include_All_Default(); }

        return $val;
    }
    
    //*
    //* function MyMod_Search_CGI_Include_All_Hidden_Field, Parameter list: 
    //*
    //* Value of include all items cgi field.
    //*

    function MyMod_Search_CGI_Include_All_Hidden_Field()
    {
        return
           $this->MakeHidden
           (
              $this->MyMod_Search_CGI_Include_All_Name(),
              $this->MyMod_Search_CGI_Include_All_Value()
           );
    }
    
    //*
    //* function MyMod_Search_CGI_Include_All_Radio_Field, Parameter list: 
    //*
    //* Value of include all items cgi field.
    //*

    function MyMod_Search_CGI_Include_All_Radio_Field()
    {
        if ($this->MyMod_Search_CGI_Vars_Defined_Has())
        {
            return $this->B($this->MyLanguage_GetMessage("IncludeAll_Inactive_Message"));
        }
        
        return
            $this->MakeRadioSet //($name,$values,$titles,$selected=-1)
            (
               $this->ModuleName."_IncludeAll",
               array(1,2),
               $this->MyLanguage_GetMessage("NoYes"),
               $this->MyMod_Search_CGI_Include_All_Value()
            ).
            "";
    }
}

?>