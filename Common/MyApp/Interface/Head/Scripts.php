<?php


    function first($list) { return $list[0]; }
trait MyApp_Interface_Head_Scripts
{
    //*
    //* sub MyApp_Interface_SCRIPTs, Parameter list:
    //*
    //* Returns interface header script section
    //*
    //*

    function MyApp_Interface_SCRIPTs()
    {
        return
            array_merge
            (
                $this->MyApp_Interface_SCRIPTs_InLine(),
                $this->MyApp_Interface_SCRIPTs_OnLine()
            );
    }
    
    //*
    //* sub MyApp_Interface_SCRIPTs_OnLine, Parameter list:
    //*
    //* Returns interface header scripts inline section
    //*
    //*

    function MyApp_Interface_SCRIPTs_OnLine()
    {
        $scripts=array();
        foreach ($this->MyApp_Interface_Head_Scripts_OnLine as $file)
        {
            array_push
            (
                $scripts,
                $this->HtmlTags
                (
                    "SCRIPT",
                    "",
                    array
                    (
                        "SRC" => $file,
                    )
                )
            );
        }

        return $scripts;
    }
        
    //*
    //* sub MyApp_Interface_SCRIPTs_InLine, Parameter list:
    //*
    //* Returns interface header scripts online section
    //*
    //*

    function MyApp_Interface_SCRIPTs_InLine()
    {
        $scripts=array();
        foreach ($this->MyApp_Interface_Head_Scripts_InLine as $file)
        {
            $scripts=array_merge
            (
                $scripts,
                $this->Htmls_Tag
                (
                    "SCRIPT",
                    array
                    (
                        $this->MyFiles_Read_Lines(array($file))
                    )
                )
            );
        }
        
        return $scripts;
    }
}

?>