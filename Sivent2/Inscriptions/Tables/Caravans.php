<?php

class InscriptionsTablesCaravans extends InscriptionsTablesCollaborations
{
    //*
    //* function Friend_Caravans_Link, Parameter list: 
    //*
    //* Creates friend caravan info row (no details).
    //*

    function Friend_Caravans_Link($caravan)
    {
        $message="Caravans_Inscribe_Link";
        if (!$this->Inscriptions_Caravans_Inscriptions_Open())
        {
            $message="Caravans_Inscriptions_Closed";
        }
        
        if (!empty($caravan))
        {
            $message="Caravans_Inscribed_Link";
        }

        return $this->Inscription_Type_Link("Caravans",$message);
    }
    
    //*
    //* function Inscription_Caravans_Row, Parameter list: $inscription,$caravan
    //*
    //* Creates inscription caravan info row (no details).
    //*

    function Inscription_Caravans_Rows($inscription,$caravan)
    {
        $event=$this->Event();
        return
            $this->Inscription_Type_Rows
            (
               $inscription,
               "Caravans",
               $this->Friend_Caravans_Link($caravan),
               array("Caravans","Caravans_StartDate","Caravans_EndDate"),
               array()
            );
    }
    
    //*
    //* function Inscription_Caravans_Event_Info, Parameter list: 
    //*
    //* Creates inscrition caravan html table.
    //*

    function Inscription_Caravans_Event_Info()
    {
        return
            array
            (
               $this->EventsObj()->Event_Caravans_Table_Html(0,$this->Event(),"Caravans")
            );
    }
    
    //*
    //* function Inscription_Caravans_Caravan_Table, Parameter list: $caravan
    //*
    //* Creates Confirm form for registering caravan.
    //*

    function Inscription_Caravans_Caravan_Table($edit,$caravan)
    {
        $edit=$this->Inscription_Caravans_Table_Edit($edit);

        if (!$this->Inscriptions_Caravans_Inscriptions_Open()) { $edit=0; }

        $table=
            $this->CaravansObj()->MyMod_Item_Table
            (
               $edit,
               $caravan,
               $this->CaravansObj()->GetGroupDatas("Basic",TRUE)
             );

        array_push
        (
           $table,
           $this->CaravansObj()->Caravan_Info_Print_Row($caravan)
        );
        
        return
            $this->Html_Table("",$table);
    }

    
    //*
    //* function Inscription_Caravans_Period_Info, Parameter list: $group
    //*
    //* Creates inscrition caravan html table.
    //*

    function Inscription_Caravans_Period_Info($group)
    {
        return
            $this->H
            (
               5,
               $this->MyLanguage_GetMessage("Inscription_Period").
               ": ".
               $this->Inscription_Caravans_Table_DateSpan()
            ).
            "";
    }

    
    //*
    //* function Friend_Caravans_Caravan_Empty, Parameter list: $edit,$friend,$inscription
    //*
    //* Creates Confirm form for registering caravan.
    //*

    function Friend_Caravans_Caravan_Empty($edit,$group,$friend,$inscription)
    {
        $caravan=$this->Friend_Caravan_New($friend);

        
        return
            array
            (
               $this->Inscription_Caravans_Period_Info($group).
               $this->Inscription_Caravans_Caravan_Table($edit,$caravan).
               $this->Button
               (
                  "submit",
                  $this->Language_Message("Caravans_Inscribe_Link"),
                  array
                  (
                     "Name" => "Add",
                     "Value" => 1,
                  )
               )
            );
    }
    
    //*
    //* function Friend_Caravans_Caravan_Info, Parameter list: $edit,$group,$friend
    //*
    //* Creates $friend caravan html info table.
    //*

    function Friend_Caravans_Caravan_Info($edit,$group,$friend)
    {
        $buttons="";
        if ($edit==1)
        {
            $buttons=$this->Buttons();
        }
        
        $caravan=$this->Friend_Caravan_Read($friend);

        return
            array
            (  
               $this->Inscription_Caravans_Period_Info($group).
               $this->Inscription_Caravans_Caravan_Table($edit,$caravan).
               $buttons
            );
    }

    
    
    //*
    //* function Friend_Caravan_New, Parameter list: $friend
    //*
    //* Creates new $caravan.
    //*

    function Friend_Caravan_New($friend)
    {
        return array
        (
           "Unit"   => $this->Unit("ID"),
           "Event"  => $this->Event("ID"),
           "Friend" => $friend[ "ID" ],
           "Status" => 1,
           "Homologated" => 1,
        );

        
    }
    
        
    //*
    //* function Friend_Caravan_Read, Parameter list: $friend
    //*
    //* Tries to read $friend registered caravan.
    //*

    function Friend_Caravan_Read($friend)
    {
        $caravan=$this->CaravansObj()->Sql_Select_Hash(array("Friend" => $friend[ "ID" ]));

        return $caravan;
    }

    //*
    //* function Friend_Caravan_Get, Parameter list: $edit,$friend
    //*
    //* Creates $friend caravan html table.
    //*

