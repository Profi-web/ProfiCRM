<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';

use Medoo\Medoo;

class Article
{
    public $db;
    public $data;
    public $error;

    /**
     * User constructor.
     * @param null $article
     */
    public function __construct($article = null)
    {
        $this->db = new Medoo(DB_INIT);
        if ($article) {
            if (!$this->find($article)) {
                Header('Location: /kennisplein');
            }
        }
    }

    public function create($text = null, $name = null, $phonenumber = null, $email = null, $address = null, $zipcode = null, $city = null)
    {
        $phonenumber = strip_tags($phonenumber);
        $email = strip_tags($email);
        $address = strip_tags($address);
        $zipcode = strip_tags($zipcode);
        $city = strip_tags($city);
        $name = strip_tags($name);
        $text = strip_tags($text, '<b><strong><i><br>');


        if (!$text) {
            $text = '';
        }

        if (!$name) {
            $this->setError('Je moet een bedrijfsnaam opgeven!');
        } else {
            if (strlen($name) < 2) {
                $this->setError('De naam moet minimaal 2 tekens lang zijn');
            }
        }

        if (!$phonenumber) {
            $phonenumber = '';
        } else {
            if (!ctype_digit($phonenumber)) {
                $this->setError('Telefoonnummer mag alleen cijfer bevatten');
            }
        }

        if (!$email) {
            $email = '';
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setError('Voer een geldig emailadres in');
            }
        }
        if (!$address) {
            $address = '';
        }
        if (!$zipcode) {
            $zipcode = '';
        }
        if (!$city) {
            $city = '';
        }
        if ($this->getError()) {
            return false;
        }


        $this->db->insert('articles', [
            'info' => $text,
            'name' => $name,
            'phonenumber' => $phonenumber,
            'email' => $email,
            'address' => $address,
            'zipcode' => $zipcode,
            'city' => $city,
        ]);

        if ($this->db->error()[2]) {
            $this->setError('Oeps er ging iets mis!');
            return false;
        }
        return true;

    }

    public function createNew($text = null, $name = null, $date = null, $newTag = null, $alreadyTag = null)
    {
        $newTag = strip_tags($newTag);
        $date = strip_tags($date);
        $name = strip_tags($name);
        $text = strip_tags($text, '<b><strong><i><br>');


        if (!$text) {
            $text = '';
        }

        if (!$name) {
            $this->setError('Je moet een onderwerp opgeven!');
        } else {
            if (strlen($name) < 2) {
                $this->setError('De naam moet minimaal 2 tekens lang zijn');
            }
        }

        if (!$date) {
            $date = '';
        }
        if (!$newTag && !$alreadyTag) {
            $this->setError('Je moet een tag opgeven of aanmaken!');
        }

        if ($this->getError()) {
            return false;
        }

        $tagBoolean = false;
        $this->db->insert('articles', [
            'text' => $text,
            'name' => $name,
            'date' => $date,
        ]);

        $articleError = $this->db->error()[2];
        $articleID = $this->db->id();

        if ($newTag && $newTag !== '') {

            if (!$articleError) {
                $this->db->insert('tags',
                    [
                        'name' => $newTag,
                    ]);
                if (!$this->db->error()[2]) {
                    $tagID = $this->db->id();
                    $this->db->insert('article_tags',
                        [
                            'article' => $articleID,
                            'tag' => $tagID
                        ]);
                    if (!$this->db->error()[2]) {
                        $tagBoolean = true;
                    } else {
                        $this->db->delete('articles', ['id' => $articleID]);
                        $this->db->delete('tags', ['id' => $tagID]);
                        $this->setError('Oeps er ging iets mis met het toevoegen van de tag!.');
                        $tagBoolean = false;
                    }

                } else {
                    $this->db->delete('articles', ['id' => $articleID]);
                    $this->setError('Oeps er ging iets mis met het toevoegen van de tag!');
                    $tagBoolean = false;
                }

            } else {
                $this->setError('Oeps er ging iets mis met het toevoegen!');
                $tagBoolean = false;
            }


        }

        if ($alreadyTag && $alreadyTag !== '') {
            if (!$articleError) {
                foreach ($alreadyTag as $tag) {
                    $this->db->insert('article_tags',
                        [
                            'article' => $articleID,
                            'tag' => $tag
                        ]);
                }
                if (!$this->db->error()[2]) {
                    $tagBoolean = true;
                } else {
                    $this->db->delete('articles', ['id' => $articleID]);
                    $this->setError('Oeps er ging iets mis met het toevoegen van de tag!');
                    $tagBoolean = false;
                }
            } else {
                $this->setError('Oeps er ging iets mis met het toevoegen!');
                $tagBoolean = false;
            }

        }
        if ($tagBoolean == true) {
            return true;
        } else {
            return false;
        }

    }

