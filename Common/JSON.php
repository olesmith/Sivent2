<?php

include_once("JSON/Query.php");
include_once("JSON/Parse.php");
include_once("JSON/Read.php");


trait JSON
{
    use
        JSON_Query,
        JSON_Parse,
        JSON_Read;
    
    var $JSON_Limit="100";
    var $JSON_Name="";
    
    ##! JSON_ID_Field
    ##! 
    ##! Name of JSON ID field.
    ##!
        
    function JSON_ID_Field($module="")
    {
        if (empty($module)) { $module=$this->ModuleName; }

        $setup=$this->ApplicationObj()->App_Sigaa_Module_Setup($module);
        return $setup[ "ID_Field" ];
    }
    

    ##! JSON_Show
    ##! 
    ##! Formats $json code for printing.
    ##!
        
    function JSON_Show($json)
    {
        return
            $this->DIV
            (
                preg_replace
                (
                    '/\s/',
                    "&nbsp;",
                    join
                    (
                        $this->BR(),
                        $json
                    )
                ).
                $this->BR(),
                array("WIDTH" => '200px')
            );

    }
}
?>