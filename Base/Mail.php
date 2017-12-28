<?php

global $ClassList;
array_push($ClassList,"Mail");

/* if (is_file("../class.phpmailer.php")) */
/* { */
/*     include_once("../class.phpmailer.php"); */
/* } */
/* else */
/* { */
/*     include_once("../../class.phpmailer.php"); */
/* } */

global $MailInfoTitles;
$MailInfoTitles=array
(
   "To" => "Para",
   "CC" => "Cópia Carbono, CC",
   "BCC" => "Cópia Carbono Oculto, CCO",
   "ReplyTo" => "Responder Para",
);

class Mail extends Zip
{
    var $AdmEmail,$CCEmail,$FromName,$EmailPassword;
    var $MailInfo=array();
    var $EmailMessage;
    var $MailDataMessages="Mail.php";
    var $EmailsToSend=array();

    function Mail()
    {
    }

    function InitMail($hash=array())
    {
        $this->MailInfo=$hash;
    }

  //*
  //* function IsValidMailAddress, Parameter list: $email
  //*
  //* Checks if $email is a valid email address: \S+@\S+.
  //*

  function IsValidMailAddress($email)
  {
      if (preg_match('/^\S+@\S+$/',$email)) { return TRUE; }

      return FALSE;
  }


  //*
  //* function SendMMail, Parameter list: $to,$subject,$body
  //*
  //* Wraps the mail sending. Traditional way (our mailserver)
  //* 
  //*

  function SendMMail($to,$subject,$body)
  {
      $headers=$this->GetMMailHeaders();

      $body.=
         "\n\n#################################################\n".
         $this->GetMessage($this->MailDataMessages,"MailTrailer")." ".
         $this->CompanyHash[ "AdmEmail" ]."\n".
         "#################################################";

      return mail($to,$subject,$body,$headers);
  }

  //*
  //* function AddGMail, Parameter list: $to,$subject,$body
  //*
  //* Adds an email to the mai queue, $this->EmailsToSend.
  //* 
  //*

  function AddGMail($to,$subject,$body,$cc="",$bcc="",$attachments=array())
  {
      array_push
      (
         $this->EmailsToSend,
         array
         (
            "To" => $to,
            "Subject" => $subject,
            "Body" => $body,
            "CC" => $cc,
            "BCC" => $bcc,
            "Attachments" => $attachments,
         )
      );
  }

  //*
  //* function SendGMails, Parameter list: $to,$subject,$body
  //*
  //* Sends the mail queue, $this->EmailsToSend.
  //* 
  //*

  function SendGMails()
  {
      foreach ($this->EmailsToSend as $id => $email)
      {
          $this->SendGMail
          (
             $email[ "To" ],
             $email[ "Subject" ],
             $email[ "Body" ],
             $email[ "CC" ],
             $email[ "BCC" ],
             $email[ "Attachments" ]
          );
      }
  }


  //*
  //* function SendGMail, Parameter list: $to,$subject,$body
  //*
  //* Wraps the mail sending. Uses logon to GMail.
  //* 
  //*

