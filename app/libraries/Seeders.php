<?php

class Seeders extends Database
{

    public function seeder()
    {

        $password = password_hash(12345678, PASSWORD_DEFAULT);
        $hash = md5( rand(0,1000) );
        $this->query('INSERT INTO users (name, email, password, role, active, created_at, hash) VALUES ("Admin", "admin@gmail.com", :password, "admin", 1, CURRENT_TIME , :hash )');
        $this->bind(':password',$password);
        $this->bind(':hash',$hash);
        $this->execute();

        $password = password_hash(12345678, PASSWORD_DEFAULT);
        $hash = md5( rand(0,1000) );
        $this->query('INSERT INTO users (name, email, password, role, active, created_at, hash) VALUES ("User", "user@gmail.com", :password, "user", 1, CURRENT_TIME , :hash)');
        $this->bind(':password',$password);
        $this->bind(':hash',$hash);
        $this->execute();


        $this->query('INSERT INTO categories(name, created_at) VALUES ("Category 1",current_date)');
        $this->execute();


        $this->query('INSERT INTO tags (name, created_at) VALUES ("Tag 1",CURRENT_DATE )');
        $this->execute();






    }


}