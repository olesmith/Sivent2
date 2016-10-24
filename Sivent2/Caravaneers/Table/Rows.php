<?php


class Caravaneers_Table_Rows extends Caravaneers_Table_Where
{
    //*
    //* function Caravaneers_Table_Titles, Parameter list: 
    //*
    //* Title row.
    //*

    function Caravaneers_Table_Titles()
    {
        return
            array
            (
               $this->GetDataTitles
               (
                  $this->Caravaneers_Table_Data()
               )
            );
    }
    
    //*
    //* function Caravaneers_Table_Row, Parameter list: $edit,$inscription,$n,$caravaneer
    //*
    //* Creates $caravaneer row. $caravaneer may be empty.
    //*

    function Caravaneers_Table_Row($edit,$inscription,$n,$caravaneer)
    {
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
    

}

?>