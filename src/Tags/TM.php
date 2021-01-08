<?php

namespace Anax\Tags;

class TM
{
    public $di;

    public function getTags()
    {
        $sql = "SELECT DISTINCT(tag) FROM tags;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetchAll($sql);

        return $res;
    }

    public function getQuestions($tag)
    {
        $sql = "SELECT * FROM questions WHERE tags LIKE ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetchAll($sql, ["%$tag%"]);

        return $res;
    }

    public function getTopTags()
    {
        $sql = "SELECT tag, COUNT(*) AS frequency FROM tags GROUP BY tag ORDER BY frequency DESC LIMIT 3;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetchAll($sql);

        return $res;
    }
}
