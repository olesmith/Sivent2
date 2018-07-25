            $this->HtmlTable
            (
               "",
               array
               (
                  "If you have already received your Confirmation Code, access ".
                  $this->Htmls_Text($this->MyActions_Entry("Confirm",array())).
                  " in order to confirm your registrationo.\n".
                  "If you have not received your Confirmation Code: ".
                  $this->HtmlList
                  (
                     array
                     (
                        "Verify your 'Spam' Inbox.",
                        "If you should find any messages send by the system there,\n".
                        "please, mark them as 'Not Spam', in order to receive future messages sent by the system.",
                     )
                  )
                  ,
               )
            ).
             //"<P></P>".
            "";