  function SendGMail($to,$subject,$body,$cc="",$bcc="",$replyto="",$attachments=array(),$nostatus=FALSE)
  {
      if (empty($to)) { return FALSE; }

      $subject=$this->FilterHash($subject,$this->CompanyHash);
      $body=$this->FilterHash($body,$this->CompanyHash);

      $obj=$this;
      if (!empty($this->ApplicationObj))
      {
          $obj=$this->ApplicationObj;
      }

      $unit=array();
      $depkey="Institution";
      if (!empty($obj->UnitHash))
      {
          $depkey="Name";
          $unit=$obj->UnitHash;
      }
      elseif (!empty($obj->Unit))
      {
          $depkey="Name";
          $unit=$obj->Unit;
      }
      elseif (!empty($obj->CompanyHash))
      {
          $depkey="Name";
          $unit=$obj->CompanyHash;
      }
      elseif (!empty($obj->MailInfo))
      {
          $depkey="Name";
          $unit=$obj->MailInfo;
      }

      $obj->MailInfo=$unit;

      $body.=
         "<BR><BR>\n".
          $this->TimeStamp2Text().
         "<BR><BR>\n".
         "###########################################################\n".
          $this->GetMessage($this->MailDataMessages,"MailTrailer")."\n".
          $this->GetMessage($this->MailDataMessages,"MailTrailer_UK")."\n".
          $unit[ $depkey ].", ".
          $this->CompanyHash[ "Institution" ]."\n".
          $unit[ "Address" ]."\n".
          "Email: ".$unit[ "Email" ]."\n".
          "###########################################################";

      $subject  =$this->Html2Text($subject);  
      $subject  =   utf8_decode($subject);  
      $body  =   $this->Html2Text($body);
      $body  =   utf8_decode($body);  

      $body=preg_replace('/\n/',"<BR>\n",$body);

      $password="";
      if (!empty($obj->MailInfo[ "EmailPassword" ]))
      {
          $password=$obj->MailInfo[ "EmailPassword" ];
      }

      if (!empty($obj->MailInfo[ "AdmEmailPassword" ]))
      {
          $password=$obj->MailInfo[ "AdmEmailPassword" ];
      }

      if (empty($obj->MailInfo[ "AdmEmail" ])) { return FALSE; }

      $mail = new PHPMailer;

      $mail->IsSMTP(); 
      $mail->SMTPAuth   = true;  
      $mail->SMTPSecure = "ssl";  
      $mail->Port       = 465;  
      $mail->Host       = "smtp.gmail.com";
      $mail->Username =  $obj->MailInfo[ "AdmEmail" ];  
      $mail->Password =  $password;

      $this->SetGMailHeaders
      (
         $mail,
         $to,
         $obj->MailInfo[ "AdmEmail" ],
         $obj->MailInfo[ "FromName" ],
         $subject,
         $obj->MailInfo[ "CCEmail" ]
       );

      $mail->Body = $body;  
      $mail->AltBody = $mail->Body;

      foreach ($attachments as $id => $attachment)
      {
          $this->AddAttachment($mail,$attachment);
      }
   
      $sent=FALSE;
      $sent= $mail->Send();
      if ($sent)
      {
          if (!$nostatus)
          {
              $msg=$this->GetMessage($this->MailDataMessages,"MailOKMessage");
              $msg=preg_replace('/#to/',$to,$msg);
              $this->EmailMessage=$msg;
          }

          return TRUE;
      }
      else
      {
          $this->EmailMessage=$this->GetMessage($this->MailDataMessages,"MailErrorMessage").
              "'$to': $sent ".$obj->MailInfo[ "AdmEmail" ];
          return FALSE;  
      }
  }


  //*
  //* function GetMMailHeaders, Parameter list: $admemail
  //*
  //* Returns the standardized headers.
  //* 
  //*

    function GetMMailHeaders()
    {
      return "From: "    .$this->CompanyHash[ "AdmEmail" ]."\r\n".
             "Reply-To: ".$this->CompanyHash[ "AdmEmail" ]."\r\n".
             "Content-type: text/plain; charset=utf-8" . "\r\n". 
             "X-Mailer: PHP/".phpversion()."\r\n";
    }

    //*
    //* function SetMailHeaders, Parameter list: $admemail
    //*
    //* Returns the standardized headers.
    //* 
    //*

    function SetGMailHeaders($mail,$to,$from,$fromname,$subject,$cc="",$bcc="")
    {
        $mail->ContentType="text/html; charset=utf-8";

        $mail->Subject  =   $subject;  
   
        //Preenchimento do campo FROM do e-mail  
        $mail->From = $from;  
        $mail->FromName = $fromname;  
   
        //E-mail para a qual o e-mail será enviado

        $tos=preg_split('/\s*[,;]\s*/',$to);
        foreach ($tos as $id =>$rto)
        {
            $mail->AddAddress($rto);
        }

        if ($cc=="") { $cc=$from; }

        $tos=preg_split('/\s*,\s*/',$cc);
        foreach ($tos as $id =>$rto)
        {
            $mail->AddAddress($rto);
        }

        return;
    }

