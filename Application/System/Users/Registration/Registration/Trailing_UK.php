            $this->HtmlTable
            (
               "",
               array
               (
                  "If you're not receiving the messages send by the system, please: ".
                  "verify your Spam Mailbox. If you find messages sent by the system in your there, ".
                  "please identify these as 'Non Spam'.".
                  $this->HtmlList
                  (
                     array
                     (
                        "Verify your Spam Mailbox!!",
                        "If you find messages sent by the system in your there, please identify these as 'Non Spam'.",
                        $this->Htmls_Text($this->MyActions_Entry("Confirm")),
                        $this->Htmls_Text($this->MyActions_Entry("ResendConfirm")),
                     )
                  ).
                  "",
               )
            ).
            "";
