<?php

class CaravansCaravaneers extends CaravansAccess
{
    //*
    //* function Caravan_Info_Table, Parameter list: $edit,$caravan
    //*
    //* Prints caravans info.
    //*

    function Caravan_Info_Table($edit,$caravan,$friend)
    {
        $this->FriendsObj()->ItemData();

        $table=
            array_merge
            (
               $this->Friendsobj()->MyMod_Item_Table
               (
                  $edit,
                  $friend,
                  array
                  (
                     "Friend","Email","Phone","Cell",
                  )
               ),
               $this->MyMod_Item_Table
               (
                  $edit,
                  $caravan,
                  array
                  (
                     "Caravans_Name","Caravans_NParticipants","Caravans_Status",
                  )
               )
            );
               
        return $this->FrameIt
        (
            $this->H(1,$this->MyLanguage_GetMessage("Caravans_Table_Title")).
            $this->Html_Table("",$table).
            ""
        );
    }

    //*
    //* function Caravan_Caravaneers_Handle, Parameter list:
    //*
    //* Prints caravaneers info for current item.
    //*

    function Caravan_Caravaneers_Handle()
    {
        $this->CaravaneersObj()->Sql_Table_Structure_Update();
        $this->CaravaneersObj()->Actions();
        $edit=1;

        $inscriptionid=$this->CGI_GETint("ID");
        $caravan=$this->InscriptionsObj()->Sql_Select_Hash(array("ID" => $inscriptionid));
        
        if (empty($caravan[ "Friend" ])) { $this->DoDie("No such inscription: ",$inscriptionid); }

        
        $friendid=$caravan[ "Friend" ];
        $friend=$this->FriendsObj()->Sql_Select_Hash(array("ID" => $friendid));

        if (empty($friend[ "ID" ])) { $this->DoDie("No such friend: ",$friendid); }
        
        $formstart="";
        $formsend="";

        if ($edit==1)
        {
            $formstart=$this->StartForm();
            $formend=
                $this->MakeHidden("Update",1).
                $this->EndForm();
        }

        $table=$this->CaravaneersObj()->Caravaneers_Table_Show($edit,$caravan);
        
        echo $this->FrameIt
        (    
            $formstart.
            $this->Caravan_Info_Table(0,$caravan,$friend).
            $table.
            $formend.
            ""
         );
            
    }
}

?>