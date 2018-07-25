<?php


trait MyApp_Interface_CSS_InLine
{
    //*
    //* sub MyApp_Interface_CSS_InLine, Parameter list:
    //*
    //* Returns list of (static) file, to be included INLINE.
    //*
    //*

    function MyApp_Interface_CSS_InLine()
    {
        $css=
            array_merge
            (
                $this->MyApp_Interface_CSS_InLine_Files_Read(),
                $this->MyApp_Interface_CSS_Module_InLine()
            );

        /* //Replace Layout vars, coded as \$key in css */
        /* foreach ($this->Layout as $key => $value) */
        /* { */
        /*     $css=preg_replace('/\$'.$key.'\b/',$value,$css); */
        /* } */

        if (!preg_grep('/\S/',$css)) { return array(); }
        
        return 
            $this->Html_Tag_List
            (
               "STYLE",
               $css
            );
    }
    
    //*
    //* sub MyApp_Interface_CSS_Module_InLine, Parameter list:
    //*
    //* Checks if module has inline CSS to inlcude.
    //*
    //*

    function MyApp_Interface_CSS_Module_InLine()
    {
        $css="";
        if ($this->Module)
        {
            if (method_exists($this->Module,"Module_CSS_InLine"))
            {
                $css=$this->Module->Module_CSS_InLine();
            }
        }

        return array($css);
    }
    
    //*
    //* sub MyApp_Interface_CSS_InLine_Files_Read, Parameter list:
    //*
    //* 
    //*
    //*

    function MyApp_Interface_CSS_InLine_Files_Read()
    {
        return
            $this->MyFiles_Read_Lines
            (
                $this->MyApp_Interface_Head_CSS_InLine
            );
   }

}

?>