<?php

trait CallStack
{
      //*
    //* function CallStack_Caller, Parameter list: $level=1,$parm=FALSE
    //*
    //* Shows call stack.
    //*

    function CallStack_Caller($level=1,$parm=FALSE)
    {
        $trace=debug_backtrace($parm);
        if (!empty($trace[ $level ])) { return $trace[ $level ]; }

        return array("Invalid level: ".$level);
    }

    
    //*
    //* function CallStack_Show, Parameter list: $msg,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array()
    //*
    //* Shows call stack.
    //*

    function CallStack_Show($parm=FALSE)
    {
        $trace=debug_backtrace($parm);
        for ($n=0;$n<count($trace);$n++)
        {
            if (!empty($trace[$n][ 'object' ]))
            {
                $trace[$n][ 'object' ]=get_class($trace[$n][ 'object' ]);
            }
            else
            {
                $trace[$n][ 'object' ]="-";
            }
            $trace[$n][ 'args' ]="";
        }

        $callerlevel=$this->CallStack_Caller_Find($trace);
        $caller=$this->CallStack_Trace_Table($callerlevel,$trace);

        $table=array();

        array_push($table,$this->CallStack_Trace_TitleRow($trace));

        for ($level=$callerlevel;$level<count($trace);$level++)
        {
            array_push($table,$this->CallStack_Trace_Row($level,$trace));
        }

        array_unshift($table,$this->H(3,"CallStack".$callerlevel));

        echo $this->HtmlTable("",$table);
    }

    //*
    //* function CallStack_Trace_Table, Parameter list: $level,$trace
    //*
    //* Shows $caller hash.
    //*

    function CallStack_Trace_Table($level,$trace)
    {
        $table=array($this->H(3,"Caller info:"));
        foreach ($trace[ $level ] as $key => $value)
        {
            array_push
            (
               $table,
               array($key.":",$value)
            );
        }

        $table=array_merge
        (
           $table,
           $this->CallStack_Trace_ClassTrait_Rows($level,$trace)
        );

        echo 
            $this->HtmlTable("",$table);
    }

    //*
    //* function CallStack_Trace_Row, Parameter list: $level,$trace
    //*
    //* Returns row with call stack info for $level.
    //*

    function CallStack_Trace_Row($level,$trace)
    {
        $row=array($level);
        foreach ($trace[ $level ] as $key => $value)
        {
            array_push($row,$value);
        }

        $rows=$this->CallStack_Trace_ClassTrait_Rows($level,$trace);
        foreach (array_keys($rows) as $id)
        {
            array_shift($rows[ $id ]);
            $rows[ $id ]=join(", ",$rows[ $id ]);
        }

        array_push($row,join(", ",$rows));

        $msg="";
        if (!empty($trace[ $level ][ 'file' ]))
        {
           if (preg_match('/(Base|MySql2)/',$trace[ $level ][ 'file' ]))
            {
                $msg="Move to Common!";
            }
        }
        array_push($row,$msg);


        return $row;
    }
    //*
    //* function CallStack_Trace_TitleRow, Parameter list: $trace
    //*
    //* Returns call stack title row.
    //*

    function CallStack_Trace_TitleRow($trace)
    {
        $row=array("No.");
        foreach (array_keys($trace) as $level)
        {
            foreach ($trace[ $level ] as $key => $value)
            {
                array_push($row,$key);
            }
            break;
       }

        array_push($row,"Class/Trait");

        return $row;
    }

    //*
    //* function CallStack_Trace_ClassTrait_Rows, Parameter list: $level,$trace
    //*
    //* Shows $caller hash.
    //*

    function CallStack_Trace_ClassTrait_Rows($level,$trace)
    {
        if ($level>0)
        {
            $trace[ $level ][ 'file' ]=$trace[ $level-1 ][ 'file' ];
        }

        $classes=array();
        $traits=array();
        foreach ($this->MyFile_Read($trace[ $level ][ 'file' ],'(class|trait)\s') as $line)
        {
            if (preg_match('/(class|trait)\s+(\S+)/',$line,$matches))
            {
                if ($matches[1]=="class") { array_push($classes,$line); break; }
                if ($matches[1]=="trait") { array_push($traits, $line);  break;  }
            }

        }

        $inforows=array();
        if (count($classes)>0)
        {
            array_push
            (
               $inforows,
               array
               (
                  "Class:",
                  join(", ",$classes)
               )
            );
        }

        if (count($traits)>0)
        {
            array_push
            (
               $inforows,
               array
               (
                  "Trait:",
                  join(", ",$traits)
               )
            );
        }

        return $inforows;
    }


    //*
    //* function CallStack_FindCaller, Parameter list: $trace
    //*
    //* Locates calling $trace entry.
    //*

    function CallStack_Caller_Find($trace)
    {
        //return 4;
        for ($level=0;$level<count($trace);$level++)
        {
            if (
                  preg_match('/^(MyMessage|CallStack)$/',$trace[ $level  ][ 'class' ])
                  ||
                  preg_match('/^Warn/',$trace[ $level  ][ 'function' ])
                  ||
                  preg_match('/^CallStack_Show/',$trace[ $level  ][ 'function' ])
               )
            {
                continue;
            }

            return $level;
        }
    }
}

?>