<?php

class Category
{
    private $db;

    /**
     * Category constructor.
     * Load database
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @param $data
     * @return bool
     * Add category to database
     */
    public function addCategory($data)
    {

        $this->db->query('INSERT INTO categories( name, created_at) VALUES (:name,:created_at)');
        $this->db->bind(':created_at', $data['created_at']);
        $this->db->bind(':name', $data['name']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @param $data
     * @return bool
     * Edit category
     */
    public function editCategory($data)
    {

        $this->db->query('UPDATE categories SET name = :name WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     * Delete category
     */
    public function deleteCategory($id)
    {
        $this->db->query('DELETE FROM categories WHERE id = :id');
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return mixed
     * returns all categories
     *
     */
    public function getCategories()
    {
        $this->db->query("SELECT * FROM categories");
        $results = $this->db->resultset();
        return $results;
    }


    /**
     * @param $id
     * @return mixed
     * returns category of specific id
     */
    public function getCategoryById($id)
    {
        $this->db->query("SELECT * FROM categories WHERE id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

}
