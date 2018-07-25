<?php


trait MyApp_Interface_CSS_OnLine
{
    
    //*
    //* sub MyApp_Interface_CSS_Online, Parameter list:
    //*
    //* ReturnsCSS online LINK tags.
    //*
    //*

    function MyApp_Interface_CSS_OnLine()
    {
        $csshtml=array();
        foreach ($this->MyApp_Interface_CSS_OnLine_Files_Get() as $cssfile)
        {
            array_push
            (
                $csshtml,
                $this->MyApp_Interface_CSS_OnLine_LINK_Tag($cssfile)
            );
        }
        
        return $csshtml;
    }

    //*
    //* sub MyApp_Interface_CSS_LINK_Tag, Parameter list:
    //*
    //* Returns list of (static) file, to be included INLINE.
    //*
    //*

    function MyApp_Interface_CSS_OnLine_LINK_Tag($cssfile)
    {
        return
            $this->HtmlTag
            (
               "LINK",
               "",
               array
               (
                  "REL" => 'stylesheet',
                  "HREF" => $cssfile,
               )
            ).
            "";
    }

    
    //*
    //* sub MyApp_Interface_CSS_OnLine_Files_Get, Parameter list:
    //*
    //* Reads css files from disk and returns code for online insertion.
    //*
    //*

    function MyApp_Interface_CSS_OnLine_Files_Get()
    {
        $cssfiles=array();
        foreach ($this->MyApp_Interface_Head_CSS_OnLine as $cssfile)
        {
            if (file_exists($cssfile))
            {
                array_push($cssfiles,$cssfile);
            }
           
        }

        $base_path=dirname($_SERVER[ "SCRIPT_FILENAME" ]);
        
        
        $action=$this->CGI_GET("Action");
        $modulename=$this->CGI_GET("ModuleName");

        $css_path=$this->MyApp_Interface_CSS_Path();
        
        if (!empty($modulename))
        {
            #Module dir, full path
            $full_path=join("/",array($base_path,$css_path,$modulename));
            $this->Dir_Create($full_path);

            #Module css file
            $module_file=$modulename.".css";

            $this->MyFile_Touch
            (
                join("/",array($base_path,$css_path,$module_file))
            );

            if (file_exists($cssfile))
            {
                array_push
                (
                    $cssfiles,
                    join("/",array($css_path,$module_file))
                );
            }
            
            if (!empty($action))
            {
                $action_file=$action.".css";
                $cssfile=join("/",array($base_path,$css_path,$modulename,$action_file));
                
                $this->MyFile_Touch($cssfile);
                if (file_exists($cssfile))
                {
                    array_push
                    (
                        $cssfiles,
                        join("/",array($css_path,$modulename,$action_file))
                    );
                }
            }
        }
        elseif (!empty($action))
        {
            #App action
            #Actions dir, full path
            $action_path="Actions";
            $action_file=$action.".css";
            
            $this->MyFile_Touch
            (
                join("/",array($base_path,$css_path,$action_path,$action_file))
            );
            
            $cssfile="CSS/Actions/".$action.".css";
            if (file_exists($cssfile))
            {
                array_push($cssfiles,$cssfile);
            }            
        }

        return $cssfiles;
    }
}

?>