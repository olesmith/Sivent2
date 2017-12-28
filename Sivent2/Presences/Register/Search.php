<?php

class Presences_Register_Search extends Presences_Register_Schedules
{
    //*
    //* function Presences_Register_Search_Titles, Parameter list: 
    //*
    //* Creates the add friends table.
    //*

    function Presences_Register_Search_Titles()
    {
        return $this->MyLanguage_GetMessage("Precenses_Friends_Search_Titles");
    }

    
    //*
    //* function Presences_Register_Search, Parameter list: 
    //*
    //* Creates the add friends table.
    //*

    function Presences_Register_Search($schedule)
    {
        $nfields=10;
        
        $table=array();
        for ($n=0;$n<$nfields;$n++)
        {
            $table=array_merge
            (
               $table,
               $this->Presences_Register_Search_Rows($schedule,$n+1)
            );
        }

        array_push
        (
           $table,
           array
           (
              $this->Html_Input_Button_Text
              (
                 $this->MyLanguage_GetMessage("Precenses_Search_Button_Title"),
                 "Search",
                 1
              )
           )
        );

        return
            $this->Html_Form
            (
               $this->H(2,$this->MyLanguage_GetMessage("Precenses_Search_Title")).
               $this->Html_Table
               (
                  $this->Presences_Register_Search_Titles(),
                  $table
               ),
               1,
               "",
               array("Search" => 1)
            ).
            $this->BR().
            "";
        
    }
    
    //*
    //* function Presences_Register_Search_Rows, Parameter list: $n
    //*
    //* Creates the add friends row $n.
    //*

    function Presences_Register_Search_Rows($schedule,$n)
    {
        return array
        (
            array
            (
               $this->B($n.":"),
               $this->Html_Input_Field
               (
                  $this->Presences_Register_Search_Result_Key($n),
                  $this->Presences_Register_Search_Result_Value($n),
                  array
                  (
                     "SIZE" => 25,
                     "TABINDEX" => 1,
                  )
               ),
               $this->Presences_Register_Search_Result_Show($schedule,$n),
            )
        );
    }
    
    
    //*
    //* function Presences_Register_Search_Result_Show, Parameter list: $n
    //*
    //* Creates the add friends row $n.
    //*

    function Presences_Register_Search_Result_Show($schedule,$n)
    {
        $value=$this->Presences_Register_Search_Result_Value($n);
        
        $rows="";
        if (!empty($value))
        {
            $rows=$this->Presences_Register_Search_Result_Table_Html($schedule,$n);
        }

        return $rows;
    }
    //*
    //* function Presences_Register_Search_Result_Table_Html, Parameter list: $schedule,$n
    //*
    //* Generates inscriptions table associated with field no $n.
    //*

    function Presences_Register_Search_Result_Table_Html($schedule,$n)
    {
        return
            $this->Html_Table
            (
               $this->Presences_Register_Search_Result_Titles(),
               $this->Presences_Register_Search_Result_Table($schedule,$n),
               array("ALIGN" => 'right')
            );
    }
    
    //*
    //* function Presences__Search_Result_Titles, Parameter list:
    //*
    //* Generates inscriptions table titles.
    //*

    function Presences_Register_Search_Result_Titles()
    {
        $titles=$this->InscriptionsObj()->MyMod_Data_Titles($this->Presences_Inscriptions_Show_Data());

        array_unshift($titles,"");

        return $titles;
    }
    
    //*
    //* function Presences_Register_Search_Result_Update, Parameter list: $schedule,$n,$inscriptions
    //*
    //* Generates inscriptions table associated with field no $n.
    //*

    function Presences_Register_Search_Result_Update($schedule,$n,&$inscriptions)
    {
        foreach ($inscriptions as $iid => $inscription)
        {
            $where=
                $this->UnitEventWhere
                (
                   array
                   (
                      "Friend" => $inscription[ "Friend" ],
                      "Schedule" => $schedule[ "ID" ],
                   )
                );
            $present=FALSE;
            $presence=$this->Sql_Select_Hash($where);
            
            if (!empty($presence))
            {
                $present=TRUE;
            }
                
            $value=$this->Presences_Register_Search_Result_Inscription_CGI_Value($n,$inscription);
            if (empty($presence) && $value==1)
            {
                $presence=$where;
                $this->MyHash_2_Hash_Transfer
                (
                   $schedule,
                   $presence,
                   $this->Presences_Schedule_Transfer_Data()
                );

                $this->Sql_Insert_Item($presence);
                $present=TRUE;
            }
            
            if ($present)
            {
                unset($inscriptions[ $iid ]);
            }
        }
    }
    
