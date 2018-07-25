<?php

class ItemsEmailsRead extends ItemsEmailsAttachments
{
    //*
    //* function ReadEmails, Parameter list: $rwhere,$friendkeys=array("Friend")
    //*
    //* Reads emails.
    //*

    function ReadEmails($rwhere,$friendkeys=array("Friend"))
    {
        if (!is_array($friendkeys)) { $friendkeys=array($friendkeys); }

        $this->NoPaging=TRUE;

        $emails=array();
        foreach ($friendkeys as $friendkey)
        {
            $emails[ $friendkey ]=array();
        }
        
        $where=array_merge($this->MyMod_Search_Where(),$rwhere);

        $this->ItemHashes=$this->SelectHashesFromTable
        (
           "",
           $where,
           array_merge($friendkeys,array_keys($this->MyMod_Search_Vars_Hash()))
        );

        if ($this->MyMod_Search_CGI_Include_All_Value()!=2)
        {
            $this->MyMod_Search_Items();
        }

        //Array keeping track of included ids. Avoids multiple entries.
        $ids=array();
        $emails=array();
        foreach ($friendkeys as $friendkey)
        {
            $remails=array();
            foreach ($this->ItemHashes as $friend)
            {
                //Avoid repeated entries.
                if (!empty($ids[ $friend[ $friendkey ] ])) { continue; }

                $rfriend=$this->ApplicationObj->UsersObj()->SelectUniqueHash
                (
                   "",
                   array("ID" => $friend[ $friendkey ]),
                   TRUE,
                   array("ID","Email","Name")
                );

                if (!empty($rfriend[ "Email" ]) && preg_match('/^\S+\@\S+$/',$rfriend[ "Email" ]))
                {
                   $remails[ $rfriend[ "Email" ] ]=$rfriend;
                }

                //Register entry
                $ids[ $friend[ $friendkey ] ]=1;
            }
 
            $emails[ $friendkey ]=$this->Sort_List_ByKey($remails,"Name");
         }

        return $emails;
    }
}
?>