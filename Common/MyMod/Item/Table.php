<?php


trait MyMod_Item_Table
{
    //*
    //* Creates item table, calling ItemTableRow for each var.
    //*

    function MyMod_Item_Table_Html($edit,$item,$datas,$plural=FALSE,$includename=FALSE,$includecompulsorymsg=FALSE,$toptions=array(),$troptions=array(),$tdoptions=array())
    {
        return
            $this->Html_Table
            (
               "",
               $this->MyMod_Item_Table
               (
                   $edit,
                   $item,
                   $datas,
                   $plural,
                   $includename,
                   $includecompulsorymsg
               ),
               $toptions,$troptions,$tdoptions
            ).
            "";
    }

    
    //*
    //* Creates item table, calling ItemTableRow for each var.
    //*

    function MyMod_Item_Table($edit,$item,$datas,$plural=FALSE,$includename=FALSE,$includecompulsorymsg=FALSE)
    {
        if (count($item)>0) {} else { $item=$this->ItemHash; }

        $table=array();

        $compulsories=0;
        $ncols=0;
        foreach ($datas as $data)
        {
            $row=$this->MyMod_Item_Table_Row($edit,$item,$data,$plural);
            if (count($row)>0) { array_push($table,$row); }
            
            $ncols=$this->Max($ncols,count($row));
        }

        if ($includename)
        {
            array_unshift
            (
               $table,
               array
               (
                  $this->MultiCell
                  (
                     $this->ItemAnchor($item).
                     $this->H(5,$this->MyMod_Item_Name_Get($item)),
                     $ncols
                  )
               )
            );
        }
        
        if ($includecompulsorymsg && $compulsories>0 && $edit==1)
        {
            array_push
            (
               $table,
               array
               (
                  $this->MultiCell
                  (
                     $this->CompulsoryMessage(),
                     $ncols
                  )
               )
             );
        }

        return $table;
    }    
}

?>