<?php
include("query.php");
include("header.php");
?>
       <!-- Content wrapper -->
       <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Products Data /</span> Products</h4>
            <!-- Hoverable Table rows -->
            <div class="card">
                <h5 class="card-header">View / Edit Products Data</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Product ID</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Product Quantity</th>
                        <th>Category Name</th>
                        <th>Brand Name</th>
                        <th>Image</th>
                        
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <?php
                        $query = $pdo->query("SELECT  brands.* , product.* , jonior_category.*
                        FROM product
                        INNER JOIN brands ON brands.brands_id = product_brand_id 
                        INNER JOIN jonior_category ON jonior_category.jonior_category_id = product.product_jonior_category_id
                        ");
                        $allProducts = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach($allProducts as $Product){             
                    ?>
                      <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $Product['product_name']?></strong></td>
                        <td><?php echo $Product['product_id']?></td>
                        <td><?php echo $Product['description']?></td>
                        <td><?php echo $Product['price']?></td>
                        <td><?php echo $Product['product_qty']?></td>
                        <td><?php echo $Product['jonior_category_name']?></td>
                        <td><?php echo $Product['brands_name']?></td>
                        <td>
                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li
                              data-bs-toggle="tooltip"
                              data-popup="tooltip-custom"
                              data-bs-placement="top"
                              class="avatar avatar-xs pull-up"
                              title="Lilian Fuller"
                            >
                              <img src="../assets/img/product-image/<?php echo $Product['product_image']?>" alt="Avatar" class="rounded-circle" />
                            </li>
                          </ul>
                        </td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="edit-product.php?id=<?php echo $Product['product_id'] ?>"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                              >
                              <a class="dropdown-item" href="?pid=<?php echo $Product['product_id'] ?>"
                                ><i class="bx bx-trash me-1"></i> Delete</a
                              >
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Hoverable Table rows -->

        </div>
<?php
include("footer.php");
?>