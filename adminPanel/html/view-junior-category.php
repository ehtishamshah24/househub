<?php
include("query.php");
include("header.php");
?>
       <!-- Content wrapper -->
       <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">All Jumior Categories /</span> Junior Category</h4>
            <!-- Hoverable Table rows -->
            <div class="card">
                <h5 class="card-header">View / Edit Junior Category</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Junior Category Name</th>
                        <th>Category Name</th>
                        <th>Image</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <?php
                        $query = $pdo->query("SELECT jonior_category.*, category.category_name as cName , category.category_id as cId from jonior_category inner join category on jonior_category.jonior_category_category_id = category.category_id");
                        $allcategory = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach($allcategory as $category){             
                    ?>
                      <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $category['jonior_category_name']?></strong></td>
                        <td><?php echo $category['cName']?></td>
                        <td>
                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li
                              data-bs-toggle="tooltip"
                              data-popup="tooltip-custom"
                              data-bs-placement="top"
                              class="avatar avatar-xs pull-up"
                              title=""
                            >
                              <img src="../assets/img/junior-category-image/<?php echo$category['jonior_category_image']?>" alt="Avatar" class="rounded-circle" />
                            </li>
                          </ul>
                        </td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="edit-junior-category.php?id=<?php echo $category['jonior_category_id'] ?>"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                              >
                              <a class="dropdown-item" href="?jcid=<?php echo $category['jonior_category_id'] ?>"
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