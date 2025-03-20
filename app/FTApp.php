<?php

class FTApp {
    protected $router;

    public function __construct() {
        $this->router = new FTM_Router();
        $this->defineRoutes();
    }

    private function defineRoutes() {
        $this->router->get('/', 'HomeController@index');
        $this->router->get('/about', 'PageController@about');
        $this->router->get('/contact', 'PageController@contact');
        $this->router->post('/submit-form', 'FormController@submit');
    }

    public function run() {
        $this->router->dispatch();
    }
}
