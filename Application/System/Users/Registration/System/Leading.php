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
                        "Cadastro Inicial: ".$this->MyActions_Entry("Register"),
                        "Confirmar Cadastro: ".$this->MyActions_Entry("Confirm"),
                        "Efetuar Login no sistema: ".
                        preg_replace
                        (
                           '/ModuleName=Friends&/',
                           "",
                           $this->MyActions_Entry("Logon")
                        ),
                        "Inscrever-se em eventos  gerenciado pelo #ApplicationName..."
                      ),
                     "OL"
                  ),
               ),
               array
               (
                  'ALIGN' => 'center',
                  'WIDTH' => '60%',
                  'CLASS' => 'inactiveinfo',
               )
             ).
            "\n<P></P>\n";
