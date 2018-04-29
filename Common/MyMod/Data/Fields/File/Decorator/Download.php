<?php


trait MyMod_Data_Fields_File_Decorator_Download
{
    //* FileDownloadLink
    //* 
    //* Creates links for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Download_Link($edit,$item,$data,$value)
    {
        return
            $this->A
            (
                $this->MyMod_Data_Fields_File_Decorator_Download_Href($item,$data),
                $this->MyMod_Data_Fields_File_Decorator_Download_Icon($item,$data),
                array
                (
                    "CLASS" => "uploadmsg",
                    "TITLE" => $this->MyMod_Data_Fields_File_Decorator_Download_Title($edit,$item,$data,$value),
                )
            ).
            "";
    }

    //* FileDownloadLink
    //* 
    //* Creates icon for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Download_Icon($item,$data)
    {
        $value="";
        if (isset($item[ $data ])) { $value=$item[ $data ]; }

        $icon="";
        if (!empty($this->ItemData[ $data ][ "Icon" ]))
        {
            $icon=$this->IMG
            (
                "icons/".$this->ItemData[ $data ][ "Icon" ],
                "teste",
                20,20
            );
        }      
        elseif (!empty($this->ItemData[ $data ][ "Iconify" ]))
        {
            $icon=$this->MyMod_Item_Action_Icon($data,$item);
        }      
        elseif (!empty($value))
        {
            $icon=$value;
            if (file_exists($icon))
            {
                $icon=
                    $this->IMG
                    (
                        $this->MyMod_Data_Fields_File_Decorator_Download_Href($item,$data),
                        $item[ $data ],
                        20,20
                    );
            }
            else
            {
                $icon=$item [ $data."_OrigName" ];
            }
        }
        else
        {
            $icon=$rvalue;
        }
        
        return $icon; 
    }
    
     //* FileDownloadMTime
    //* 
    //* Creates title entry for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Download_TimeStamp($item,$data)
    {
        $value="";
        if (isset($item[ $data ])) { $value=$item[ $data ]; }
        
        $filetime="";
        if (!empty($item[ $data."_Time" ]))
        {
            $filetime=$item[ $data."_Time" ];
        }
        elseif (file_exists($value))
        {
            $filetime=filemtime($value);
        }

        return $this->TimeStamp2Text($filetime,FALSE);
    }
    
    //* FileDownloadTitle
    //* 
    //* Creates title entry for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Download_Title($edit,$item,$data)
    {
        $title=
            $item[ $data."_OrigName" ].". ".
            $this->MyLanguage_GetMessage("Uploaded")." : ".
            $this->MyMod_Data_Fields_File_Decorator_Download_TimeStamp($item,$data).
            " (".
            $this->MyMod_Data_Fields_File_Decorator_SizeInfo($item,$data).
            ")";

        if ($edit==1)
        {
            $title.=
                " ".
                $this->MyMod_Data_Fields_File_Extensions_Permitted_Text($data).
                "";
        }

        return preg_replace('/<BR>/',"\n",$title);
    }
    
    //* FileDownloadHref
    //* 
    //* Creates links for file download.
    //*

    function MyMod_Data_Fields_File_Decorator_Download_Href($item,$data)
    {
        $args=$this->CGI_URI2Hash();
        $args=$this->Hidden2Hash($args);
        $this->AddCommonArgs2Hash($args);

        $args[ "ModuleName" ]=$this->ModuleName;
        $args[ "Action" ]="Download";
        $args[ "ID" ]=$item[ "ID" ];
        $args[ "Data" ]=$data;

        return "?".$this->Hash2Query($args);        
    }
}

?>