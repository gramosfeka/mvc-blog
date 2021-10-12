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

}
