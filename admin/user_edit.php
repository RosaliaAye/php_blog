<?php

session_start();
require '../config/config.php';

if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
    header("location: login.php");
}

if ($_SESSION['role'] != 1) {
    header('Location: login.php');
  } 

if($_POST) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(empty($_POST['role'])) {
        $role = 0;
    }else{
        $role = 1;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
    $stmt -> execute(array(':email'=>$email,':id'=>$id));
    $user = $stmt -> fetch(PDO::FETCH_ASSOC);
   
    if($user) {
        echo "<script> alert('Email Duplicated');</script>";
    }else{
    if ($password != null) {
        $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',password='$password',role='$role' WHERE id='$id'");
    }else{
        $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',role='$role' WHERE id='$id'");
    }
    
  /*   else{
    $stmt = $pdo->prepare("UPDATE users SET name='$name',email='$email',password='$password',role='$role' WHERE id='$id'"); */

    $result = $stmt->execute();
  
    if($result) {
        echo "<script> alert('Successfully Updated');window.location.href='user_list.php';</script>";
    }
    }

}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
$stmt->execute();
$result= $stmt->fetchAll();

?>

<?php
  include ('header.php');
?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form class="" action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>" >
                            <label for="">Title</label>
                            <input type="text" class="form-control" name="name" value="<?php echo $result[0]['name'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label><br>
                            <input type="text" class="form-control" name="email" value="<?php echo $result[0]['email'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label><br><p><?php echo $result[0]['password'] ?></p>
                            <input type="password"  name="password" class="form-control" placeholder="Password" >
                        </div>
                        <div class="form-group">
                            <label for="">Role</label>
                            <input type="checkbox" name="role" value="1" <?php echo $result[0]['role'] == 1 ? 'checked':''?>>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                            <a href="user_list.php" class="btn btn-warning">Back</a>
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
