<?php


class InscriptionsCollaborations extends InscriptionsForm
{
    //*
    //* function Inscriptions_Collaborations_Has, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscriptions_Collaborations_Has($inscription=array())
    {
        return $this->EventsObj()->Event_Collaborations_Has($this->Event());
    }
    
    /* //\* */
    /* //\* function Inscriptions_Collaborations_Inscriptions_Has, Parameter list:  */
    /* //\* */
    /* //\* Detects if current event has collaborations activated. */
    /* //\* */

    /* function Inscriptions_Collaborations_Inscriptions_Has($inscription=array()) */
    /* { */
    /*     return $this->EventsObj()->Event_Collaborations_Inscriptions_Has($this->Event()); */
    /* } */

    //*
    //* function Inscriptions_Collaborations_Inscriptions_Open, Parameter list: 
    //*
    //* Detects if current event has inscriptions to collaborations activated.
    //*

    function Inscriptions_Collaborations_Inscriptions_Open($inscription=array())
    {
        return $this->EventsObj()->Event_Collaborations_Inscriptions_Open($this->Event());
    }

    /* //\* */
    /* //\* function Friend_Collaborators_Has, Parameter list: $inscription */
    /* //\* */
    /* //\* Detects if $inscription has any collaborations. */
    /* //\* */

    /* function Friend_Collaborators_Has($friend,$inscription=array()) */
    /* { */
    /*     $res=FALSE; */

    /*     $nentries=0; */
    /*     if (!empty($friend[ "ID" ])) */
    /*     { */
    /*         $nentries=$this->CollaboratorsObj()->Sql_Select_NEntries(array("Friend" => $friend[ "ID" ])); */
    /*     } */

    /*     if ($nentries>0) { $res=TRUE; } */

    /*     return $res; */
    /* } */

    
    //*
    //* function Inscriptions_Collaborations_Show_Should, Parameter list: 
    //*
    //* Detects if current event has collaborations activated.
    //*

    function Inscriptions_Collaborations_Show_Should($inscription=array())
    {
        $res=
            $this->EventsObj()->Event_Collaborations_Inscriptions_Open($this->Event())
            ||
            $this->Friend_Collaborators_Has(array("ID" => $inscription[ "Friend" ]));

        return $res;
    }

    //*
    //* function Inscriptions_Collaborations_Show_Name, Parameter list: 
    //*
    //* Generates  name for Collaborators link.
    //*

    function Inscriptions_Collaborations_Show_Name($data,$inscription=array())
    {
        $title="";
        if ($this->Friend_Collaborators_Has(array("ID" => $inscription[ "Friend" ])))
        {
            $title=$this->MyLanguage_GetMessage("Events_Collaborations_Show_Has_Name");
        }
        else
        {
            $title=$this->MyLanguage_GetMessage("Events_Collaborations_Show_Inscriptions_Name");
        }

        return $title;
    }

     //*
    //* function Inscriptions_Collaborations_Show_Title, Parameter list: 
    //*
    //* Generates title for Collaborators link.
    //*

    function Inscriptions_Collaborations_Show_Title($data,$inscription=array())
    {
        $title="";
        if ($this->Friend_Collaborators_Has(array("ID" => $inscription[ "Friend" ])))
        {
            $title=$this->MyLanguage_GetMessage("Events_Collaborations_Show_Has_Title");
        }
        else
        {
            $title=$this->MyLanguage_GetMessage("Events_Collaborations_Show_Inscriptions_Title");
        }

        return $title;
    }
   
    //*
    //* function Inscription_Collaborations_Table_Edit, Parameter list: $edit
    //*
    //* Detects value of $edit: are inscriptions open? if not, set $edit=0.
    //*

    function Inscription_Collaborations_Table_Edit($edit)
    {
        $startdate=$this->Event("Collaborations_StartDate");
        $enddate=$this->Event("Collaborations_EndDate");

        $today=$this->MyTime_2Sort();
        if ($today<$startdate || $today>$enddate) { $edit=0; }

        return $edit;
    }
    
   
    //*
    //* function Inscription_Group_Update, Parameter list: &$inscription
    //*
    //* Updates data from Collaborations form.
    //*

    function Inscription_Group_Update($group,&$inscription)
    {
        $inscription=
            $this->MyMod_Item_Update_CGI
            (
                $inscription,
                $this->MyMod_Data_Group_Datas_Get($group,TRUE),
                $prepost=""
            );
        
        return $inscription;
    }
    
    //*
    //* function Friend_Collaborations_Show, Parameter list: $edit,$friend,$inscription,$msgkey=""
    //*
    //* Shows currently allocated collaborations for inscription in $inscription.
    //*

    function Friend_Collaborations_Table_Show($edit,$friend,$inscription,$msgkey="")
    {
        if (empty($msgkey)) { $msgkey="Collaborators_User_Inscription_Title"; }
        
        $this->CollaborationsObj()->Sql_Table_Structure_Update();
        $this->CollaboratorsObj()->Sql_Table_Structure_Update();

        return
            $this->CollaboratorsObj()->Collaborators_User_Table_Show($edit,$friend[ "ID" ],$msgkey);
    }
    
}

?>