<?php


/* global $HtmlMessages; //global and common for all classes */
/* $HtmlMessages=array(); */

class SqlMessages extends Latex
{
    var $BackTraceLevel=1; 
    var $Debug=0;

    /* function Messages() */
    /* { */
    /* } */

    function InitMessages($list)
    {
    }

    function DebugShowCallers($maxlevel=0,$field='function')
    {
        $trace=debug_backtrace();
        //var_dump($trace[1]['function']);
        if ($maxlevel==0) { $maxlevel=count($trace); }
        $functions=array();
        $n=1;
        foreach ($trace as $level => $rtrace)
        {
            if ($n>=$maxlevel) { break; }

            array_push($functions,$rtrace[ $field ]);
            $n++;
        }

        return $functions;
    }


    function MakeMsg($msg,$reportlevel=3)
    {
        $trace=debug_backtrace();

        if ($reportlevel+1>=count($trace))
        {
            $reportlevel=count($trace)-2;
        }

        $function=$trace[$reportlevel+1][ 'function' ];
        $file=$trace[$reportlevel][ 'file' ];
        $line=$trace[$reportlevel][ 'line' ];

        if (is_array($msg))
        {
            $msg=var_export($msg,TRUE);
        }

        $msg=preg_replace('/\n/',"<BR>",$msg);


        $trace=debug_backtrace();
        $msgs=array();

        $maxlevel=$this->Max($reportlevel,$this->BackTraceLevel);
        for ($level=1;$level<=$maxlevel;$level++)
        {
            array_push
            (
               $msgs,
               $this->B
               (
                  $this->I
                  (
                     $trace[ $level+1 ][ 'class' ]." (".
                     $trace[ $level ][ 'function' ].", ".
                     $trace[ $level ][ 'file' ]." l. ".
                     $trace[ $level ][ 'line' ].")"
                  )
                )
            );
        }

        array_push
        (
           $msgs,
           "<B>".$this->ModuleName."</B>, ".
           "<U>".$this->SqlTableName()."</U>: ".$msg
        );
        global $HtmlMessages;
        array_push($HtmlMessages,join("<BR>",$msgs));
    }

    function AddMsg($msg="",$reportlevel=3,$always=FALSE,$callstack=FALSE)
    {
        if ($this->Debug>0 || $always)
        {
            $this->MakeMsg($msg,$reportlevel);

            if ($callstack) { $this-> ShowCallStack(); }
        }
    }

    function ShowCallStack($parm=FALSE)
    {
        $debug=$this->Debug;

        $text=debug_backtrace($parm);
        array_shift($text);

        $this->AddMsg($text);

        $this->Debug=$debug;

        return $text;
    }

    function WriteHtmlMessages()
    {
        global $HtmlMessages;
        $text=""; 
        if (count($HtmlMessages)>0)
        {
            $table=array();
            for ($n=0;$n<count($HtmlMessages);$n++)
            {
                array_push($table,array($n+1,$HtmlMessages[ $n ]));
            }

            $text.= 
                "      <HR WIDTH='100%'>\n".
                "<DIV CLASS='messages'>\n".
                $this->H(4,"Mensagens gerado durante a execu&ccedil;&atilde;o:").
                $this->HTMLTable("",$table).
                "</DIV>\n".
                "      <HR WIDTH='100%'>\n".
                "";
        }

        return $text;
    }
}
?>