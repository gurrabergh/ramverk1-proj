<?php

namespace Anax\User;

class UserData
{
    public $di;

    public function getUsers()
    {
        $sql = "SELECT * FROM users;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetchAll($sql);

        return $res;
    }

    public function getProfile($nick)
    {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetch($sql, [$nick]);

        return $res;
    }

    public function getUser($nick)
    {
        $sql = "SELECT * FROM users WHERE nick = ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetch($sql, [$nick]);

        return $res;
    }

    public function changeRep($rep, $nick)
    {
        $sql = "UPDATE users SET rep = rep + ? WHERE nick = ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $db->executeFetch($sql, [$rep, $nick]);

        return;
    }

    public function getTopProfiles()
    {
        $sql = "SELECT * FROM users ORDER BY rep DESC LIMIT 3;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetchAll($sql);

        return $res;
    }

    public function castVote($nick)
    {
        $sql = "UPDATE users SET votes = votes + 1 WHERE nick = ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $db->executeFetch($sql, [$nick]);

        return;
    }
}
