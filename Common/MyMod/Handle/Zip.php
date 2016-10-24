<?php

trait MyMod_Handle_Zip
{
    var $ZipShowDatas=array("No","Edit","Name");
    var $ZipTmpFiles=array();
    
    //*
    //* function MyMod_Handle_Zip, Parameter list: 
    //*
    //* Handles Module zipping of file.
    //*

    function MyMod_Handle_Zip()
    {
        $this->MyMod_Handle_Zip_ReadItems();
        if (TRUE) //$this->CGI_POSTint("ZIP")==1)
        {
            $this->NoPaging=TRUE;
            $this->MyMod_Handle_Zip_Do();
        }

    }

    //*
    //* function MyMod_Handle_Zip_Do, Parameter list: 
    //*
    //* Will do the actual zipping on searched items.
    //*

    function MyMod_Handle_Zip_Do()
    {
        $zipname="/tmp/".$this->ModuleName.".".$this->MTime2FName().".zip";

        $zip=$this->OpenZip($zipname);

        $nfiles=$this->MyMod_Handle_Zip_Items($zip);
        
        $this->CloseZip($zip,$zipname);
        $this->SendZip($zipname);

        $this->MyMod_Handle_Zip_Tmp_Remove($zipname);
        exit();
    }

    //*
    //* function MyMod_Handle_Zip_ReadItems, Parameter list: 
    //*
    //* Reads data of items to zip.
    //*

    function MyMod_Handle_Zip_ReadItems()
    {
        $id=$this->CGI_GETint("ID");
        if (!empty($id))
        {
            $this->ItemHashes=
                array
                (
                   $this->Sql_Select_Hash(array("ID" => $id))
                );
        }
        else
        {
            $this->NoPaging=TRUE;
            $this->ReadItems("",$this->GetFileFieldDatas(),FALSE,FALSE,0,TRUE);
        }
    }

    
    //*
    //* function , Parameter list: $zipname
    //*
    //* Removes temporary files created (in $this->ZipTmpFiles) - and $zipname.
    //*

    function MyMod_Handle_Zip_Tmp_Remove($zipname)
    {
        unlink($zipname);
        foreach ($this->ZipTmpFiles as $file)
        {
            if (file_exists($file) && preg_match('/^ \/tmp/',$file)) //extra precaution!
            {
                unlink($file);
            }
        }
    }

    //*
    //* function MyMod_Handle_Zip_Items, Parameter list: $zip
    //*
    //* Will do the actual zipping on searched items.
    //*

    function MyMod_Handle_Zip_Items($zip)
    {
        if (preg_match('/^(Admin)$/',$this->Profile()))
        {
            $zip->addEmptyDir($this->GetUploadPath());
        }

        $nfiles=0;
        foreach ($this->ItemHashes as $id => $item)
        {
            $nfiles+=$this->MyMod_Handle_Zip_Item($zip,$item);
        }

        return $nfiles;
    }

    //*
    //* function MyMod_Handle_Zip_Item, Parameter list: $zip,$item
    //*
    //* Will do the actual zipping on $item.
    //*

    function MyMod_Handle_Zip_Item($zip,$item)
    {
        $nfiles=0;
        foreach ($this->GetFileFields() as $filefield)
        {
            $file=$this->MyMod_Handle_Zip_Item_Field($zip,$item,$filefield);

            //$this->ZipItemFileField($zip,$item,$filefield);
            $nfiles++;
        }

        return $nfiles;
    }

    //*
    //* function MyMod_Handle_Zip_Item_Field_FileName, Parameter list: $item,$data
    //*
    //* Returns name of $item $data file in ZIP file.
    //*

    function MyMod_Handle_Zip_Item_Field_FileName($item,$data)
    {
        $file=$item[ $data ];
        
        return basename($file);
    }

    //*
    //* function MyMod_Handle_Zip_Item_Field, Parameter list: $zip,$item,$data
    //*
    //* Will do the actual filed $data zipping on $item.
    //*

    function MyMod_Handle_Zip_Item_Field($zip,$item,$data)
    {
        $file=$item[ $data ];

        if (!empty($file))
        {
            if (file_exists($file))
            {
                $path=dirname($file);
                $fname=basename($file);
                $zip->addFile
                (
                   $file,
                   $this->MyMod_Handle_Zip_Item_Field_FileName($item,$data)
                ); 
            }
        }
    }



}

?>