  //*
  //* function AddAttachment, Parameter list: $mail,$file
  //*
  //* Adds $file as attachment; $file must exist.
  //* 
  //*

  function AddAttachment($mail,$file)
  {
      $comps=preg_split('/\//',$file);
      $rfile=$comps[ count($comps)-1 ];

      return $mail->AddAttachment($file,$rfile);

  }

  //*
  //* function SendMail, Parameter list: $to,$subject,$body
  //*
  //* Wraps the mail sending.
  //* 
  //*

  function SendMail($to,$subject,$body)
  {
      return $this->SendGMail($to,$subject,$body,$headers);
  }

  //*
  //* function GetMailFile, Parameter list: $file,$filterhash=array()
  //*
  //* Returns contents of mail file, $file, filtered by $filterhash.
  //* 

  function GetMailFile($file,$filterhash=array())
  {
      $text=join("",$this->MyReadFile($file));
      $text=$this->FilterHash($text,$filterhash);
      $text=$this->Filter($text);

      return $text;
  }

  //*
  //* function FilterMailText, Parameter list: $file,$hash
  //*
  //* Filters contents of $file over $hash.
  //* 

  function FilterMailText($text,$hash)
  {
      $text=$this->FilterHash($text,$hash);
      $text=$this->FilterHash($text,$this->CompanyHash);
      $text=$this->Filter($text);

      return $text;
  }

  //*
  //* function GetMailHead, Parameter list: $filterhash1=array(),$filterhash2=array()
  //*
  //* Returns mail head filtered over $filterhash1 and $filterhash2.
  //* 

  function GetMailHead($filterhash1=array(),$filterhash2=array())
  {
      $file="System/Mail/Head.txt";
      $language=$this->GetCGIVarValue("Lang");
      if ($language!="")
      {
          $rfile="Mail/Head.".$language.".txt";
          if (file_exists($rfile))
          {
              $file=$rfile;
          }
      }

      $text=join("",$this->MyReadFile($file));

      $text=$this->FilterHash($text,$filterhash1);
      $text=$this->FilterHash($text,$filterhash2);

      $text=$this->Filter($text);

      return $text;
  }

  //*
  //* function GetMailTail, Parameter list: $filterhash1=array(),$filterhash2=array()
  //*
  //* Returns mail tail filtered over $filterhash1 and $filterhash2.
  //* 

  function GetMailTail($filterhash1=array(),$filterhash2=array())
  {
      $file="System/Mail/Tail.txt";
      $language=$this->GetCGIVarValue("Lang");
      if ($language!="")
      {
          $rfile="Mail/Tail.".$language.".txt";
          if (file_exists($rfile))
          {
              $file=$rfile;
          }
      }

      $text=join("",$this->MyReadFile($file));

      $text=$this->FilterHash($text,$filterhash1);
      $text=$this->FilterHash($text,$filterhash2);
      $text=$this->Filter($text);

      return $text;
  }

  //*
  //* function GetMailBody, Parameter list: $mailskel,$filterhash1=array(),$filterhash2=array()
  //*
  //* Returns mail body var $mailskel filtered over $filterhash1 and $filterhash2.
  //* 

  function GetMailBody($mailskel,$filterhash1=array(),$filterhash2=array())
  {
      if (is_array($this->MailInfo))
      {
        $text=
            $this->GetRealNameKey
            (
               $this->MailInfo[ $mailskel ],
               "Body"
            ).
            "\n\n";
      }
      else
      {
          $file="Mail/".$mailskel.".txt";
          $language=$this->GetCGIVarValue("Lang");
          if ($language!="")
          {
              $rfile="Mail/".$mailskel.".".$language.".txt";
              if (file_exists($rfile))
              {
                  $file=$rfile;
              }
          }

          $text=join("",$this->MyReadFile($file));
      }

      if ($text=="") { $text=$mailskel; }

      $text=$this->FilterHash($text,$filterhash1);
      $text=$this->FilterHash($text,$filterhash2);

      $text=$this->Filter($text);

      return $text;
  }

