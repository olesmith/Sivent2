            $this->HtmlTable
            (
               "",
               array
               (
                  "Para cadastrar usuários, precisamos recolher alguns dados:".
                  $this->HtmlList
                  (
                     array
                     (
                        "Seu Nome - como sairá em certificados emetidos pelo sistema.",
                        "Seu email - sendo utilizado como seu nome de usuário (login) no sistema.",
                        "Uma senha para autenticação."
                     )
                  ),
                  "O email informado, deve ser ".$this->I("válido")." e sobre seu controle ".
                  "- o que será confirmado através do envio de uma mensagem para o email ".
                  "informado, contendo:".
                  $this->HtmlList
                  (
                     array
                     (
                        "O Código de Confirmação.",
                        "Link direto para Confirmação nesse formulário."
                     )
                  ),
                  ""
                  ,
               )
            );
