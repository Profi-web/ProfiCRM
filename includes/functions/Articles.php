<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Articles
{
    public $db;
    public $data;
    public $limit;


    public function __construct($article = null, $limit = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($article) {
            $this->find($article);
        }
        if ($article) {
            $this->limit = $limit;
        }
    }

    public function find($article = null)
    {
        if ($article) {
            $query = $this->db->select('articles', '*', ['id' => $article]);
            $error = $this->db->error();
            if (!$error[2]) {
                return $query[0];
            }
            return 'Not found';
        }

        return 'Not found';
    }

    public function findAll($limit_1 = null, $limit_2 = null, $tags = null, $search = null)
    {
        if ($tags || $search) {
            $articles = [];

            if ($tags) {
                $tags = explode(',', $tags);
                $data = $this->db->select('article_tags', '*', ['tag' => $tags]);

                foreach ($data as $da) {
                    $articles[] = $da['article'];
                }

                if ($search && $articles) {
                    $data_tags = $this->db->select('articles', '*', ['id' => $articles, 'name[~]' => '%' . $search . '%']);
                    $articles = [];
                    foreach ($data_tags as $da) {
                        $articles[] = $da['id'];
                    }
                }

            } else {
                if ($search) {
                    $data = $this->db->select('articles', '*', ['name[~]' => '%' . $search . '%']);
                    foreach ($data as $da) {
                        $articles[] = $da['id'];
                    }
                }
            }

            if (!$articles) {
                return 'No results';
            }

            $query = $this->db->select('articles', '*', ["LIMIT" => [$limit_1, $limit_2], "ORDER" => 'name', 'id' => $articles, 'name[~]' => '%' . $search . '%']);
            $test = '<br>TAG FOUND IN FINDALL<br>';
        } else {

            $query = $this->db->select('articles', '*', ["LIMIT" => [$limit_1, $limit_2], "ORDER" => 'name']);
            $test = '<br>TAG NOT FOUND IN FINDALL<br>';
        }
        $error = $this->db->error();
        if (!$error[2]) {
            return $query;
        }
        return 'Error';

    }

    public function getTags($id)
    {
        $query = $this->db->select('article_tags', [
            "[><]tags" => ['tag' => 'id']
        ], '*', ['article' => $id]);
        $names = [];
        if (!$this->db->error()[2]) {
            foreach ($query as $item) {
                $names[] = $item['name'];
            }
            return implode(', ', $names);
        }

        return false;
    }

}

?>