<?php
include("query.php");
include("header.php");
?>

<?php
if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query = $pdo->prepare("SELECT users.*, employees_information.* FROM users INNER JOIN employees_information ON users.id = employees_information.users_id WHERE users.id = :eId");
        $query->bindParam('eId',$id);
        $query->execute();
        $employee = $query->fetch(PDO::FETCH_ASSOC);
        // print_r($cat);
}
?>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Edit Employee /</span> Employee</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Edit Employee Account</h5>
                    <!-- Account -->
                    <form id="formAccountSettings" action="" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img
                                    src="../assets/img/employee-image/<?php echo $employee['image']?>"
                                    alt="user-avatar"
                                    class="d-block rounded"
                                    height="100"
                                    width="100"
                                    id="uploadedAvatar"
                                />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input
                                            type="file"
                                            id="upload"
                                            name="employeeimage"
                                            class="account-file-input visually-hidden"
                                            accept="image/png, image/jpeg"
                                            onchange="previewImage(this)"
                                        />
                                    </label>

                                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="fullname" class="form-label">Full Name</label>
                                <input
                                class="form-control"
                                type="text"
                                id="fullname"
                                name="fullname"
                                value="<?php echo $employee['fullname']?>"
                                placeholder="John Doe"
                                autofocus
                                required
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">User Name</label>
                                <input class="form-control" type="text" name="name" id="name" value="<?php echo $employee['name']?>" placeholder="johndoe01" required />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="email" class="form-label">E-mail</label>
                                <input
                                class="form-control"
                                type="email"
                                id="email"
                                name="email"
                                value="<?php echo $employee['email']?>"
                                placeholder="john.doe@example.com"
                                required
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="password" class="form-label">Password</label>
                                <input
                                class="form-control"
                                type="password"
                                id="password"
                                name="password"
                                value="<?php echo $employee['password']?>"
                                placeholder="Xcl235i"
                                autofocus
                                required
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label" for="phoneNumber">Phone Number</label>
                                <div class="input-group input-group-merge">
                                <input
                                    type="text"
                                    id="phoneNumber"
                                    name="phoneNumber"
                                    value="<?php echo $employee['phoneno']?>"
                                    class="form-control"
                                    placeholder="032 555 0111"
                                    required
                                />
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?php echo $employee['address']?>" placeholder="Address" required />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="city" class="form-label">City</label>
                                <input class="form-control" type="text" id="city" name="city" value="<?php echo $employee['city']?>" placeholder="California" required />
                            </div>
        
                            <div class="mt-2">
                            <button type="submit" name="editemployee" class="btn btn-primary me-2">Update</button>
                            </div>  
                        </div>
                    </form>
                    <!-- /Account -->
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
            <script>
    function previewImage(input) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            var img = document.getElementById('uploadedAvatar');
            img.src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
</script>


<?php
include("footer.php");
?>