<?php


trait MyApp_Handle_Process
{
    var $MyApp_Handle_Process_NTables=0;
    var $MyApp_Handle_Process_NTables_Empty=0;
    
    //*
    //* function MyApp_Handle_Process, Parameter list: 
    //*
    //* Application processor. 
    //*

    function MyApp_Handle_Process()
    {
        $this->MyApp_Handle_Process_Tables_Form();
    }

    
    
    
    //*
    //* function MyApp_Handle_Process_Table_Titles, Parameter list: 
    //*
    //* Shows the empty tables in DB.
    //*

    function MyApp_Handle_Process_Table_Titles()
    {
        $row=
            array
            (
                "Nº",
                "Table",
                "Nº of Items",
                "DROP - All: ".
                $this->Html_Input_CheckBox_Field
                (
                    "DROP_All",
                    $value=1,$checked=FALSE
                )
            );

        return $row;    
    }

    //*
    //* function MyApp_Handle_Process_Table_Action_Cells, Parameter list: $table
    //*
    //* Creates row action cell $table: DROP checkbox for empties.
    //*

    function MyApp_Handle_Process_Table_Drop_Cell($table)
    {
        $cell="";
        if ($this->Sql_Table_Empty_Is($table))
        {
            $cell=
                $this->Html_Input_CheckBox_Field
                (
                    "DROP_".$table,
                    $value=1,$checked=FALSE
                );
        }

        return $cell;
    }
    //*
    //* function MyApp_Handle_Process_Table_Action_Cells, Parameter list: $table
    //*
    //* Creates row action cell $table: DROP checkbox for empties.
    //*

    function MyApp_Handle_Process_Table_Action_Cells($table)
    {
        return
            array
            (
                $this->MyApp_Handle_Process_Table_Drop_Cell($table),
            );
    }
    
    //*
    //* function MyApp_Handle_Process_Table_Row, Parameter list: $table,$n
    //*
    //* Creates row of info for $table.
    //*

    function MyApp_Handle_Process_Table_Row($table,$n)
    {
        $nitems=$this->Sql_Table_NItems($table);
        $row=
            array
            (
                $this->B($n.":"),
                $table,
                $nitems
            );

        return
            array_merge
            (
                $row,
                $this->MyApp_Handle_Process_Table_Action_Cells($table)
            );    
    }

    //*
    //* function MyApp_Handle_Process_Tables_Update, Parameter list: 
    //*
    //* Updates Process_Tables_Form, that is drops selected (empty) tables.
    //*

    function MyApp_Handle_Process_Tables_Update()
    {
        $removetables=array();
        foreach ($this->Sql_Tables_Get() as $table)
        {
            if ($this->Sql_Table_Empty_Is($table))
            {
                $drop=FALSE;
                
                $key="DROP_".$table;
                if ($this->CGI_POSTint($key)==1)
                {
                    $drop=TRUE;
                }
                
                $key="DROP_All";
                if ($this->CGI_POSTint($key)==1)
                {
                    $drop=TRUE;
                }

                if ($drop)
                {
                    $this->Sql_Table_Drop($table);
                    array_push($removetables,$table);
                }
            }
        }

        return
            $this->H(3,count($removetables)." Tables dropped:").
            join($this->BR(),$removetables).
            $this->BR().$this->BR().
            "";
    }

    
    //*
    //* function MyApp_Handle_Process_Tables_Table, Parameter list: 
    //*
    //* Generate table showing tables and no of entries.
    //*

    function MyApp_Handle_Process_Tables_Table()
    {
        $htmltable=array();

        $n=1;
        foreach ($this->Sql_Tables_Get() as $table)
        {
            array_push($htmltable,$this->MyApp_Handle_Process_Table_Row($table,$n));
            $n++;
        }

        return $htmltable;
    }

    //*
    //* function MyApp_Handle_Process_Tables_Form, Parameter list: 
    //*
    //* Shows the empty tables in DB.
    //*

    function MyApp_Handle_Process_Tables_Form()
    {
        if ($this->CGI_POSTint("DO")==1)
        {
            $this->MyApp_Handle_Process_Tables_Update();
        }

        echo
            $this->H(1,"Tables in DB: ".$this->DBHash("DB")).
            $this->Html_Table
            (
                "",
                array
                (
                    array
                    (
                        $this->B("No of Tables in Database:"),
                        $this->Sql_Tables_N(),
                    ),
                    array
                    (
                        $this->B("No of Empty Tables in Database:"),
                        $this->Sql_Tables_Empties_N(),
                    ),
                )
            ).
            $this->H(2,"Tables Info").
            $this->StartForm().
            $this->Buttons("DROP").
            
            
            $this->Html_Table
            (
                $this->MyApp_Handle_Process_Table_Titles(),
                $this->MyApp_Handle_Process_Tables_Table()
            ).
            $this->MakeHidden("DO",1).
            $this->Buttons("DROP").
            $this->EndForm().
            "";
    }
}

?>