<?php

class InscriptionsTablesCaravans extends InscriptionsTablesCollaborations
{
    //*
    //* function Inscription_Caravans_Link, Parameter list: 
    //*
    //* Creates inscription caravan info row (no details).
    //*

    function Inscription_Caravans_Link($item,$caravan)
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
    //* function Inscription_Caravans_Row, Parameter list: $item,$caravan
    //*
    //* Creates inscription caravan info row (no details).
    //*

    function Inscription_Caravans_Rows($item,$caravan)
    {
        $event=$this->Event();
        return
            $this->Inscription_Type_Rows
            (
               $item,
               "Caravans",
               $this->Inscription_Caravans_Link($item,$caravan),
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
    //* function Inscription_Caravans_Caravan_Empty, Parameter list: $edit,$item
    //*
    //* Creates Confirm form for registering caravan.
    //*

    function Inscription_Caravans_Caravan_Empty($edit,$group,$item)
    {
        $caravan=$this->Inscription_Caravan_New($item);

        
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
    //* function Inscription_Caravans_Caravan_Info, Parameter list: $edit,$group,$item
    //*
    //* Creates inscrition caravan html table.
    //*

    function Inscription_Caravans_Caravan_Info($edit,$group,$item)
    {
        $buttons="";
        if ($edit==1)
        {
            $buttons=$this->Buttons();
        }
        
        $caravan=$this->Inscription_Caravan_Read($item);

        return
            array
            (  
               $this->Inscription_Caravans_Period_Info($group).
               $this->Inscription_Caravans_Caravan_Table($edit,$caravan).
               $buttons
            );
    }

    
    
    //*
    //* function Inscription_Caravan_New, Parameter list: $item
    //*
    //* Creates new $caravan.
    //*

    function Inscription_Caravan_New($item)
    {
        return array
        (
           "Unit"   => $this->Unit("ID"),
           "Event"  => $this->Event("ID"),
           "Friend" => $item[ "Friend" ],
           "Status" => 1,
           "Homologated" => 1,
        );

        
    }
    
        
    //*
    //* function Inscription_Caravan_Read, Parameter list: $item
    //*
    //* Tries to read registered caravan.
    //*

    function Inscription_Caravan_Read($item)
    {
        $caravan=$this->CaravansObj()->Sql_Select_Hash(array("Friend" => $item[ "Friend" ]));

        return $caravan;
    }

    //*
    //* function Inscription_Caravan_Get, Parameter list: $edit,$item
    //*
    //* Creates inscrition caravan html table.
    //*

    function Inscription_Caravan_Get($edit,$item)
    {
        $caravan=$this->Inscription_Caravan_Read($item);

        if ($edit==1)
        {
            if (empty($caravan))
            {
                if ($this->CGI_POSTint("Add")==1)
                {
                    $caravan=$this->Inscription_Caravan_New($item);
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
    //* function Inscription_Caravans_Table, Parameter list: $edit,$item,$group=""
    //*
    //* Creates inscrition caravan html table.
    //*

    function Inscription_Caravans_Table($edit,$item,$group="")
    {
        if (!$this->Inscriptions_Caravans_Has()) { return array(); }

        if (!$this->Inscriptions_Caravans_Inscriptions_Open()) { $edit=0; }

        foreach (array("CaravansObj","CaravaneersObj") as $module)
        {
            $this->$module()->Sql_Table_Structure_Update();
            $this->$module()->ItemDataGroups("Basic");
            $this->$module()->Actions("Show");
        }
        

        $caravan=$this->Inscription_Caravan_Get($edit,$item);
        
        $table=$this->Inscription_Caravans_Rows($item,$caravan);

        if (empty($group)) { $group="Caravans"; }

        if (empty($this->ItemDataSGroups[ $group ]))
        {
            $this->ItemDataSGroups[ $group ]=
                $this->ReadPHPArray("System/Inscriptions/SGroups.".$group.".php");
        }
        
        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $this->Inscription_Group_Update($group,$item);
        }
                
        $caravanstable=array();
        if (!empty($caravan[ "ID" ]))
        {
            $redit=$edit;
            if ($caravan[ "Status" ]==2) { $redit=0; }
            
            $caravanstable=$this->Inscription_Caravaneers_Table_Show($redit,$item);
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
               $this->Inscription_Caravans_Caravan_Info($edit,$group,$item),
               array($caravanstable)
            );
        }
        else
        {
            array_push($table,$this->Inscription_Caravans_Caravan_Empty($edit,$group,$item));
        }
        
        return $table;
    }
    
    //*
    //* function Inscription_Caravans_Form, Parameter list: $edit,&$item
    //*
    //* Shows currently allocated collaborations for inscription in $item.
    //*

    function Inscription_Caravans_Table_Form($edit,&$item)
    {
        if (!$this->Inscriptions_Caravans_Has()) { return array(); }

        $edit=$this->Inscription_Caravans_Table_Edit($edit);
        if (!$this->Inscriptions_Caravans_Inscriptions_Open()) { $edit=0; }

        foreach (array("CaravansObj","CaravaneersObj") as $module)
        {
            $this->$module()->Sql_Table_Structure_Update();
            $this->$module()->ItemDataGroups("Basic");
            $this->$module()->Actions("Show");
        }

        $caravan=$this->Inscription_Caravan_Get($edit,$item);
        
        $table=$this->Inscription_Caravans_Rows($item,$caravan);
        $type=$this->InscriptionTablesType($item);
        if ($type!="Caravans")
        {
            return $this->Inscription_Caravans_Rows($item,$caravan);
        }
        
        $buttons="";
        $html="";
        if ($edit==1)
        {
            $buttons=$this->Buttons();
            $html.=$this->StartForm();
        }

        $html.=
            $this->Html_Table
            (
               "",
               $this->Inscription_Caravans_Table($edit,$item)
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
    //* function Inscription_Caravaneers_Show, Parameter list: $edit,&$item
    //*
    //* Shows currently allocated collaborations for inscription in $item.
    //*

    function Inscription_Caravaneers_Table_Show($edit,&$item)
    {
        if ($edit==1)
        {
            $this->MyMod_Item_Update_SGroup($item,"Caravans");
        }
                                            
        //if ($item[ "Caravans" ]==1) { return "No"; }

        return $this->Inscription_Event_Caravaneers_Table($edit,$item);
    }
    
    //*
    //* function Inscription_Event_Caravaneers_Table, Parameter list: $edit,&$item
    //*
    //* Creates a table listing inscription caravaneers.
    //*

    function Inscription_Event_Caravaneers_Table($edit,&$item)
    {
        foreach (array("CaravansObj","CaravaneersObj") as $module)
        {
            $this->$module()->Sql_Table_Structure_Update();
            $this->$module()->ItemDataGroups("Basic");
            $this->$module()->Actions("Show");
        }
        
        return 
            $this->CaravaneersObj()->Caravaneers_Table_Show($edit,$item).
            "";
    }
}

?>