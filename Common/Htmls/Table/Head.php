<?php

trait Htmls_Table_Head
{
    //*
    //* function Htmls_Table_Head, Parameter list: $row
    //*
    //* Returns a table head row, hashing row; 
    //*

    function Htmls_Table_Head($titles)
    {
        $table=array();
        if (!empty($titles))
        {
            if (!is_array($titles[0]))
            {
                $titles=array($titles);
            }

            foreach ($titles as $trow)
            {
                array_push
                (
                    $table,
                    $this->Htmls_Table_Row
                    (
                        $trow,
                        array(),
                        array("Class" => 'head'),
                        "TH"
                    )
                );
            }
        }

        return $table;
    }
    
    //*
    //* function Htmls_Table_Head_Row, Parameter list: $row
    //*
    //* Returns a table head row, hashing row; 
    //*

    function Htmls_Table_Head_Row($row)
    {
        return
            array
            (
               "Row" => $row,
               "Class" => 'head',
               "TitleRow" => TRUE,
            );
    }
    
    //*
    //* function Htmls_Table_Head_Rows, Parameter list: $rows
    //*
    //* Returns a table head row, hashing rows; 
    //*

    function Htmls_Table_Head_Rows($rows)
    {
        foreach (array_keys($rows) as $id)
        {
            $rows[ $id ]=$this->Html_Table_Head_Row($rows[ $id ]);
        }
        
        return $rows;
    }
    
}

?>