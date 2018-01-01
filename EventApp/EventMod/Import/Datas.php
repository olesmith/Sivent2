<?php



trait EventMod_Import_Datas
{
    //* function EventMod_Import_Events_Data_Group, Parameter list: 
    //*
    //* Data to show for showing compare tables.
    //*

    function EventMod_Import_Events_Data_Group()
    {
        $group="Import";
        if (empty($this->ItemDataGroups[ $group ][ "Data" ]))
        {
            $group="Basic";
        }

        return $group;
    }
        
    //* function EventMod_Import_Events_Datas_Show, Parameter list: 
    //*
    //* Data to show for showing compare tables.
    //*

    function EventMod_Import_Events_Datas_Show()
    {
        $group=$this->EventMod_Import_Events_Data_Group();
        
        $datas=$this->ItemDataGroups[ $group ][ "Data" ];
        array_unshift($datas,"ID"); #"Event");
        $datas=preg_grep('/^No$/',$datas,PREG_GREP_INVERT);

        return $datas;
    }
    
    //* function EventMod_Import_Events_Datas_Read, Parameter list:
    //*
    //* Data to show for showing compare tables.
    //*

    function EventMod_Import_Events_Datas_Read()
    {
        #Read all, as all data should be copied.
        return array();
        $datas=$this->EventMod_Import_Events_Datas_Show();
        $datas=$this->MyMod_Datas($datas);

        return $datas;
    }
    
}

?>