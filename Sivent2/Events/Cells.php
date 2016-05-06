<?php

class EventsCells extends MyEvents
{
    //*
    //* function Event_Caravans_Has, Parameter list: $edit,$item=array()
    //*
    //* Returns TRUE if event has collaborations.
    //*

    function Event_Inscriptions_InfoCell($event=array())
    {
        if (empty($event)) { return $this->MyLanguage_GetMessage("Event_Inscriptions_InfoCell_Title"); }

        $msgs=array();
        if ($this->Event_Collaborations_Inscriptions_Open($event))
        {
            array_push
            (
               $msgs,
               $this->MyLanguage_GetMessage("Event_Inscriptions_Collaborations_Has")
            );
        }
        
        if ($this->Event_Submissions_Inscriptions_Open($event))
        {
            array_push
            (
               $msgs,
               $this->MyLanguage_GetMessage("Event_Inscriptions_Submissions_Has")
            );
        }
        
        if ($this->Event_Caravans_Inscriptions_Open($event))
        {
            array_push
            (
               $msgs,
               $this->MyLanguage_GetMessage("Event_Inscriptions_Caravans_Has")
            );
        }

        $cell="";
        if (count($msgs)>0)
        {
             $cell=
                 $this->HtmlList($msgs).
                 $this->MyLanguage_GetMessage("Event_Inscriptions_InfoCell_Message").
                 "";
        }
        
        return $cell;
    }
}

?>