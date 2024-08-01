<?php
include("query.php");
include("header.php");

// Fetch user information from the database
$query = $pdo->prepare("SELECT * FROM users WHERE role_id = 1");
$query->execute();
$user = $query->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['savechanges'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update query for users table
    $updateUserQuery = $pdo->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE role_id = 1");
    $updateUserQuery->bindParam(':name', $name);
    $updateUserQuery->bindParam(':email', $email);
    $updateUserQuery->bindParam(':password', $password);

    if($updateUserQuery->execute()){
        echo "<script>alert('admin information updated successfully');</script>";
    } else {
        echo "<script>alert('Error updating admin information');</script>";
    }
}
?>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Account Settings /</span> Account</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" action="" method="POST">
                        <div class="row">
                          <div class="mb-3 col-md-12">
                            <label for="firstName" class="form-label">First Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="Name"
                              name="name"
                              value="<?php echo $user['name'] ?>"
                              autofocus
                            />
                          </div>
                          <div class="mb-3 col-md-12">
                            <label for="email" class="form-label">E-mail</label>
                            <input
                              class="form-control"
                              type="email"
                              maxlength="20"
                              id="email"
                              name="email"
                              value="<?php echo $user['email'] ?>"
                            />
                          </div>
                          <div class="mb-3 col-md-12">
                            <label for="email" class="form-label">Password</label>
                            <input
                              class="form-control"
                              type="password"
                              minlength="8"
                              maxlength="12"
                              id="password"
                              name="password"
                              value="<?php echo $user['password'] ?>"
                            />
                          </div>        
                        </div>
                        <div class="mt-2">
                          <button type="submit" name="savechanges" class="btn btn-primary me-2">Save changes</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

<?php
include("footer.php");
?>