  function RecipientField($key,$mailinfo)
  {
      $input="";
      if (!is_array($mailinfo[ $key ]))
      {
          $input=$this->MakeInput($key,$mailinfo[ $key ],75);
      }
      elseif (count($mailinfo[ $key ])==1)
      {
          $input=$this->MakeInput($key,join(",\n",$mailinfo[ $key ]),75);
      }
      else
      {
          $input=$this->MakeTextArea($key,count($mailinfo[ $key ])-1,75,join(",\n",$mailinfo[ $key ]),'off');
      }

      global $MailInfoTitles;
      return array("<B>".$MailInfoTitles[ $key ].":</B>",$input);
  }

  //*
  //* function SendGMail, Parameter list: $hash
  //*
  //* Wraps the mail sending. Uses logon to GMail.
  //* 
  //*

  function MySendMail($hash)
  {
      return $this->SendGMail
      (
         $hash[ "To" ],
         $hash[ "Subject" ],
         $hash[ "Body" ],
         $hash[ "CC" ],
         $hash[ "BCC" ],
         $hash[ "ReplyTo" ],
         $hash[ "Attachments" ]
      );

      $subject=$this->FilterHash($hash[ "Subject" ],$this->CompanyHash);
      $body=$this->FilterHash($hash[ "Body" ],$this->CompanyHash);

      $obj=$this;
      if (!empty($this->ApplicationObj->MailInfo))
      {
          $obj=$this->ApplicationObj;
      }

      $body.=
         "<BR><BR>\n".
         "#################################################\n".
          $this->GetMessage($this->MailDataMessages,"MailTrailer")." ".
         $this->CompanyHash[ "Email" ]."\n".
         "#################################################";

      $subject  =   utf8_decode($subject);  
      $body  =   utf8_decode($body);  
      $body=preg_replace('/\n/',"<BR>\n",$body);

      $password=$obj->MailInfo[ "EmailPassword" ];
      if (!empty($obj->MailInfo[ "AdmEmailPassword" ]))
      {
          $password=$obj->MailInfo[ "AdmEmailPassword" ];
      }

      $mail = new PHPMailer;

      $mail->IsSMTP(); 
      $mail->SMTPAuth   = true;  
      $mail->SMTPSecure = "ssl";  
      $mail->Port       = 465;  
      $mail->Host       = "smtp.gmail.com";
      $mail->ContentType="text/html; charset=utf-8";
      $mail->Username =  $obj->MailInfo[ "AdmEmail" ];  
      $mail->Password =  $password;


      $mail->Subject  =   $subject;  
      $mail->Body = $body;  
      $mail->AltBody = $mail->Body;

      $mail->From = $this->AdmEmail;  
      $mail->FromName = $this->FromName;

      if ($hash[ "ReplyTo" ]!="")
      {
          $mail->AddReplyTo($hash[ "ReplyTo" ]);
      }
   
      $tos=preg_split('/\s*,\s*/',$hash[ "To" ]);
      foreach ($tos as $id =>$rto)
      {
          if (preg_match('/\S/',$rto))
          {
              $this->AddMsg("Add $rto");
              $mail->AddAddress($rto);
          }
      }

      $tos=preg_split('/\s*,\s*/',$hash[ "CC" ]);
      foreach ($tos as $id =>$rto)
      {
          if (preg_match('/\S/',$rto))
          {
              $this->AddMsg("AddCC $rto");
              $mail->AddCC($rto);
          }
      }

      $tos=preg_split('/\s*,\s*/',$hash[ "BCC" ]);
      foreach ($tos as $id =>$rto)
      {
          if (preg_match('/\S/',$rto))
          {
              $this->AddMsg("AddBCC $rto");
              $mail->AddBCC($rto);
          }
      }

      if (is_array($hash[ "Attachments" ]))
      {
          foreach ($hash[ "Attachments" ] as $id => $attachment)
          {
              $this->AddAttachment($mail,$attachment);
          }
      }
   
      $enviado = $mail->Send();  
   
      if ($enviado)
      {
          $msg=$this->GetMessage($this->MailDataMessages,"MailOKMessage");
          $msg=preg_replace('/#to/',$hash[ "To" ],$msg);
          $this->EmailMessage=$msg;
          return TRUE;
      }
      else
      {
          $this->EmailMessage=
              $this->GetMessage
              (
                 $this->MailDataMessages,
                 "MailErrorMessage"
              ).
              "'".$hash[ "To" ]."': $enviado".$this->FromName;

          return FALSE;  
      }
  }

