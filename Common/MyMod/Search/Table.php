<?php


trait MyMod_Search_Table
{  
    //*
    //* function MyMod_Search_Table_Extra_Rows, Parameter list: 
    //*
    //* Returns search table extra rows
    //*

    function MyMod_Search_Table_Extra_Rows()
    {
        $table=array();
        if (!empty($this->MyMod_Search_Extra_Method))
        {
            $method=$this->MyMod_Search_Extra_Method;
            $table=$this->$method();
        }

        return $table;
    }
    
    //*
    //* function MyMod_Search_Table_Extra_Vars_Rows, Parameter list: 
    //*
    //* Returns search table extra vars rows
    //*

    function MyMod_Search_Table_Extra_Vars_Rows($extravars)
    {
        $table=array();
        foreach ($extravars as $id => $extravar)
        {
            $val=$this->CGI_POST($extravar[ "Name" ]);
            if ($val=="" && isset($extravar[ "Default" ])) { $val=$extravar[ "Default" ]; }

            $width=10;
            if (isset($extravar[ "Width" ])) { $width=$extravar[ "Width" ]; }

            if (empty($extravar[ "Hidden" ]))
            {
                array_push
                (
                   $tbl,
                   array
                   (
                      $this->B($extravar[ "Title" ]),
                      $this->MakeInput($extravar[ "Name" ],$val,$width)
                   )
                );
            }
            else
            {               
                array_push
                (
                   $tbl,
                   array
                   (
                    $this->MakeHidden($extravar[ "Name" ],$val)
                   )
                );
            }
        }

        return $table;
    }
    

    
    //*
    //* function MyMod_Search_Table_Buttons_Row, Parameter list: 
    //*
    //* Returns search table title
    //*

    function MyMod_Search_Table_Button_Title()
    {
        return
            strtoupper
            (
                $this->GetMessage($this->MyMod_Search_Messages,"SearchButton")
            );
            
    }
    //*
    //* function MyMod_Search_Table_Buttons_Row, Parameter list: $buttons
    //*
    //* Returns search table title
    //*

    function MyMod_Search_Table_Buttons_Row($buttons)
    {
        return
            array
            (
                $this->Html_Input_Button_Make
                (
                    "submit",
                    $this->MyMod_Search_Table_Button_Title()
                ).
                join("",$buttons)
           );        
    }
    
    //*
    //* function MyMod_Search_Table_Title, Parameter list: 
    //*
    //* Returns search table title
    //*

    function MyMod_Search_Table_Title($title)
    {
        $btitle=$this->GetMessage($this->MyMod_Search_Messages,"SearchButton");
        if (empty($title))
        {
            $language=$this->MyLanguage_GetLanguageKey();

            $acc="ItemsName".$language;
            $title=
                $this->GetMessage($this->MyMod_Search_Messages,"SearchButton").
                " ".
                $this->$acc;
        }

        return $title;        
    }
    
    //*
    //* function MyMod_Search_Table_Title_Row, Parameter list: 
    //*
    //* Returns search table title rows (matrix)
    //*

    function MyMod_Search_Table_Title_Row($title)
    {
        return
            array
            (
                $this->Center
                (
                    $this->SPAN
                    (
                        $this->MyMod_Search_Table_Title($title),
                        array("CLASS" => 'searchtabletitle')
                    )
                )
            );
    }

    //*
    //* function MyMod_Search_Table_Fields_Table, Parameter list: 
    //*
    //* Generates two row search fields matrix.
    //*

    function MyMod_Search_Table_Fields_Table($fixedvalues,$omitvars)
    {
        $table=array();
        foreach (array_keys($this->ItemData) as $data)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->MyMod_Search_Rows_Generate($data,$fixedvalues,$omitvars,$rval="")
                );
        }

        if ($this->MyMod_Search_Table_Two_Col)
        {
            $table=$this->MyMod_Search_Table_Double_Make($table);
        }

        return $table;
    }
    
    //*
    //* function MyMod_Search_Table_Double_Make, Parameter list: 
    //*
    //* Rearranges search table var fields matrix, if set my attribute.
    //*

    function MyMod_Search_Table_Double_Make($table)
    {
        if ($this->MyMod_Search_Table_Two_Col)
        {
            $rtbl=array();
            while ($row=array_shift($table))
            {
                $rrow=array_shift($table);
                while (count($row)>2) { array_pop($row); }
                while (count($rrow)>2) { array_pop($rrow); }

                if (is_array($rrow))
                {
                    $row=array_merge($row,$rrow);
                }
                array_push($rtbl,$row);
            }

            $table=$rtbl;
        }

        return $table;
    }

    //*
    //* function MyMod_Search_Table_Matrix, Parameter list: $omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array()
    //*
    //* Creates form search vars table. Returns table as matrix.
    //*

    function MyMod_Search_Table_Matrix($omitvars=array(),$title="",$action="",$addvars=array(),$fixedvalues=array(),$tabmovesdown="",$buttons=array())
    {

        return
            array_merge
            (
                $this->MyMod_Search_Table_Title_Row($title),
                $this->MyMod_Search_Table_Fields_Table($fixedvalues,$omitvars),
                $this->MyMod_Search_Options_Rows($omitvars),
                $this->MyMod_Search_Table_Extra_Vars_Rows($addvars),
                array_merge
                (
                    $this->MyMod_Search_Options_Tab_Moves_Down_Row(),
                    $this->MyMod_Search_Table_Buttons_Row($buttons)
                )
        );
    }
}

?>