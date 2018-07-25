<?php


class Inscriptions_Handle_Submissions_Info extends Inscriptions_Handle_Submissions_Read
{
    //*
    //* function Inscription_Handle_Submissions_Info, Parameter list: $edit,$friend,$inscription
    //*
    //* Creates Inscription submissions html.
    //*

    function Inscription_Handle_Submissions_Info($edit,$friend,$inscription)
    {
        return
            array
            (
                $this->Htmls_DIV
                (
                    $this->Inscription_Handle_Submissions_Info_Divs($edit,$friend,$inscription),
                    array
                    (
                        "CLASS" => $this->CSS[ "Leading" ],
                    )
                ),
            );
    }
    
    //*
    //* function Inscription_Handle_Submissions_Info_Divs, Parameter list: $edit,$friend,$inscription
    //*
    //* Creates Inscription submissions html.
    //*

    function Inscription_Handle_Submissions_Info_Divs($edit,$friend,$inscription)
    {
        $divs=
            array
            (
                $this->MyLanguage_GetMessage("Submissions_Inscriptions_Message"),

                $this->Htmls_DIV
                (
                    array
                    (
                        $this->MyLanguage_GetMessage("Submissions_Inscriptions_Period_Message").
                        ": ",
                
                        $this->Inscription_Handle_Submissions_Info_DateSpan($edit,$friend,$inscription),
                        $this->Inscription_Handle_Submissions_Info_HREF($edit,$friend,$inscription),
                    ),
                    array
                    (
                        "CLASS" => $this->CSS[ "Text" ],
                    )
                 )
            );

        return $divs;
    }
    
    //*
    //* function Inscription_Handle_Submissions_Info_DateSpan, Parameter list: $edit,$friend,$inscription
    //*
    //* Conditionally creates link to submit.
    //*

    function Inscription_Handle_Submissions_Info_DateSpan($edit,$friend,$inscription)
    {
        return
            $this->Date_Span_Interval
            (
                $this->Event(),
                "Submissions_StartDate",
                "Submissions_EndDate"
            ).
            ". ";
    }
    
    //*
    //* function Inscription_Handle_Submissions_Info_HREF, Parameter list: $edit,$friend,$inscription
    //*
    //* Conditionally creates link to submit.
    //*

    function Inscription_Handle_Submissions_Info_HREF($edit,$friend,$inscription,$event=array())
    {
        if (empty($event))
        {
            $event=$this->Event();
        }
        
        $message_key=
            $this->Date_Span_Position_Status_Message
            (
                array
                (
                    "Submissions_Inscriptions_Waiting_Message",
                    "Submissions_Inscriptions_Open_Message",
                    "Submissions_Inscriptions_Closed_Message",
                ),
                $event,
                "Submissions_StartDate","Submissions_EndDate"
            );

        $href=$this->MyLanguage_GetMessage($message_key);

        if (!empty($friend))
        {
            $href= 
                $this->Htmls_HRef
                (
                    "?".$this->Inscription_Handle_Submissions_URI($friend),
                    $this->MyLanguage_GetMessage("Submissions_Inscriptions_New_Link_Title")
                );
        }
        
        return $href;
    }
}

?>