<?php require APPROOT . '/views/includes/header.php'; ?>
<div class="container">

    <div class="row">
      <div class="col-md-6 m-auto">
      <?php echo flash('error_message'); ?>
        <h1 class="text-center display-4 my-4">CSV File Upload</h1>
         <form action="<?php echo URLROOT; ?>/pages/upload" method="post" enctype="multipart/form-data">
            
                <input type="file" name="fileToUpload" id="fileToUpload" >
                <input type="submit" value="Upload File" name="submit" class="btn btn-primary btn-block">
        
            
        </form>
        <hr>
       
        
    
      </div>
    </div>
  </div>

  
<?php require APPROOT . '/views/includes/footer.php'; ?>