<?php



trait MyMod_Data_Read
{
    //*
    //* function MyMod_Data_Read, Parameter list:
    //*
    //* Returns item  data files in $this->MyMod_Data_Files list.
    //*

    function MyMod_Data_Read()
    {
        $this->MyMod_Data_AddTimeData();

        //Allows defining more data, before we update module sql structure.
        if (method_exists($this,"PreProcessItemData"))
        {
            $this->PreProcessItemData();
        }

        foreach ($this->MyMod_Data_Files_Get() as $file)
        {
            if (file_exists($file))
            {
                $this->MyMod_Data_Add_File($file);
            }
        }

        //Allows defining more data, before we update module sql structure.
        if (method_exists($this,"PostProcessItemData"))
        {
            $this->PostProcessItemData();
        }

        $this->MyMod_Datas_AddDefaultKeys();
    }

    
    //*
    //* function MyMod_Data_Add_File, Parameter list: $file
    //*
    //* Returns item  data files in $this->MyMod_Data_Files list.
    //*

    function MyMod_Data_Add_File($file)
    {
        $itemdatas=$this->ReadPHPArray($file);
        foreach (array_keys($itemdatas) as $data)
        {
            $this->MyMod_Data_Add_Data($data,$itemdatas[ $data ]);
            //if (empty($this->ItemData[ $data ][ "File" ])) var_dump($data);
            $this->ItemData[ $data ][ "File" ]=$file;
         }
    }

    
    //*
    //* function MyMod_Data_Add_Data, Parameter list: $file
    //*
    //* Returns item  data files in $this->MyMod_Data_Files list.
    //*

    function MyMod_Data_Add_Data($data,$hash)
    {
        if (!isset($this->ItemData[$data  ]))
        {
            $this->ItemData[ $data ]=$hash;
        }
        else
        {
            if (!is_array($hash)) { var_dump($hash); }
        
            foreach ($hash as $key => $value)
            {
                $this->ItemData[ $data ][ $key ]=$value;
            }
        }
    }
}

?>