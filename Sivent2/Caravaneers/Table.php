<?php

include_once("Table/Update.php");


class CaravaneersTable extends CaravaneersTableUpdate
{
    //*
    //* function Caravaneers_Table_ReadN, Parameter list: $inscription
    //*
    //* Read currently allocated Caravaneers for $inscription.
    //*

    function Caravaneers_Table_ReadN($inscription)
    {
        return 
            $this->Sql_Select_NHashes(array("Friend" => $inscription[ "Friend" ]));
    }

    //*
    //* function Caravaneers_Table_Read, Parameter list: $inscription
    //*
    //* Read currently allocated Caravaneers for $inscription.
    //*

    function Caravaneers_Table_Read($inscription)
    {
        return 
            $this->Sql_Select_Hashes(array("Friend" => $inscription[ "Friend" ]),array(),"ID",TRUE);
    }

    //*
    //* function Caravaneers_Table_Row, Parameter list: $edit,$inscription,$n,$caravaneer,$datas
    //*
    //* Creates $caravaneer row. $caravaneer may be empty.
    //*

    function Caravaneers_Table_Row($edit,$inscription,$n,$caravaneer,$datas)
    {
        $row=$this->MyMod_Items_Table_Row($edit,$n,$caravaneer,$datas,$plural=FALSE,"No_".$n."_");

        if (!empty($caravaneer[ "Email" ]))
        {
            $comps=preg_split('/@/',$caravaneer[ "Email" ]);
            if (count($comps)>=2)
            {
                $mailname=$comps[0];
                $mailhost=$comps[1];

                $regex='[\/#,:<>]';
                
                if (
                      preg_match('/'.$regex.'/',$mailname)
                      ||
                      preg_match('/'.$regex.'/',$mailname)
                   )
                {
                    
                }
           }
        }
            
        return $row;
    }
    

    //*
    //* function Caravaneers_Table_Sort, Parameter list: $caravaneers
    //*
    //* Puts caravaneers in alphabetical order.
    //*

    function Caravaneers_Table_Sort($caravaneers)
    {
        $sort=$this->MyHash_HashesList_Key($caravaneers,"Status");
        $statuses=array_keys($sort);
        sort($statuses,SORT_NUMERIC);

        $rcaravaneers=array();
        foreach ($statuses as $id => $status)
        {
            $statuscars=$sort[ $status ];

            $statuscars=$this->SortList($statuscars,array("Name"));
            $rcaravaneers=array_merge($rcaravaneers,$statuscars);
        }
        
        return $rcaravaneers; //$this->SortList($caravaneers,array("Name"));
    }
    
   
    //*
    //* function Caravaneers_Table, Parameter list: $edit,&$inscription
    //*
    //* Shows currently allocated Caravaneers for inscription with $userid.
    //*

    function Caravaneers_Table($edit,&$inscription)
    {
        $caravaneers=$this->Caravaneers_Table_Read($inscription);

        $datas=$this->GetGroupDatas("Inscription");

        $empty=array
        (
           "Unit" => $this->Unit("ID"),
           "Event" => $this->Event("ID"),
           "Friend" => $inscription[ "Friend" ],
           "Name" => "",
           "Email" => "",
           "Registration" => 0,
        );
        
        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $caravaneers=$this->Caravaneers_Table_Update($inscription,$caravaneers,$empty);
        }
        
        $caravaneers=$this->Caravaneers_Table_Sort($caravaneers);
        $this->Caravaneers_Table_Inscription_Update($inscription);

        
        $min=$this->EventsObj()->Event_Caravans_Min();
        $max=$this->EventsObj()->Event_Caravans_Max();

        $table=array();
        for ($n=1;$n<=$max;$n++)
        {
            $caravaneer=array();
            if (count($caravaneers)>0) { $caravaneer=array_shift($caravaneers); }
            else                       { $caravaneer=$empty; }
            
            if ($edit==1 || !empty($caravaneer[ "ID" ]))
            {
                array_push($table,$this->Caravaneers_Table_Row($edit,$inscription,$n,$caravaneer,$datas));
            }

            if ($n==$min && $edit==1)
            {                
                array_push
                (
                   $table,
                   array
                   (
                      $this->HR().
                      $this->MyLanguage_GetMessage("Caravaneers_Minimum_Title").
                      ": ".
                      $min.
                      $this->HR()
                   )
                );
            }
        }
        
        return $table;
    }
    
    //*
    //* function Caravaneers_Show, Parameter list: $edit,&$inscription
    //*
    //* Shows currently allocated Caravaneers for inscription in .
    //*

    function Caravaneers_Table_Show($edit,&$inscription)
    {
        $buttons="";
        if ($edit==1) { $buttons=$this->Buttons(); }
        
        $n=$this->Caravaneers_Table_ReadN($inscription);

        if ($n==0 && $edit!=1) { return ""; }
        
        return
            $this->H(3,$this->MyLanguage_GetMessage("Caravaneers_Table_Title")).
            $buttons.
            $this->Html_Table
            (
               $this->GetDataTitles($this->GetGroupDatas("Inscription")),
               $this->Caravaneers_Table($edit,$inscription)
            ).
            $buttons.
            "";
    }
}

?>