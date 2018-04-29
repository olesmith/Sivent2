<?php


trait MyMod_Handle_Import_Cells
{
    //*
    //* function MyMod_Handle_Import_Item_Email_Status_Cell, Parameter list: $item
    //*
    //* Generates item email status cell.
    //*

    function MyMod_Handle_Import_Item_Email_Status_Cell($item)
    {
        return $this->Import_Mail_Status[ $item[ "Mail_Status" ] ];
    }
    
    //*
    //* function MyMod_Handle_Import_Item_Register_Cell, Parameter list: &$item
    //*
    //* Generates item email register cell.
    //*

    function MyMod_Handle_Import_Item_Register_Cell(&$item)
    {
        $item[ "Registered" ]=FALSE;
        $res=$this->MyMod_Handle_Import_Email_Is_Registered($item);
        if (!$res)
        {
            $cginame=$item[ "No" ]."_Register";
            
            return
                $this->Html_Input_CheckBox_Field
                (
                    $cginame,
                    1,
                    FALSE,
                    $disabled=FALSE,
                    $options=array
                    (
                        "TABINDEX" => 1,
                    )
                );
        }

        $item[ "Registered" ]=TRUE;
        return
            $this->FriendsObj()->MyActions_Entry("Edit",$item[ "Friend_Hash" ]).
            "";
        #return $this->IMG($this->Icons."/ok.png","Registered",20,0,array("TITLE" => "Registered"));
    }
    
    //*
    //* function MyMod_Handle_Import_Item_Inscribe_Cell, Parameter list: &$item
    //*
    //* Generates item email inscribe cell.
    //*

    function MyMod_Handle_Import_Item_Inscribe_Cell(&$item)
    {
        $item[ "Inscribed" ]=FALSE;
        $res=$this->MyMod_Handle_Import_Friend_Is_Inscribed($item);
        if (!$res)
        {
            $cginame=$item[ "No" ]."_Inscribe";
            return $this->Html_Input_CheckBox_Field($cginame,1,FALSE,$disabled=FALSE,$options=array("TABINDEX" => 2));
        }
        $item[ "Inscribed" ]=TRUE;
        
        return
            $this->InscriptionsObj()->MyActions_Entry("Edit",$item[ "Inscription_Hash" ]).
            "";
    }
    
    //*
    //* function MyMod_Handle_Import_Item_Certificate_Cell, Parameter list: &$item
    //*
    //* Generates item email certificate cell.
    //*

    function MyMod_Handle_Import_Item_Certificate_Cell(&$item)
    {
        $item[ "Certificate" ]=FALSE;
        if (empty($item[ "Inscription_Hash" ]) || intval($item[ "Inscription_Hash" ][ "Certificate" ])!=2)
        {
            $cginame=$item[ "No" ]."_Certificate";
            return $this->Html_Input_CheckBox_Field($cginame,1,FALSE,$disabled=FALSE,$options=array("TABINDEX" => 3));
        }
        
        $item[ "Certificate" ]=TRUE;
        return
            $this->InscriptionsObj()->MyActions_Entry("GenCert",$item[ "Inscription_Hash" ]).
            "";
    }
}
?>