    //*
    //* function Presences_Register_Search_Result_Table, Parameter list: $schedule,$n
    //*
    //* Generates inscriptions table associated with field no $n.
    //*

    function Presences_Register_Search_Result_Table($schedule,$n)
    {
        $inscriptions=$this->Presences_Register_Search_Result_Inscriptions($n);
        
        if ($this->CGI_POSTint("Search")==1)
        {
            $this->Presences_Register_Search_Result_Update($schedule,$n,$inscriptions);
        }
        
        $table=
            $this->InscriptionsObj()->MyMod_Items_Table
            (
               0,
               $inscriptions,
               $this->Presences_Inscriptions_Show_Data()
            );

        $checked=FALSE;
        if (count($inscriptions)==1) { $checked=TRUE; }
        
        foreach ($inscriptions as $iid => $inscription)
        {
            array_unshift
            (
               $table[ $iid ],
               $this->Presences_Register_Search_Result_Inscription_Cell($n,$inscription,$checked)
            );
        }
        
        return $table;
    }
    
    //*
    //* function Presences__Search_Result_Inscription_CGI_Key, Parameter list: $n,$inscription
    //*
    //* Name of CGI key associated with $n,$inscription.
    //*

    function Presences_Register_Search_Result_Inscription_CGI_Key($n,$inscription)
    {
        return $inscription[ "ID" ]."_Include_".$n;
    }

    //*
    //* function Presences__Search_Result_Inscription_CGI_Value, Parameter list: $n,$inscription
    //*
    //* Name of CGI value associated with $n,$inscription.
    //*

    function Presences_Register_Search_Result_Inscription_CGI_Value($n,$inscription)
    {
        return
            $this->CGI_POSTint
            (
               $this->Presences_Register_Search_Result_Inscription_CGI_Key($n,$inscription)
            );
    }

    
    //*
    //* function Presences__Search_Result_Inscription_Cell, Parameter list: $n,$inscription,$checked
    //*
    //* Reads inscriptions associated with field no $n.
    //*

    function Presences_Register_Search_Result_Inscription_Cell($n,$inscription,$checked)
    {
        return
            $this->Html_Input_CheckBox_Field
            (
               $this->Presences_Register_Search_Result_Inscription_CGI_Key($n,$inscription),
               1,
               $checked
            );
    }
    
    //*
    //* function Presences__Search_Result_Inscriptions, Parameter list: $n
    //*
    //* Reads inscriptions associated with field no $n.
    //*

    function Presences_Register_Search_Result_Inscriptions($n)
    {
        return
            $this->InscriptionsObj()->Sql_Select_Hashes
            (
               $this->Presences_Register_Search_Result_Where($n),
               $this->Presences_Inscriptions_Read_Data()
            );
    }
    
    //*
    //* function Presences__Search_Result_Where, Parameter list: $n
    //*
    //* Returns where clase associated with field no $n.
    //*

    function Presences_Register_Search_Result_Where($n)
    {
        $value=$this->Presences_Register_Search_Result_Value($n);
        
        $ors=array();
        foreach ($this->Presences_Inscriptions_Search_Data() as $data)
        {
            array_push($ors,$data." LIKE '%".$value."%'");
        }

        return
            $this->UnitEventWhere
            (
               array
               (
                  "__SortName" => join(" OR ",$ors),
               )
            );
     }
    
    //*
    //* function Presences_Register_Search_Result_Key, Parameter list: $n
    //*
    //* Returns name of Inscriptions search form key no $n.
    //*

    function Presences_Register_Search_Result_Key($n)
    {
        return "Search_".$n;
    }
    
    //*
    //* function Presences_Register_Search_Result_Value, Parameter list: $n
    //*
    //* Returns name of Inscriptions search form value no $n.
    //*

    function Presences_Register_Search_Result_Value($n)
    {
        return $this->CGI_POST($this->Presences_Register_Search_Result_Key($n));
    }
    
    
}

?>