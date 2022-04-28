<?php

class Connection
{
    public function connectToDatabase()
    {
        $connection = new mysqli("localhost", "root", "", "site");

        if (mysqli_connect_errno()) {
            $error['error'] = "failed to connect database";
            echo json_encode($error);
            die();
        }

        $connection->set_charset("utf8");
        mysqli_set_charset($connection, "utf8");

        return $connection;
    }
}
