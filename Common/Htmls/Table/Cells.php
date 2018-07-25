<?php

trait Htmls_Table_Cells
{
    //*
    //* function Htmls_Table_Cell, Parameter list: $cell,$options=array(),$tdtag="TD"
    //*
    //* Creates TD cell.
    //* 
    //*

    function Htmls_Table_Cell($cell,$options=array(),$tdtag="TD")
    {
        if (is_array($cell) && isset($cell[ "Text" ]))
        {
            if (!empty($cell[ "Options" ]))
            {
                foreach ($cell[ "Options" ] as $key => $value)
                {
                    $options[ $key ]=$value;
                }
            }

            if (!empty($cell[ "Class" ]))
            {
                 $this->Html_CSS_Add($cell[ "Class" ],$options);
            }

            $cell=$cell[ "Text" ];
        }

        return $this->Htmls_Tag($tdtag,$cell,$options);
    }
}

?>