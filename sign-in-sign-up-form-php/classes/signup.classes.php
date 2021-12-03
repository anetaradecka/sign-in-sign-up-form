<?php

// Tutaj będziemy zmieniać coś w bazie danych - model

class Signup extends Dbh {
    /* extends oznacza, że chcemy korzystać z metod lub właściwości tej klasy 
    - w tym przypadku chcemy korzystać z połączenia z bazą danych */
    protected function setUser($uid, $pwd, $email) {
        // Tutaj ustawiamy zalogowanego użytkownika, więc próbujemy "ustawić"dane w bazie danych (a nie wyciągnąć z niej jak w funkcji checkUser)
        $stmt = $this->connect()->prepare('INSERT INTO users (users_uid, users_pwd, users_email) VALUES (?, ?, ?);');
        
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        if(!$stmt->execute(array($uid, $hashedPwd, $email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed"); // redirect to the index page
            exit();
        }

        $stmt = null;
    }

    protected function checkUser($uid, $email) {
        // korzystamy tu de facto z metody klasy Dbh: $this->connect()
        // Przygotowanie zapytania do bazy danych 
        $stmt = $this->connect()->prepare('SELECT users_uid FROM users WHERE users_uid = ? OR users_email = ?;');
        // znak zapytania działa tu jak placeholder dla tego co wpiszemy w funkcji execute(),
        // w ten sposób oddzielamy dane od query i zapobiegamy SQL injection
        if(!$stmt->execute(array($uid, $email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed"); // redirect to the index page
            exit();
        }

        if($stmt->rowCount() > 0) {
            return false;
        }
        else 
        {
            return true;
        }
    }


}