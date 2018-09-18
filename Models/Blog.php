<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Blog
 *
 * @author MSI
 */
class Blog 
{
    private $dbConnect;
    
    public function __construct(DBConnect $dbConnect) 
    {
        $this->dbConnect = $dbConnect;
    }
    
    public function getAllPosts($condition = NULL, $search = NULL)
    {
        $query = 'SELECT * FROM post';
        if (!is_null($condition)) {
            $query .= ' WHERE '. $condition;
        }
        $this->dbConnect->query($query);
        if (!is_null($search)) {
            $this->dbConnect->bind(':title', '%' . $search . '%');
        }
        $result = $this->dbConnect->resultSet();
        
        return $result;
    }
    
    public function getPostById($postId)
    {
        $this->dbConnect->query('SELECT * FROM post WHERE id = :id');
        $this->dbConnect->bind(':id', $postId);
        $result = $this->dbConnect->single();
        
        return $result;
    }
    
    public function createNewPost($post)
    {
        $this->dbConnect->query('INSERT INTO post (title) VALUES (:title)');
        $this->dbConnect->bind(':title', $post['title']);
        $this->dbConnect->execute();
        
        return $this->dbConnect->lastInsertId();
    }
}
