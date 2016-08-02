<?php


trait MyMod_Items_Latex
{
    //*
    //* function LatexItems, Parameter list: $items=array()
    //*
    //* Latexifies all items read ($items, or as usual: $this-<ItemHashes if empty).
    //* First reads latex doc no from CGI, then $latexinfo from $this->LatexData.
    //* Next, reads Head, Glue and Tail based on $latexinfo.
    //* Looping over items, we fabricate the text string:
    //*
    //*  Head.
    //*  Glue filtered over first item.
    //*  Glue filtered over second item.
    //* ...
    //*  Glue filtered over last item.
    //*  Tail
    //*
    //*  If defined $accessmethod ($this->Actions[ "Print" ][ "AccessMethod" ]), this method
    //*  is called on item, in order to check if inclusion of each item is allowed or not.
    //* Checks $latexinfo[ "ItemsPerPage" ] in order to change page, inserting:
    //* Head.
    //* \newpage
    //* Tail.
    //*

    function MyMod_Items_Latex($items=array())
    {
        //Test access methods and deny if not satified!!! Used individually for each item, should be used overall too.
        $accessmethod=$this->Actions[ "Print" ][ "AccessMethod" ];


        if (count($items)==0) { $items=$this->ItemHashes; }

        $items=$this->SplitLatexItems($items);
        $latexdocno=$this->CGI2LatexDocNo();
        $latexinfo=$this->LatexData[ "PluralLatexDocs" ][ "Docs" ][ $latexdocno ];

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
        $count=0;
        foreach ($items as $id => $item)
        {
            //See if we need to check access on individual objects
            if ($accessmethod!="")
            {
                if (method_exists($this,$accessmethod))
                {
                    if (!$this->$accessmethod($item))
                    {
                        continue;
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

            
            $count++;
            if (
                  !empty($latexinfo[ "ItemsPerPage" ])
                  &&
                  $latexinfo[ "ItemsPerPage" ]>0
                  &&
                  $count==$latexinfo[ "ItemsPerPage" ]
                  &&
                  $nitems<count($items)
               )
            {
                $latex.=
                    $tail.
                    "\n\n\\clearpage\n\n".
                    $head;

                $count=0;

            }
        }

        if ($nitems==0) { $latex="Empty Document..."; }

        $latex.=$tail;

        return $latex;
    }
}

?>