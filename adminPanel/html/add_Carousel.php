<?php
include("query.php");
include("header.php");
?>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add Carousel /</span> Carousel</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Add New Carousel</h5>
                    <!-- Account -->
                    <form id="formAccountSettings" action="" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img
                                    src="../assets/img/avatars/1.png"
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
                                            accept="image/png, image/jpeg, image/avif"
                                            onchange="previewImage(this)"
                                            required
                                        />
                                    </label>

                                    <p class="text-muted mb-0">Allowed JPG, GIF, avif or PNG. Max size of 800K</p>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="fullname" class="form-label">Heading</label>
                                <input
                                class="form-control"
                                type="text"
                                id="fullname"
                                name="categoryname"
                                value=""
                                placeholder="stationery"
                                autofocus
                                required
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="name" class="form-label">Paragraph</label>
                                <input class="form-control" type="text" name="categorydescription" id="name" value="" placeholder="johndoe01" required />
                            </div>
                            <div class="mt-2">
                            <button type="submit" name="addCarousel" class="btn btn-primary me-2">Add</button>
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