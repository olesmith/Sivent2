<?php

include_once("Tables/Events.php");

class MyEventsTables extends MyEventsTablesEvents
{
    //*
    //* function Events_By_Years, Parameter list: $events,$key="Date"
    //*
    //* Generates events table matrix.
    //*

    function Events_By_Years($events,$key="StartDate")
    {
        $revents=array();
        foreach ($events as $event)
        {
            if (preg_match('/^(\d\d\d\d)\d\d\d\d$/',$event[ $key ],$matches))
            {
                $year=$matches[1];
                if (empty($revents[ $year ]))
                {
                    $revents[ $year ]=array();
                }

                array_push($revents[ $year ],$event);
            }
        }

        return $revents;
    }

    
    //*
    //* function Events_Year_Table, Parameter list: 
    //*
    //* Generates events table matrix.
    //*

    function Events_Year_Table($edit,$events,$year)
    {
        return
            array_merge
            (
                array
                (
                    $this->H(4,$year),
                ),
                $this->MyMod_Data_Group_Table
                (
                    "",
                    $edit,
                    $this->ApplicationObj()->EventGroup,
                    $events
                )
            );
    }
    
    //*
    //* function Events_Year_Table, Parameter list: 
    //*
    //* Generates events table matrix.
    //*

    function Events_Table($edit,$events)
    {
        $table=array();
        foreach ($this->Events_By_Years($events) as $year => $revents)
        {
            $table=
                array_merge
                (
                    $table,
                    $this->Events_Year_Table($edit,$revents,$year)
                );
        }
        
        return $table;
    }

    
    //*
    //* function Events_Form, Parameter list: $edit,$events
    //*
    //* Generates events table matrix.
    //*

    function Events_Form($edit,$events)
    {
        $prehtml=$posthtml="";
        if ($edit==1)
        {
            $prehtml=$this->StartForm();
            $posthtml=$this->EndForm();

            #Update: implement
        }
        
        return 
            $this->Htmls_Form
            (
                $edit,
                "Events_Form",
                $action="",
                $this->Htmls_Table
                (
                    "",
                    $this->Events_Table($edit,$events),
                    $options=array(),$troptions=array(),$tdoptions=array(),
                    $evenodd=True,$hover=True
                ),
                $args=array(),
                $options=array()
            );

        
    }
    
    //*
    //* function ShowEvents, Parameter list: $force=False
    //*
    //* Generates events table matrix.
    //*

    function Events_Read($force=False)
    {
        if ($force || empty($this->ApplicationObj()->Events))
        {
            $this->ApplicationObj()->Events=
                $this->Sql_Select_Hashes
                (
                    $this->ApplicationObj()->HtmlEventsWhere(),
                    array(),
                    array("StartDate","ID")
                );
        
            $this->ApplicationObj()->Events=
                array_reverse
                (
                    $this->ApplicationObj()->Events
                );
        }

        return $this->ApplicationObj()->Events;
    }
    
    //*
    //* function ShowEvent, Parameter list:
    //*
    //* Generates events table matrix.
    //*

    function ShowEvent($event)
    {
        echo
            $this->Htmls_Text
            (
                $this->Htmls_Frame
                (
                    $this->InscriptionsObj()->Inscription_Handle_Form_Tables(0,array(),array()),
                    array
                    (
                        "CLASS" => 'frame',
                        "ALIGN" => 'center',
                    )
                )
            );
    }
    
    //*
    //* function ShowEvents, Parameter list:
    //*
    //* Generates events table matrix.
    //*

    function ShowEvents()
    {
        /* $event=$this->Event(); */
        /* if (!empty($event)) */
        /* { */
        /*     $this->ShowEvent($event); */
        /*     return; */
        /* } */
        
        echo
            $this->Htmls_Text
            (
                array
                (
                    $this->Htmls_Comment_Section
                    (
                        "Show Events",
                        array_merge
                        (
                            $this->Htmls_H
                            (
                                1,
                                $this->MyLanguage_GetMessage("Events_Table_Title")
                            ),
                            $this->Events_Form
                            (
                                0,
                                $this->Events_Read(True)
                            )
                        )
                    )
                )
            );
    }
}

?>