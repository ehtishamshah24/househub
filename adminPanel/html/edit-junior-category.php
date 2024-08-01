<?php
include("query.php");
include("header.php");
?>

<?php
if(isset($_GET['id'])){
        $id = $_GET['id'];
         $query = $pdo->prepare("SELECT jonior_category.* , category.category_name as cName , category.category_id as catId from jonior_category inner join category on jonior_category.jonior_category_id = category.category_id  where jonior_category.jonior_category_id = :cId");
        $query->bindParam(':cId',$id);
        $query->execute();
        $category = $query->fetch(PDO::FETCH_ASSOC);
        // print_r($cat);
}
?>

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Edit Junior Category /</span> Junior Category</h4>

              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-4">
                    <h5 class="card-header">Edit Junior Category</h5>
                    <!-- Account -->
                    <form id="formAccountSettings" action="" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img
                                    src="../assets/img/junior-category-image/<?php echo$category['jonior_category_image']?>"
                                    alt="user-avatar"
                                    class="d-block rounded"
                                    height="100"
                                    width="100"
                                    id="uploadedAvatar"
                                />
                                <div class="button-wrapper">
                                    <label for="juniorcategoryimage" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input
                                            type="file"
                                            id="juniorcategoryimage"
                                            name="junior_category_image"
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
                                <label for="juniorcategoryname" class="form-label">Junior Category Name</label>
                                <input
                                class="form-control"
                                type="text"
                                id="juniorcategoryname"
                                name="juniorcategoryname"
                                value="<?php echo $category['jonior_category_name']?>"
                                placeholder="stationery"
                                autofocus
                                required
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                            <label class="form-label" for="category">Category</label>
                            <select id="category" name="cId" class="select2 form-select">
                              <option value="<?php echo $category['catId']?>"><?php echo $category['cName']?></option>
                              <?php
                                $query = $pdo->prepare("SELECT * FROM category where category_name != :cName");
                                $query->bindParam(':cName',$category['cName']);
                                 $query->execute();
                                $allcategory1 = $query->fetchAll(PDO::FETCH_ASSOC);
                                foreach($allcategory1 as $category1){ 
                                ?>
                                    <option value="<?php echo $category1['category_id']?>"><?php echo $category1['category_name']?></option>                 
                                <?php
                                }
                                ?>
                            </select>
                          </div>
                            <div class="mt-2">
                            <button type="submit" name="updatejuniorcategory" class="btn btn-primary me-2">Update</button>
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