<?php
include("header.php");
?>

<body>
    <div class="container-fluid">
        <form action="query.php" method="post" id="account">
            <div class="row mt-5 justify-content-around">
            <div class="col-md-3" style="background-color: white;">
                <div class="m-3">
                    <a href="account.php">Profile</a>
                </div>
            </div>
                <div class="col-md-8 p-5" style="background-color: white;">
                        
                    <h3>Additional Information</h3>
                    <div class="form-group m-3">
                        <label for="inputname">Name</label>
                        <input type="name" class="form-control" id="inputname" placeholder="name">
                    </div>
                    <div class="form-group m-3">
                        <label for="inputEmail4">Email</label>
                        <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                    </div>
                    <div class="form-group m-3">
                        <label for="inputAddress">Address</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                    </div>
                    <div class="form-group m-3">
                        <label for="inputAddress2">Phone no.</label>
                        <input type="text" class="form-control" id="inputAddress2" placeholder="013519427...">
                    </div>
                    <div class="form-group m-3">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" id="inputCity">
                    </div>
                    <div class="card-body m-3">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img
                                    src="img\1.png"
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
                                            class="account-file-input"
                                            hidden
                                            accept="image/png, image/jpeg"
                                            onchange="previewImage(this)"
                                            required
                                        />
                                    </label>

                                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                </div>
                            </div>
                        </div>
                    <button type="submit" class="btn  btn-primary m-3">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
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

</body>
<?php
include("footer.php");
?>