<?php

class ItemsEmailsCells extends ItemsEmailsRead
{
    var $MailFilters=array();
    
    //*
    //* function RecipientCell , Parameter list: $edit,$emails
    //*
    //* Creates recipients cell as table.
    //*

    function RecipientCell($edit,$emails)
    {
        $rrow=array();
        foreach (array_keys($emails) as $friendkey)
        {
            $table=$this->Emails2Table($edit,$emails[ $friendkey ],2,FALSE,FALSE);


            $name=$this->ItemsName;
            if ($friendkey!="ID")
            {
                if (!empty($this->ItemData[ $friendkey ][ "PName" ]))
                {
                    $name=$this->ItemData[ $friendkey ][ "PName" ];
                }
                if (!empty($this->ItemData[ $friendkey ][ "Name" ]))
                {
                    $name=$this->ItemData[ $friendkey ][ "Name" ];
                }                
            }

            array_unshift($table,$this->B($name));
            array_push($rrow,$this->Html_Table("",$table,array(),array(),array(),TRUE,TRUE));
        }

        return $this->Html_Table("",array($rrow),array("ALIGN" => 'left'),array(),array(),TRUE,TRUE);
    }

    //*
    //* function CCCell, Parameter list:
    //*
    //* Creates CC cell as table.
    //*

    function CCCell($edit)
    {
        $emails=array
        (
           array
           (
              "ID" => 0,
              "Email" => $this->MailInfo[ "BCCEmail" ],
              "Name" => "Sistema",
           ),
           $this->LoginData
        );

        $table=$this->Emails2Table($edit,$emails,2,TRUE,TRUE);

        return $this->Html_Table("",$table,array("ALIGN" => 'left'),array(),array(),TRUE,TRUE);
    }

    //*
    //* function Emails2TableCell, Parameter list: $edit,$email,$selected=FALSE,$disabled=FALSE
    //*
    //* Creates table with checkboxes and emails.
    //*

    function Emails2TableCell($edit,$email,$selected=FALSE,$disabled=FALSE)
    {
       return
            $this->Emails2TableCheckBox($edit,$email,$selected,$disabled)." ".
            $this->Span($email[ "Email" ].";",array("TITLE" => $email[ "Name" ]." (".$email[ "ID" ].")")).
            "";
    }

    //*
    //* function Emails2TableCheckBox, Parameter list: $edit,$email,$selected=FALSE,$disabled=FALSE
    //*
    //* Creates table with checkboxes and emails.
    //*

    function Emails2TableCheckBox($edit,$email,$selected=FALSE,$disabled=FALSE)
    {
        $check="";
        if ($edit==1)
        {
            $cgi="Inc_".$email[ "ID" ];
            if (!$selected)
            {
                $val=$this->GetPOSTint($cgi);
                if ($val==1) { $selected=TRUE; }
                else         { $selected=FALSE; }
            }

             $check=$this->MakeCheckBox($cgi,1,$selected,$disabled);
        }
        
        return $check;
    }

    //*
    //* function GetMailField Parameter list: 
    //*
    //* Detects mail subject from either CGI (if set) - or $this->MailTexs[ "Form" ].
    //*

    function GetMailField($field)
    {
        $subject="";
        if (!empty($_POST[ $field ])) { $subject=$this->CGI_POST($field); }

        if (empty($subject))
        {
            if (empty($this->MailTexts))
            {
                $this->MailTexts=$this->FriendsObj()->MyMod_Mail_Texts_Get();
            }

            $subject=$this->GetRealNameKey( $this->MailTexts[ "Emails" ],$field );
            $subject=$this->ApplicationObj()->FilterMailField
            (
               $subject,
               $this->MailFilters
            );
        }

        return $subject;
    }

    
    //*
    //* function SubjectCell , Parameter list: $edit
    //*
    //* Creates subject cell as table.
    //*

    function SubjectCell($edit)
    {
        $subject=$this->GetMailField("Subject");
        
        $cell="";
        if ($edit==1)
        {
            $cell=$this->MakeInput("Subject",$subject,80);
        }
        else
        {
            $cell=$subject;
        }

        return  $this->Span($cell,array("WIDTH" => '75%'));
    }

    //*
    //* function BodyCell , Parameter list: $edit
    //*
    //* Creates body (textarea) cell as table.
    //*

    function BodyCell($edit)
    {
        $body=$this->GetMailField("Body");
        $cell="&nbsp;";
        if ($edit==1)
        {
            $cell=$this->MakeTextArea("Body",20,78,$body);
        }
        else
        {
            $cell=$body;
        }

        return $this->Span($cell,array("WIDTH" => '75%'));
    }
}
?>