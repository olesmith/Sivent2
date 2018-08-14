            $this->HtmlTable
            (
               "",
               array
               (
                  "#ApplicationName is a #ApplicationDescription_UK. ".
                  "You'll only need to register once only. ".
                  "After this preliminary registration, you will have access to inscriptions managed by the system.",

                  "Outline of the Registration Process:".
                  $this->HtmlList
                  (
                     array
                     (
                         "Initial Registration: ".$this->Htmls_Text($this->MyActions_Entry("Register")),
                         "Confirm Registration: ".$this->Htmls_Text($this->MyActions_Entry("Confirm")),
                        "Login: ".
                        preg_replace
                        (
                           '/ModuleName=Friends&/',
                           "",
                           $this->Htmls_Text($this->MyActions_Entry("Logon"))
                        ),
                        "Inscribe to inscriptions manage by #ApplicationName..."
                      ),
                     "OL"
                  ),
               ),
               array
               (
                  'ALIGN' => 'center',
                  'WIDTH' => '80%',
                  'CLASS' => 'content inactiveinfo',
               )
             ).
            "\n<P></P>\n";
