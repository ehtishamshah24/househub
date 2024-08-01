<?php
include("header.php");

// Fetch user information from the database
$query = $pdo->prepare("SELECT * FROM admin");
$query->execute();
$user = $query->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['savechanges'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Hash the password before storing it
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Update query for admin table
  $updateAdminQuery = $pdo->prepare("UPDATE admin SET Username = :name, Email = :email, Password = :password WHERE ID = :adminId");
  $updateAdminQuery->bindParam(':name', $name);
  $updateAdminQuery->bindParam(':email', $email);
  $updateAdminQuery->bindParam(':password', $hashedPassword);
  $updateAdminQuery->bindParam(':adminId', $_SESSION['adminId']);

  if ($updateAdminQuery->execute()) {
      echo "<script>alert('Admin information updated successfully');</script>";
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
                              value="<?php echo $user['Username'] ?>"
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
                              value="<?php echo $user['Email'] ?>"
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
                              value="<?php echo $user['Password'] ?>"
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