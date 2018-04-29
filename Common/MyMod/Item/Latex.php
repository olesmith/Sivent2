<?php


trait MyMod_Item_Latex
{
    //*
    //* function MyMod_Item_Latex, Parameter list: $item=array()
    //*
    //* Latexifies one item.
    //*

    function MyMod_Item_Latex($item=array())
    {
        //Test access methods and deny if not satified!!! Used individually for each item, should be used overall too.
        $accessmethod=$this->Actions[ "Print" ][ "AccessMethod" ];


        if (empty($item)) { $item=$this->ItemHash; }

        $latexdocno=$this->CGI2LatexDocNo();
        if (empty($this->LatexData) || empty($this->LatexData[ "SingularLatexDocs" ]))
        {
            echo "Latex Info undef:";
            var_dump($this->LatexData);
            exit();
        }

        
        $latexinfo=$this->LatexData[ "SingularLatexDocs" ][ "Docs" ][ $latexdocno ];

        $glue=$this->GetLatexSkel($latexinfo[ "Glue" ],TRUE);

        $head="";
        if (!empty($latexinfo[ "PageHead" ]))
        {
            $head=$this->GetLatexSkel($latexinfo[ "PageHead" ],TRUE);
        }

        $tail="";
        if (!empty($latexinfo[ "PageTail" ]))
        {
            $tail=$this->GetLatexSkel($latexinfo[ "PageTail" ],TRUE);
        }

        $latex=$head;
        $nitems=0;

        //See if we need to check access on individual objects
        if ($accessmethod!="")
        {
            if (method_exists($this,$accessmethod))
            {
                if (!$this->$accessmethod($item))
                {
                    return;
                }
            }
        }

        $item=$this->ApplyAllEnums($item,TRUE);
        $item=$this->TrimLatexItem($item);

        $nitems++;
        $item[ "No" ]=sprintf("%03d",$nitems);
            
        $rlatex="";
        if (isset($item[ "LatexPre" ]))
        {
            $rlatex.=$item[ "LatexPre" ];
        }
        $rlatex.=$glue;

        $rlatex=$this->FilterHash($rlatex,$item);

        $rlatex=$this->FilterObject($rlatex);

        $latex.=$rlatex;

        if ($nitems==0) { $latex="Empty Document..."; }

        $latex.=$tail;

        $this->ShowLatexCode($latex);
        exit();
        return $latex;
    }
}

?>