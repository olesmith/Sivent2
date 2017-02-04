<?php


trait MyMod_Item_Group_Data
{
    //*
    //* Returns list of data of $group - singular or plural.
    //*

    function MyMod_Item_Group_Data($group,$singular=FALSE)
    {
        if ($singular)
        {
            return $this->ItemDataSGroups[ $group ][ "Data" ];
        }
        else
        {
            return $this->ItemDataGroups[ $group ][ "Data" ];
        }
    }
    
    //*
    //* Returns list of data of $groups - singular or plural.
    //*

    function MyMod_Item_Groups_Data($groups,$singular=FALSE)
    {
        $datas=array();
        foreach ($groups as $group)
        {
            $gdatas=$this->MyMod_Item_Group_Data($group,$singular);
            foreach ($gdatas as $data) { $datas[ $data ]=1; }
        }

        return array_keys($datas);
    }
    
    //*
    //* Checks if compulsoruy data in $group are all defined.
    //*

    function MyMod_Item_Group_Data_IsDefined($group,$item,$undefs=array())
    {
        if (empty($this->Actions)) { $this->InitActions(); }

        $datas=$this->MyMod_Item_Group_Data($group,TRUE);
        $rdatas=array();
        foreach ($datas as $data)
        {
            if (!empty($this->ItemData[ $data ]))
            {
                array_push($rdatas,$data);
            }
        }


        $this->MakeSureWeHaveRead("",$item,$rdatas);

        foreach ($datas as $data)
        {
            if (!empty($this->Actions[ $data ])) { continue; }
            if (!$this->ItemData[ $data ][ "Compulsory" ]) {  continue; }

            if (empty($item[ $data ]))
            {
                $undefs[ $data ]=TRUE;
            }            
        }

        return $undefs;
    }

    
    //*
    //* Checks if compulsory data in $groups are all defined.
    //*

    function MyMod_Item_Groups_Data_IsDefined($groups,$item)
    {
        $undefs=array();
        foreach ($groups as $group)
        {
            $undefs=$this->MyMod_Item_Group_Data_IsDefined($group,$item,$undefs);       
        }

        return array_keys($undefs);
    }
    
    //*
    //* Returns list of data of $group that are compulsory.
    //*

    function MyMod_Item_Group_Compulsory_Data($group,$singular=FALSE)
    {
        $datas=array();
        foreach ($this->MyMod_Item_Group_Data($group,$singular) as $data)
        {
            if ($this->MyMod_Data_Field_Is_Compulsory($data))
            {
                $datas[ $data ]=1;
            }
        }

        return array_keys($datas);
    }
    
    //*
    //* Returns list of data of all groups that are compulsory.
    //*

    function MyMod_Item_Groups_Compulsory_Data($groups,$singular=FALSE)
    {
        $datas=array();
        foreach ($groups as $id => $rgroups)
        {
            foreach ($rgroups as $group => $edit)
            {
                foreach ($this->MyMod_Item_Group_Compulsory_Data($group,$singular) as $data)
                {
                    $datas[ $data ]=1;
                }
            }
        }

        return array_keys($datas);
    }
    
}

?>