            $this->HtmlTable
            (
               "",
               array
               (
                  "#ApplicationName é um #ApplicationDescription. ".
                  "É preciso cadastrar-se uma vez só. ".
                  "Após o cadastro inicial, é possivel inscrever-se em editais divulgados no sistema.",

                  "Roteiro do Cadastramento:".
                  $this->HtmlList
                  (
                     array
                     (
                         "Cadastro Inicial: ".$this->Htmls_Text($this->MyActions_Entry("Register")),
                         "Confirmar Cadastro: ".$this->Htmls_Text($this->MyActions_Entry("Confirm")),
                        "Efetuar Login no sistema: ".
                        preg_replace
                        (
                           '/ModuleName=Friends&/',
                           "",
                           $this->Htmls_Text($this->MyActions_Entry("Logon"))
                        ),
                        "Inscrever-se em eventos  gerenciado pelo #ApplicationName..."
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
