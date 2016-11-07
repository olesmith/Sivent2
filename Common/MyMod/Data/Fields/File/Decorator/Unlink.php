<?php


trait MyMod_Data_Fields_File_Decorator_Unlink
{

    
    //* FileUnlinkLink
    //* 
    //* Creates icon for file unlinking.
    //*

    function MyMod_Data_Fields_File_Decorator_Unlink_Icon($item,$data)
    {
        $icon="";
        if (!empty($this->Actions[ "Unlink" ][ "Icon" ]))
        {
            $icon="icons/".$this->Actions[ "Unlink" ][ "Icon" ];
        }

        return $this->MyMod_Item_Action_Icon("Unlink",$item);; 
    }
     
    //* FileDownloadTitle
    //* 
    //* Creates title entry for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Unlink_Title($edit,$item,$data)
    {
        $title=
            $item[ $data."_OrigName" ].
            " Remover: ".
            "";

        return preg_replace('/<BR>/',"\n",$title);
    }
     
    //* FileDownloadRemove Link
    //* 
    //* Creates links for file download removal.
    //*

    function MyMod_Data_Fields_File_Decorator_Unlink_Href($item,$data)
    {
        $args=$this->CGI_URI2Hash();
        $args=$this->Hidden2Hash($args);
        $this->AddCommonArgs2Hash($args);

        $args[ "ModuleName" ]=$this->ModuleName;
        $args[ "Action" ]="Unlink";
        $args[ "ID" ]=$item[ "ID" ];
        $args[ "Data" ]=$data;

        return
            $this->MyActions_Entry_Alert
            (
                "?".$this->Hash2Query($args),
                $this->MyLanguage_GetMessage("Upload_Remove_Confirm")."?"
            );
    }
    
    //* FileDownloadLink
    //* 
    //* Creates links for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Unlink_Link($edit,$item,$data,$value)
    {
        if ($edit==0 || empty($item[ $data ])) { return ""; }

        
        return
            $this->A
            (
                $this->MyMod_Data_Fields_File_Decorator_Unlink_Href($item,$data),
                $this->MyMod_Data_Fields_File_Decorator_Unlink_Icon($item,$data),
                array
                (
                    "CLASS" => "uploadmsg",
                    "TITLE" => $this->MyMod_Data_Fields_File_Decorator_Unlink_Title($edit,$item,$data,$value),
                )
            ).
            "";
    }
}

?>