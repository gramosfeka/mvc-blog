<?php
class Tag{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addTag($data){

        $this->db->query('INSERT INTO tags (id, name, created_at) VALUES (:id,:name,:created_at)');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':created_at', $data['created_at']);
        $this->db->bind(':name',$data['name']);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function editTag($data){

        $this->db->query('UPDATE tags SET name = :name WHERE id = :id');

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function deleteTag($id){
        $this->db->query('DELETE FROM tags WHERE id = :id');

        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }


    public function getTags(){
        $this->db->query("SELECT * FROM tags");

        $results = $this->db->resultset();

        return $results;
    }


    public function getTagById($id){
        $this->db->query("SELECT * FROM tags WHERE id = :id");

        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }


    public function getTagByArticle($id){
        $this->db->query("SELECT tag_id FROM article_tag WHERE article_id = :id");
        $this->db->bind(':id', $id);
        $tagsIds = $this->db->resultSetASSOC();


        $this->db->query("SELECT * FROM tags");
        $tags = $this->db->resultSetASSOC();

        foreach ($tagsIds as $Tid){
            foreach ($tags as $tag){
                if(in_array($tag['id'], $Tid)){
                     die('asasd');
                }
            }
        }

    }



}
