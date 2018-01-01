<?php


trait MyMod_Handle_Import_Update
{
    //*
    //* function MyMod_Handle_Import_Items_Show, Parameter list: 
    //*
    //* Shows the detected info.
    //*

    function MyMod_Handle_Import_Items_Update($items)
    {
        foreach (array_keys($items) as $id)
        {
            $key=$items[ $id ][0][ "N" ]."_Register";
            $register=$this->CGI_POSTint($key);
            if ($register==0) { $register=$this->CGI_POSTint("Register_All"); }
            
            if (!$this->MyMod_Handle_Import_Email_Is_Registered($items[ $id ][0]))
            {
                if ($register==1)
                {
                    $friend=array();
                    $friend[ "Name" ] =$items[ $id ][0][ "Name" ];
                    $friend[ "Email" ]=$items[ $id ][0][ "Email" ];

                    $this->FriendsObj()->Friend_Add_Do($friend);
                    $items[ $id ][0][ "Friend_Hash" ]=$friend;
                }
            }
            
            
            $key=$items[ $id ][0][ "N" ]."_Inscribe";
            $inscribe=$this->CGI_POSTint($key);
            if ($inscribe==0) { $inscribe=$this->CGI_POSTint("Inscribe_All"); }
            
            if
                (
                    $this->MyMod_Handle_Import_Email_Is_Registered($items[ $id ][0])
                    &&
                    $inscribe==1
                    &&
                    !$this->MyMod_Handle_Import_Friend_Is_Inscribed($item)
                )
            {

                $items[ $id ][0][ "Inscription_Hash" ]=$this->InscriptionsObj()->Friend_Inscribe_Do($items[ $id ][0][ "Friend_Hash" ]);
            }
            
            $key=$items[ $id ][0][ "N" ]."_Certificate";
            $certificate=$this->CGI_POSTint($key);
            if ($certificate==0) { $certificate=$this->CGI_POSTint("Certificate_All"); }
            
            if
                (
                    $this->MyMod_Handle_Import_Friend_Is_Inscribed($items[ $id ][0])
                    &&
                    $certificate==1
                )
            {

                $items[ $id ][0][ "Inscription_Hash" ][ "Certificate" ]=2;
                $items[ $id ][0][ "Inscription_Hash" ][ "Certificate_CH" ]=$this->Event("TimeLoad");

                $this->InscriptionsObj()->Sql_Update_Item_Values_Set(array("Certificate","Certificate_CH"),$items[ $id ][0][ "Inscription_Hash" ]);
            }
        }
        

        return $items;
    }
    
}
?>