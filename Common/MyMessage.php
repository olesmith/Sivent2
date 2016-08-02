<?php


trait MyMessage
{
    //*
    //* function MyMessage_DebugMessage, Parameter list: $msg
    //*
    //* Shows message and dies.
    //*

    function MyMessage_Message($msg)
    {
        if (is_array($msg))
        {
            $msg=join("<BR>\n",$msg);
        }

        echo "MyMessage@".$this->ModuleName().": ".$msg;
    }

    //*
    //* function MyMessage_DebugMessage, Parameter list: $msg,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array()
    //*
    //* Shows message and dies.
    //*

    function MyMessage_DebugMessage($msg,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array())
    {
        if (is_array($msg))
        {
            $msg=join("<BR>\n",$msg);
        }

        echo "MyMessage@".$this->ModuleName().": ".$msg;

        if (!empty($info1)) { var_dump($info1); }
        if (!empty($info2)) { var_dump($info2); }
        if (!empty($info3)) { var_dump($info3); }
        if (!empty($info4)) { var_dump($info4); }
        if (!empty($info5)) { var_dump($info5); }

        $this->CallStack_Show();
    }

    //*
    //* function MyMessage_Die, Parameter list: $msg,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array()
    //*
    //* Shows message and dies.
    //*

    function MyMessage_Die($msg,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array())
    {
        if (method_exists($this,"MyApp_Interface_Head") && !$this->HeadersSend)
        {
            echo
                $this->MyApp_Interface_Head();
        }

        if (
              empty($this->ApplicationObj()->DBHash)
              ||
              (
                 !empty($this->ApplicationObj()->DBHash[ "Debug" ])
                 &&
                 intval($this->ApplicationObj()->DBHash[ "Debug" ])==2
              )
          )
        {
           $this->MyMessage_DebugMessage($msg,$info1,$info2,$info3,$info4,$info5);
        }
        else
        {
            $this->MyMessage_Message($msg);
        }

        die("<BR>Exiting...");

    }
    
    //*
    //* function MyMessage_Warn, Parameter list: $msg,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array()
    //*
    //* Shows message and returns.
    //*

    function MyMessage_Warn($msg,$info1=array(),$info2=array(),$info3=array(),$info4=array(),$info5=array())
    {
        echo "Warning! ";

        if (!empty($this->ApplicationObj()->DBHash[ "Debug" ]) || empty($this->ApplicationObj()->DBHash))
        {
            $this->MyMessage_DebugMessage($msg,$info1,$info2,$info3,$info4,$info5);
        }
        else
        {
            $this->MyMessage_Message($msg);
        }

        echo "<BR>Ignored...";

    }
}
?>