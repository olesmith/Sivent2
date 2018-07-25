<?php


trait MyMod_Item_Table
{
    var $MyMod_Item_Table_Data_Edit_Control=array();
    
    //*
    //* Sets Item_Data_Edit_Control var to array, if un defined for $item.
    //*

    function MyMod_Item_Table_Edit_Control_Set($item,$data)
    {
        if (is_array($data))
        {
            foreach ($data as $rdata)
            {
                $this->MyMod_Item_Table_Edit_Control_Set($item,$rdata);                
            }

            return;
        }
        
        if (!empty($item[ "ID" ] ))
        {
            if (empty($this->Item_Data_Edit_Control[ $item[ "ID" ] ]))
            {
                $this->MyMod_Item_Table_Data_Edit_Control[ $item[ "ID" ] ]=array();
            }

            $this->MyMod_Item_Table_Data_Edit_Control[ $item[ "ID" ] ][ $data ]=True;
        }
    }
    
    //*
    //* Sets Item_Data_Edit_Control var to array, if un defined for $item.
    //*

    function MyMod_Item_Table_Edit($item,$edit,$data)
    {
        if
            (
                !empty($item[ "ID" ] )
                &&
                !empty($this->Item_Data_Edit_Control[ $item[ "ID" ] ])
                &&
                !empty($this->Item_Data_Edit_Control[ $item[ "ID" ] ][ $data ])
            )
        {
            $edit=0;
        }

        return $edit;
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
            $redit=$this->MyMod_Item_Table_Edit($item,$edit,$data);
            
            $row=$this->MyMod_Item_Table_Row($redit,$item,$data,$plural);
            if (count($row)>0) { array_push($table,$row); }
            
            $this->MyMod_Item_Table_Edit_Control_Set($item,$data);
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
                     $this->MyMod_Item_Anchor($item).
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
                     $this->MyMod_Data_Compulsory_Message(),
                     $ncols
                  )
               )
             );
        }

        return $table;
    }    
}

?>