<?php
include("query.php");
include("header.php");
?>

<?php
if(isset($_GET['id'])){
        $id = $_GET['id'];
         $query = $pdo->prepare("SELECT  brands.* , product.* , jonior_category.*
         FROM product
         INNER JOIN brands ON brands.brands_id = product_brand_id 
         INNER JOIN jonior_category ON jonior_category.jonior_category_id = product.product_jonior_category_id  
         where product.product_id = :pId");
        $query->bindParam(':pId',$id);
        $query->execute();
        $Product = $query->fetch(PDO::FETCH_ASSOC);
        // print_r($cat);
}
?>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Edit Product /</span> Product</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Edit Product</h5>
                    <!-- Account -->
                    <form id="formAccountSettings" action="" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img
                                    src="../assets/img/product-image/<?php echo $Product['product_image']?>"
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
                                value="<?php echo $Product['product_name']?>"
                                placeholder=""
                                autofocus
                                required
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <input class="form-control" type="text" name="description" id="description" value="<?php echo $Product['description']?>" placeholder="" required />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="productcode" class="form-label">Product Code</label>
                                <input class="form-control" type="text" minlength="2" maxlength="2" name="productcode" id="productcode" value="<?php echo $Product['product_code']?>" placeholder="" required />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="productnumber" class="form-label">Product Number</label>
                                <input class="form-control" type="text" minlength="5" maxlength="5" name="productnumber" id="productnumber" value="<?php echo $Product['product_number']?>" placeholder="" required />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="price" class="form-label">Price</label>
                                <input class="form-control" type="text" name="price" id="price" value="<?php echo $Product['price']?>" placeholder="" required />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="productquantity" class="form-label">Product Quantity</label>
                                <input class="form-control" type="text" name="productquantity" id="productquantity" value="<?php echo $Product['product_qty']?>" placeholder="" required />
                            </div>
                            <div class="mb-3 col-md-12">
                            <label class="form-label" for="bId">Brand</label>
                            <select id="bId" name="bId" class="select2 form-select" required>
                              <option value="<?php echo $Product['brands_id']?>"><?php echo $Product['brands_name']?></option>
                              <?php
                                $query = $pdo->prepare("SELECT * FROM brands where brands_name != :bName");
                                $query->bindParam(':bName',$Product['brands_name']);
                                 $query->execute();
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
                              <option value="<?php echo $Product['jonior_category_id']?>"><?php echo $Product['jonior_category_name']?></option>
                              <?php
                                $query = $pdo->prepare("SELECT * FROM jonior_category where jonior_category_name != :cName");
                                $query->bindParam(':cName',$Product['jonior_category_name']);
                                $query->execute();
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
                            <button type="submit" name="updateproduct" class="btn btn-primary me-2">Update Product</button>
                            <span class="ml-5"><a href="#"><button type="submit" name="updateproduct" class="btn btn-primary me-2">Edit Specification</button></a></span>
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