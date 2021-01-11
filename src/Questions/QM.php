<?php

namespace Anax\Questions;

use Anax\TextFilter\TextFilter;

class QM
{
    public $di;

    public function getQuestions()
    {
        $sql = "SELECT * FROM questions ORDER BY id DESC;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetchAll($sql);

        return $res;
    }

    public function getLatestQuestions()
    {
        $sql = "SELECT * FROM questions ORDER BY id DESC LIMIT 3;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetchAll($sql);

        return $res;
    }

    public function getQuestion($id)
    {
        $sql = "SELECT * FROM questions WHERE id = ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetch($sql, [$id]);
        $textFilter = new TextFilter();

        $res->content = $textFilter->parse($res->content, ["markdown"]);
        $res->tags = explode(" ", $res->tags);


        return $res;
    }

    public function updateScore($type, $id, $score)
    {
        $sql = "UPDATE {$type} SET rating = rating +? WHERE id = ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $db->executeFetch($sql, [$score, $id]);

        return;
    }

    public function answer($id, $auth, $content)
    {
        $db = $this->di->get("dbqb");
        $db->connect()
        ->insert("answers", ["question", "author", "content"])
        ->execute([$id, $auth, $content]);
        $last = $db->lastInsertId();

        $sql = "UPDATE questions SET answers = answers + 1 WHERE id = ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $db->execute($sql, [$id]);

        return $last;
    }

    
    public function comment($id, $auth, $content, $question)
    {
        $db = $this->di->get("dbqb");
        $db->connect()
        ->insert("comments", ["answer", "author", "content", "question"])
        ->execute([$id, $auth, $content, $question]);

        return $db->lastInsertId();
    }

    public function getAnswers($id, $order)
    {
        $sql = "SELECT * FROM answers WHERE question = ? ORDER BY {$order} DESC;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetchAll($sql, [$id]);
        $textFilter = new TextFilter();
        foreach ($res as $row) {
            $row->content = $textFilter->parse($row->content, ["markdown"]);
        }

        return $res;
    }

    public function getComments($id)
    {
        $sql = "SELECT * FROM comments WHERE question = ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetchAll($sql, [$id]);
        $textFilter = new TextFilter();
        foreach ($res as $row) {
            $row->content = $textFilter->parse($row->content, ["markdown"]);
        }

        return $res;
    }

    public function getUserComments($nick)
    {
        $sql = "SELECT * FROM comments WHERE author = ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetchAll($sql, [$nick]);

        return $res;
    }

    public function getUserQuestions($nick)
    {
        $sql = "SELECT * FROM questions WHERE author = ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetchAll($sql, [$nick]);

        return $res;
    }

    public function getUserAnswers($nick)
    {
        $sql = "SELECT * FROM answers WHERE author = ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $res = $db->executeFetchAll($sql, [$nick]);

        return $res;
    }

    public function acceptAnswer($id, $qid)
    {
        $sql = "UPDATE answers SET accepted = 1 WHERE id = ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $db->executeFetch($sql, [$id]);

        $sql = "UPDATE questions SET solved = 1 WHERE id = ?;";
        $db = $this->di->get("dbqb");
        $db->connect();
        $db->executeFetch($sql, [$qid]);

        return;
    }
}
