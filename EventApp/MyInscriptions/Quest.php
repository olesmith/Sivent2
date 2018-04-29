<?php

class MyInscriptions_Quest extends MyInscriptions_Zip
{
    //*
    //* function EventQuestGroupDatasCommon, Parameter list:
    //*
    //* Returns  common data to show for group.
    //*

    function EventQuestGroupDatasCommon()
    {
        $event=$this->Event();
        
        $datas=array("No","Edit","Friend","Email");
        if ($this->EventsObj()->Event_Certificates_Has($event))
        {
            array_push
            (
                $datas,
                array
                (
                    "Certificate","Certificate_CH","Inscription_Certificate_Generated_Cell",
                    "GenCert",
                )
            );
        }

        return $datas;
    }
    
    //*
    //* function AddEventQuestDataGroups, Parameter list:
    //*
    //* Reads item data defs from Quest - and adds to $this->ItemData..
    //*

    function AddEventQuestDataGroups()
    {
        $event=$this->Event();
        
        if (empty($event[ "ID" ])) { return; }
        if (!method_exists($this,"GroupDatasObj")) { return; }

        $this->GroupDatasObj()->Sql_Table_Structure_Update();
        $this->ReadDBGroups
        (
           $this->GroupDatasObj()->Sql_Select_Hashes
           (
             array
             (
                "Event" => $this->Event("ID"),
                "Pertains" => 1,
             ),
             array(),
             array("SortOrder","ID")
           ),
           $this->EventQuestGroupDatasCommon()
        );
    }

    //*
    //* function AddEventQuestDatas, Parameter list:
    //*
    //* Reads item data defs from Datas - and adds to $this->ItemData.
    //* Should be called by PostProcessItemData(), before SQL table structure update.
    //*

    function AddEventQuestDatas()
    {
        $event=$this->Event();
        
        if (empty($event[ "ID" ])) { return; }
        if (!method_exists($this,"DatasObj")) { return; }

        $this->DatasObj()->Sql_Table_Structure_Update();
        $this->ReadDBData
        (
           $this->DatasObj()->Sql_Select_Hashes
           (
              array
              (
                 "Event" => $this->Event("ID"),
                 "Pertains" => 1,
              ),
              array(),
              array("SortOrder","ID")
           )
        );
    }

    
    //*
    //* function ShowInscriptionQuest, Parameter list: $profile="Friend"
    //*
    //* Displays trial version of the quest form.
    //* Pretends to be $profile.
    //* 
    //*

    function ShowInscriptionQuest($profile="Friend")
    {
        $this->ItemData();
        
        $this->Inscription=$this->InscriptionsObj()->GetEmptyItem();
        $this->MyMod_Data_Groups_Initialize();

        $this->AddEventQuestDatas();
        $this->AddEventQuestDataGroups();

        foreach (array_keys($this->ItemDataSGroups) as $group)
        {
            if (empty($this->ItemDataSGroups[ $group ][ $profile ]))
            {
                unset($this->ItemDataSGroups[ $group ]); 
            }
        }
        
        return
            $this->FrameIt
            (
               $this->H(2,"Visualização do Questionário").
               $this->InscriptionHtmlTable(1,FALSE,$this->Inscription).
               ""
            );
    }
}

?>