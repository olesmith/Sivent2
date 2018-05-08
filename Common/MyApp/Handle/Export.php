<?php

trait MyApp_Handle_Export
{
    //*
    //* function MyApp_Handle_Export, Parameter list:
    //*
    //* Handles system Export (via PHP).
    //*

    function MyApp_Handle_Export()
    {
        if ($this->CGI_POSTint("Export"))
        {
            $this->MyApp_Handle_Export_Do();
            exit();
        }
        elseif ($this->CGI_POSTint("Import"))
        {
            $this->MyApp_Handle_Import_Handle();
            exit();
        }

        echo
            $this->MyApp_Handle_Export_Form();
    }

    //*
    //* function MyApp_Handle_Export_Form, Parameter list:
    //*
    //* Produces Export table - with option for Import file.
    //*

    function MyApp_Handle_Export_Form()
    {
        $this->MyApp_Interface_Head();
        
        $table=array();
        foreach ($this->SQL_Tables() as $module => $sqltables)
        {
            $row=array($this->B($module));
            foreach ($sqltables as $sqltable)
            {
                array_push
                (
                   $row,
                   $sqltable,
                   $this->Sql_Select_NHashes($where="",$sqltable),
                   $this->Html_Input_CheckBox_Field($sqltable,1)
                );
                
                array_push($table,$row);
                $row=array("");
            }
        }
        
        array_push
        (
            $table,
            array
            (
             "","",
               $this->Html_Input_Button("submit","Export",array("NAME" => "Export","VALUE" => 1)),
            ),
            array
            (
               $this->H(2,"Import"),
            ),
            array
            (
               $this->B("Create Structure:"),
               $this->Html_Input_CheckBox_Field("Structure",1)
            ),
            array
            (
               $this->B("Insert new Items:"),
               $this->Html_Input_CheckBox_Field("Insert",1)
            ),
            array
            (
               $this->B("Update existing Items:"),
               $this->Html_Input_CheckBox_Field("Update",1)
            ),
            array
            (
               $this->B("File:"),
               $this->Html_Input_Field("Import","",array("TYPE" => "file")),
               $this->Html_Input_Button_Make("submit","Import",array("NAME" => "Import","VALUE" => 1))
            )
        );

        
        return
            $this->H(1,"Exportar, PHP").
            $this->H(2,"SQL Tables").
            $this->StartForm().
            $this->Html_Table
            (
                array("Module","Table","No of Items","Include"),
                $table
            ).
            $this->EndForm();
    }

    //*
    //* function MyApp_Handle_Export_Do, Parameter list:
    //*
    //* Does actual system Export (via PHP).
    //*

    function MyApp_Handle_Export_Do()
    {
        $text="array\n(\n";
        foreach ($this->SQL_Tables() as $module => $sqltables)
        {
            $obj=$module."Obj";
            foreach ($sqltables as $sqltable)
            {
                if ($this->CGI_POSTint($sqltable)==1)
                {
                    $text.=
                        "   '".$sqltable."' => \n".
                        $this->$obj()->MyMod_Items_Export
                        (
                            $this->$obj()->Sql_Select_Hashes
                            (
                                array(),
                                array(),
                                "ID"
                            ),
                            $sqltable
                        );
                }
            }
        }

        $text.=");\n";
               
        echo
            $this->MyMod_Doc_Header_Send("txt","Sids.php").
            $text;
    }

}

?>