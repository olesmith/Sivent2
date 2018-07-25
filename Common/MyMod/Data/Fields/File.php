<?php

include_once("File/Update.php");
include_once("File/Decorator.php");
include_once("File/Extensions.php");

//Should be obsolete
include_once("File/Correct.php");

trait MyMod_Data_Fields_File
{
    use
        MyMod_Data_Fields_File_Update,
        MyMod_Data_Fields_File_Decorator,
        MyMod_Data_Fields_File_Extensions,
        MyMod_Data_Fields_File_Correct;
    
    //*
    //* 
    //*

    function MyMod_Data_Value_Image_Is($item,$data)
    {
        return $this->MyMod_Data_Image_Value_Is($item[ $data ]);
    }
    
    //*
    //* function MyMod_Data_Field_File_Edit, Parameter list: $data,$item,$value,$tabindex,$plural,$links,$callmethod,$rdata 
    //*
    //* Creates file edit field.
    //*

    function MyMod_Data_Field_File_Edit($data,$item,$value,$tabindex,$plural,$links,$callmethod,$rdata)
    {
        $options=
            array
            (
                "SIZE" => $this->ItemData[ $data ][ "Size" ],
                "TITLE" => $this->MyMod_Data_Fields_File_Extensions_Permitted_Text($data)
            );

        if (!empty($tabindex))
        {
            $options[ "TABINDEX" ]=$tabindex;
        }

        return
            array
            (
                $this->Html_File
                (
                    $rdata,
                    $options                
                ),
                $this->MyMod_Data_Fields_File_Decorator
                (
                    $data,
                    $item,
                    $plural,
                    1
                )
            );
        
    }
    
    //*
    //* function MyMod_Data_Fields_File_Contents_Save, Parameter list: &$item,$file,$filefield
    //*
    //* Saves properly formatted version of file contents.
    //*

    function MyMod_Data_Fields_File_Contents_Save(&$item,$file,$filefield)
    {
        $this->Sql_Update_Item_Value_Set
        (
            $item[ "ID" ],
            $filefield."_Contents",
            $this->MyMod_Data_Fields_File_Contents_2DB($file),
            "ID"
        );

        $rfilefield=$filefield."_Time";
        $item[ $rfilefield ]=time();
        $this->Sql_Update_Item_Value_Set
        (
            $item[ "ID" ],
            $rfilefield,
            $item[ $rfilefield ],
            "ID"
        );

        $rfilefield=$filefield."_Size";
        $item[ $rfilefield ]=filesize($file);
        $this->MySqlSetItemValue
        (
            $item[ "ID" ],
            $rfilefield,
            $item[ $rfilefield ],
            "ID"
        );
    }

    //*
    //* function MyMod_Data_Fields_File_Contents_2DB, Parameter list: &$item,$file,$filefield
    //*
    //* Returns properly formatted version of file contents.
    //*

    //*
    //* function FileContents2DB, Parameter list: $file
    //*
    //* Returns properly formatted file contents ready to store in DB.
    //*

    function MyMod_Data_Fields_File_Contents_2DB($file)
    {
        $fp      = fopen($file, 'r');
        $content = fread($fp, filesize($file));
        fclose($fp);

        if (empty($content)) { return $content; }
      
        return 
            strtr
            (
                base64_encode
                (
                    addslashes
                    (
                        gzcompress( serialize($content) , 9)
                    )
                ),
                '+/=',
                '-_,'
            );
    }
    
    //*
    //* function DB2FileContents, Parameter list: $content
    //*
    //* Reverses db file content encodings.
    //*

    function MyMod_Data_Fields_File_DB_2Contents($content)
    {
        if (empty($content)) { return $content; }
      
        return unserialize
            (
                gzuncompress
                (
                    stripslashes
                    (
                        base64_decode
                        (
                            strtr($content,'-_,', '+/=')
                        )
                    )
                )
            );
    }

    //* FileDownloadLink
    //* 
    //* Detects data as image height key. Checks if ItemData "Height" is set.
    //* If value is number, maintain, elsewise interpret as value of $key in $item.
    //* Default 20.
    //*

    function MyMod_Data_Fields_File_IMG_Height($item,$data,$key="Height",$value=20)
    {
        $key=$this->ItemData($data,$key);

        if (preg_match('/^[0-9\.]+/',$key))
        {
            $value=$key;
        }
        elseif (!empty($item[ $key ]))
        {
            $value=$item[ $key ];
        }
        
        return $value;
    }
    
    //* FileDownloadLink
    //* 
    //* Creates links for file download.
    //*

    function MyMod_Data_Fields_File_IMG($item,$data)
    {
        $value="";
        if (isset($item[ $data ])) { $value=$item[ $data ]; }
        
        $args=$this->CGI_Query2Hash();
        $args[ "Action" ]="Download";
        $args[ "Data" ]=$data;
        
        return
            $this->IMG
            (
                "?".$this->CGI_Hash2Query($args),
                basename($value),
                $this->MyMod_Data_Fields_File_IMG_Height($item,$data,"Height"),
                $this->MyMod_Data_Fields_File_IMG_Height($item,$data,"Width")
            );
  }
}
?>