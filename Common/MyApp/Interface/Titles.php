<?php

//include_once("Tail/Thanks.php");


trait MyApp_Interface_Titles
{
    //use MyApp_Interface_Head_Thanks;

    //*
    //* sub MyApp_Name, Parameter list:
    //*
    //* Returns titles to use in interface top center cell.
    //*
    //*

    function MyApp_Name()
    {
        return $this->GetRealNameKey($this->HtmlSetupHash,"ApplicationName");
    }
    
    //*
    //* sub MyApp_Title, Parameter list:
    //*
    //* Returns titles to use in interface top center cell.
    //*
    //*

    function MyApp_Title()
    {
        return $this->GetRealNameKey($this->HtmlSetupHash,"ApplicationTitle");
    }
    
    //*
    //* sub MyApp_Interface_Titles, Parameter list:
    //*
    //* Returns titles to use in interface top center cell.
    //*
    //*

    function MyApp_Interface_Titles()
    {
        return array
        (
           $this->CompanyHash[ "Institution" ],
           $this->CompanyHash[ "Department" ],
           $this->CompanyHash[ "Address" ],
           $this->CompanyHash[ "Area" ].", ".
           $this->CompanyHash[ "City" ]."-".
           $this->CompanyHash[ "State" ].", CEP: ".
           $this->CompanyHash[ "ZIP" ],
           $this->CompanyHash[ "Url" ]." - ".
           $this->CompanyHash[ "Phone" ]." - ".
           $this->CompanyHash[ "Email" ],
        );
    }

    //*
    //* sub MyApp_Interface_Title_Classes, Parameter list:
    //*
    //* Returns titles to use in interface top center cell.
    //*
    //*

    function MyApp_Interface_Title_Classes()
    {
        return array
        (
           "headinst","headdept","headaddress",
           "headcity","headcontacts","headcontacts",
        );
    }


    //*
    //* sub MyApp_Interface_Titles_Latex, Parameter list:
    //*
    //* Returns titles to use in interface top center cell, latex versions.
    //*
    //*

    function MyApp_Interface_Titles_Latex()
    {
        return $this->MyApp_Interface_Titles();
    }


     //*
    //* sub MyApp_Interface_Titles_Icons, Parameter list:
    //*
    //* Returns titles to use in interface top center cell.
    //*
    //*

    function MyApp_Interface_Titles_Icons()
    {
        return array
        (
           1 => array
           (
              "Icon"   => $this->CompanyHash[ "HtmlIcon1" ],
              "Height" => "100",
              "Width"  => "",
           ),
           2 => array
           (
              "Icon"   => $this->CompanyHash[ "HtmlIcon2" ],
              "Height" => "100",
              "Width"  => "",
           ),
        );
    }

     //*
    //* sub MyApp_Interface_Titles_LatexIcons, Parameter list:
    //*
    //* Returns titles to use in interface top center cell.
    //*
    //*

    function MyApp_Interface_Titles_LatexIcons()
    {
        return array
        (
           1 => array
           (
              "Icon"   => $this->CompanyHash[ "LatexIcon1" ],
              "Height" => "",
              "Width"  => "",
           ),
           2 => array
           (
              "Icon"   => $this->CompanyHash[ "LatexIcon2" ],
              "Height" => "",
              "Width"  => "",
           ),
        );
    }

    
    //*
    //* sub MyApp_Info, Parameter list:
    //*
    //* Info line for application.
    //*

    function MyApp_Info()
    {
        return array
        (
           $this->GetRealNameKey($this->HtmlSetupHash,"ApplicationName"),
           $this->GetRealNameKey($this->HtmlSetupHash,"ApplicationTitle").
           ", Ver. ".
           $this->GetRealNameKey($this->HtmlSetupHash,"ApplicationVersion"),
           $this->A
           (
              $this->GetRealNameKey($this->HtmlSetupHash,"ApplicationURL"),
              $this->GetRealNameKey($this->HtmlSetupHash,"ApplicationURL"),
              array
              (
                 "CLASS" => 'applicationlink',
              )
           )
        );
    }
}

?>