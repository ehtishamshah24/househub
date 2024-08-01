<?php
include("query.php");
include("header.php");
?>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add Product /</span> Product</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Add New Product</h5>
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
                                            name="productimage"
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
                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="fullname" class="form-label">Product Name</label>
                                <input
                                class="form-control"
                                type="text"
                                id="fullname"
                                name="productname"
                                value=""
                                placeholder=""
                                autofocus
                                required
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <input class="form-control" type="text" name="description" id="description" value="" placeholder="" required />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="productcode" class="form-label">Product Code</label>
                                <input class="form-control" type="text" minlength="2" maxlength="2" name="productcode" id="productcode" value="" placeholder="" required />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="productnumber" class="form-label">Product Number</label>
                                <input class="form-control" type="text" minlength="5" maxlength="5" name="productnumber" id="productnumber" value="" placeholder="" required />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="price" class="form-label">Price</label>
                                <input class="form-control" type="text" name="price" id="price" value="" placeholder="" required />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="productquantity" class="form-label">Product Quantity</label>
                                <input class="form-control" type="text" name="productquantity" id="productquantity" value="" placeholder="" required />
                            </div>
                            <div class="mb-3 col-md-12">
                            <label class="form-label" for="bId">Brand</label>
                            <select id="bId" name="bId" class="select2 form-select" required>
                              <option value="">Select</option>
                              <?php
                                $query = $pdo->query("SELECT * FROM brands");
                                $allBrands = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach($allBrands as $brand){ 
                                ?>
                                    <option value="<?php echo $brand['brands_id']?>"><?php echo $brand['brands_name']?></option>                 
                                <?php
                                }
                                ?>
                            </select>
                          </div>
                            <div class="mb-3 col-md-12">
                            <label class="form-label" for="cId">Category</label>
                            <select id="cId" name="cId" class="select2 form-select" required>
                              <option value="">Select</option>
                              <?php
                                $query = $pdo->query("SELECT * FROM jonior_category");
                                $allcategory = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach($allcategory as $category){ 
                                ?>
                                    <option value="<?php echo $category['jonior_category_id']?>"><?php echo $category['jonior_category_name']?></option>                 
                                <?php
                                }
                                ?>
                            </select>
                          </div>
                            <div class="mt-2">
                            <button type="submit" name="addproduct" class="btn btn-primary me-2">Add Product</button>
                            <span class="ml-5"><a href="#"><button type="submit" name="addproduct" class="btn btn-primary me-2">Add Specification</button></a></span>
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