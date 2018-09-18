<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controllers
 *
 * @author MSI
 */
class BlogController 
{
    private $model;
    
    public function __construct(Blog $model) 
    {
        $this->model = $model;
    }
    
    public function listAction()
    {
        $posts = $this->model->getAllPosts();
        
        require 'templates/list.php';
    }
    
    public function showAction($postId)
    {
        $post = $this->model->getPostById($postId);
        
        require 'templates/show.php';
    }
    
    public function createAction()
    {
        require 'templates/create.php';
    }
    
    public function saveAction($formData)
    {
        try{
            if ('' == $formData['title'] && empty($formData['title'])) {
                $error['form']['title'] = 'Title cannot be empty';  
            }
            if (isset($error)) {
                $return = [
                    'type' => 'error',
                    'success' => false,
                    'message' => 'Unable to create Post',
                    'error' => $error
                ];
                throw new CustomException($return);
            } else {
                $post = $this->model->createNewPost($formData);
                if (isset($post)) {
                    $return = [
                        'success' => true,
                        'message' => 'Post Created'
                    ];
                    echo json_encode($return);
                }
            }
        } catch (CustomException $ex) {
            http_response_code(500);
            echo json_encode($ex->getParams());
        }
    }
    
    public function ajaxAction($ajaxSelect)
    {
        switch($ajaxSelect) {
            case 'title-select':
                echo json_encode($this->loadTitle());
                break;
            case 'search-post':
                echo json_encode($this->loadSearchPosts());
                break;
        }
    }
    
    public function loadTitle()
    {
        $posts = $this->model->getAllPosts();
        
        return $posts;
    }
    
    public function loadSearchPosts()
    {
        $search = $_GET['search'];
        $posts = $this->model->getAllPosts("title LIKE :title", $search);
        
        return $posts;
    }
}
