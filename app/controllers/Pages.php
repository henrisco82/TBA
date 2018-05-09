<?php
  class Pages extends Controller {
    public function __construct(){
       $this->postModel =  $this->model('Post');
     
    }

    //default controller 
    public function index(){
       
       $posts = $this->postModel->getPosts();
       $data = [
         'title' => 'Welcome to this Shit',
         'posts' => $posts
        ];

       $this->postModel->getPosts();
       $this->view('pages/index', $data);
    }

    //default method
    public function about(){
      $data = ['title' => 'About Us'];
      $this->view('pages/about', $data);
    }
  }