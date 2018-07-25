<?php


trait MyMod_Data_Fields_File_Decorator_Unlink
{

    
    //* FileUnlinkLink
    //* 
    //* Creates icon for file unlinking.
    //*

    function MyMod_Data_Fields_File_Decorator_Unlink_Icon($item,$data)
    {
        return $this->MyActions_Entry_Icon("Unlink");
    }
     
    //* FileDownloadTitle
    //* 
    //* Creates title entry for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Unlink_Title($item,$data)
    {
        return
            $this->MyMod_Data_Fields_File_Decorator_Title($item,$data,"Field_File_Delete_Title");
    }
     
    //* FileDownloadRemove Link
    //* 
    //* Creates links for file download removal.
    //*

    function MyMod_Data_Fields_File_Decorator_Unlink_Href($item,$data)
    {
        $args=$this->CGI_URI2Hash();
        $args=$this->CGI_Hidden2Hash($args);
        $this->AddCommonArgs2Hash($args);

        $args[ "ModuleName" ]=$this->ModuleName;
        $args[ "Action" ]="Unlink";
        $args[ "ID" ]=$item[ "ID" ];
        $args[ "Data" ]=$data;

        return
            $this->MyActions_Entry_Alert
            (
                "?".$this->CGI_Hash2Query($args),
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
        if (!file_exists($item[ $data ])) { return ""; }

        
        return
            $this->A
            (
                $this->MyMod_Data_Fields_File_Decorator_Unlink_Href($item,$data),
                $this->MyMod_Data_Fields_File_Decorator_Unlink_Icon($item,$data),
                array
                (
                    "CLASS" => "uploadmsg",
                    "TITLE" => $this->MyMod_Data_Fields_File_Decorator_Unlink_Title($item,$data),
                )
            ).
            "";
    }
}

?>