//
    public function update($data = null, $column = null, $id = null)
    {
        if ($column && $id) {
            if (!$data) {
                $data = '';
            }
            $data = strip_tags($data, '<b><strong><i><br><em><a>');

            $this->db->update('articles', ["text" => $data], ['id' => $id]);
            $error = $this->db->error();
            if (!$error[2]) {
                $this->setError('');
                return true;
            }
            $this->setError('Oeps bijwerken is mislukt!');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }


    public function update_contact($id = null, $name = null, $date = null)
    {
        if ($id) {
            $name = strip_tags($name);
            $date = strip_tags($date);


            $data = $this->db->select('articles', '*', ['id' => $id]);
            if (!$this->db->error()[2]) {

                if (!isset($name) || !$name) {
                    $this->setError('Voer een geldige naam in');
                } else {
                    if (strlen($name) < 2) {
                        $this->setError('De naam moet minimaal 2 tekens lang zijn');
                    }
                }
                if (!isset($date)) {
                    $address = $data[0]['address'];
                }


                if ($this->getError()) {
                    return false;
                }


                $this->db->update('articles', [
                    "date" => $date,
                    "name" => $name
                ],
                    ['id' => $id]
                );

                $error = $this->db->error();
                if (!$error[2]) {
                    $this->setError('');
                    return true;
                }
                $this->setError('Oeps bijwerken is mislukt!');
                return false;
            }
            $this->setError('Oeps kon artikel niet vinden');
            return false;
        }
        $this->setError('Oeps bijwerken is mislukt!');
        return false;
    }


    public function find($article = null)
    {
        if ($article) {
            $count = $this->db->count('articles', ['id' => $article]);
            if ($count > 0) {
                $query = $this->db->select('articles', '*', ['id' => $article]);
                if (!$this->db->error()[2]) {
                    $this->data = $query[0];
                    return true;
                }
                return false;
            }
            return false;
        }

        return false;

    }

    public function getData($data, $replaced = null)
    {
        if ($this->data && $this->data[$data]) {
            if ($replaced) {
                return str_replace(' ', '%20', $this->data[$data]);
            }
            return $this->data[$data];
        }

        return '';
    }

    public function exists()
    {

    }

    public function delete($id = null)
    {
        if ($id) {

            $count = $this->db->count('articles', ['id' => $id]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $this->db->delete('article_tags', ['article' => $id]);
                    if (!$this->db->error()[2]) {
                        $this->db->delete('articles', ['id' => $id]);
                        if (!$this->db->error()[2]) {
                            return true;
                        }
                        $this->setError('Verwijderen mislukt, er zijn nog gekoppelde tags' . $this->db->error()[2]);
                        return false;
                    }

                    $this->setError('Verwijderen mislukt.' . $this->db->error()[2]);
                    return false;
                }
                $this->setError('Geen artikel gevonden');
                return false;
            }
            $this->setError('Geen artikel gevonden.');
            return false;
        }
        $this->setError('Verwijderen mislukt');

        return false;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    public function countAmount()
    {
        $count = $this->db->count('articles');
        if (!$this->db->error()[2]) {
            if ($count) {
                return $count;
            }
            return 0;
        }
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error .= $error . '<br>';
    }

    public function getRelations($id)
    {
        $return_data = array();
        if ($id) {
            $count = $this->db->count('article_tags', ['article' => $id, 'ORDER' => 'article']);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $data = $this->db->select('article_tags', '*', ['article' => $id, 'ORDER' => 'article']);
                    foreach ($data as $value) {
                        $count = $this->db->count('tags', ['id' => $value['tag']]);
                        if (!$this->db->error()[2]) {
                            if ($count > 0) {
                                $query = $this->db->select('tags', '*', ['id' => $value['tag']]);
                                $return_data[$value['uid']] = $query;
                            }
                        }
                    }

                    return $return_data;
                }
            }
            return false;
        }
        return false;
    }

    public function showRelations($id)
    {
        if ($this->getRelations($id) !== null && !empty($this->getRelations($id))) {
            echo '<div class="col-12 font-weight-bold p-0 pt-2">Gekoppelde tags:</div>';
            foreach ($this->getRelations($id) as $value) {
                foreach ($value as $item) {
                    echo '<a class="col-12 p-0" href="/kennisplein?tag=' . $item['id'] . '">' . $item['name'] . '</a>';
                }
            }
        } else {
            echo '<a class="col-12 p-0 py-2">Geen tags gevonden</a>';
        }
    }

    public function showEditRelations($id)
    {


        /*Leveranciers*/
        echo '<div class="col-12 font-weight-bold p-0 pt-2">Gekoppelde tags:</div>';
        if ($this->getRelations($id)) {
            foreach ($this->getRelations($id) as $key => $value) {
                foreach ($value as $valuekey => $item) {
                    echo '<div class="container-fluid">';
                    echo '<div class="row justify-content-between align-items-center bg-light p-2 mb-1 rounded">';
                    echo '<a class="p-0" id="' . $key . '">' . $item['name'] . '</a>';
                    echo '<a class="p-0 delete text-danger" id="' . $key . '"><i class="fad fa-times-circle text-danger"></i></a>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        } else {
            echo '<div class="container-fluid">';
            echo '<div class="row justify-content-between align-items-center p-0 mb-1 rounded">';
            echo '<a class="p-0">Niks gevonden</a>';
            echo '</div>';
            echo '</div>';
        }
    }

    public function showAllEditRelations()
    {


        /*Leveranciers*/
        echo '<div class="col-12 font-weight-bold p-0 pt-2">Gekoppelde tags:</div>';
        if ($this->db->count('tags', '*', ['ORDER' => 'id']) > 0) {
            $data = $this->db->select('tags', '*', ['ORDER' => 'id']);
            foreach ($data as $tag) {
                echo '<div class="container-fluid">';
                echo '<div class="row justify-content-between align-items-center bg-light p-2 mb-1 rounded">';
                echo '<a class="p-0" id="' . $tag['id'] . '">' . $tag['name'] . '</a>';
                echo '<a class="p-0 deleteTag text-danger" id="' . $tag['id'] . '"><i class="fad fa-times-circle text-danger"></i></a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="container-fluid">';
            echo '<div class="row justify-content-between align-items-center p-0 mb-1 rounded">';
            echo '<a class="p-0">Niks gevonden</a>';
            echo '</div>';
            echo '</div>';
        }
    }

    public
    function deleteRelation($id = null)
    {
        if ($id) {

            $count = $this->db->count('article_tags', ['uid' => $id]);
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $this->db->delete('article_tags', ['uid' => $id]);
                    if (!$this->db->error()[2]) {
                        return true;
                    }
                    $this->setError('Verwijderen mislukt');
                    return false;
                }
                $this->setError('Geen tag gevonden.');
                return false;
            }
            $this->setError('Geen tag gevonden.');
            return false;
        }
        $this->setError('Verwijderen mislukt');

        return false;
    }

    public
    function showOptions($id)
    {
        if ($id) {
            $count = $this->db->count('tags');
            if (!$this->db->error()[2]) {
                if ($count > 0) {
                    $data = $this->db->select('tags', '*');
                    if (!$this->db->error()[2]) {
                        foreach ($data as $item) {
                            $count = $this->db->count('article_tags', [
                                'article' => $id,
                                'tag' => $item['id']
                            ]);
                            if (!$this->db->error()[2]) {
                                if ($count > 0) {
                                    echo "<option value='" . $item['id'] . "' disabled>" . $item['name'] . " (#" . $item['id'] . ")</option>";
                                } else {
                                    echo "<option value='" . $item['id'] . "'>" . $item['name'] . " (#" . $item['id'] . ")</option>";
                                }
                            }
                        }
                    }
                }
                return false;
            }
            return false;
        }
        return false;
    }

    public
    function showOptionsNoId()
    {
        $count = $this->db->count('tags');
        if (!$this->db->error()[2]) {
            if ($count > 0) {
                $data = $this->db->select('tags', '*');
                if (!$this->db->error()[2]) {
                    foreach ($data as $item) {
                        echo "<option value='" . $item['id'] . "'>" . $item['name'] . " (#" . $item['id'] . ")</option>";
                    }
                }
            }
            return false;
        }
        return false;
    }

    public
    function saveRelation($tag_id = null, $choice_id = null)
    {
        if ($tag_id && $choice_id) {
            $data = $this->db->insert('article_tags', [
                'article' => $tag_id,
                'tag' => $choice_id
            ]);
            if (!$this->db->error()[2]) {
                return true;
            }
            $this->setError('Oeps er ging iets mis!');
            return false;
        }

        $this->setError('Oeps er ging iets mis!');
        return false;
    }

    function saveRelationNew($tag_id = null, $choice_id = null)
    {
        if ($tag_id && $choice_id) {
            $data = $this->db->insert('tags', [
                'name' => $choice_id,
            ]);
            if (!$this->db->error()[2]) {
                $data = $this->db->insert('article_tags', [
                    'article' => $tag_id,
                    'tag' => $this->db->id()
                ]);
                if (!$this->db->error()[2]) {
                    return true;
                }
                $this->setError('Oeps er ging iets mis!');
                return false;
            }
            $this->setError('Oeps er ging iets mis!..');
            return false;
        }

        $this->setError('Oeps er ging iets mis!.');
        return false;
    }

    public function deleteTag($id)
    {
        if ($id) {
            $data = $this->db->delete('article_tags', ['tag' => $id]);
            if (!$this->db->error()[2]) {
                $data = $this->db->delete('tags', ['id' => $id]);
                if (!$this->db->error()[2]) {
                    return true;
                }
                return false;
            }
            return false;
        }

        return false;
    }
}

