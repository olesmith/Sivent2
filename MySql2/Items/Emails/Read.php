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

        $where=array();
        if ($this->CGI2IncludeAll()!=2)
        {
            $where=$this->GetSearchVarsWhere();
        }

        foreach ($rwhere as $key => $value) { $where[ $key ]=$value; }

        $this->ItemHashes=$this->SelectHashesFromTable
        (
           "",
           $where,
           array_merge($friendkeys,array_keys($this->GetDefinedSearchVars()))
        );

        if ($this->CGI2IncludeAll()!=2)
        {
            $this->SearchItems();
        }

        //Array keeping track of inlcuded ids. Avoids multiple entries.
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
 
            $emails[ $friendkey ]=$this->SortListByKey($remails,"Name");
         }

        return $emails;
    }
}
?>