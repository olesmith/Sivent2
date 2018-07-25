<?php

trait EventMod_May
{        
    //*
    //* sub Current_User_Event_Type_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access edit event data.
    //*
    //*

    function Current_User_Event_Type_May_Edit($type,$event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Type_May_Edit($type,$event);
   }
    
    //*
    //* sub Current_User_Event_Type_May_Access, Parameter list: $type,$event=array()
    //*
    //* Checks whether coordinator (current login) has access edit event data.
    //*
    //*

    function Current_User_Event_Type_May_Access($type,$event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_May_Access($type,$event);
    }

    
    //*
    //* sub Current_User_Event_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access edit event data.
    //*
    //*

    function Current_User_Event_May_Edit($event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_May_Edit($event);
    }

    
    //*
    //* sub Current_User_Event_Inscriptions_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit inscriptions.
    //*
    //*

    function Current_User_Event_Inscriptions_May_Edit($event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Inscriptions_May_Edit($event);
    }

    //*
    //* sub Current_User_Event_Sponsors_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit sponsors.
    //*
    //*

    function Current_User_Event_Sponsors_May_Edit($event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Sponsors_May_Edit($event);
    }

    //*
    //* sub Current_User_Event_Inscription_May_Edit, Parameter list: $inscription,$event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit $inscription.
    //*
    //*

    function Current_User_Event_Inscription_May_Edit($inscription,$event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Inscription_May_Edit($inscription,$event);
    }

    
    //*
    //* sub Current_User_Event_Inscriptions_May_Access, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit inscriptions.
    //*
    //*

    function Current_User_Event_Inscriptions_May_Access($event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Inscriptions_May_Access($event);
    }

    
    //*
    //* sub Current_User_Event_Certificates_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit inscriptions.
    //*
    //*

    function Current_User_Event_Certificates_May_Edit($event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Certificates_May_Edit($event);
    }

    
    //*
    //* sub Current_User_Event_Collaborations_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit Collaborations.
    //*
    //*

    function Current_User_Event_Collaborations_May_Edit($event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Collaborations_May_Edit($event);
    }

     //*
    //* sub Current_User_Event_Collaborations_May_Show, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to show Collaborations.
    //*
    //*

    function Current_User_Event_Collaborations_May_Show($event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Collaborations_May_Show($event);
    }

    
    //*
    //* sub Current_User_Event_Submissions_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit Submissions.
    //*
    //*

    function Current_User_Event_Submissions_May_Edit($item=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Submissions_May_Edit($item);
    }
    
    //*
    //* sub Current_User_Event_Submissions_May_Show, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit Submissions.
    //*
    //*

    function Current_User_Event_Submissions_May_Show($item=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Submissions_May_Show($item);
    }
    
    //*
    //* sub Current_User_Event_Schedule_May_Show, Parameter list: $event=array()
    //*
    //* Checks whether user (current login) has access to edit Schedule.
    //*
    //*

    function Current_User_Event_Schedule_May_Show($item=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Schedule_May_Show($item);
    }
    
    //*
    //* sub Current_User_Event_Caravans_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit Caravans.
    //*
    //*

    function Current_User_Event_Caravans_May_Edit($event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Caravans_May_Edit($event);
    }
        
    //*
    //* sub Current_User_Event_PreInscriptions_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit n.
    //*
    //*

    function Current_User_Event_PreInscriptions_May_Edit($event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_PreInscriptions_May_Edit($event);
    }
    
    //*
    //* sub Current_User_Event_Presences_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit Presences.
    //*
    //*

    function Current_User_Event_Presences_May_Edit($event=array())
    {
        return $this->ApplicationObj()->Current_User_Event_Presences_May_Edit($event);
    }
}
?>