  function SendMailForm($pretitle,$posttitle,$mailinfo,$id)
  {
          $send=$this->GetPOST("Send");
          $table=array();
          if ($send==1)
          {
              print $this->H(2,$posttitle);

              $mailinfo[ "To" ]=$this->GetPOST("To");
              $mailinfo[ "CC" ]=$this->GetPOST("CC");
              $mailinfo[ "BCC" ]=$this->GetPOST("BCC");
              $mailinfo[ "ReplyTo" ]=$this->GetPOST("ReplyTo");
              $mailinfo[ "Subject" ]=$this->GetPOST("Subject");
              $body=$this->GetPOST("Body");

              $mailinfo[ "Body" ]=$body;

              $body=preg_replace('/\n/',"<BR>\n",$body);
              $mailinfo[ "Head" ]="";
              $mailinfo[ "Tail" ]="";

              $table=array
              (
                 array
                 (
                    "<B>Para:</B>",$mailinfo[ "To" ]
                 ),
                 array
                 (
                    "<B>CC:</B>",$mailinfo[ "CC" ]
                 ),
                 array
                 (
                    "<B>BCC/CCO:</B>",$mailinfo[ "BCC" ]
                 ),
                 array
                 (
                    "<B>Reply-to:</B>",$mailinfo[ "ReplyTo" ]
                 ),
                 array
                 (
                    "<B>Assunto:</B>",$mailinfo[ "Subject" ]
                 ),
                 array
                 (
                    "<B>Mensagem:</B>",
                    $body
                 ),
              );

              for ($n=0;$n<count($mailinfo[ "Attachments" ]);$n++)
              {
                  array_push
                  (
                     $table,
                     array("<B>Attachment No. ".($n+1).":</B>",$mailinfo[ "Links" ][ $n ])
                  );
              }

              $this->MySendMail($mailinfo);

          }
          else
          {
              print $this->H(2,$pretitle);

              $table=array
              (
                 $this->RecipientField("To",$mailinfo),
                 $this->RecipientField("CC",$mailinfo),
                 $this->RecipientField("BCC",$mailinfo),
                 $this->RecipientField("ReplyTo",$mailinfo),
                 array
                 (
                    "<B>Subject:</B>",
                    $this->MakeInput("Subject",$mailinfo[ "Subject" ],50)
                 ),
                 array
                 (
                    "<B>Body:</B>",
                    $this->MakeTextArea
                    (
                       "Body",
                       20,75,
                       $mailinfo[ "Head" ].
                       $mailinfo[ "Body" ].
                       $mailinfo[ "Tail" ]
                    )
                 )
              );

              for ($n=0;$n<count($mailinfo[ "Attachments" ]);$n++)
              {
                  array_push
                  (
                     $table,
                     array
                     (
                        "<B>Attachment No. ".($n+1).":</B>",
                        $mailinfo[ "Links" ][ $n ]
                     )
                  );
              }

              array_push
              (
                 $table,
                 array
                 (
                    $this->Buttons("Enviar","Resetar").
                    $this->MakeHidden("ID",$id).
                    $this->MakeHidden("Send",1)
                 )
              );

              print $this->StartForm();
          }

          print
              $this->HtmlTable
              (
                 "",
                 $table
              );

          if ($send!=1)
          {
              print $this->EndForm();
          }
  }
}
?>