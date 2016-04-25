<?php


class DataPrintInclude extends DataPrintTable
{

    //*
    //* function DataToIncludeTable, Parameter list: 
    //*
    //* Creates table for selecting student data to include.
    //*

    function DataToIncludeTable()
    {
        $table=array();

        array_push
        (
           $table,
           array
           (
              $this->B($this->ColsDef[ "NColTitle" ]),
              $this->IncludeNColsField()
           )
        );

        for ($n=0;$n<$this->ColsDef[ "NCols" ];$n++)
        {
            array_push
            (
               $table,
               array
               (
                $this->B($this->ColsDef[ "NColTitle" ]." ".($n+1).":"),
                $this->IncludeDataField($n)
               )
            );
        }


        return $table;
    }

    //*
    //* function DataToIncludeHtmlTable, Parameter list: 
    //*
    //* Creates table for selecting student data to include.
    //*

   function DataToIncludeHtmlTable()
    {
        return $this->FrameIt
        (
            $this->Html_Table
            (
               "",
               $this-> DataToIncludeTable(),
               array("ALIGN" => 'center'),
               array(),
               array(),
               FALSE,FALSE
            )
        );
    }

}

?>