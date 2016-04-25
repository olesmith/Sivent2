<?php

class MyFriendsAddTable extends MyFriendsAddNew
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
                  $edit,
                  $this->FriendSelectDatas,
                  $friends
               );

        if (!empty($this->SubObject))
        {
            foreach (array_keys($table) as $id)
            {
                foreach ($this->SubObjectData as $data)
                {
                    array_push($table[ $id ],$this->SubObject->$data($friends[ $id ]));
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
        $titles=$this->GetDataTitles($this->FriendSelectDatas);
        if (!empty($this->SubObject))
        {
            foreach ($this->SubObjectData as $data)
            {
                array_push($titles,$this->SubObject->$data());
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
                $this->MakeHidden("Name",$this->GetPOST("Name")).
                $this->MakeHidden("Email",$this->GetPOST("Email"));

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
            $updatedatas=array();
            $advisor=$this->GetPOST($friends[ $id ][ "ID" ]."_Profile_Advisor");

            if (empty($friends[ $id ][ "Profile_Advisor" ]))
            {
                continue;
            }

            if ($advisor==2 && $friends[ $id ][ "Profile_Advisor" ]!=$advisor)
            {
                $friends[ $id ][ "Profile_Advisor" ]=$advisor;
                array_push($updatedatas,"Profile_Advisor");

                if (empty($friends[ $id ][ "Unit" ]))
                {
                    $unit=$this->ApplicationObj->LoginData[ "Unit" ];
                    $friends[ $id ][ "Unit" ]=$unit;
                    array_push($updatedatas,"Unit");
                }
            }
            elseif ($advisor!=2 && $friends[ $id ][ "Profile_Advisor" ]!=$advisor)
            {
                $friends[ $id ][ "Profile_Advisor" ]=$advisor;
                array_push($updatedatas,"Profile_Advisor");
            }

            if ($this->Profile=="Admin")
            {
                $unit=$this->GetPOST($friends[ $id ][ "ID" ]."_Unit");
                if ($friends[ $id ][ "Profile_Advisor" ]!=$unit)
                {
                    $friends[ $id ][ "Unit" ]=$unit;
                    array_push($updatedatas,"Unit");
                }
                
            }
            
            if (count($updatedatas)>0)
            {
                $this->MySqlSetItemValues("",$updatedatas,$friends[ $id ]);
            }
        }
     }
}

?>