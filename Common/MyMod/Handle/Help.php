<?php

trait MyMod_Handle_Help
{
    
    /* //\* */
    /* //\* function MyMod_Handle_Help, Parameter list: */
    /* //\* */
    /* //\* Creates application Help Screen. */
    /* //\* */

    /* function MyMod_Handle_Help() */
    /* { */
    /*     if (!$this->MyMod_Handle_Help_Has()) { return ""; } */

    /*     echo */
    /*         $this->H(1,"Ajuda: ".$this->ModuleName). */
    /*         $this->MyMod_Handle_Help_Show(); */
    /* } */

    //*
    //* function MyMod_Handle_Help_Has, Parameter list:
    //*
    //* Returns true if application help file exists.
    //*

    function MyMod_Handle_Help_Has()
    {
        return FALSE;
    }


    /* //\* */
    /* //\* function MyMod_Handle_Help_Dir, Parameter list:  */
    /* //\* */
    /* //\* Returns name of module help dir. */
    /* //\* */

    /* function MyMod_Handle_Help_Dir() */
    /* { */
    /*     return */
    /*         $this->ApplicationObj()->MyApp_Setup_Path(). */
    /*         "/Help/". */
    /*         $this->ModuleName; */
    /* } */
    
    /* //\* */
    /* //\* function MyMod_Handle_Help_Show, Parameter list:  */
    /* //\* */
    /* //\* Displays Module Help. Runs over action subdirs, creating list */
    /* //\* of links to action help/tutorials. */
    /* //\* */

    /* function MyMod_Handle_Help_Show() */
    /* { */
    /*     $actiondir=$this->MyMod_Handle_Help_Dir(); */

    /*     $table=$this->MyMod_Handle_Help_Show_Action_Rows($actiondir); */

    /*     return $this->Html_Table("",$table); */
        
    /* } */
    
    /* //\* */
    /* //\* function MyMod_Handle_Help_Show_Action_Rows, Parameter list: $actiondir,$level=1 */
    /* //\* */
    /* //\* Creates module actions level rows. */
    /* //\* */

    /* function MyMod_Handle_Help_Show_Action_Rows($actiondir,$level=1) */
    /* { */
    /*     $table= */
    /*        array_merge */
    /*        ( */
    /*           $this->MyMod_Handle_Help_Show_Action_Row($actiondir,$level), */
    /*           $this->MyMod_Handle_Help_Show_Action_Show($actiondir,$level)             */
    /*        ); */

    /*      $subactiondirs=$this->Dir_Subdirs($actiondir); */
    /*      sort($subactiondirs); */
        
    /*      foreach ($subactiondirs as $subactiondir) */
    /*      { */
    /*          $table= */
    /*             array_merge */
    /*             ( */
    /*                $table, */
    /*                $this->MyMod_Handle_Help_Show_Action_Rows */
    /*                ( */
    /*                   $subactiondir, */
    /*                   $level++ */
    /*                ) */
    /*             ); */
    /*     } */

    /*     return $table; */
    /* } */
    
    /* //\* */
    /* //\* function MyMod_Handle_Help_Show_Action_Row, Parameter list: $actiondir,$level */
    /* //\* */
    /* //\* That is, shows module help file. */
    /* //\* */

    /* function MyMod_Handle_Help_Show_Action_Row($actiondir,$level) */
    /* { */
    /*     $file=$actiondir."/Info.html"; */

    /*     $help=""; */
    /*     if (file_exists($file)) */
    /*     { */
    /*         $help=$this->MyFile_Read($file); */
    /*     } */
        
    /*     return array($help); */
    /* } */

    
    /* //\* */
    /* //\* function MyMod_Handle_Help_Show_Action_Show, Parameter list: $actiondir,$level */
    /* //\* */
    /* //\* That is, shows module help file. */
    /* //\* */

    /* function MyMod_Handle_Help_Show_Action_Show($actiondir,$level) */
    /* { */
    /*     $table=array(); */

    /*     $files=$this->Dir_Files($actiondir,'^\d+\.png$',TRUE); */
    /*     sort($files); */
        
    /*     $slevel=$level; */
    /*     foreach ($files as $pngfile) */
    /*     { */
    /*         array_push */
    /*         ( */
    /*            $table, */
    /*            $this->MyMod_Handle_Help_Show_Action_Entry($actiondir,$pngfile,$level,$slevel++) */
    /*         ); */
    /*     } */
        
    /*     return $table; */
    /* } */
    
    /* //\* */
    /* //\* function MyMod_Handle_Help_Show_Action_Entry, Parameter list: $actiondir,$pngfile,$level */
    /* //\* */
    /* //\* That is, shows module help file. */
    /* //\* */

    /* function MyMod_Handle_Help_Show_Action_Entry($actiondir,$pngfile,$level,$slevel) */
    /* { */
    /*     $file=preg_replace('/\.png$/',".html",$pngfile); */
    /*     $titlefile=preg_replace('/(\d+)\.html/',"$1.Title.html",$file); */

    /*     $title=""; */
    /*     if (file_exists($titlefile)) */
    /*     { */
    /*        $title=join("",$this->MyFile_Read($titlefile)); */
    /*     } */
        
    /*     $text=""; */
    /*     if (file_exists($file)) */
    /*     { */
    /*     $text=join("",$this->MyFile_Read($file)); */
    /*     } */

    /*     $img=""; */
    /*     if (file_exists($pngfile)) */
    /*     { */
    /*         $img= */
    /*             $this->Html_IMG */
    /*             ( */
    /*                $pngfile, */
    /*                $text, */
    /*                array */
    /*                ( */
    /*                   "Height" => 300, */
    /*                   "Title" => $title, */
    /*                ) */
    /*              ); */

    /*         $ihref=$this->A */
    /*         ( */
    /*          $pngfile, */
    /*          $img */
    /*         );    */
    /*     } */
        
    /*     return array */
    /*     ( */
    /*        $this->B($level."-".$slevel.":"), */
    /*        $text, */
    /*        $ihref */
    /*     ); */
    /* } */
}

?>