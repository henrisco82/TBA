<?php require APPROOT . '/views/includes/header.php'; ?>
<?php echo flash('upload_success'); ?>
<?php flash('post_message'); ?>
<?php flash('test_message'); ?>
<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Test Takers</th>
      <th scope="col">Correct Answers</th>
      <th scope="col">Incorrect Answers</th>
      <th><a href="<?php echo URLROOT; ?>/pages/add" class="btn btn-light"><i class="fa fa-plus"></i> Add New</a></th>
      <th><a href="<?php echo URLROOT; ?>/pages/makeChart" class="btn btn-light"><i class="fa fa-plus"></i> Plot Graph</a></th>
    </tr>
  </thead>
  <tbody>
  <?php
  $count = 1;
    foreach($data as $testData): 
	echo "<tr>";
	echo "<td>$count</td>";
    echo "<td>$testData->testTaker</td>";
    echo "<td>$testData->correctAnswers</td>";
    echo "<td>$testData->incorrectAnswers</td>";
  ?>
	<td><form  method="post" action="<?php echo URLROOT; ?>/pages/delete/<?php echo $testData->id; ?>">
	        <input type="submit" value="Delete" class="btn btn-danger">
	</form></td>
	<td>
    <a href="<?php echo URLROOT; ?>/pages/edit/<?php echo $testData->id; ?>" class="btn btn-dark">Edit</a>
    </td>
	
        </tr>
<?php 
    $count++;	
    endforeach;
    echo "</tbody>";	
    echo "</table>";
?>
   




<?php require APPROOT . '/views/includes/footer.php'; ?>