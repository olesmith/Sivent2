<?php

trait MyApp_Handle_Help
{    
    //*
    //* function MyApp_Handle_Help, Parameter list:
    //*
    //* Creates Help Screen
    //*

    function MyApp_Handle_Help()
    {
        $this->MyApp_Interface_Head();
        
        echo
            $this->H(1,"Tópicos de Ajuda").
            $this->MyApp_Handle_Help_Show();
    }

    //*
    //* function MyApp_Handle_HasHelp, Parameter list: 
    //*
    //* Returns true if application help file exists.
    //*

    function MyApp_Handle_HasHelp()
    {
        return TRUE;
    }
    
    //*
    //* function MyApp_Handle_Help_Dir, Parameter list: 
    //*
    //* Returns name of module help dir.
    //*

    function MyApp_Handle_Help_Dir()
    {
        return
            $this->ApplicationObj()->MyApp_Setup_Path().
            "/Help";
    }
    
    //*
    //* function MyApp_Handle_Help_Show, Parameter list: 
    //*
    //* Displays application help. browsing System/Help subtree.
    //*

    function MyApp_Handle_Help_Show()
    {
        $actiondir=$this->MyApp_Handle_Help_Dir();

        $table=$this->MyApp_Handle_Help_Show_Dir_Rows($actiondir);

        return $this->Html_Table("",$table);
        
    }

    
    //*
    //* function MyApp_Handle_Help_Show_Action_Rows, Parameter list: $actiondir,$level=1,$numbers=array())
    //*
    //* Creates module actions level rows.
    //*

    function MyApp_Handle_Help_Show_Dir_Rows($actiondir,$level=1,$numbers=array())
    {
        $table=$this->MyApp_Handle_Help_Show_Dir_Row($actiondir,$level,$numbers);
    
        $ractiondir=preg_replace('/System\/Help\/?/',"",$actiondir);
        $ractiondir=preg_replace('/\//',"_",$ractiondir);
        
        $cpath=preg_replace('/\//',"_",$this->CGI_GET("Path"));
        
        if (preg_match('/^'.$ractiondir.'/',$cpath))
        {
            $table=
                array_merge
                (
                   $table,
                   $this->MyApp_Handle_Help_Show_Dir_Show($actiondir,$level,$numbers)            
                );
        }

        $subactiondirs=$this->Dir_Subdirs($actiondir);
        sort($subactiondirs);
        
        $snumber=1;
        foreach ($subactiondirs as $subactiondir)
        {
            if (preg_match('/^'.$ractiondir.'/',$cpath))
            {
                $snumbers=$numbers;
                array_push($snumbers,$snumber++);
                
                $table=
                    array_merge
                    (
                       $table,
                       $this->MyApp_Handle_Help_Show_Dir_Rows
                       (
                          $subactiondir,
                          $level+1,
                          $snumbers
                       )
                    );
            }
        }

        return $table;
    }

     //*
    //* function MyApp_Handle_Help_Show_Dir_URI, Parameter list: $actiondir
    //*
    //* Creates to URI for help dir entry.
    //*

    function MyApp_Handle_Help_Show_Dir_URI($actiondir)
    {
        $args=$this->CGI_URI2Hash();

        $comps=preg_split('/\/+/',$actiondir);
        array_shift($comps);array_shift($comps);
        
        $args[ "Path" ]=join("/",$comps);

        return "?".$this->CGI_Hash2URI($args);
    }
    
   
    //*
    //* function MyApp_Handle_Help_Show_Dir_Href, Parameter list: $actiondir
    //*
    //* Creates to link to help dir.
    //*

    function MyApp_Handle_Help_Show_Dir_Href($actiondir)
    {
        $ractiondir=preg_replace('/System\/Help\/?/',"",$actiondir);
        $ractiondir=preg_replace('/\//',"_",$ractiondir);
        $cpath=preg_replace('/\//',"_",$this->CGI_GET("Path"));
        
        $text="++";
        if (preg_match('/^'.$ractiondir.'/',$cpath))
        {
            $text="--";
            $comps=preg_split('/\/+/',$actiondir);
            array_pop($comps);
            
            $actiondir=join("/",$comps);
        }
        
        return
           $this->Href
           (
              $this->MyApp_Handle_Help_Show_Dir_URI($actiondir),
              $text
           );
    }
    
    //*
    //* function MyApp_Handle_Help_Show_Dir_Row, Parameter list: $actiondir,$level,$numbers
    //*
    //* That is, shows module help file.
    //*

    function MyApp_Handle_Help_Show_Dir_Row($actiondir,$level,$numbers)
    {
        $file=$actiondir."/Name.html";

        $row=array();
        if (file_exists($file))
        {
            $row=array
            (
                $this->MyApp_Handle_Help_Show_Dir_Href($actiondir),
                $this->B( join(".",$numbers).": "  ).
                join(",",$this->MyFile_Read($file)),
               $this->MyApp_Handle_Help_Show_Dir_Info($actiondir),
                ""
            );
        }
        
        return array($row);
    }

    
    //*
    //* function MyApp_Handle_Help_Show_Dir_Show, Parameter list: $actiondir,$level,$numbers
    //*
    //* 
    //*

    function MyApp_Handle_Help_Show_Dir_Show($actiondir,$level,$numbers)
    {
        $table=array();

        $files=$this->Dir_Files($actiondir,'^\d+\.png$',TRUE);
        sort($files);
        
        $slevel=$level;

        $rnumber=1;
        foreach ($files as $pngfile)
        {
            array_push
            (
               $table,
               $this->MyApp_Handle_Help_Show_Dir_Entry($actiondir,$pngfile,$level,$slevel++,$rnumber++)
            );
        }
        
        return array(array($this->Html_Table("",$table)));
    }
    
    //*
    //* function MyApp_Handle_Help_Show_Dir_Info, Parameter list: $actiondir,$pngfile,$level,$number
    //*
    //* That is, shows module help file.
    //*

    function MyApp_Handle_Help_Show_Dir_Info($actiondir)
    {
        $info="";

        $file=$actiondir."/Info.html";
        if (file_exists($file)) { $info=$this->MyFile_REad($actiondir."/Info.html"); }

        return $info;
    }
    
     //*
    //* function MyApp_Handle_Help_Show_Dir_Entry, Parameter list: $actiondir,$pngfile,$level,$number
    //*
    //* That is, shows module help file.
    //*

    function MyApp_Handle_Help_Show_Dir_Entry($actiondir,$pngfile,$level,$slevel,$number)
    {
        $file=preg_replace('/\.png$/',".html",$pngfile);
        $titlefile=preg_replace('/(\d+)\.html/',"$1.Title.html",$file);

        $title="";
        if (file_exists($titlefile))
        {
           $title=join("",$this->MyFile_Read($titlefile));
        }
        
        $text="";
        if (file_exists($file))
        {
            $text=join("",$this->MyFile_Read($file));
        }

        $img="";
        if (file_exists($pngfile))
        {
            $img=
                $this->Html_IMG
                (
                   $pngfile,
                   $text,
                   array
                   (
                      "Height" => 300,
                      "Title" => $title,
                   )
                 );

            $ihref=$this->A
            (
             $pngfile,
             $img
            );   
        }
        
        return array
        (
           "",
           $this->B($number.":"),
           $text,
           $ihref
        );
    }
}

?>