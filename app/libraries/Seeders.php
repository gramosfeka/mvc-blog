<?php

class Seeders extends Database
{
    /**
     * Insert data into specific table
     */
    public function seeder()
    {
        $password = password_hash(12345678, PASSWORD_DEFAULT);
        $hash = md5( rand(0,1000) );
        $this->query('INSERT INTO users (name, email, password, role, active, created_at, hash) VALUES ("Admin", "admin@gmail.com", :password, "admin", 1, CURRENT_TIMESTAMP , :hash )');
        $this->bind(':password',$password);
        $this->bind(':hash',$hash);
        $this->execute();

        $password = password_hash(12345678, PASSWORD_DEFAULT);
        $hash = md5( rand(0,1000) );
        $this->query('INSERT INTO users (name, email, password, role, active, created_at, hash) VALUES ("User", "user@gmail.com", :password, "user", 1, CURRENT_TIMESTAMP , :hash )');
        $this->bind(':password',$password);
        $this->bind(':hash',$hash);
        $this->execute();


        $this->query('INSERT INTO categories(name) VALUES ("Category 1")');
        $this->execute();


        $this->query('INSERT INTO tags (name) VALUES ("Tag 1" )');
        $this->execute();

    }

}