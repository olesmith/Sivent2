<?php


class Inscriptions_Handle_Event extends Inscriptions_Handle_Inscription
{
    //*
    //* function Inscription_Handle_Event_Status_Form, Parameter list: $edit,$inscription
    //*
    //* Creates Inscription status table.
    //*

    function Inscription_Handle_Event_Status_Form($edit,$inscription)
    {
        return
            $this->Htmls_Comment_Section
            (
                "Event Status Form",
                $this->Htmls_Table
                (
                    "",
                    $this->Inscription_Handle_Event_Status_Table($edit,$inscription)
                )
            );
    }
 
    //*
    //* function Inscription_Handle_Event_Status_Table, Parameter list: $edit,$inscription
    //* Creates $inscription status table.
    //*

    function Inscription_Handle_Event_Status_Table($edit,$inscription)
    {
        $table=$this->Inscription_Handle_Event_Status_Rows($edit,$inscription);

            
        array_push
        (
            $table,
            $this->Inscription_Handle_Event_Status_Row($edit,$inscription)
        );

        if (!empty($inscription[ "ID" ]))
        {
            array_push
            (
                $table,
                $this->Inscription_Handle_Event_Status_Created_Row($edit,$inscription)
            );
        }
        
        return $table;
    }
    
    //*
    //* function Inscription_Status_Row, Parameter list: $edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE
    //*
    //* Creates $inscription status row.
    //*

    function Inscription_Handle_Event_Status_Row($edit,$inscription)
    {
        return
            array
            (
                $this->B($this->MyLanguage_GetMessage("Friend_Data_Status_Title").":"),
                $this->Inscription_Handle_Event_Status_Get($inscription)
            );
    }
    
    //*
    //* function Inscription_Handle_Event_Status_Rows, Parameter list: $edit,$inscription
    //* 
    //*

    function Inscription_Handle_Event_Status_Rows($edit,$inscription)
    {
        $event=$this->Event();
        return
            array
            (
                array
                (
                    $this->Htmls_H
                    (
                        5,
                        array
                        (
                            $this->EventsObj()->MyMod_Data_Fields_Show("Name",$event),
                            "<P>",
                            $this->EventsObj()->Event_Date_Span($event),
                        )
                    ),
                        
                ),
                array
                (
                    $this->B
                    (
                        $this->MyLanguage_GetMessage
                        (
                            "Events_Inscriptions_Status_Title"
                        ).
                        ":"
                    ),
                    $this->EventsObj()->Events_Status_Cell($event),
                ),
                array
                (
                    $this->B
                    (
                        $this->EventsObj()->Event_Inscriptions_Date_Span().
                        ":"
                    ),
                    $this->EventsObj()->Event_Inscriptions_Date_Span($event),
                ),
                array
                (
                    $this->B
                    (
                        $this->EventsObj()->Event_Inscriptions_Editable_Date().
                        ":"
                    ),
                    $this->EventsObj()->Event_Inscriptions_Editable_Date($event),
                ),
            );
     }
 
    
    //* function Inscription_Handle_Event_Created_Row, Parameter list: $edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE
    //*
    //* Creates $inscription status row.
    //*

    function Inscription_Handle_Event_Status_Created_Row($edit,$inscription)
    {
        return
            array
            (
                $this->B
                (
                    $this->MyLanguage_GetMessage("Inscription_Create_Title").":"
                ),
                $this->MyMod_Data_Fields_Show("CTime",$inscription)
            );
    }
    
    //*
    //* function Inscription_Status_Get, Parameter list: $edit,$buttons=FALSE,$inscription=array(),$includeassessments=FALSE
    //*
    //* Returns $inscription status: inscribed or not.
    //*

    function Inscription_Handle_Event_Status_Get($inscription)
    {
        $status="";
        if (!empty($inscription[ "ID" ]))
        {
            $status=$this->MyLanguage_GetMessage("Inscription_Inscribed");
        }
        else
        {
            $status=$this->MyLanguage_GetMessage("Inscription_Not_Inscribed");
        }

        return $status;
    }
}

?>