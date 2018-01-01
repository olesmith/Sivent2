<?php



trait EventMod_Import_Table
{
    //* function EventMod_Import_Events_Table, Parameter list: $dest_event,$dest_items,$src_event=array(),$items2=array()
    //*
    //* Generates src/dest compare table.
    //*

    function EventMod_Import_Events_Table($edit,$dest_event,$dest_items,$src_event=array(),$src_items=array())
    {
        $dest_items=$this->MyHash_HashesList_2ID($dest_items);
        $src_items=$this->MyHash_HashesList_2ID($src_items);

        $ids=array();
        foreach (array_keys($dest_items) as $id)
        {
            $ids[ $id ]=True;
        }
        
        foreach (array_keys($src_items) as $id)
        {
            $ids[ $id ]=True;
        }
        
        $ids=array_keys($ids);
        sort($ids,SORT_NUMERIC);

        if (count($ids)<=0)
        {
            return array(array($this->H(5,"No items in source table")));
        }

        $datas=$this->EventMod_Import_Events_Datas_Show();

        $table=array();
        if ($edit==1)
        {
            array_push
            (
                $table,
                $this->EventMod_Import_Event_Row_Buttons()
            );
        }

        $n=1;
        foreach ($ids as $id)
        {
            array_push
            (
                $table,
                $this->EventMod_Import_Events_Row
                (
                    $n++,$id,
                    $dest_event,$dest_items,
                    $src_event,$src_items
                )
            );
            
        }

        if ($edit==1)
        {
            array_push
            (
                $table,
                $this->EventMod_Import_Event_Row_Buttons()
            );
        }
        
        return $table;
    }
}

?>