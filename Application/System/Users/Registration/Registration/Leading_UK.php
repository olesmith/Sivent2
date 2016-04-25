            $this->HtmlTable
            (
               "",
               array
               (
                  "In order to register users, we need some data:".
                  $this->HtmlList
                  (
                     array
                     (
                        "Your Name - as it should be known in any Inscriptions and/or Certificates submitted within the system.",
                        "Your Email - will be used as your user name (login) by the system.",
                        "A Password for authentication."
                     )
                  ).
                  "The informed email, must be ".$this->I("valid")." and controlled by you ".
                  "- this will be confirmed by the system, sending you a message ".
                  "containingo:".
                  $this->HtmlList
                  (
                     array
                     (
                        "Confirm Code.",
                        "Direct link to the Confirm Form."
                     )
                  ).
                  ""
                  ,
               )
            );
