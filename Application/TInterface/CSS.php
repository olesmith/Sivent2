<?php

class TInterfaceCSS extends Help
{
    //*
    //* sub ReadCSSFile, Parameter list: $cssfile
    //*
    //* Reads CSS file $cssfile.
    //*
    //*

    function ReadCSSFile($cssfile)
    {
        return
            "\n/* CSS file: ".$cssfile." Start */\n".
            join("",$this->MyReadFile($cssfile)).
            "\n/* CSS file: ".$cssfile." End */\n".
            "";
    }
    //*
    //* sub ReadCSS, Parameter list:
    //*
    //* Reads CSS.
    //*
    //*

    function ReadCSS()
    {
        $cssfiles=array
        (
           $this->CSSFile,
           $this->HtmlSetupHash[ "CssUrl"  ],
           $this->ModuleName.".css"
        );

        $css="";
        foreach ($cssfiles as $cssfile)
        {
            if (is_file($cssfile))
            {
                $css.=$this->ReadCSSFile($cssfile);
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