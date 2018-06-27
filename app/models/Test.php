<?php
  class Test {
    private $db;
    public $testTakers;
    public $correctAnswers;
    public $incorrectAnswers;

    public function __construct(){
      $this->db = new Database;
    }

    public function getTest(){
        $this->db->query('SELECT * FROM test');
  
        $results = $this->db->resultSet();
  
        return $results;
      }

      public function getTestForChart(){
        $this->db->query('SELECT * FROM test');
  
        $results = $this->db->resultSet();

        
  
        return $results;
      }


      public function add(){
        $this->db->query('INSERT INTO test (testTaker, correctAnswers, incorrectAnswers) 
        VALUES(:testTaker, :correctAnswers, :incorrectAnswers)');
        // Bind values
        $this->db->bind(':testTaker', $this->testTaker);
        $this->db->bind(':correctAnswers', $this->correctAnswers);
        $this->db->bind(':incorrectAnswers', $this->incorrectAnswers);
  
        // Execute
        if($this->db->execute()){
          return true;
        } else {
          return false;
        }
      }
  
      public function addTest($data){
        $this->db->query('INSERT INTO test (testTaker, correctAnswers, incorrectAnswers) 
        VALUES(:testTaker, :correctAnswers, :incorrectAnswers)');
        // Bind values
        $this->db->bind(':testTaker', $data['testTaker']);
        $this->db->bind(':correctAnswers', $data['correctAnswers']);
        $this->db->bind(':incorrectAnswers', $data['incorrectAnswers']);
  
        // Execute
        if($this->db->execute()){
          return true;
        } else {
          return false;
        }
      }
  
      public function updateTest($data){
        $this->db->query('UPDATE test SET testTaker = :testTaker, correctAnswers = :correctAnswers, incorrectAnswers = :incorrectAnswers WHERE id = :id');
        // Bind values
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':testTaker', $data['testTaker']);
        $this->db->bind(':correctAnswers', $data['correctAnswers']);
        $this->db->bind(':incorrectAnswers', $data['incorrectAnswers']);
  
        // Execute
        if($this->db->execute()){
          return true;
        } else {
          return false;
        }
      }
  
      public function deleteTest($id){
        $this->db->query('DELETE FROM test WHERE id = :id');
        // Bind values
        $this->db->bind(':id', $id);
  
        // Execute
        if($this->db->execute()){
          return true;
        } else {
          return false;
        }
      }
  
  
      public function getTestById($id){
        $this->db->query('SELECT * FROM test WHERE id = :id');
        $this->db->bind(':id', $id);
  
        $row = $this->db->single();
  
        return $row;
      }

  }