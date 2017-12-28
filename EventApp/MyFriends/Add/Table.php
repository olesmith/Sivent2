<?php

class MyFriends_Add_Table extends MyFriends_Add_New
{
    var $SubObject=NULL;
    var $SubObjectData=NULL;

    //*
    //* function FriendSelectResultTable, Parameter list: $edit,$friends
    //*
    //* Genertates Friend result table for $friends.
    //*

    function FriendSelectResultTable($edit,$friends)
    {
        $table=
               $this->ItemsTable
               (
                  "",
                  0,
                  $this->FriendSelectDatas,
                  $friends
               );

        if (!empty($this->SubObject))
        {
            foreach (array_keys($table) as $id)
            {
                $inscription=
                    $this->InscriptionsObj()->Sql_Select_Hash
                    (
                       array("Friend" => $friends[ $id ][ "ID" ],)
                    );

                foreach ($this->SubObjectData as $data)
                {
                    $cell="---";
                    if (!empty($this->SubObject->ItemData[ $data ]))
                    {
                        if (empty($inscription)) { $cell=""; }
                        else
                        {
                            $cell=$this->SubObject->MyMod_Data_Field(1,$inscription,$data,TRUE);
                        }
                    }
                    else
                    {
                        $cell=$this->SubObject->$data($friends[ $id ]);
                    }
                 
                    array_push($table[ $id ],$cell);
                }
            }
        }

        return $table;
    }


    //*
    //* function FriendSelectResultTitles, Parameter list:
    //*
    //* Generates Friend result title row.
    //*

    function FriendSelectResultTitles()
    {
        $titles=$this->MyMod_Data_Titles($this->FriendSelectDatas);
        if (!empty($this->SubObject))
        {
            foreach ($this->SubObjectData as $data)
            {
                $cell="";
                if (!empty($this->SubObject->ItemData[ $data ]))
                {
                    $cell=$this->SubObject->MyMod_Data_Title($data);
                }
                else
                {
                    $cell=$this->SubObject->$data();
                }
                 
                array_push($titles,$cell);
            }
        }

        return $titles;
    }
    //*
    //* function FriendSelectResultHtmlTable, Parameter list: $edit,$friends
    //*
    //* Genertates Friend result html table for $friends.
    //*

    function FriendSelectResultHtmlTable($edit,$friends)
    {
        return
            $this->Html_Table
            (
               $this->FriendSelectResultTitles(),
               $this->FriendSelectResultTable($edit,$friends),
               array(),
               array(),
               array(),
               TRUE,TRUE
            ).
            "";
    }

    //*
    //* function FriendSelectResultForm, Parameter list: $edit,$title,&$friends,$resulthiddens=array()
    //*
    //* Genertates Friend result form for $friends.
    //*

    function FriendSelectResultForm($edit,$title,&$friends,$resulthiddens=array())
    {
        $pre="";
        $post="";
        if ($edit==1 && count($friends)>0)
        {
            $pre=
                $this->StartForm("",$method="post",$enctype=0,$options=array(),array("Friend")).
                "";
            $post=
                $this->MakeHidden("Name",$this->CGI_POSTOrGET("Name")).
                $this->MakeHidden("Email",$this->CGI_POSTOrGET("Email"));

            foreach ($resulthiddens as $hidden)
            {
                $post.=
                    $this->MakeHidden($hidden,$this->GetGETOrPOST($hidden));
            }
            
            $post.=
                $this->MakeHidden("Save",1).
                $this->Buttons().
                $this->EndForm().
                "";
        }

        return
            $this->H(2,$title).
            $pre.
            $this->FriendSelectResultHtmlTable($edit,$friends).
            $post.
            "";
     }

    //*
    //* function FriendSelectResultUpdate, Parameter list: &$friends
    //*
    //* Updates Friend result form for $friends.
    //*

    function FriendSelectResultUpdate(&$friends)
    {
        if ($this->GetPOST("Save")!=1) { return; }

        foreach (array_keys($friends) as $id)
        {
            $inscription=
                $this->InscriptionsObj()->Sql_Select_Hash
                (
                   array("Friend" => $friends[ $id ][ "ID" ],)
                );

            //Not inscribed?
            if (empty($inscription)) { continue; }
            
            $updatedatas=array();
            foreach ($this->SubObjectData as $data)
            {
                if (!empty($this->SubObject->ItemData[ $data ]))
                {
                    $cgikey=$inscription[ "ID" ]."_".$data;
                    $cgivalue=$this->CGI_POST($cgikey);
                    if ($inscription[ $data ]!=$cgivalue)
                    {
                        $inscription[ $data ]=$cgivalue;
                        array_push($updatedatas,$data);
                    }
               }
            }
            
            $this->SubObject->PostProcess($inscription);

            if (count($updatedatas)>0)
            {
                $this->SubObject->MySqlSetItemValues("",$updatedatas,$inscription);
            }
        }
     }
}

?>