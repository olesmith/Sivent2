<?php

class MyEventApp_Access_May extends MyEventApp_Accessors
{
    var $Coordinator_Types=array
    (
       "Event"           => 1,
       "Inscriptions"    => 2,
       "Collaborations"  => 3,
       "Caravans"        => 4,
       "Submissions"     => 5,
       "PreInscriptions" => 6,
       "Presences"       => 7,
    );

    //*
    //* sub Coordinator_Type, Parameter list: $type
    //*
    //* Checks whether coordinator (current login) has access edit event data.
    //*
    //*

    function Coordinator_Type($type)
    {
        return $this->Coordinator_Types[ $type ];
    }

        
    //*
    //* sub Current_User_Event_Type_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access edit event data.
    //*
    //*

    function Current_User_Event_Type_May_Edit($type,$event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        
        return
            $this->Coordinator_Access_Has
            (
               $this->Coordinator_Type($type),
               $event
            );
    }
    
    //*
    //* sub Current_User_Event_May_Access, Parameter list: $type,$event=array()
    //*
    //* Checks whether coordinator (current login) has access edit event data.
    //*
    //*

    function Current_User_Event_May_Access($type,$event=array())
    {
        return TRUE;
    }

    
    //*
    //* sub Current_User_Event_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access edit event data.
    //*
    //*

    function Current_User_Event_May_Edit($event=array())
    {
        return $this->Current_User_Event_Type_May_Edit("Event",$event);
    }

    
    //*
    //* sub Current_User_Event_Inscriptions_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit inscriptions.
    //*
    //*

    function Current_User_Event_Inscriptions_May_Edit($event=array())
    {
        return $this->Current_User_Event_Type_May_Edit("Inscriptions",$event);
    }

    //*
    //* sub Current_User_Event_Inscription_May_Edit, Parameter list: $inscription,$event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit $inscription.
    //*
    //*

    function Current_User_Event_Inscription_May_Edit($inscription,$event=array())
    {
        return
            $this->Current_User_Event_Type_May_Edit("Inscriptions",$event)
            ||
            $inscription[ "Friend" ]==$this->LoginData("ID");
    }

    
    //*
    //* sub Current_User_Event_Inscriptions_May_Access, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit inscriptions.
    //*
    //*

    function Current_User_Event_Inscriptions_May_Access($event=array())
    {
        //If we may read event, we may read inscriptions too
        return $this->Current_User_Event_May_Access("Event",$event);
    }

    
    //*
    //* sub Current_User_Event_Certificates_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit inscriptions.
    //*
    //*

    function Current_User_Event_Certificates_May_Edit($event=array())
    {
        $res=
            $this->Current_User_Event_Type_May_Edit("Inscriptions",$event)
            &&
            $this->HasCertificates($event);

        return $res;
    }

    
    //*
    //* sub Current_User_Event_Collaborations_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit Collaborations.
    //*
    //*

    function Current_User_Event_Collaborations_May_Edit($event=array())
    {
        $res=
            $this->Current_User_Event_Type_May_Edit("Collaborations",$event)
            &&
            $this->HasCollaborations($event);

        return $res;
    }

    
    //*
    //* sub Current_User_Event_Submissions_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit Submissions.
    //*
    //*

    function Current_User_Event_Submissions_May_Edit($item=array())
    {
        $event=$this->Event();
        
        $res=
            $this->Current_User_Event_Type_May_Edit("Submissions",$event)
            &&
            $this->HasSubmissions($event);

        return $res;
    }
    
    //*
    //* sub Current_User_Event_Submissions_May_Show, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit Submissions.
    //*
    //*

    function Current_User_Event_Submissions_May_Show($item=array())
    {
        $event=$this->Event();
        
        $res=
            $this->Current_User_Event_Type_May_Edit("Submissions",$event)
            &&
            $this->HasSubmissions($event);

        $res=
            $res
            ||
            $this->EventsObj()->Event_Submissions_Public($event);

        return $res;
    }
    
    //*
    //* sub Current_User_Event_Caravans_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit Caravans.
    //*
    //*

    function Current_User_Event_Caravans_May_Edit($event=array())
    {
        $res=
            $this->Current_User_Event_Type_May_Edit("Caravans",$event)
            &&
            $this->HasCaravans($event);

        return $res;
    }
    
    //*
    //* sub Current_User_Event_PreInscriptions_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit n.
    //*
    //*

    function Current_User_Event_PreInscriptions_May_Edit($event=array())
    {
        $res=
            $this->Current_User_Event_Type_May_Edit("PreInscriptions",$event)
            //&&
            //$this->($event)
            ;

        return $res;
    }
    
    //*
    //* sub Current_User_Event_Presences_May_Edit, Parameter list: $event=array()
    //*
    //* Checks whether coordinator (current login) has access to edit Presences.
    //*
    //*

    function Current_User_Event_Presences_May_Edit($event=array())
    {
        $res=
            $this->Current_User_Event_Type_May_Edit("Presences",$event)
            //&&
            //$this->($event)
            ;

        return $res;
    }
}
?>
