<?php
    class Article{
        private $db;

        public function __construct()
        {
            $this->db = new Database();
        }


        public function getArticles(){
            $this->db->query("SELECT * FROM articles");

            $results = $this->db->resultset();

            return $results;
        }


        public function getArticleById($id){
            $this->db->query("SELECT * FROM articles WHERE id = :id");

            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        public function createArticle($data)
        {
            $this->db->query('INSERT INTO articles (category_id, title, slug, body, user_id, image) VALUES (:category_id, :title, :slug, :body, :user_id,:image)');

            $this->db->bind(':title', $data['title']);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':category_id', $data['category_id']);
            $this->db->bind(':slug', $data['slug']);
            $this->db->bind(':image', $data['image']);
            $this->db->bind(':body', $data['body']);

            if ($this->db->execute()) {
                return true;
                } else {
                    return false;
                }

            }

            public function tagsArticle($data)
            {
                $this->db->query('SELECT id FROM articles WHERE slug = :slug');
                $this->db->bind(':slug', $data['slug']);
                $row = $this->db->single();

                foreach ($data['tags'] as $tag) {
                    $this->db->query('INSERT INTO article_tag (articles_id, tags_id) VALUES (:articles_id, :tags_id)');
                    $this->db->bind(':articles_id', $row->id);
                    $this->db->bind(':tags_id', $tag);
                    if ($this->db->execute()) {
                        return true;
                    } else {
                        return false;
                    }
                }

            }


        public function editArticle($data){

            $this->db->query('UPDATE articles SET title = :title, slug = :slug, category_id = :category_id, body = :body, image = :image WHERE id = :id');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':slug', $data['slug']);
            $this->db->bind(':category_id', $data['category_id']);
            $this->db->bind(':image', $data['image']);
            $this->db->bind(':body', $data['body']);

            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }

        public function deleteArticle($id){
            $this->db->query('DELETE FROM articles WHERE id = :id');

            $this->db->bind(':id', $id);

            if($this->db->execute()){
                return true;
            } else {
                return false;
            }
        }
    }