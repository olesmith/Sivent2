<?php

class ApplMsgs extends Setup
{
    function DeliverMessage($userid,$priority,$subject,$message)
    {
        $mtime=time();

        $message=array
        (
           "Recipient" => $userid,
           "Sender" => $this->LoginData[ "ID" ],
           "Status" => 1,
           "Priority" => $priority,
           "Subject" => $subject,
           "Message" => preg_replace('/\n/',"<BR>\n",$message),
           "CTime" => $mtime,
           "ATime" => $mtime,
           "MTime" => $mtime,
        );

        $this->MySqlInsertItem
        (
           "Messages",
           $message
        );
    }

    function DeliverMessages($userids,$priority,$subject,$message)
    {
        foreach ($userids as $userid)
        {
            $this->DeliverMessage($userid,$priority,$subject,$message);
        }
    }
}
?>