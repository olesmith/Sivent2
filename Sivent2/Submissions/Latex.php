<?php



class Submissions_Latex extends Submissions_Schedule
{
    //*
    //* function Submissions_Latex_Event, Parameter list: 
    //*
    //* Returns event with keys trimmed for latex.
    //*

    function Submissions_Latex_Event()
    {
        $event=$this->Event();
        $event=$this->EventsObj()->ApplyAllEnums($event,TRUE);
        $event=$this->EventsObj()->TrimLatexItem($event);

        return $event;
    }
    
    //*
    //* function Submissions_Latex_Doc_Head, Parameter list: 
    //*
    //* Returns until latex \begin{document} from Event setup
    //*

    function Submissions_Latex_Doc_Head($item)
    {
        $event=$this->Submissions_Latex_Event();
        
        return
            '\documentclass'.
            '['.
            $event[ "Proceedings_DocType_Options" ].
            ']'.
            '{'.
            $event[ "Proceedings_DocType" ].
            '}\n\n'.
            $event[ "Proceedings_Preamble" ].
            '\title{'.$item[ "Title" ].'}\n'.
            '\date{\today}\n'.
            ''.$this->Submission_Authors_Latex($item).'\n\n'.
            '\begin{document}\n'.   
            '';
    }
    
    //*
    //* function Submissions_Latex_Tail, Parameter list: 
    //*
    //* Returns \end{document}
    //*

    function Submissions_Latex_Doc_Tail()
    {
        $event=$this->Submissions_Latex_Event();
        
        return
            '\n\n'.
            $event[ "Proceedings_Postamble" ].            
            '\end{document}\n'.   
            '';
    }

    //*
    //* function MyMod_Item_Print, Parameter list: $item=array()
    //*
    //* Overrides print item.
    //*

    function MyMod_Item_Print($item=array())
    {
        if (empty($item)) { $item-$this->ItemHash; }

        $latex=
            $this-> Submissions_Latex_Doc_Head($item).
            "\n".
            $this->MyMod_Item_Latex($item).
            $this->Submissions_Latex_Doc_Tail().
            "";

        if ($this->CGI_GETint("Latex")==1)
        {
            $this->ShowLatexCode($latex);
            exit();
        }
        
        return $this->Latex_PDF
        (
           $this->MyMod_Item_Print_FileName($item),
           $latex
        );
        
        
    }

     //*
    //* function MyMod_Item_Latex, Parameter list: $item=array()
    //*
    //* Overrides latex item.
    //*

    function MyMod_Item_Latex($item=array())
    {
        if (empty($item)) { $item=$this->ItemHash; }

        #$item[ "Authors_Latex" ]=$this->Submission_Authors_Latex($item);
        
        $latexdocno=$this->CGI2LatexDocNo();

        $latex=$this->MyMod_Latex_Skel("Singular","Glue",$latexdocno);

        $latex=$this->FilterHash($latex,$item);
        return $latex;
    }

        
}

?>