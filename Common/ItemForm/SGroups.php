<?php

trait ItemForm_SGroups
{
    //*
    //* function ItemForm_SGroups, Parameter list: $edit
    //*
    //* Creates Assessment SGroups array.
    //*

    function ItemForm_SGroups($edit)
    {
        if (!empty($this->Args[ "SGroups" ]))
        {
            if (is_array($this->Args[ "SGroups" ]))
            {
                return $this->Args[ "SGroups" ];
            }
            else
            {
                $method=$this->Args[ "SGroups" ];
                return $this->$method($edit);
            }
        }
        $profile=$this->Profile();

        
        $sgroups=array();
        foreach (array_keys($this->ItemDataSGroups) as $group)
        {
            if (
                  !empty($this->ItemDataSGroups[ $group ][ $profile ])
                  &&
                  count($this->ItemDataSGroups[ $group ][ "Data" ])>0
               )
            {
                array_push($sgroups,$group);
            }
        }

        $sgroups=$this->PageArray($sgroups,$this->Args[ "SGroupsNCols" ]);
        $groups=array();
        foreach ($sgroups as $row => $rgroups)
        {
            $groups[ $row ]=array();
            foreach ($rgroups as $group)
            {
                $redit=$edit;
                if ($edit==1)
                {
                    $redit=$this->ItemDataSGroups[ $group ][ $profile ]-1;
                }
                
                $groups[ $row ][ $group ]=$redit;
            }
        }

        return $groups;
    }

    //*
    //* function ItemForm_SGroupsDatas, Parameter list: $edit,$onlyedits=FALSE
    //*
    //* Detects SGroups data. Optionally only editable data.
    //*

    function ItemForm_SGroupsDatas($edit,$onlyedits=FALSE)
    {
        if (!empty($this->Args[ "SGroupsDatas" ]))
        {
            if (is_array($this->Args[ "SGroupsDatas" ]))
            {
                return $this->Args[ "SGroupsDatas" ];
            }
            else
            {
                $method=$this->Args[ "SGroupsDatas" ];
                return $this->$method($edit);
            }
        }

        $datas=array();
        foreach ($this->ItemForm_SGroups($edit) as $id => $groups)
        {
            foreach ($groups as $group => $edit)
            {
                foreach ($this->ItemDataSGroups[ $group ][ "Data" ] as $data)
                {
                    if (!$onlyedits || $this->MyMod_Data_Access($data)==2)
                    {
                        array_push($datas,$data);
                    }
                }                
            }
        }

        return $datas;
    }
}

?>