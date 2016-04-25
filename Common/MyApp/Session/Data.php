            array
            (
              "ID" => array
               (
                  "Name"   => "ID",
                  "Sql"    => "INT NOT NULL PRIMARY KEY AUTO_INCREMENT",
                  "Public" => "0",
                  "Person" => "0",
                  "Admin"  => "1",
               ),
               "Login" => array
               (
                  "Name"   => "Login",
                  "Sql"    => "VARCHAR(55)",
                  "Public" => "0",
                  "Person" => "0",
                  "Admin"  => "1",
               ),
               "LoginID" => array
               (
                  "Name"   => "Login ID",
                  "Sql"    => "INT",
                  "Public" => "0",
                  "Person" => "0",
                  "Admin"  => "1",
               ),
               "LoginName" => array
               (
                  "Name"   => "Nome",
                  "Sql"    => "VARCHAR(255)",
                  "Public" => "0",
                  "Person" => "0",
                  "Admin"  => "1",
               ),
               "SID" => array
               (
                  "Name"   => "Login",
                  "Sql"    => "VARCHAR(55)",
                  "Public" => "0",
                  "Person" => "0",
                  "Admin"  => "1",
               ),
               "IP" => array
               (
                  "Name"   => "Login",
                  "Sql"    => "VARCHAR(55)",
                  "Public" => "0",
                  "Person" => "0",
                  "Admin"  => "1",
               ),
               "CTime" => array
               (
                  "Name" => "Início da Sessão",
                  "Sql" => "INT",
                  "Public" => "0",
                  "Person" => "0",
                  "Admin" => "1",
               ),
               "ATime" => array
               (
                  "Name"   => "Último Autenticação",
                  "Sql"    => "INT",
                  "Public" => "0",
                  "Person" => "0",
                  "Admin"  => "1",
               ),
               "Authenticated" => array
               (
                  "Name"   => "Autenticado",
                  "Sql"    => "ENUM",
                  "Values" => array("Não","Sim"),
                  "Public" => "0",
                  "Person" => "0",
                  "Admin"  => "1",
               ),
               "LastAuthenticationAttempt" => array
               (
                  "Name"     => "Última Autenticação Falhado",
                  "Sql"      => "INT",
                  "TimeType" => 1,
                  "Public"   => "0",
                  "Person"   => "0",
                  "Admin"    => "1",
               ),
               "LastAuthenticationSuccess" => array
               (
                  "Name"     => "Última Autenticão com Êxito",
                  "Sql"      => "INT",
                  "TimeType" => 1,
                  "Public"   => "0",
                  "Person"   => "0",
                  "Admin"    => "1",
               ),
               "NAuthenticationAttempts" => array
               (
                  "Name"     => "Nº de Tentativas",
                  "Sql"      => "INT",
                  "TimeType" => 1,
                  "Public"   => "0",
                  "Person"   => "0",
                  "Admin"    => "1",
               ),
               "SULoginID" => array
               (
                  "Name"   => "SU'ed Login ID",
                  "Sql"    => "INT",
                  "Public" => "0",
                  "Person" => "0",
                  "Admin"  => "1",
               ),
        );