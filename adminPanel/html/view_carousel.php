<?php
include("query.php");
include("header.php");
?>
       <!-- Content wrapper -->
       <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">All carousel /</span> carousel</h4>
            <!-- Hoverable Table rows -->
            <div class="card">
                <h5 class="card-header">View / Edit carousel</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>carousel Heading</th>
                        <th>carousel paragraph</th>
                        <th>Image</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    <?php
                        $query = $pdo->query("SELECT * FROM carousel");
                        $allcarousel = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach($allcarousel as $carousel){             
                    ?>
                      <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $carousel['Carousel_heading']?></strong></td>
                        <td><?php echo $carousel['Carousel_paragraph']?></td>
                        <td>
                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li
                              data-bs-toggle="tooltip"
                              data-popup="tooltip-custom"
                              data-bs-placement="top"
                              class="avatar avatar-xs pull-up"
                              title=""
                            >
                              <img src="../assets/img/carousel_image/<?php echo $carousel['Carousel_image']?>" alt="Avatar" class="rounded-circle" />
                            </li>
                          </ul>
                        </td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="edit-category.php?id=<?php echo $carousel['Carousel_id'] ?>"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                              >
                              <a class="dropdown-item" href="?cid=<?php echo $carousel['Carousel_id'] ?>"
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
        </div>
<?php
include("footer.php");
?>