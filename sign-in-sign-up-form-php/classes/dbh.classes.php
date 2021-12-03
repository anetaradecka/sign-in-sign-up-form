<?php

// Tutaj będziemy zmieniać coś w bazie danych

class Dbh {

    protected function connect() {
        try {
            $username = "anetarad_HomeBudgetAdmin";
            $password = "Fafanka94!";
            $dbh = new PDO('mysql:host=cl12.netmark.pl;dbname=anetarad_sign-in-sign-up-form', $username, $password);
            return $dbh;
        }
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

}