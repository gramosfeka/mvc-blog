<?php
    class Category{
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }

        public function addCategory($data){

            $this->db->query('INSERT INTO categories(id, name, created_at) VALUES (:id,:name,:created_at)');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':created_at', $data['created_at']);
            $this->db->bind(':name',$data['name']);
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }

        }

        public function editCategory($data){

            $this->db->query('UPDATE categories SET name = :name WHERE id = :id');

            $this->db->bind(':id', $data['id']);
            $this->db->bind(':name', $data['name']);

            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function deleteCategory($id){
        $this->db->query('DELETE FROM categories WHERE id = :id');

        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }


        public function getCategories(){
            $this->db->query("SELECT * FROM categories");

            $results = $this->db->resultset();

            return $results;
        }


        public function getCategoryById($id){
            $this->db->query("SELECT * FROM categories WHERE id = :id");

            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

    }
