<?php

class InscriptionsForm extends InscriptionsStatistics
{
    //*
    //* function InscriptionForm, Parameter list: $edit
    //*
    //* Creates Inscription Edit form.
    //*

    function InscriptionForm($edit)
    {
        return parent::InscriptionForm($edit);
    }

    
    //*
    //* function InscriptionFriendSGroups, Parameter list: $edit,
    //*
    //* Returns friend SGroups to display.
    //*

    function InscriptionFriendSGroups()
    {
        return
            $this->MyHash_HashesList_Values
            (
                $this->RegGroupsObj()->Sql_Select_Hashes
                (
                    array("Active" => 2),
                    array("GroupKey")
                ),
                "GroupKey"
            );
    }

    //*
    //* function InscriptionFriendDatas, Parameter list: $edit,
    //*
    //* Returns friend Datas to display.
    //*

    function InscriptionFriendDatas()
    {
        return
            $this->MyHash_HashesList_Values
            (
                $this->RegDatasObj()->Sql_Select_Hashes
                (
                    array("Active" => 2),
                    array("DataKey")
                ),
                "DataKey"
            );
    }

    
    //*
    //* function InscriptionFriendGroupDefs, Parameter list: $edit,
    //*
    //* Returns
    //*

    function InscriptionFriendGroupDefs($edit)
    {
        $this->RegDatasObj()->RegDatas_Friend_Datas_Add();
        $this->RegGroupsObj()->RegGroups_SGroups_Add();
        
        $sdatas=$this->InscriptionFriendDatas();

        #2 groups per line
        $ngroups=2;
        $groupdefs=array();
        $groupsdefs=array();
        foreach ($this->InscriptionFriendSGroups() as $sgroup)
        {
            if (!empty($this->FriendsObj()->ItemDataSGroups[ $sgroup ][ "Registration" ]))
            {
                $groupdefs[ $sgroup ]=$edit;

                $datas=array();
                foreach ($this->FriendsObj()->ItemDataSGroups[ $sgroup ][ "Data" ] as $data)
                {
                    if (preg_grep('/^'.$data.'$/',$sdatas))
                    {
                        array_push($datas,$data);
                    }
                }
                
                $this->FriendsObj()->ItemDataSGroups[ $sgroup ][ "Data" ]=$datas;
                
            }

            if (count($groupdefs)>=$ngroups)
            {
                array_push($groupsdefs,$groupdefs);
                $groupdefs=array();
            }
        }

        if (count($groupdefs)>0)
        {
            array_push($groupsdefs,$groupdefs);
        }

        return $groupsdefs;
    }
    
}

?>