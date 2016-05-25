<?php

class CaravaneersTableUpdate extends CaravaneersAccess
{
    //*
    //* function Caravaneer_Table_CGI2Name, Parameter list: $n
    //*
    //* Returns cgi value.
    //*

    function Caravaneer_Table_CGI2Name($n)
    {
        $value="No_".$n."_Name";
        $value=$this->CGI_POST($value);
        
        return
            preg_replace
            (
               '/\s+/',
               " ",
               preg_replace
               (
                  '/^\s+/',
                  "",
                  preg_replace('/s+$/',"",$value)
               )
            );
    }

    //*
    //* function Caravaneer_Table_CGI2Email, Parameter list: $n
    //*
    //* Returns cgi value.
    //*

    function Caravaneer_Table_CGI2Email($n)
    {
        $value="No_".$n."_Email";
        $value=$this->CGI_POST($value);
        
        return preg_replace('/\s+/',"",$value);
    }

    
    //*
    //* function Caravaneer_Table_Update, Parameter list: $n,&$caravaneers,$empty,&$remails
    //*
    //* Updates currently allocated Caravaneers for inscription with $userid.
    //*

    function Caravaneer_Table_Update($n,&$caravaneers,$empty,&$remails)
    {
        $name=$this->Caravaneer_Table_CGI2Name($n);
        $email=$this->Caravaneer_Table_CGI2Email($n);
            
        $updatedatas=array();
        
        $status=0;
        $caravaneer=array();
        if (!empty($name) || !empty($email))
        {
            $rcaravaneer=$empty;
            $rcaravaneer[ "Name" ]=$name;
            $rcaravaneer[ "Email" ]=$email;
            $rcaravaneer[ "Status" ]=0;

            if (count($caravaneers)>0)
            {
                $caravaneer=array_shift($caravaneers);

                foreach (array("Name","Email") as $data)
                {
                    if ($caravaneer[ $data ]!=$rcaravaneer[ $data ])
                    {
                        $caravaneer[ $data ]=$rcaravaneer[ $data ];
                        array_push($updatedatas,$data);
                    }
                }
            }
            else
            {
                $caravaneer=$rcaravaneer;
                $this->Sql_Insert_Item($caravaneer);
            }
        }

        
        $status=2;
        if (!empty($caravaneer[ "Email" ]))
        {
            $comps=preg_split('/@/',strtolower($caravaneer[ "Email" ]));
            $status=3;
            if (count($comps)>=2)
            {
                $mailname=$comps[0];
                $mailhost=$comps[1];
                
                if (filter_var($caravaneer[ "Email" ], FILTER_VALIDATE_EMAIL))
                {
                    $status=1;
                }
            }

            if (!empty($remails[ $caravaneer[ "Email" ] ]))
            {
               $status=4;
            }

            $remails[ $caravaneer[ "Email" ] ]=1;
        }

        if (!empty($caravaneer[ "ID" ]))
        {
            if (empty($caravaneer[ "Status" ]) || $caravaneer[ "Status" ]!=$status)
            {
                $caravaneer[ "Status" ]=$status;
                array_push($updatedatas,"Status");
            }

            $friend=0;
            if ($status==1)
            {
                $rfriend=$this->FriendsObj()->Sql_Select_Hash(array("Email" => $caravaneer[ "Email" ] ),array("ID"));
                if (!empty($rfriend))
                {
                    $friend=$rfriend[ "ID" ];
                }
            }
        
            if (
                  empty($caravaneer[ "Registration" ])
                  ||
                  $caravaneer[ "Registration" ]!=$friend
                )
            {
                $caravaneer[ "Registration" ]=$friend;
                array_push($updatedatas,"Registration");
            }

            if (preg_match('/^(Admin|Coordinator)$/',$this->Profile()))
            {
                $this->Caravaneer_Table_Update_Certificate($caravaneer,$n,$updatedatas);
            }

            if (count($updatedatas)>0 && !empty($caravaneer[ "ID" ]))
            {
                $this->Sql_Update_Item_Values_Set($updatedatas,$caravaneer);
            }
        }
       
        return $caravaneer;
    }
    
    //*
    //* function Caravaneers_Table_Update, Parameter list: $inscription,$caravaneers
    //*
    //* Updates currently allocated Caravaneers for inscription with $userid.
    //*

    function Caravaneers_Table_Update($inscription,$caravaneers,$empty)
    {
        $remails=array();
        $rcaravaneers=array();
        for ($n=1;$n<=$this->Event("Caravans_Max");$n++)
        {
            $rcaravaneer=$this->Caravaneer_Table_Update($n,$caravaneers,$empty,$remails);
            
            if (!empty($rcaravaneer))
            {
                array_push($rcaravaneers,$rcaravaneer);
            }
        }

        while (count($caravaneers)>0)
        {
            $caravaneer=array_shift($caravaneers);
            $this->Sql_Delete_Item($caravaneer[ "ID" ],"ID");
        }
        

        return $rcaravaneers;
    }

    //*
    //* function Caravaneers_Table_Inscription_Update, Parameter list: &$inscription,$caravaneers
    //*
    //* Puts caravaneers in alphabetical order.
    //*

    function Caravaneers_Table_Inscription_Update(&$inscription)
    {
        $ncaravaneers=$this->CaravaneersObj()->Sql_Select_NEntries(array("Friend" => $inscription[ "Friend" ],"Status" => 1));
        
        $updatedatas=array();
        if (
              empty($inscription[ "Caravans_NParticipants" ])
              ||
              $inscription[ "Caravans_NParticipants" ]!=$ncaravaneers
            )
        {
            $inscription[ "Caravans_NParticipants" ]=$ncaravaneers;
            array_push($updatedatas,"Caravans_NParticipants");
        }
        

        $status=1;
        if ($ncaravaneers>=$this->Event("Caravans_Min")) { $status=2; }
        
        if (
              empty($inscription[ "Caravans_Status" ])
              ||
              $inscription[ "Caravans_Status" ]!=$status
            )
        {
            $inscription[ "Caravans_Status" ]=$status;
            array_push($updatedatas,"Caravans_Status");
        }
        
        if (count($updatedatas)>0)
        {
            $this->InscriptionsObj()->Sql_Update_Item_Values_Set($updatedatas,$inscription);
        }
    }

    
     //*
    //* function Caravaneer_Table_Update_Certificate, Parameter list: &$caravaneer,$n,&$updatedatas
    //*
    //* Updates certificate data for caravaneer.
    //*

    function Caravaneer_Table_Update_Certificate(&$caravaneer,$n,&$updatedatas)
    {
        foreach (array("Certificate","Timeload") as $data)
        {
            $cgikey="No_".$n."_".$data;
            if (isset($_POST[ $cgikey ]))
            {
                $cgivalue=$this->CGI_POSTint($cgikey);
                if ($caravaneer[ $data ]!=$cgivalue)
                {
                    $caravaneer[ $data ]=$cgivalue;
                    array_push($updatedatas,$data);
                }
            }
        }
    }

    
}

?>