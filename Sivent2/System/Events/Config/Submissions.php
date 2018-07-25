"Submissions" => array
(
    "Active_Var"   => "Submissions",
    "Active_Value" => 2,
    "Title" => array
    (
        "Name" => "Submissões & Avaliações",
        "Name_ES" => "Submissónes & Avaliaciónes",
        "Name_UK" => "Submissions & Assessments",
    ),
    "Text" => array
    (
        "Name" =>
        "Para incluir submissões, ative 'Atividades' nos dados a baixo.".
        $this->HtmlList
        (
            array
            (
                "Se quisser liberar inscriçoes de trabalhos no sistema, ative também 'Com Inscrições'.",
                "Lembre-se de definir as datas Início e Fim.",
                "Ative Anais para incluir captura de LaTeX.".
                "se ativar 'Atividades Publicadas'.",
                "As submissões serão publicadas pelo sistema, se ativar 'Atividades Publicadas'.",
                "Precisa-se definir pelo menos uma Área de Interesse, veja os módulos abaixo.",
                "Caso de seja efeturar Avaliação dos trabalhos submetidos, precisa-se definir:".
                "Critérios de Avaliação e em seguida, Avaliadores. Os avaliadores precisam ser usuários cadastrods no sistema."
            )
        ).

        "",

        
        "Name_ES" => "Configuración de Submissónes",
        "Name_UK" => "Submissions",
    ),
    "Modules" => array
    (
        "Areas" => array
        (
            "Text" => "Trilhas",
            "Text_ES" => "Trillas",
            "Text_UK" => "Areas of Interest",
        ),
        "Criterias" => array
        (
            "Text" => "Critérias",
            "Text_ES" => "Critérias",
            "Text_UK" => "Criterias",
        ),
        "Assessors" => array
        (
            "Text" => "Avaliadores",
            "Text_ES" => "Avaliadores",
            "Text_UK" => "Assessors",
        ),
        "Assessments" => array
        (
            "Text" => "Avaliações",
            "Text_ES" => "Avaliaciónes",
            "Text_UK" => "Assessments",
        ),
    ),
    "Datas" => array
    (
        "Submissions",
    ),
    "Groups" => array
    (
        array
        (
            "Submissions" => 1,
        ),
    ),
),

       