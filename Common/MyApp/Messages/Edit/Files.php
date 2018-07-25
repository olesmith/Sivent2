<?php


trait MyApp_Messages_Edit_Files
{
    //*
    //* function MyApp_Messages_Edit_File_Link, Parameter list: $file
    //*
    //* Creates link to edit file.
    //*

    function MyApp_Messages_Edit_File_Link($file)
    {
        $args=$this->CGI_URI2Hash();
        $args[ "File" ]=$file;
        
        return
            $this->Href
            (
               "?".$this->CGI_Hash2URI($args),
               basename($file),
               "Edit File: ".$file,
               $target="",$class="",$noqueryargs=FALSE,$options=array(),
               $anchor=$file
            );
    }
    
    //*
    //* function MyApp_Messages_Edit_File_Writeable_Cell, Parameter list: $file
    //*
    //* Celkl with yes/no depending on writeability of $file.
    //*

    function MyApp_Messages_Edit_File_Writeable_Cell($file)
    {
        $writeable="No";
        if (is_writable ($file))
        {
            $writeable="Yes";
        }

        return $writeable;
    }

    //*
    //* function MyApp_Messages_Edit_File, Parameter list: $edit,$path,$file,$keys=array()
    //*
    //* Handles message $file editing.
    //*

    function MyApp_Messages_Edit_File($edit,$path,$file,$keys=array())
    {
        if (empty($keys)) $keys=$this->MyApp_Messages_Edit_Keys();

        $cgifile=$this->CGI_GET("File");

        $active=TRUE;
        if ($file!=$cgifile) { $active=FALSE; }
        
        $redit=$edit && $active;
        $tmp=array();
        $hashes=$this->ReadPHPArray($file,$tmp,FALSE);

        $writeable=$this->MyApp_Messages_Edit_File_Writeable_Cell($file);

        $rfile=basename($file);
        if ($active==0)
        {
            $rfile=$this->MyApp_Messages_Edit_File_Link($file);
        }

        $table=array(array($rfile,$writeable,count(array_keys($hashes))));
        if (!is_writeable($file))
        {
            $edit=0;
        }

        if ($active)
        {
            $table=
                array_merge
                (
                   $table,
                   $this->MyApp_Messages_Edit_File_Active($edit,$path,$file,$hashes,$keys)
                );
        }

        

        return $table;
    }

    //*
    //* function MyApp_Messages_Edit_File_Active, Parameter list: $edit,$path,$file,$hashes,$keys=array()
    //*
    //* Rows for active message $file editing.
    //*

    function MyApp_Messages_Edit_File_Active($edit,$path,$file,$hashes,$keys=array())
    {
        if (empty($keys)) $keys=$this->MyApp_Messages_Edit_Keys();

        if ($edit==1 && $this->CGI_POSTint("Update")==1)
        {
            $this->MyApp_Messages_Edit_Hashes_Update($file,$hashes,$keys);
        }
        
        $cgifile=$this->CGI_GET("File");

        $active=TRUE;
        if ($file!=$cgifile) { $active=FALSE; }
        
        $redit=$edit && $active;
        
        $table=array();
        foreach (array_keys($hashes) as $hashkey)
        {
            //$table=array_merge($table,$this->MyApp_Messages_Edit_File_Title_Rows($path,$file));
        

            //Individual hashes as references!
            $table=
                array_merge
                (
                   $table,
                   $this->MyApp_Messages_Edit_Hash($edit,$path,$file,$hashkey,$hashes[ $hashkey ],$keys)
                );
        }

        $title="Show";
        if ($edit==1)
        {
            array_unshift($table,array($this->Buttons("Save ".basename($cgifile))));
            array_push($table,array($this->Buttons("Save ".basename($cgifile))));
            $title="Edit";
        }

        $table=
            $this->Html_Form
            (
               $this->H
               (
                   2,
                   $title." ".$file,
                   array("ID" => $file)
               ).
               $this->Html_Table
               (
                  $this->MyApp_Messages_Edit_File_Title_Row($path,$file),
                  $table
               ).
               "",
               $edit
            );
        
        return array(array($table));
    }
    
}

?>