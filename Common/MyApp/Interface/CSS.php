<?php


trait MyApp_Interface_CSS
{
    var $CSSPath="CSS";
    var $CSSFiles=
        array
        (
           "HTMLs.css","Envs.css",
           //"App.css",
           "Application.css",
           "Left.Menu.css","Hor.Menu.css",
           "Odd.Even.css","Modules.css",
        );
    
    //*
    //* sub MyApp_Interface_Application_CSS_Generate, Parameter list:
    //*
    //* Generates interface header CSS entries.
    //*
    //*

    function MyApp_Interface_Application_CSS_Generate()
    {
        return
            $this->MyApp_Interface_Application_CSS_INLINE().
            "";
    }

    //*
    //* sub MyApp_Interface_Application_CSS_INLINE, Parameter list:
    //*
    //* Returns list of (static) file, to be included INLINE.
    //*
    //*

    function MyApp_Interface_Application_CSS_INLINE()
    {
        $css="";
        if ($this->Module)
        {
            if (method_exists($this->Module,"Module_CSS"))
            {
                $css=$this->Module->Module_CSS();
            }
        }

        return 
            $this->HtmlTags
            (
               "STYLE",
               $css //.$this->MyApp_Interface_Application_CSS_Files_Read()
            ).
            "";
    }
    
    //*
    //* sub MyApp_Interface_Application_CSS_LINKs, Parameter list:
    //*
    //* Returns list of (static) file, to be included as LINKs.
    //*
    //*

    function MyApp_Interface_Application_CSS_LINKs()
    {
        $csshtml="";
        foreach ($this->MyApp_Interface_Application_CSS_Files() as $cssfile)
        {
            $cssfile=$cssfile;
            $csshtml.=$this->MyApp_Interface_Application_CSS_LINK_File($cssfile);
        }
        
        return $csshtml;
    }

    //*
    //* sub MyApp_Interface_Application_CSS_LINK_File, Parameter list:
    //*
    //* Returns list of (static) file, to be included INLINE.
    //*
    //*

    function MyApp_Interface_Application_CSS_LINK_File($cssfile)
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
            "\n";
    }

    //*
    //* sub MyApp_Interface_Application_CSS_File, Parameter list:
    //*
    //* Reads css files from disk and returns code for iniline insertion.
    //*
    //*

    function MyApp_Interface_Application_CSS_File($file)
    {
        return $this->CSSPath."/".$file;
    }
    
    //*
    //* sub MyApp_Interface_Application_CSS_Files, Parameter list:
    //*
    //* Reads css files from disk and returns code for iniline insertion.
    //*
    //*

    function MyApp_Interface_Application_CSS_Files()
    {
        $cssfiles=array();
        foreach ($this->CSSFiles as $cssfile)
        {
            $cssfile=$this->CSSPath."/".$cssfile;
            if (file_exists($cssfile))
            {
                array_push($cssfiles,$cssfile);
            }
           
        }
        
        $action=$this->CGI_GET("Action");
        $modulename=$this->CGI_GET("ModuleName");
        if (!empty($modulename))
        {
            $cssfile=$this->MyApp_Interface_Application_CSS_File("Modules/".$modulename.".css");
            if (file_exists($cssfile))
            {
                array_push($cssfiles,$cssfile);
            }
            
            if (!empty($action))
            {
                $cssfile=$this->MyApp_Interface_Application_CSS_File("Modules/".$modulename."/Actions/".$action.".css");
                if (file_exists($cssfile))
                {
                    array_push($cssfiles,$cssfile);
                }
            }
        }
        elseif (!empty($action))
        {
            $cssfile=$this->MyApp_Interface_Application_CSS_File("Actions/".$action.".css");
            if (file_exists($cssfile))
            {
                array_push($cssfiles,$cssfile);
            }            
        }

        return $cssfiles;
    }

    
    //*
    //* sub MyApp_Interface_Application_CSS_Files_Read, Parameter list:
    //*
    //* Reads css files from disk and returns code for iniline insertion.
    //*
    //*

    function MyApp_Interface_Application_CSS_Files_Read()
    {
        $css="";
        foreach ($this->MyApp_Interface_Application_CSS_Files() as $cssfile)
        {
            if (is_file($cssfile))
            {
                $css.=join("",$this->MyReadFile($cssfile));
            }
        }

        //Replace Layout vars, coded as \$key in css
        foreach ($this->Layout as $key => $value)
        {
            $css=preg_replace('/\$'.$key.'\b/',$value,$css);
        }


        return $css;
   }

}

?>