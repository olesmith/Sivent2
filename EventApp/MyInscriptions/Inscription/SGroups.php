<?php

class MyInscriptionsInscriptionSGroups extends MyInscriptionsInscriptionMessages
{
    //*
    //* function InscriptionSGroups, Parameter list: $edit
    //*
    //* Creates Inscription SGroups array.
    //*

    function InscriptionSGroups($edit)
    {
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
        
        $sgroups=$this->PageArray($sgroups,3);
        $groups=array();
        foreach ($sgroups as $row => $rgroups)
        {
            $groups[ $row ]=array();

            foreach ($rgroups as $group)
            {
                $redit=$edit;
                if ($edit==1) { $redit=$this->ItemDataSGroups[ $group ][ $profile ]-1; }
            
                $groups[ $row ][ $group ]=$redit;
            }
        }

        return $groups;
    }

    //*
    //* function InscriptionSGroupsDatas, Parameter list: $edit,$onlyedits=FALSE
    //*
    //* Detects SGroups data. Optionally only editable data.
    //*

    function InscriptionSGroupsDatas($edit,$onlyedits=FALSE)
    {
        $datas=array();
        foreach ($this->InscriptionSGroups($edit) as $id => $groups)
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

    //*
    //* function InscriptionSGroupsCompulsoryData, Parameter list: 
    //*
    //* Returns SGroups compulsory data
    //*

    function InscriptionSGroupsCompulsoryData()
    {
        $datas=array();
        foreach ($this->InscriptionSGroupsDatas(1,TRUE) as $data)
        {
            if ($this->ItemData[ $data ][ "Compulsory" ])
            {
                array_push($datas,$data);
            }
        }  

        return $datas;
    }

    //*
    //* function UndefinedCompulsorySGroupsDatas, Parameter list:
    //*
    //* Returns undefined compulsoru SGrouyps datas.
    //*

    function UndefinedCompulsorySGroupsDatas()
    {
        $datas=array();
        foreach ($this->InscriptionSGroupsCompulsoryData() as $data)
        {
            if (empty($this->Inscription[ $data ]))
            {
                array_push($datas,$data);
            }
        }

        return $datas;
    }


}

?>