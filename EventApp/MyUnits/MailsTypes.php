<?php


class MyUnitsMailsTypes extends MyUnitsMails
{
    //*
    //* function AddMailTypes2ItemData, Parameter list: $file
    //*
    //* Reads and adds emails type data: Confirm, Confirmed,....
    //*

    function AddMailTypes2ItemData($file)
    {
        $maildatas=$this->MyLanguage_ItemData_Get($file);
        
        $this->DataFilesMTime=$this->Max(filemtime($file),$this->DataFilesMTime);
        array_push($this->ItemDataPaths,$this->MailsPath);

        $this->Mails=array();
        foreach ($this->MailTypes as $mailtype)
        {
            array_push($this->ItemDataFiles,$mailtype.".php");
            $this->AddMailType2ItemData($maildatas,$mailtype);
        }
    }
    
    //*
    //* function AddMailType2ItemData, Parameter list: $maildatas,$mailtype
    //*
    //* Reads and adds emails type data: Confirm, Confirmed,....
    //*

    function AddMailType2ItemData($maildatas,$mailtype)
    {
        $file=
            $this->MailsPath."/".
            $mailtype.".php";

        $this->DataFilesMTime=$this->Max(filemtime($file),$this->DataFilesMTime);
        
        $this->Mails[ $mailtype ]=$this->ReadPHPArray($file);

        $rmaildatas=array();
        foreach ($this->MyLanguage_Keys() as $lang)
        {
            $rmaildatas[ $lang ]=array();
        }

        foreach (array("Subject","Body") as $mailpart)
        {
            foreach ($this->MyLanguage_Keys() as $lang)
            {
                $langkey=$this->MyLanguage_GetLanguageKey($lang);

                $destkey=$mailtype."_".$mailpart.$langkey;
                    
                $rmaildatas[ $lang ][ $destkey ]=
                    $this->Mails[ $mailtype ][ $mailpart ];
                    
                $rmaildatas[ $lang ][ $destkey ][ "Default" ]=
                    $rmaildatas[ $lang ][ $destkey ][ "Default".$langkey ];
                    
                foreach (array("Name","Title","ShortName") as $key)
                {
                    $rmaildatas[ $lang ][ $destkey ][ $key ]=
                        $maildatas[ $lang ][ $mailpart.$langkey ][ $key.$langkey ];
                    //unset other languages?
                }
                    
                foreach ($this->ApplicationObj()->GetProfiles() as $profile => $def)
                {                        
                    $rmaildatas[ $lang ][ $destkey ][ $profile ]=
                        $this->Max
                        (
                         $rmaildatas[ $lang ][ $destkey ][ $profile ],
                         $maildatas[ $lang ][ $mailpart.$langkey ][ $profile ]
                         );
                }
            }
        }
            
        foreach ($rmaildatas as $lang => $defs)
        {
            $this->ItemData=array_merge($this->ItemData,$defs);
        }
    }

    //*
    //* function AddMails2ItemGroups, Parameter list:
    //*
    //* Adds mails defs to groups and sgroups.
    //*

    function AddMailTypes2ItemGroups($gfile,$sgfile)
    {
        $hash=array();
        foreach ($this->MyLanguage_Keys() as $lang)
        {
            $langkey=$this->MyLanguage_GetLanguageKey($lang);
            $hash[ $lang ]=array
            (
               "Subject".$langkey => 1,
               "Body".$langkey => 1,
            );
        }
        
        $mailgroups=$this->MyLanguage_ItemData_Groups_Get($hash,$gfile);
        $mailsgroups=$this->MyLanguage_ItemData_Groups_Get($hash,$sgfile);

        foreach ($this->Mails as $mailtype => $maildef)
        {
            foreach ($mailgroups as $group => $def)
            {
                $langkey=$def[ "Language_Key" ];
                foreach ($maildef[ "Data" ] as $data)
                {
                    array_push($def[ "Data" ],$mailtype."_".$data.$langkey);
                }
                
                foreach (array("Name","Title") as $key)
                {
                    $def[ $key ]=$maildef[ $key.$langkey ];
                }
                
                $this->ItemDataGroups[ $mailtype."_".$group ]=$def;
            }
            
            foreach ($mailsgroups as $sgroup => $def)
            {
                $langkey=$def[ "Language_Key" ];
                foreach ($maildef[ "Data" ] as $id => $data)
                {
                    array_push($def[ "Data" ],$mailtype."_".$data.$langkey);
                }
               
                foreach (array("Name","Title") as $key)
                {
                    $def[ $key ].=
                        "<BR>".
                        $maildef[ $key.$langkey ];
                }
                $this->ItemDataSGroups[ $mailtype."_".$sgroup ]=$def;
            }
        }
    }


}

?>