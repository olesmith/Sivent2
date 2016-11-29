<?php


trait MyMod_Items_Table
{
    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Table($edit,$items,$datas,$options=array())
    {
        $plural=FALSE;
        if (!empty($options[ "Plural" ])) { $plural=TRUE; }

        $table=array();
        $n=1;
        foreach ($items as $id => $item)
        {
            if (empty($item[ "No" ])){ $item[ "No" ]=$n; }

            if (!empty($item[ "No" ]) && !empty($options[ "Format" ]))
            {
                $item[ "No" ]=sprintf($options[ "Format" ],$item[ "No" ]);
            }

            $pre="";
            if ($plural) { $pre=$item[ "ID" ]."_"; }
            $table[ $id ]=$this->MyMod_Items_Table_Row($edit,$n,$item,$datas,$plural,$pre);;

            $n++;
        }

        return $table;
    }

    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Table_Html($edit,$items,$datas,$options=array(),$troptions=array(),$tdoptions=array())
    {
        if (!is_array($datas)) { $datas=$this->ItemDataGroups($datas,"Data"); }
        
        $plural=FALSE;
        if (!empty($options[ "Plural" ])) { $plural=TRUE; unset($options[ "Plural" ]); }

        return
            $this->Html_Table
            (
               $this->MyMod_Item_Titles($datas),
               $this->MyMod_Items_Table($edit,$items,$datas,array("Plural" => $plural)),
               $options,$troptions,$tdoptions
            ).
            "";
    }
    
    //*
    //* Creates table with $items
    //*

    function MyMod_Items_Html($edit,$title,$emptytitle,$where,$datas,$options)
    {
        $items=
            $this->Sql_Select_Hashes
            (
               $where,
               $datas,
               "Name"
            );

        if (empty($items))
        {
            return $this->Div($emptytitle,array("CLASS" => 'errors'));
        }

        return
            $this->H(3,$title).
            $this->Html_Table
            (
               $this->MyMod_Item_Titles($datas),
               $this->MyMod_Items_Table($edit,$items,$datas),
               $options
            ).
            "";
    }
    
}

?>