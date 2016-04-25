<?php



trait MyMod_Data_Groups_Add
{
    //*
    //* function MyMod_Data_Groups_Files_Add_Files, Parameter list: $singular,$files
    //*
    //* Adds action files.
    //*

    function MyMod_Data_Groups_Files_Add_Files($singular,$files)
    {
        foreach ($files as $file)
        {
            $this->MyMod_Data_Groups_Files_Add_File($singular,$file);
        }
    }

    //*
    //* function MyMod_Data_Groups_Files_Add_File, Parameter list: $singular,$file
    //*
    //* Adds actions
    //*

    function MyMod_Data_Groups_Files_Add_File($singular,$file)
    {
        $this->MyMod_Data_Groups_Files_Add_Groups($singular,$this->ReadPHPArray($file),$file);
    }

    //*
    //* function MyMod_Data_Groups_Files_Add_Groups, Parameter list: $singular,$groups,$file
    //*
    //* Adds actions
    //*

    function MyMod_Data_Groups_Files_Add_Groups($singular,$groups,$file)
    {
        //$this->MyMod_Data_Groups_Defaults_Take($groups);

        foreach (array_keys($groups) as $group)
        {
            $this->MyMod_Data_Group_Defaults_Take($groups[ $group ]);
            $groups[ $group ][ "File" ]=$file;
            if ($singular)
            { 
                $this->MyMod_Data_Groups_Files_Add_SGroup($group,$groups[ $group ]);
            }
            else
            {
                $this->MyMod_Data_Groups_Files_Add_Group($group,$groups[ $group ]);
            }
        }
    }

    //*
    //* function MyMod_Data_Groups_Files_Add_Group, Parameter list: $group,$hash
    //*
    //* Adds $group.
    //*

    function MyMod_Data_Groups_Files_Add_Group($group,$hash)
    {
        if (!isset($this->ItemDataGroups[ $group ]))
        {
            $this->ItemDataGroups[ $group ]=$hash;
        }
        else
        {
            foreach ($hash as $key => $value)
            {
                $this->ItemDataGroups[ $group ][ $key ]=$value;
            }
        }
    }

    //*
    //* function MyMod_Data_Groups_Files_Add_SGroup, Parameter list: $group,$hash
    //*
    //* Adds $group.
    //*

    function MyMod_Data_Groups_Files_Add_SGroup($group,$hash)
    {
        if (!isset($this->ItemDataSGroups[ $group ]))
        {
            $this->ItemDataSGroups[ $group ]=$hash;
        }
        else
        {
            foreach ($hash as $key => $value)
            {
                $this->ItemDataSGroups[ $group ][ $key ]=$value;
            }
        }
    }


}

?>