<?php

trait MyMod_Group_Rows
{
    //*
    //* function MyMod_Group_Rows_Item, Parameter list: ($edit,$item,$nn,$datas,$subdatas,$even=TRUE,$last=False)
    //*
    //* Generate group rows, as matrix.
    //* Specific class may override MyMod_Group_Rows_Item (returns matrix) or
    //* MyMod_Group_Row_Item, return list.
    //* 
    
    function MyMod_Group_Rows_Item($edit,$item,$nn,$datas,$subdatas,$even=TRUE,$last=False)
    {
        if ($this->ItemTableRowsMethod && $this->ItemTableRowsMethod!="MyMod_Group_Rows_Item")
        {
            $method=$this->ItemTableRowsMethod;
            return $this->$method($edit,$item,$nn,$datas,$subdatas,$even);
        }

        $rows=
            array
            (
                $this->MyMod_Group_Row_Item($edit,$item,$nn,$datas,$even)
            );
        
        if (count($subdatas)>0)
        {
            $ctable=array();
            for ($i=1;$i<=$item[ $countdef[ "Counter" ] ];$i++)
            {
                $crow=array($this->B($i));

                foreach ($subdatas as $data)
                {
                    $value=$this->MakeField($edit,$item,$data.$i,TRUE);//TRUE for plural
                    array_push($crow,$value);
                }

                array_push($ctable,$crow);
            }

            array_push
            (
               $rows,
               array
               (
                  $this->HtmlTable
                  (
                     $subtitles,
                     $ctable,
                     array
                     (
                        'BORDER' => 1,
                        'ALIGN' => 'center'
                     )
                  )
               )
            );
        }

        return $rows;
    }
}

?>