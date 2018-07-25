<?php

trait MyApp_Handle_SU_Profiles
{
    //*
    //* function MyApp_Handle_SU_Profiles_Table, Parameter list: 
    //*
    //* Creates table of shoift user selects fields, per profile.
    //*

    function MyApp_Handle_SU_Profiles_Table()
    {
        $profile2people=$this->MyApp_Handle_SU_Users_Read_Per_Profile();

        $selectrows=array();
        foreach ($this->MyApp_Handle_SU_Users_Read_Per_Profile() as $profile => $rpeople)
        {
            if (count($rpeople)>0)
            {
                array_push
                (
                    $selectrows,
                    array
                    (
                        $this->B
                        (
                            $this->MyApp_Profile_Name($profile,True)
                            .":"
                        ),
                        $this->MyApp_Handle_SU_Profile_Select($profile,$rpeople)
                    )
                );
            }
        }

        return $selectrows;
    }
    
    //*
    //* function MyApp_Handle_SU_Select, Parameter list: 
    //*
    //* Creates shift user select field.
    //*

    function MyApp_Handle_SU_Profile_Select($profile,$rpeople)
    {
        $selectids=array(0);
        $selectnames=array("");
        foreach ($rpeople as $person)
        {
            if ($person[ "Profile_Admin" ]==2) { continue; } //newer su to admin!
            if (empty($person[ "Email" ]))     { continue; }

            $name=
                preg_replace('/^\s+/',"",$person[ "Name" ]).
                " (".$person[ "Email" ]." - ".
                $person[ "ID" ].")".
                "";

            array_push($selectids,$person[ "ID" ]);
            array_push($selectnames,$name);
        }

        return
            $this->Htmls_Select
            (
                $profile,
                $selectids,
                $selectnames
            );
    }

    //*
    //* function MyApp_Handle_SU_Profiles_Allowed, Parameter list:
    //*
    //* Find profiles, that we are allowed to shift to.
    //*

    function MyApp_Handle_SU_Profiles_Allowed()
    {
        $trust=$this->ApplicationObj()->Profiles[ $this->Profile() ][ "Trust" ];

        $profiles=array();
        foreach (array_keys($this->Profiles()) as $profile)
        {
            if ($profile=="Public") { continue; }
            
            if ($trust>$this->ApplicationObj()->Profiles[ $profile ][ "Trust" ])
            {
                array_push($profiles,$profile);
            }
        }
        
        return $profiles;
    }
    //*
    //* function MyApp_Handle_SU_Profiles_Unallowed, Parameter list:
    //*
    //* Find profiles, that we are NOT allowd to shift to.
    //*

    function MyApp_Handle_SU_Profiles_Unallowed()
    {
        $trust=$this->ApplicationObj()->Profiles[ $this->Profile() ][ "Trust" ];

        $profiles=array();
        foreach (array_keys($this->Profiles()) as $profile)
        {
            if ($profile=="Public") { continue; }
            
            if ($trust<=$this->ApplicationObj()->Profiles[ $profile ][ "Trust" ])
            {
                array_push($profiles,$profile);
            }
        }
        
        return $profiles;
    }
}

?>