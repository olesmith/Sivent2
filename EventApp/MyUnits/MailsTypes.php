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

        $maildef=array
        (
           "Sql"           => "INT",
           "SqlClass"      => "MailTypes",
           "Name"          => "Email",
           "HRef"          => "?ModuleName=MailTypes&Action=Edit&ID=#",
      
           "Public"   => 0,
           "Person"   => 1,
           "Friend"    => 1,
           "Admin"    => 1,
           "Coordinator" => 1,
           "Default" => "0 ",
        );

        foreach ($this->MyLanguage_Keys() as $lang)
        {
            $data=$mailtype."_".$lang;
            $this->ItemData[ $data ]=$maildef;
            $this->ItemData[ $data ][ "Name" ]=$lang;
            $this->ItemData[ $data ][ "HRef" ]="?ModuleName=MailTypes&Action=Edit&ID=#".$data;
        }
        
        return;
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
            $hash[ $lang ]=array();
            /* ( */
            /*    "Subject".$langkey => 1, */
            /*    "Body".$langkey => 1, */
            /* ); */
        }
        
        /* $mailgroups=$this->MyLanguage_ItemData_Groups_Get($hash,$gfile); */
        $mailsgroups=$this->ReadPHPArray($sgfile);
        

        foreach ($this->Mails as $mailtype => $maildef)
        {
            foreach ($mailsgroups as $sgroup => $def)
            {
                foreach ($this->MyLanguage_Keys() as $lang)
                {
                    $langkey=$this->MyLanguage_GetLanguageKey($lang);
                    array_push($def[ "Data" ],$mailtype."_".$lang);

                    foreach (array("Name","Title") as $data)
                    {
                        if (!empty($maildef[ $data.$langkey ]))
                        {
                            $def[ $data.$langkey ]=$maildef[ $data.$langkey ];
                        }
                        else
                        {
                            $def[ $data.$langkey ]=$maildef[ $data ];
                        }
                    }
                }
                
                $this->ItemDataSGroups[ $mailtype."_".$sgroup ]=$def;
            }
        }
    }


    //*
    //* function PostProcessMailTypes, Parameter list: &$item
    //*
    //* Post processes mail types data.
    //* Creates MailTypes entries for ach languege.
    //*

    function PostProcessMailTypes(&$item)
    {
        $datas=array();
        foreach ($this->MailTypes as $mailtype)
        {
            $datas=array_merge($datas,$this->PostProcessMailType($item,$mailtype));
        }

        return $datas;
    }
    
    //*
    //* function PostProcessMailType, Parameter list: &$item,$mailtype
    //*
    //* Post processes mail type data.
    //* Creates MailTypes entries for ach languege.
    //*

    function PostProcessMailType(&$item,$mailtype)
    {
        $datas=array();
        foreach ($this->MyLanguage_Keys() as $lang)
        {
            $langkey=$this->MyLanguage_GetLanguageKey($lang);
            foreach (array("Subject","Body") as $comp)
            {
               array_push($datas,$mailtype."_".$comp.$langkey);
            }
        }
        
        $oldval=
            $this->Sql_Select_Hash
            (
               array("ID" => $item[ "ID" ]),
               $datas
            );

        $datas=array();
        foreach ($this->MyLanguage_Keys() as $lang)
        {
            $langkey=$this->MyLanguage_GetLanguageKey($lang);
                
            $where=
                $this->UnitWhere
                (
                   array
                   (
                      "Event" => 0,
                      "Name" => $mailtype,
                      "Language" => $lang,
                    )
                );

            $mail=$this->MailTypesObj()->Sql_Select_Hash($where);

            if (empty($mail))
            {
                $mail=$where;
                foreach (array("Subject","Body") as $comp)
                {
                    if (!empty($oldval[ $mailtype."_".$comp."_".$lang ]))
                    {
                        $mail[ $comp ]=$oldval[ $mailtype."_".$comp."_".$lang ];
                    }
                    elseif (!empty($this->Mails[ $mailtype ][ $comp ][ "Default".$langkey ] ))
                    {
                        $mail[ $comp ]=$this->Mails[ $mailtype ][ $comp ][ "Default".$langkey ];
                    }
                    elseif (!empty($oldval[ $mailtype."_".$comp ]))
                    {
                        $mail[ $comp ]=$oldval[ $mailtype."_".$comp ];
                    }
                    elseif (!empty($this->Mails[ $mailtype ][ $comp ][ "Default" ] ))
                    {
                        $mail[ $comp ]=$this->Mails[ $mailtype ][ $comp ][ "Default" ];
                    }

                    $mail[ $comp ]=preg_replace('/\'/',"",$mail[ $comp ]);
                }

                $this->MailTypesObj()->Sql_Insert_Item($mail);
                if (!empty($mail[ "ID" ]))
                {
                    $item[ $mailtype."_".$lang ]=$mail[ "ID" ];
                    array_push($datas,$mailtype."_".$lang);
                }
            }
        }
 
        return $datas;
    }
}

?>