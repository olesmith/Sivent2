<?php

// Table generation.

include_once("Table/Frame.php");
include_once("Table/Row.php");
include_once("Table/Cells.php");
include_once("Table/Pad.php");
include_once("Table/Head.php");

trait Htmls_Table
{
    use
        Htmls_Table_Frame,
        Htmls_Table_Row,
        Htmls_Table_Cells,
        Htmls_Table_Head,
        Htmls_Table_Pad;
     //*
    //* function Htmls_Table, Parameter list: $titles,$rows,$options=array()
    //*
    //* Generates a HTML table.
    //*

    function Htmls_Table($titles,$rows,$options=array(),$troptions=array(),$tdoptions=array(),$evenodd=False,$hover=False)
    {
        if (empty($options)) { $options[ "ALIGN" ]='center'; }
        if (empty($rows)) { return array(); }
        if (!is_array($rows)) { return array(); }

        //Find noof columns in table
        $count=$this->Htmls_Table_NRows($titles,$rows);

        $evenclass="even";
        $oddclass="odd";
        if (!$evenodd)
        {
            $evenclass="ceven";
            $oddclass="codd";
        }

        $html=$this->Htmls_Table_Head($titles);

        $even=True;
        foreach ($rows as $row)
        {
            if (!is_array($row)) { $row=array($row); }

            $rtroptions=$troptions;
            $tag="TD";
            if (!empty($row[ "TitleRow" ])) { $tag="TH"; }

            if (!empty($row[ "Class" ]))
            {
                $this->Html_CSS_Set($row[ "Class" ],$rtroptions); 
            }
            elseif ($evenodd && count($row)>1)
            {
                $this->Html_CSS_Reset($rtroptions); 
                if ($even)
                {
                    $this->Html_CSS_Add($evenclass,$rtroptions); 
                }
                else
                {
                    $this->Html_CSS_Add($oddclass,$rtroptions);
                }
            }

            if (!empty($row[ "Row" ]))
            {
                $row=$row[ "Row" ];
            }

            array_push
            (
                $html,
                $this->Htmls_Table_Row($row,$rtroptions,$tdoptions,$tag,$count)
            );

            if ($even) { $even=False; }
            else       { $even=True; }
        }

        $options["CLASS"] = $options["CLASS"]. " table";
        return $this->Htmls_Tag
        (
            "TABLE",
            $html,
            $options
         );
    }


    

}

?>