<?php

trait MyLatex
{
    var $LatexScript="../pdflatex.sh";
    var $LatexDelete=FALSE;

    
    //*
    //* Apply latex filters in ApplicationObj()->MyApp_Latex_Filters
    //*

    function Latex_Apply_Filters($latex)
    {
        foreach ($this->ApplicationObj()->MyApp_Latex_Filters as $key => $hash)
        {
            if (!is_array($hash))
            {
                if (method_exists($this->ApplicationObj(),$hash))
                {
                    $rhash=$this->ApplicationObj()->$hash();

                    $obj=$key."sObj";
                    if (method_exists($this,$obj))
                    {
                        $rhash=$this->$obj()->ApplyAllEnums($rhash,TRUE);
                    }
                    
                    $hash=array();
                    foreach ($rhash as $rkey => $rvalue)
                    {
                        $hash[ $key."_".$rkey ]=$rvalue;
                    }
                }
            }
            
            if (is_array($hash))
            {
                $latex=$this->FilterHash($latex,$hash);
            }
        }


        return $latex;
    }

    //*
    //* Runs pdflatex, saving cntent of $latex to $path."/".$texfilename.
    //*

    function Latex_Command($path,$texfilename)
    {
        $command=
            $this->LatexScript." ".
            $path." ".
            $texfilename;

        return $command;
    }

    
    //*
    //* Runs pdflatex, saving cntent of $latex to $path."/".$texfilename.
    //*

    function Latex_Run($texfilename,$latex,$runbibtex=FALSE)
    {
        if ($this->GetGETOrPOST("ShowLatexCode")==1)
        {
            $this->ShowLatexCode($latex);
            exit();
        }

        $cwd=getcwd();
        $texfilename=$this->Html2Sort($texfilename);

        $path=$this->LatexTmpPath();

        $latexbin=$this->LatexScript;
        $pdffilename=$texfilename;
        $pdffilename=preg_replace('/\.tex$/',".pdf",$pdffilename);

        $latex=$this->Latex_Apply_Filters($latex);
        $latex=html_entity_decode($latex);
        $latex=$this->Text2Tex($latex);

        $this->MyWriteFile($path."/".$texfilename,$latex);
        //$this->ShowLatexCode($latex); exit();
        
        $command=$this->Latex_Command($path,$texfilename);
        
        //Run pdflatex first time
        $mess=system($command,$res1);

        if ($runbibtex)
        {
            $cwd=getcwd();
            chdir($path);

            $bibtex=preg_replace('/\.tex$/',"",$texfilename);
            system("/usr/bin/bibtex $bibtex > bibtex.log 2>&1");

            chdir($cwd);
        }

        if ($this->RunLatexThrice || $runbibtex)
        {
            //Make sure we run Latex 3 times, so all refs tect are updated
            $mess=system($command,$res1);
            $mess=system($command,$res1);
            $this->UnlinkFiles(array($bibtex.".bib",$bibtex.".blg",$bibtex.".bbl"),$path);
        }

        $logfile=preg_replace('/\.pdf/',".log",$pdffilename);
        $auxfile=preg_replace('/\.pdf/',".aux",$pdffilename);
        $tocfile=preg_replace('/\.pdf/',".toc",$pdffilename);

        $this->UnlinkFiles(array($auxfile,$tocfile,"latex.log"),$path);

        if (is_file($path."/".$pdffilename))
        {
            if ($this->LatexDelete)
            {
                $this->UnlinkFiles(array($texfilename,$logfile),$path);
            }
            
            return $pdffilename;
        }
        else
        {
            //print "Res pdflatex: $res1, $mess\n";
            return NULL;
        }
    }
    
    //*
    //* Runs Latex, and displays resulting pdf.
    //*

    function Latex_PDF($texfilename,$latex,$printpdf=TRUE,$runbibtex=FALSE,$copypdfto=FALSE)
    {
        $texfilename=preg_replace('/&quot;/',"",$texfilename);

        $path=$this->LatexTmpPath();
        $pdffilename=$this->Latex_Run($texfilename,$this->TrimLatex($latex),$runbibtex);

        $logfilename="$path/latex.log";

        $rpdffilename=$path."/".$pdffilename;
        if ($pdffilename && is_file($rpdffilename))
        {
            if ($printpdf)
            {
                $this->SendDocHeader("pdf",$pdffilename);
                echo join("",$this->MyReadFile($path."/".$pdffilename));

                if ($copypdfto)
                {
                    rename($rpdffilename,$copypdfto);
                }
                else
                {
                    unlink($path."/".$pdffilename);
                }

                exit();
            }
            else
            {
                if ($copypdfto)
                {
                    rename($rpdffilename,$copypdfto);
                }
                return $path."/".$pdffilename;
            }
        }
        else
        {
            $this->ApplicationObj->UnSetLatexMode();
            $this->ApplicationObj->MyApp_Interface_Head();

            echo
                "Error generating latex ($path/$texfilename):".
                $this->BR().
                "Caller 1: ".$this->Caller(1).".".
                $this->BR().
                "Caller 2: ".$this->Caller(2).".".
                $this->BR().
                "";

            if (!file_exists($logfilename))
            {
                $logfilename=$path."/".preg_replace('/\.tex$/',".log",$texfilename);
            }

            if (file_exists($logfilename))
            {
                echo
                    "Logfile: ".$logfilename."<BR>".
                    join("<BR>",$this->MyReadFile($logfilename)).
                    "";
            }
            else
            {       
                echo "No logfile: ".$logfilename."<BR>";
            }

            echo "Arquivo gerado:<BR>";
            $lines=$this->MyReadFile($path."/".$texfilename);
            
            $n=1;
            foreach ($lines as $line)
            {
                $line=preg_replace('/ /',"&nbsp;",$line);
                $nn=sprintf("%04d",$n);
                echo $nn." ".$line."<BR>";
                $n++;
            }

            exit();
        }

        return $pdffilename;
    }

    //*
    //* Shows latex code. Runs through \n --> <BR>, etc.
    //*

    function Latex_Code_Show($latex,$exit=TRUE)
    {
        echo preg_replace
        (
           '/\n/',
           "<BR>",
           preg_replace
           (
              '/ /',
              "&nbsp;",
              $latex
           )
        );

        if ($exit) { exit(); }
    }

    //*
    //* function Latex_Minipage, Parameter list: $width,$orient="t",$height=""
    //*
    //* Generate a latex minipage env.
    //* 
    //*

    function Latex_Minipage($content,$width,$orient="t",$height="")
    {
        if (!empty($height)) { $height="[".$height."cm]"; }
        
        return
            "\\begin{minipage}[".$orient."]".$height."{".$width."cm}\n".
            $content.
            "\\end{minipage}\n".
            "";
    }

    
}
?>