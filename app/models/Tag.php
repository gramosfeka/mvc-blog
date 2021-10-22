<?php
class Tag{
    private $db;

    /**
     * Tag constructor
     * Load database
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @param $data
     * @return bool
     * Add tag to database
     */
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

    /**
     * @param $data
     * @return bool
     * Edit tag
     */
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

    /**
     * @param $id
     * @return bool
     * Delete tag
     */
    public function deleteTag($id){
        $this->db->query('DELETE FROM tags WHERE id = :id');

        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }


    /**
     * @return mixed
     * returns all tags
     */
    public function getTags(){
        $this->db->query("SELECT * FROM tags");

        $results = $this->db->resultset();

        return $results;
    }


    /**
     * @param $id
     * @return mixed
     * returns tag of specific id
     */
    public function getTagById($id){
        $this->db->query("SELECT * FROM tags WHERE id = :id");

        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }


    /**
     * @param $id
     * @return array
     * returns all names of tags of specific article
     */
    public function getTagByArticle($id){
        $this->db->query("SELECT tag_id FROM article_tag WHERE article_id = :id");
        $this->db->bind(':id', $id);
        $tagsIds = $this->db->resultSetASSOC();


        $this->db->query("SELECT * FROM tags");
        $tags = $this->db->resultSetASSOC();

        foreach ($tags as $tag){
            foreach ($tagsIds as $tId){
                if(in_array($tag['id'], $tId)){
                    $tagNames[] = $tag['name'];

                }
            }
        }
        return $tagNames;
    }







}
