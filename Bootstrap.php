<?php
require_once './Database/DBConnect.php';
require_once './Models/Blog.php';
require_once './Controllers/BlogController.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bootstrap
 *
 * @author MSI
 */
class Bootstrap 
{
    public function execute()
    {
        $dbConnect = new DBConnect();
        $model = new Blog($dbConnect);
        $controller = new BlogController($model);

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->routeUrl($uri, $controller);
    }
    
    protected function routeUrl($uri, $controller)
    {
        switch(true)
        {
            case '/blog/index.php' === $uri || $uri === '/blog/':
                $controller->listAction();
                break;
            case '/blog/index.php/show' === $uri && isset($_GET['id']) && $_GET['id'] != '':
                $controller->showAction($_GET['id']);
                break;
            case '/blog/index.php/create' === $uri:
                $controller->createAction();
                break;
            case '/blog/index.php/save' === $uri:
                $controller->saveAction($_POST);
                break;
            case '/blog/index.php/load' === $uri && isset($_GET['select']) && $_GET['select'] != '':
                $controller->ajaxAction($_GET['select']);
                break;
            case '/blog/index.php/search' === $uri && isset($_GET['select']) && $_GET['select'] != '':
                $controller->ajaxAction($_GET['select']);
                break;
            default:
                header('HTTP/1.1 404 Not Found');
                echo '<html><body><h1>Page Not Found</h1></body></html>';
        }
    }
}
