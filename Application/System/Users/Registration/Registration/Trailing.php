            $this->HtmlTable
            (
               "",
               array
               (
                  "Se você não está recebendo as mensagens enviado pelo sistema, por favor: ".
                  "verifique sua Caixa de Spam. Caso encontrar mensagens do sistema na Caixa de Spam, ".
                  "por favor identifique as mensagens como 'Não Spam'.".
                  $this->HtmlList
                  (
                     array
                     (
                        "Verifique sua Caixa de Spam!!",
                        "Caso encontrar mensagens do sistema na Caixa de Spam, identifique estas como 'Não Spam'.",
                        $this->Htmls_Text($this->MyActions_Entry("Confirm")),
                        $this->Htmls_Text($this->MyActions_Entry("ResendConfirm")),
                     )
                  ).
                  "",
               )
            ).
            "";
