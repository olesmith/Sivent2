<?php



trait EventMod_Import_Cells
{
    //* function EventMod_Import_Events_CheckBox_All, Parameter list: $id
    //*
    //* Generates src/dest check box .
    //*

    function EventMod_Import_Events_CheckBox_All()
    {
        return
            $this->Html_Input_CheckBox_Field
            (
                "Import_All",
                $value=1,
                $checked=FALSE,
                $disabled=FALSE,
                array
                (
                    "ID" => "select_1",
                )
            );
    }
    //* function EventMod_Import_Event_CheckBox, Parameter list: $id,$dest_items,$src_items
    //*
    //* Generates src/dest check box.
    //*

    function EventMod_Import_Event_CheckBox($id,$dest_items,$src_items)
    {
        $disabled=False;
        if (!empty($dest_items[ $id ]))
        {
            return "-";
        }
        
        return
            $this->Html_Input_CheckBox_Field
            (
                "Import_".$id,
                $value=1,
                False,
                $disabled,
                $options=array
                (
                    "CLASS" => "checkbox_1",
                )
            );
    }

}

?>