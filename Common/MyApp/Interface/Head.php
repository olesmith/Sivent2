<?php

include_once("Head/Styles.php");
include_once("Head/Scripts.php");
include_once("Head/Metas.php");
include_once("Head/Links.php");

trait MyApp_Interface_Head
{
    use
        MyApp_Interface_Head_Styles,
        MyApp_Interface_Head_Scripts,
        MyApp_Interface_Head_Metas,
        MyApp_Interface_Head_Links;

    //*
    //* sub MyApp_Interface_Head, Parameter list:
    //*
    //* Prints leading interface html:
    //*
    //* Sends http header then prints application head part.
    //*
    //*

    function MyApp_Interface_Head()
    {
        echo
            $this->Htmls_Text
            (
                array_merge
                (
                    $this->MyApp_Interface_Header(),
                    $this->MyApp_Interface_Body_Start()
                )
            );

            
        $this->Htmls_Indent_Inc($this->Body_Increment);
        
    }

    //*
    //* sub MyApp_Interface_HEAD_Tag, Parameter list:
    //*
    //* HEAD tag with contents.
    //*
    //*

    function MyApp_Interface_HEAD_Tag()
    {
        return
            array_merge
            (
                $this->Htmls_Comment_Section
                (
                    "HTML HEAD section",
                    $this->Htmls_Tag
                    (
                        "HEAD",
                        array
                        (
                            $this->MyApp_Interface_METAs(),
                            $this->MyApp_Interface_Title(),
                            $this->MyApp_Interface_LINKs(),
                            $this->MyApp_Interface_STYLEs(),
                            $this->MyApp_Interface_SCRIPTs()
                        )
                    )
                )
            );
    }

    
    //*
    //* sub MyApp_Interface_HTML_Tag, Parameter list:
    //*
    //* HTML tag with contents.
    //*
    //*

    function MyApp_Interface_HTML_Tag()
    {
        return
            $this->Htmls_Tag_Start
            (
                "HTML",
                array
                (
                    $this->MyApp_Interface_HEAD_Tag(),
                )
            );
     }
    
    //*
    //* sub MyApp_Interface_Header, Parameter list:
    //*
    //* Sends the HTML header part.
    //*
    //*

    function MyApp_Interface_Header()
    {
        //Printed promptly!
        $this->MyApp_Interface_Headers_Send();

        return
            array_merge
            (
                $this->MyApp_Interface_DocType(),
                $this->MyApp_Interface_HTML_Tag()
            );
    }
    
    
    //*
    //* sub MyApp_Interface_DocType, Parameter list:
    //*
    //* Sends 'before HTML tag' doc type.
    //*
    //*

    function MyApp_Interface_DocType()
    {
        return
            array
            (
                $this->MyApp_Interface_Head_DocType
            );
    }
    
    
    //*
    //* sub MyApp_Interface_, Parameter list:
    //*
    //* Returns interface header <TITLE>...</TITLE> section.
    //*
    //*

    function MyApp_Interface_Title()
    {
        return
            array
            (
                $this->HtmlTags("TITLE",$this->MyApp_Interface_HEAD_TITLE())
            );
    }
    
   

    //*
    //* sub MyApp_Interface_HEAD_Title, Parameter list:
    //*
    //* Returns title to include as HTML TITLE.
    //*
    //*

    function MyApp_Interface_HEAD_Title()
    {
        $id=$this->GetGET("ID");

        $vals=array();
        if ($this->Module)
        {
            if ($id!="" && $id>0)
            {
                array_push($vals,$this->Module->ItemName);
            }
            else
            {
                array_push($vals,$this->Module->ItemsName);
            }
        }

        foreach ($this->ExtraPathVars as $id => $var)
        {
            if ($this->$var!="")
            {
                array_push($vals,$this->$var);
            }
        }

        $title=$this->HtmlSetupHash[ "WindowTitle" ]."::";
        $action=$this->MyActions_Detect();
        if ($this->Module)
        {
            if (!empty($action) && isset($this->Module->Actions[ $action ]))
            {
                $action=$this->GetRealNameKey($this->Module->Actions[ $action ],"Name");

                $action=preg_replace('/#ItemsName/',$this->Module->ItemsName,$action);
                $action=preg_replace('/#ItemName/',$this->Module->ItemsName,$action);
                $id=$this->GetGET("ID");
                if ($id!="" && $id>0)
                {
                    $name=$this->Module->MyMod_Item_Name_Get($this->Module->ItemHash);
                    array_push($vals,$name);
                }
            }
        }
        else
        {
            array_push($vals,$action);
        }

        return 
            $title.
            join("::",$vals).
            "";
    }
}

?>