    function Friend_Caravan_Get($edit,$friend)
    {
        $caravan=$this->Friend_Caravan_Read($friend);

        if ($edit==1)
        {
            if (empty($caravan))
            {
                if ($this->CGI_POSTint("Add")==1)
                {
                    $caravan=$this->Friend_Caravan_New($friend);
                    $datas=$this->CaravansObj()->MyMod_Item_Group_CGI2Item("Basic",$caravan);

                    $add=TRUE;
                    foreach ($datas as $data)
                    {
                        if (empty($caravan[ $data ])) { $add=FALSE; }                    
                    }
                    if ($add)
                    {
                        $this->CaravansObj()->Sql_Insert_Item($caravan);
                    }
                }
            }
            else
            {
                if ($this->CGI_POSTint("Update")==1)
                {
                    $datas=$this->CaravansObj()->MyMod_Item_Group_CGI2Item("Basic",$caravan);
                    if (count($datas)>0)
                    {
                        $this->CaravansObj()->Sql_Update_Item_Values_Set($datas,$caravan);
                    }
                }
            }
        }
        
        return $caravan;
    }

    
    //*
    //* function Friend_Caravans_Table, Parameter list: $edit,$friend,$inscription,$group=""
    //*
    //* Creates inscrition caravan html table.
    //*

    function Friend_Caravans_Table($edit,$friend,$inscription,$group="")
    {
        if (!$this->Friend_Caravans_Should($friend)) { return array(); }
        
//        if (!$this->Inscriptions_Caravans_Has()) { return array(); }

//        if (!$this->Inscriptions_Caravans_Inscriptions_Open()) { $edit=0; }

        foreach (array("CaravansObj","CaravaneersObj") as $module)
        {
            $this->$module()->Sql_Table_Structure_Update();
            $this->$module()->ItemDataGroups("Basic");
            $this->$module()->Actions("Show");
        }
        

        $caravan=$this->Friend_Caravan_Get($edit,$friend);
        
        $table=$this->Inscription_Caravans_Rows($inscription,$caravan);

        if (empty($group)) { $group="Caravans"; }

        if (empty($this->ItemDataSGroups[ $group ]))
        {
            $this->ItemDataSGroups[ $group ]=
                $this->ReadPHPArray("System/Inscriptions/SGroups.".$group.".php");
        }
        
        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $this->Inscription_Group_Update($group,$inscription);
        }
                
        $caravanstable=array();
        if (!empty($caravan[ "ID" ]))
        {
            $redit=$edit;
            if ($caravan[ "Status" ]==2) { $redit=0; }
            
            $caravanstable=$this->Inscription_Caravaneers_Table_Show($redit,$inscription);
        }

        array_push
        (
            $table,
            $this->Inscription_Caravans_Event_Info()
        );
        
        if (!empty($caravan[ "ID" ]))
        {
            array_push
            (
               $table,
               $this->Friend_Caravans_Caravan_Info($edit,$group,$friend),
               array($caravanstable)
            );
        }
        else
        {
            array_push($table,$this->Friend_Caravans_Caravan_Empty($edit,$group,$friend,$inscription));
        }
        
        return $table;
    }
    
    //*
    //* function Friend_Caravans_Form, Parameter list: $edit,$friend,&$inscription
    //*
    //* Shows currently allocated collaborations for inscription in $inscription.
    //*

    function Friend_Caravans_Table_Form($edit,$friend,&$inscription)
    {
        if (!$this->Friend_Caravans_Should($friend)) { return array(); }
        
        //if (!$this->Inscriptions_Caravans_Has()) { return array(); }

        $edit=$this->Inscription_Caravans_Table_Edit($edit);
        if (!$this->Inscriptions_Caravans_Inscriptions_Open()) { $edit=0; }

        foreach (array("CaravansObj","CaravaneersObj") as $module)
        {
            $this->$module()->Sql_Table_Structure_Update();
            $this->$module()->ItemDataGroups("Basic");
            $this->$module()->Actions("Show");
        }

        $caravan=$this->Friend_Caravan_Get($edit,$friend);
        
        //$table=$this->Inscription_Caravans_Rows($inscription,$caravan);
        $type=$this->InscriptionTablesType($inscription);
        if ($type!="Caravans")
        {
            return $this->Inscription_Caravans_Rows($inscription,$caravan);
        }
        
        $buttons="";
        $html="";
        if ($edit==1)
        {
            $buttons=$this->Buttons();
            $html.=$this->StartForm($action="",$method="post",$fileupload=FALSE,$options=array("Anchor" => "Caravan"));
        }

        $html.=
            $this->Html_Table
            (
               "",
               $this->Friend_Caravans_Table($edit,$friend,$inscription)
            ).
            "";

        if ($edit==1)
        {
            $html.=
                $this->MakeHidden("Update",1).
                $this->EndForm();
        }
        
        return array($html);
    }
    
    //*
    //* function Inscription_Caravaneers_Show, Parameter list: $edit,&$inscription
    //*
    //* Shows currently allocated collaborations for inscription in $inscription.
    //*

    function Inscription_Caravaneers_Table_Show($edit,&$inscription)
    {
        if ($edit==1)
        {
            $this->MyMod_Item_Update_SGroup($inscription,"Caravans");
        }
                                            
        //if ($inscription[ "Caravans" ]==1) { return "No"; }

        return $this->Inscription_Event_Caravaneers_Table($edit,$inscription);
    }
    
    //*
    //* function Inscription_Event_Caravaneers_Table, Parameter list: $edit,&$inscription
    //*
    //* Creates a table listing inscription caravaneers.
    //*

    function Inscription_Event_Caravaneers_Table($edit,&$inscription)
    {
        foreach (array("CaravansObj","CaravaneersObj") as $module)
        {
            $this->$module()->Sql_Table_Structure_Update();
            $this->$module()->ItemDataGroups("Basic");
            $this->$module()->Actions("Show");
        }
        
        return 
            $this->CaravaneersObj()->Caravaneers_Table_Show($edit,$inscription).
            "";
    }
}

?>