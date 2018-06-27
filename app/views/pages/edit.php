<?php require APPROOT . '/views/includes/header.php'; ?>
  <a href="<?php echo URLROOT; ?>/pages" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
  <div class="card card-body bg-light mt-5">
    <h2>Edit Test Taker</h2>
    <form action="<?php echo URLROOT; ?>/pages/edit/<?php echo $data['id']; ?>" method="post">
      <div class="form-group">
        <label for="testTaker">TestTaker: <sup>*</sup></label>
        <input type="text" name="testTaker" class="form-control form-control-lg <?php echo (!empty($data['testTaker_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['testTaker']; ?>">
        <span class="invalid-feedback"><?php echo $data['testTaker_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="correctAnswers">Correct Answers: <sup>*</sup></label>
        <input type="text" name="correctAnswers" class="form-control form-control-lg <?php echo (!empty($data['correctAnswers_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['correctAnswers']; ?>">
        <span class="invalid-feedback"><?php echo $data['correctAnswers_err']; ?></span>
      </div>
      <div class="form-group">
        <label for="incorrectAnswers">InCorrect Answers: <sup>*</sup></label>
        <input type="text" name="incorrectAnswers" class="form-control form-control-lg <?php echo (!empty($data['incorrectAnswers_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['incorrectAnswers']; ?>">
        <span class="invalid-feedback"><?php echo $data['incorrectAnswers_err']; ?></span>
      </div>

      <input type="submit" class="btn btn-success" value="Submit">
    </form>
  </div>
<?php require APPROOT . '/views/includes/footer.php'; ?>