echo
            $this->HtmlTable
            (
               "",
               array
               (
                  "SiPOS é um Sistema para Gerenciamento de inscrições para editais com avaliação dos candidatos, ".
                  "por exemplo inscrição online em cursos de posgraduação.".
                  "É preciso cadastrar-se uma vez só. ".
                  "Apos o cadastro inicial, é possivel inscrever-se nos eventos gerenciado pelo sistema.",
               ),
               $options
            ).
            "<P></P>".
            $this->H(2,"Cadastro Inicial").
            $this->HtmlTable
            (
               "",
               array
               (
                  "Antes de fazer inscrição em qualquer processo seletivo, é preciso fazer seu cadastro inicial. ".
                  "Se você ainda não está cadastrado no sistema, acesse: ".
                  $this->MyActions_Entry("Register",array()).
                  ", para iniciar seu cadastro.",
               ),
               $options
            ).
            "<P></P>".
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
                  ).
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
                  ).
                  ""
                  ,
               ),
               $options
            );
