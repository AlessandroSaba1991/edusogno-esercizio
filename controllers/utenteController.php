<?php
include __DIR__ . '/../models/utente.php';
include __DIR__ . '/../config.php';

class UtenteController
{
    public static function save($data)
    {
        $new_utente = new Utente($data['nome'], $data['cognome'], $data['email'], $data['password']);
        $query = "INSERT INTO `utenti` (`nome`, `cognome`, `email`, `password`) VALUES ('$new_utente->nome','$new_utente->cognome','$new_utente->email','$new_utente->password')";
        MysqliService::request($query, 'INSERT');
        return true;
    }
    public static function autorize($email, $password)
    {
        $query = "SELECT `email`, `password`,`nome` FROM `utenti` WHERE `email` = '$email'";
        $response = MysqliService::request($query, 'SELECT');

        if (!$response) {
            $result = 'Email errata';
            return $result;
        }

        $result = $response->fetch_object();
        if ($result->password !== $password) {
            $result = 'Password sbagliata';
        }
        return $result;
    }
    public static function events($email)
    {
        $query = "SELECT * FROM `eventi` WHERE `attendees` LIKE '%$email%'";
        $response = MysqliService::request($query, 'SELECT');
        if ($response->num_rows <= 0) {
            return false;
        }
        return $response;
    }
    public static function resetPassword($email, $password)
    {
        $query = "SELECT `email`, `password`,`nome`,`cognome` FROM `utenti` WHERE `email` = '$email'";
        $response = MysqliService::request($query, 'SELECT');

        if (!$response) {
            $result = 'Email non esiste';
            return $result;
        }
        $query = "UPDATE `utenti` SET `password` = '$password' WHERE `email` = '$email'";
        MysqliService::request($query, 'UPDATE');
        return true;
    }
};

/* $message =
    "<html>
<head>
    <title>Reset Password</title>
</head>
<body>
        <h1 style=\"text-align: center; margin-bottom: 2rem\">Ciao '$data->nome' '$data->cognome'</h1>
        <p style=\"text-align: center;\">Ecco il link per resettare la tua password <a href=\"http://localhost/PHP/edusogno-esercizio/reset-password.php?email='$data->email'\">Clicca qui</a></p>
</body>
</html>";
 */

/* EmailService::sendEmail($data->email,$message); */