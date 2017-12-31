<?php


class MyInscriptions_Handle extends MyInscriptions_Receit
{
    //*
    //* function HandleEmails, Parameter list:
    //*
    //* Handle friend inscription. 
    //*

    function HandleEmails()
    {
        $where=array();
        $fixedvars=$where;

        $this->MailFilters=array
        (
           $this->Event(),
        );
        
        echo 
            $this->HandleSendEmails($where,array("Friend"),$fixedvars).
             "";
    }

    
    //*
    //* function HandleReceit, Parameter list:
    //*
    //* Handle inscription receit generation.
    //*

    function HandleReceit()
    {
        $latex=
            $this->GetLatexSkel("Head.tex").
            $this->Receit_Latex($this->ItemHash).
            $this->GetLatexSkel("Tail.tex").
            "";
        
        if ($this->CGI_GET("Latex")!=1)
        {
            return $this->ShowLatexCode($latex);
        }

        $texfile=preg_replace('/\s+/',".",$this->ItemHash[ "Name" ]);
        
        $file=
            "Receit.".
            $this->Text2Sort($texfile).".".
            $this->MTime2FName().
            ".tex";

        return $this->ApplicationObj()->Latex_PDF($file,$latex);
    }
    
    //*
    //* function HandleReceits, Parameter list:
    //*
    //* Handle inscription receit generation.
    //*

    function HandleReceits()
    {
        $this->MyMod_Items_Read(array(),array_keys($this->ItemData));
        
        $latex=
            $this->GetLatexSkel("Head.tex").
            $this->Receits_Latex($this->ItemHashes).
            $this->GetLatexSkel("Tail.tex").
            "";
      
        if ($this->CGI_GET("Latex")!=1)
        {
            return $this->ShowLatexCode($latex);
        }
        
        $file=
            "Receit.".
            $this->MTime2FName().
            ".tex";

        return $this->ApplicationObj()->Latex_PDF($file,$latex);
    }
}

?>