            $this->HtmlTable
            (
               "",
               array
               (
                  "Se você já recebeu seu Código de Confirmação, acesse ".
                  $this->Htmls_Text($this->MyActions_Entry("Confirm",array())).
                  " para efetuar a confirmação.\n".
                  "Se você não recebeu o email com o Código de Confirmação: ".
                  $this->HtmlList
                  (
                     array
                     (
                        "Verifique sua Caixa 'Spam'.",
                        "Caso encontra os emails do sistema aqui,\n".
                        "por favor, marque como 'Não Spam', para receber futuros emails enviado pelo sistema.",
                     )
                  )
               )
            );
