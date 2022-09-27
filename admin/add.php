<?php

session_start();
require '../config/config.php';

if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
    header("location: login.php");
}

if ($_POST) {
    $file = 'images/'.($_FILES['image']['name']);
    $imageType = pathinfo($file,PATHINFO_EXTENSION);

   if($imageType != 'png' && $imageType !='jpg' && $imageType != 'jpeg') {
    echo "<script> alert('Incorrect must be png, jpg, jpeg')</script>";
   }else{
    $title = $_POST['title'];
   // echo $title;
    $content = $_POST['content'];
   // echo $content;
    $image = $_FILES['image']['name'];
    //echo $image;
    move_uploaded_file($_FILES['image']['tmp_name'], $file);
    $stmt = $pdo->prepare("INSERT INTO posts(title,content,image,author_id) VALUES (:title,:content,:image,:author_id)");
    $result = $stmt->execute(
        array(
            ':title'=>$title, 
            ':content'=> $content, 
            ':image'=>$image,
            ':author_id'=>$_SESSION['user_id']
        )
    );
   // print_r($result);
    if($result) {
        echo "<script> alert('Successfully added');window.location.href='index.php';</script>";
       // echo "<script> alert('Successfully added')</script>";
    }
   }
}

?>

<?php
  include ('header.html');
?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="" action="add.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" class="form-control" name="title" value="" required>
                        </div>
                        <div class="form-group">
                            <label for="">Content</label><br>
                            <textarea class="form-control" name="content" cols="80" rows="8"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Image</label><br>
                            <input type="file" name="image" value="" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                            <a href="index.php" class="btn btn-warning">Back</a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card -->

            
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <?php include('footer.html'); ?>
