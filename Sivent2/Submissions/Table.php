<?php

//include_once("Table/Update.php");


class SubmissionsTable extends SubmissionsAccess
{
    //*
    //* function Submissions_Table_Read, Parameter list: $inscription
    //*
    //* Read currently allocated Submissions for $inscription.
    //*

    function Submissions_Table_Read($inscription)
    {
        return 
            $this->Sql_Select_Hashes(array("Friend" => $inscription[ "Friend" ]),array(),"ID");
    }

    //*
    //* function Submissions_Table_Row, Parameter list: $edit,$inscription,$n,$submission,$datas
    //*
    //* Creates $submission row. $submission may be empty.
    //*

    function Submissions_Table_Row($edit,$inscription,$n,$submission,$datas)
    {
        $row=$this->MyMod_Items_Table_Row($edit,$n,$submission,$datas,$plural=FALSE,"No_".$n."_");
            
        return $row;
    }
    

    //*
    //* function Submissions_Table_Data, Parameter list: 
    //*
    //* Puts submissions in alphabetical order.
    //*

    function Submissions_Table_Data()
    {
        return $this->GetGroupDatas("Submission",FALSE);
        return $this->ItemDataGroups[ "Submission" ][ "Data" ];
    }
    
   
    //*
    //* function Submissions_Table_Sort, Parameter list: $submissions
    //*
    //* Puts submissions in alphabetical order.
    //*

    function Submissions_Table_Sort($submissions)
    {
        return $this->SortList($submissions,array("Title"));
    }
    
     //*
    //* function Submissions_Table, Parameter list: $edit,&$inscription
    //*
    //* Shows currently allocated Submissions for inscription with $userid.
    //*

    function Submissions_Table($edit,&$inscription)
    {
        $submissions=$this->Submissions_Table_Read($inscription);

        $datas=$this->Submissions_Table_Data();

        $empty=array
        (
           "Unit" => $this->Unit("ID"),
           "Event" => $this->Event("ID"),
           "Friend" => $inscription[ "Friend" ],
           "Title" => "",
           "Email" => "",
           "Friend" => 0,
        );
        
        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $submissions=$this->Submissions_Table_Update($inscription,$submissions,$empty);
        }
        
        $n=1;
        $table=array();
        foreach ($this->Submissions_Table_Sort($submissions) as $id => $submission)
        {
            array_push($table,$this->Submissions_Table_Row($edit,$inscription,$n++,$submission,$datas));
        }
        
        return $table;
    }
    
     //*
    //* function Submissions_Table_Html, Parameter list: $edit,&$inscription
    //*
    //* Shows currently allocated Submissions for inscription with $userid.
    //*

    function Submissions_Table_Html($edit,&$inscription)
    {
        return
            $this->Html_Table
            (
               $this->GetDataTitles($this->Submissions_Table_Data()),
               $this->Submissions_Table($edit,$inscription)
            ).
            "";
    }
    
    //*
    //* function Submissions_Show, Parameter list: $edit,&$inscription
    //*
    //* Shows currently allocated Submissions for inscription in .
    //*

    function Submissions_Table_Show($edit,&$inscription)
    {
        $buttons="";
        if ($edit==1) { $buttons=$this->Buttons(); }
        

        $msg=$this->MyLanguage_GetMessage("Submissions_Inscriptions_Closed");
        if ($this->EventsObj()->Event_Submissions_Inscriptions_Open())
        {
            $msg=$this->MyLanguage_GetMessage("Submissions_Inscriptions_Open");
        }

        $action=$this->MyActions_Entry("Add",array(),TRUE);
        if (!empty($action))
        {
            $action=$this->Html_BR().$this->Html_BR().$action;
            
        }
        
        return
            $this->H
            (
               3,
               $this->MyLanguage_GetMessage("Submissions_Inscriptions_Table_Title").
               " ".
               $msg.
               $action
            ).
            $buttons.
            $this->Submissions_Table_Html($edit,$inscription).
            $buttons.
            "";
    }
}

?>