<?php



trait EventMod_Import_Row
{
    //* function EventMod_Import_Events_Row_Buttons, Parameter list: $n,$id,$dest_items,$src_items=array()
    //*
    //* Generates src/dest buttons row.
    //*

    function EventMod_Import_Event_Row_Buttons()
    {
        $datas=$this->EventMod_Import_Events_Datas_Show();
        return
            array
            (
                $this->MultiCell("",count($datas)+1),
                $this->Buttons("Import","Reset"),
                $this->MultiCell("",count($datas)),
            );
    }
    
    //* function EventMod_Import_Events_Row, Parameter list: $n,$id,$dest_items,$src_items=array()
    //*
    //* Generates src/dest compare row.
    //*

    function EventMod_Import_Event_Cells($id,$event,$items)
    {
        $datas=$this->EventMod_Import_Events_Datas_Show();
        $row=array(  $this->MultiCell("------",count($datas))  );
        if (!empty($items[ $id ]))
        {
            $row=$this->MyMod_Items_Table_Row(0,0,$items[ $id ],$datas);
            foreach (array_keys($row) as $id)
            {
                $row[ $id ]=preg_replace('/\bEvent=(\d+)\b/',"Event=".$event[ "ID" ],$row[ $id ]);
            }
        }

        return $row;
    }

    
    //* function EventMod_Import_Events_Row, Parameter list: $n,$id,$dest_items,$src_items=array()
    //*
    //* Generates src/dest compare row.
    //*

    function EventMod_Import_Events_Row($n,$id,$dest_event,$dest_items,$src_event=array(),$src_items=array())
    {
        return
            array_merge
            (
                array($n),
                $this->EventMod_Import_Event_Cells($id,$src_event,$src_items),
                array
                (
                    $this->Center
                    (
                        $this->EventMod_Import_Event_CheckBox($id,$dest_items,$src_items)
                    )
                ),
                $this->EventMod_Import_Event_Cells($id,$dest_event,$dest_items)
            );
            
    }
}

?>