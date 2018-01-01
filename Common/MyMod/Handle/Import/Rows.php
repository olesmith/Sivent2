<?php


trait MyMod_Handle_Import_Rows
{
    //*
    //* function MyMod_Handle_Import_Items_Table_Titles, Parameter list: 
    //*
    //* Generates import items table title row.
    //*

    function MyMod_Handle_Import_Items_Table_Titles()
    {
        return
            array
            (
                "No",
                "Name",
                "Email",
                "Status",
                "Register",
                "Inscribe",
                "Certificate",
                "Time Load",
            );
    }
    
    //*
    //* function MyMod_Handle_Import_Items_Table_AllRow, Parameter list: 
    //*
    //* Generates import items table leading row with check boxes for all.
    //*

    function MyMod_Handle_Import_Items_Table_AllRow()
    {
        return
            array
            (
                "",
                "",
                "",
                $this->B("Select All:"),
                $this->Html_Input_CheckBox_Field("Register_All",1,FALSE),
                $this->Html_Input_CheckBox_Field("Inscribe_All",1,FALSE),
                $this->Html_Input_CheckBox_Field("Certificate_All",1,FALSE),
                ""
            );
    }
    //*
    //* function MyMod_Handle_Import_Items_Table_SumsRow, Parameter list: 
    //*
    //* Generates import items table leading row with check boxes for all.
    //*

    function MyMod_Handle_Import_Items_Table_SumsRow($nitems,$nregistered,$ninscribed,$ncerts)
    {
        return
            array
            (
                $nitems,
                "",
                "",
                "",
                ($nitems-$nregistered),
                ($nitems-$ninscribed),
                ($nitems-$ncerts),
                ""
            );
    }
    
    //*
    //* function MyMod_Handle_Import_Item_Row, Parameter list: 
    //*
    //* Generates item row.
    //*

    function MyMod_Handle_Import_Item_Row(&$item)
    {
        $row=array($this->B($item[ "No" ]));

        foreach ($this->Import_Datas as $data)
        {
            array_push
            (
                $row,
                $item[ $data ].
                $this->MakeHidden($item[ "No" ]."_".$data,$item[ $data ])
            );
        }

        $tl="-";
        if
            (
                !empty($item[ "Inscription_Hash" ])
                &&
                !empty($item[ "Inscription_Hash" ][ "Certificate_CH" ])
            )
        {
            $tl=$item[ "Inscription_Hash" ][ "Certificate_CH" ];
        }
        
        $msg=$this->Import_Mail_Status[ $item[ "Mail_Status" ] ];

        if (!empty($item[ "Name" ]) && !empty($item[ "Email" ]))
        {
            array_push
            (
                $row,
                $this->MyMod_Handle_Import_Item_Email_Status_Cell($item),
                $this->MyMod_Handle_Import_Item_Register_Cell($item),
                $this->MyMod_Handle_Import_Item_Inscribe_Cell($item),
                $this->MyMod_Handle_Import_Item_Certificate_Cell($item),
                $tl
            );
        }
        else
        {

            array_push
            (
                $row,
                "Name or Email Undef"
            );
        }
        

        return $row;
    }
}
?>