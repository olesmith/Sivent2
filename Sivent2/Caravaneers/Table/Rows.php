<?php


class Caravaneers_Table_Rows extends Caravaneers_Table_Where
{
    //*
    //* function Caravaneers_Table_Titles, Parameter list: 
    //*
    //* Title rows (matrix).
    //*

    function Caravaneers_Table_Titles()
    {
        $row=
            array
            (
               $this->GetDataTitles
               (
                  $this->Caravaneers_Table_Data()
               )
            );

        $cred=$this->CGI_GET("Cred");
        if ($cred==1)
        {
            array_push($row[0],$this->MyLanguage_GetMessage("Signatures"));
        }

        return $row;
    }
    
    //*
    //* function Caravaneers_Table_Row, Parameter list: $edit,$inscription,$n,$caravaneer
    //*
    //* Creates $caravaneer row. $caravaneer may be empty.
    //*

    function Caravaneers_Table_Row($edit,$inscription,$n,$caravaneer)
    {
        if ($this->LatexMode())
        {
            $caravaneer[ "Email" ]=preg_replace('/_/',"\_",strtolower($caravaneer[ "Email" ]));
            $caravaneer[ "Name" ]=$this->TrimCase($caravaneer[ "Name" ]);
        }

        
        
        $row=
            $this->MyMod_Items_Table_Row
            (
               $edit,
               $n,
               $caravaneer,
               $this->Caravaneers_Table_Data(),
               $plural=FALSE,
               "No_".$n."_"
            );
        
        $cred=$this->CGI_GET("Cred");
        if ($cred==1)
        {
            array_push($row," \\hspace{6cm} ");
        }
          
        return $row;
    }
    

}

?>