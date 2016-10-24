<?php


class Caravaneers_Table_Table extends Caravaneers_Table_Sort
{
    //*
    //* function Caravaneers_Table, Parameter list: $edit,&$inscription
    //*
    //* Shows currently allocated Caravaneers for inscription with $userid.
    //*

    function Caravaneers_Table($edit,&$inscription)
    {
        $caravaneers=$this->Caravaneers_Table_Read($inscription);

        
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
                array_push($table,$this->Caravaneers_Table_Row($edit,$inscription,$n,$caravaneer));
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
}

?>