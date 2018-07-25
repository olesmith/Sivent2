<?php

trait Htmls_Table_Pad
{
    //*
    //* function Htmls_Table_Pad, Parameter list: 
    //*
    //* Prepads $pre and post pads $post to all rows of $table.
    //*

    function Htmls_Table_Pad($table,$pre,$post=array())
    {
        if (!is_array($pre))  { $pre=array($pre); }
        if (!is_array($post)) { $post=array($post); }
        
        foreach (array_keys($table) as $id)
        {
            if (!is_array($table[ $id ])) { $table[ $id ]=array($table[ $id ]); }
            
            $table[ $id ]=array_merge($pre,$table[ $id ],$post);
        }

        return $table;
    }
}

?>