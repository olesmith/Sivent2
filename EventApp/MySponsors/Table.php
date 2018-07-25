<?php



class MySponsors_Table extends MySponsors_Access
{
   //*
    //* function Sponsors_Read_Unit, Parameter list: $location
    //*
    //* Returns list of sponsers off the Unit (Event 0).
    //*

    function Sponsors_Read_Unit()
    {
        $unit=$this->Unit("ID");
        $where=array
        (
           "Unit" => $unit,
           "Event" => " 0",
        );

        return $this->Sql_Select_Hashes($where);
    }
    //*
    //* function Sponsors_Read_Event, Parameter list: $event=array()
    //*
    //* Returns list of sponsers off Event.
    //*

    function Sponsors_Read_Event($event=array())
    {
        if (empty($event)) { $event=$this->Event(); }
        $unit=$this->Unit("ID");

        if (empty($event)) { return array(); }
        
        $where=array
        (
           "Unit" => $unit,
           "Event" => $event[ "ID" ],
        );

        return $this->Sql_Select_Hashes($where);
    }
    
    //*
    //* function Sponsors_Cell_Text, Parameter list: $sponsor,$sponsertitleclass
    //*
    //* Produces cell name.
    //*

    function Sponsors_Cell_Text($sponsor)
    {
        $name=$sponsor[ "Name" ];
        if (!empty($sponsor[ "Text" ]))
        {
            $name.=": ".$sponsor[ "Text" ];
        }

        return $name;
    }
    
    //*
    //* function Sponsors_Cell_TITLEs, Parameter list: $sponsor,$sponsertitleclass
    //*
    //* Produces cell titles list.
    //*

    function Sponsors_Cell_TITLEs($sponsor)
    {
        $titles=
            array
            (
                $this->Sponsors_Cell_Text($sponsor).
                join("",$this->MyMod_Data_Field(0,$sponsor,"URL")),
                
                $this->MyMod_Data_Title("Level").
                ": ".
                join("",$this->MyMod_Data_Field(0,$sponsor,"Level")),
                
                $this->MyMod_Data_Title("Value").
                ": ".
                join("",$this->MyMod_Data_Field(0,$sponsor,"Value")),
            );

        return $titles;
    }
    
    //*
    //* function Sponsors_Cell_TITLE, Parameter list: $sponsor,$sponsertitleclass
    //*
    //* Produces cell title for $sponsor.
    //*

    function Sponsors_Cell_TITLE($sponsor)
    {
        return join("\n",$this->Sponsors_Cell_TITLEs($sponsor));
    }

    
    //*
    //* function Sponsors_Cell, Parameter list: $sponsor,$sponsertitleclass
    //*
    //* Produces cell for $sponsor.
    //*

    function Sponsors_Cell($sponsor)
    {
        $args=array
        (
           "Unit"       => $this->Unit("ID"),
           "ModuleName" => "Sponsors",
           "ID"         => $sponsor[ "ID" ],
           "Action"     => "Download",
           "Data"       => "Logo",
        );
        $cell=
            //$this->Div($sponsor[ "Initials" ].":",array("CLASS" => 'sponsortitle')).
            $this->Htmls_A
            (
               $sponsor[ "URL" ],
               $this->IMG
               (
                   "?".$this->CGI_Hash2URI($args),
                   $sponsor[ "Text" ],
                   $sponsor[ "Height" ],
                   $sponsor[ "Width" ]
               ),
               array
               (
                   $this->Sponsors_Cell_TITLE($sponsor),
               ),
               array
               (
                   "TARGET" => '_blank',
                   "CLASS" => 'sponsorlink'
               )
            );

        return $cell;
    }
   
    //*
    //* function Sponsors_Table, Parameter list: $sponsors,$vertical
    //*
    //* Produces a list of Ssponsors.
    //*

    function Sponsors_Table($sponsors,$vertical)
    {
        $table=array();
        foreach ($sponsors as $sponsor)
        {
            $cell=$this->Sponsors_Cell($sponsor);
            if ($vertical)
            {
                $cell=array($cell);
            }

            array_push($table,$cell);
        }

        return $table;
    }

    //*
    //* function Sponsors_Show, Parameter list: $location,$event=array()
    //*
    //* Produces htmls table of unit and event sponsors.
    //*

    function Sponsors_Table_Html($event=array())
    {
        $vertical=TRUE;
        $table=array_merge
        (
           $this->Sponsors_Table
           (
              $this->Sponsors_Read_Unit(),
              $vertical
           ),
           $this->Sponsors_Table
           (
              $this->Sponsors_Read_Event($event),
              $vertical
           )
        );

        if (empty($table)) { return ""; }

        return
            array
            (
                $this->Htmls_DIV
                (
                    $this->MyLanguage_GetMessage("Sponsors_Table_Title"),
                    array("CLASS" => 'sponsorstitle')
                ),
                $this->Htmls_Table
                (
                    "",
                    $table,
                    array("CLASS" => 'sponsorstable',"ALIGN" => 'center'),
                    array("CLASS" => 'sponsorstable'),
                    array("CLASS" => 'sponsorstable'),
                    FALSE,FALSE
                )
            );
    }
}

?>