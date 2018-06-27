<?php

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    // require_once 'C:/xampp/htdocs/project/app/libraries/pChart2.1.4/pChart2.1.4/class/pData.class.php';

  class Pages extends Controller {
   
    public function __construct(){

      $this->testModel = $this->model('Test');
     
    }

    //default controller 
    public function index(){
    
       $this->view('pages/index');
    }

    // upload method
    public function upload(){
        
      $target_dir = APPROOT . '/views/uploads/';
      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


      
      // Check if image file is a actual image or fake image
      
      if(isset($_POST['upload'])){
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
      
      }
      

       //Check if file already exists
      if (file_exists($target_file)) {
        flash('error_message', 'Sorry, file already exists.', 'alert alert-danger');
          $uploadOk = 0;
      }
      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 500000) {
          flash('error_message', 'Sorry, your file is too large.', 'alert alert-danger');
          $uploadOk = 0;
      }
      // Allow certain file formats
      if($imageFileType != "csv") {
          flash('error_message', 'Sorry, only csv files are allowed.', 'alert alert-danger');
          $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          flash('error_message', 'Sorry, your file was not uploaded.', 'alert alert-danger');
      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
               flash('upload_success', 'file has been uploaded');
               redirect('pages/show');
              // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
          } else {
              flash('error_message', 'Sorry, there was an error uploading your file.', 'alert alert-danger');
          }
      }

     
      $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($target_file);

      $worksheet = $spreadsheet->getActiveSheet();
      $rows = [];
      $outer = 1;
      ini_set('max_execution_time', 300);
      foreach ($worksheet->getRowIterator() AS $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;

            if($outer > 1){
              $data = [
                'testTaker' => $cells[1],
                'correctAnswers' => $cells[2],
                'incorrectAnswers' => $cells[3],
              ];
              $this->testModel->addTest($data);
           
            }
            
           
            $outer++;
      }
 

      $this->view('pages/index');

    }


    public function makeChart(){
       
         //  $testTakerArray = array();
           $correctAnswersArray = array();
           $incorrectAnswersArray = array();
           $data = $this->testModel->getTest();
           foreach($data as $datay){
            //  array_push($testTakerArray, $datay->testTaker);
              array_push($correctAnswersArray, $datay->correctAnswers);
              array_push($incorrectAnswersArray, $datay->incorrectAnswers);
           }

           // Create the graph. These two calls are always required
                $graph = new Graph(1950,1000);
                $graph->SetScale('intlin',0,100);

                $theme_class=new UniversalTheme;
                $graph->SetTheme($theme_class);

                $graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
                $graph->SetBox(false);

                $graph->ygrid->SetFill(false);
                $graph->xaxis->SetTickLabels(array('A','B','C','D'));
                $graph->yaxis->HideLine(false);
                $graph->yaxis->HideTicks(false,false);

                // Create the bar plots
             //   $b1plot = new BarPlot($testTakerArray);
                $b2plot = new BarPlot($correctAnswersArray);
                $b3plot = new BarPlot($incorrectAnswersArray);
                
                // Create the grouped bar plot
                $gbplot = new GroupBarPlot(array($b2plot,$b3plot));
                // ...and add it to the graPH
                $graph->Add($gbplot);


              //  $b1plot->SetColor("white");
               // $b1plot->SetFillColor("#cc1111");

                $b2plot->SetColor("blue");
                $b2plot->SetFillColor("blue");

                $b3plot->SetColor("red");
                $b3plot->SetFillColor("red");

                $graph->title->Set("Bar Plots Showing the correct and incorrect answers of test takers");

                $b2plot->SetLegend("Correct Answers");
                $b3plot->SetLegend("Incorrect Answers");

                $graph->legend->Pos( 0.05,0.95,"left" ,"bottom");
                $graph->legend->SetLayout(LEGEND_VERT);

                // Display the graph
                $graph->Stroke();
         
         


        
            // Load view with the graph
                    $this->view('pages/about');
    }

    public function add(){
       
        // Check for POST
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
             // Process form
           // Sanitize POST data
           $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

           $data = [
            'testTaker' => trim($_POST['testTaker']),
            'correctAnswers' => trim($_POST['correctAnswers']),
            'incorrectAnswers' => trim($_POST['incorrectAnswers']),
            'testTaker_err' => '',
            'correctAnswers_err' => '',
            'incorrectAnswers_err' => ''
          ];
   
           // Validate data
           if(empty($data['testTaker'])){
             $data['testTaker_err'] = 'Please enter the test taker number';
           }
           if(empty($data['correctAnswers'])){
             $data['correctAnswers_err'] = 'Please enter the number of correct answers';
           }
           if(empty($data['incorrectAnswers'])){
            $data['incorrectAnswers_err'] = 'Please enter the number of incorrect answers';
          }
   
           // Make sure no errors
           if(empty($data['testTaker_err']) && empty($data['correctAnswers_err']) && empty($data['incorrectAnswers_err'])){
             // Validated
             if($this->testModel->addTest($data)){
               flash('test_message', 'Test Taker Added');
               redirect('pages/show');
             } else {
               die('Something went wrong');
             }
           } else {
             // Load view with errors
             $this->view('pages/add', $data);
           }
        }else{
               $data = [
                 'testTaker' => '',
                 'correctAnswers' => '',
                 'incorrectAnswers' => ''
               ];
 
               $this->view('pages/add', $data);
        }
 
 
     }


     public function edit($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          // Sanitize POST array
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  
          $data = [
            'id' => $id,
            'testTaker' => trim($_POST['testTaker']),
            'correctAnswers' => trim($_POST['correctAnswers']),
            'incorrectAnswers' => trim($_POST['incorrectAnswers']),
            'testTaker_err' => '',
            'correctAnswers_err' => '',
            'incorrectAnswers_err' => ''
          ];
  
          // Validate data
          if(empty($data['testTaker'])){
            $data['testTaker_err'] = 'Please enter the test taker number';
          }
          if(empty($data['correctAnswers'])){
            $data['correctAnswers_err'] = 'Please enter the number of correct answers';
          }
          if(empty($data['incorrectAnswers'])){
           $data['incorrectAnswers_err'] = 'Please enter the number of incorrect answers';
         }
  
          // Make sure no errors
          if(empty($data['testTaker_err']) && empty($data['correctAnswers_err']) && empty($data['incorrectAnswers_err'])){
            // Validated
            if($this->testModel->updateTest($data)){
                flash('test_message', 'Test Taker Data Updated');
                redirect('pages/show');
            } else {
              die('Something went wrong');
            }
          } else {
            // Load view with errors
            $this->view('pages/edit', $data);
          }
  
        } else {
          // Get existing post from model
          $test = $this->testModel->getTestById($id);
  
          $data = [
            'id'=> $id,
            'testTaker' => $test->testTaker,
            'correctAnswers' => $test->correctAnswers,
            'incorrectAnswers' => $test->incorrectAnswers,
          ];
    
          $this->view('pages/edit', $data);
        }
      }
    
  
    

    public function delete($id){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          // Get existing post from model
          
          $test = $this->testModel->getTestById($id);
          
  
          if($this->testModel->deleteTest($id)){
            flash('post_message', 'Test Result Removed');
            redirect('pages/show');
          } else {
            die('Something went wrong');
          }
        } else {
          redirect('pages/show');
        }
      }


    public function show(){
        $data = $this->testModel->getTest();
  
        $this->view('pages/show', $data);
      }



  
  }