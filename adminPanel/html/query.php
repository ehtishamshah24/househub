<?php
include("dbcon.php");
session_start();

// login ...
if (isset($_POST['signin'])) {
    $loginEmail = $_POST['email'];
    $loginPassword = $_POST['password'];

    // Prepare and execute query to check if user exists
    $query = $pdo->prepare("SELECT * FROM admin WHERE Email = :lEmail");
    $query->bindParam(':lEmail', $loginEmail);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify the password against the hashed password
        if (password_verify($loginPassword, $user['Password'])) {
            // Start session and set session variables
            $_SESSION['adminId'] = $user['ID'];
            $_SESSION['adminEmail'] = $user['Email'];
            $_SESSION['adminName'] = $user['Username'];

            echo "<script>alert('Login successful'); location.assign('index.php');</script>";
        } else {
            echo "<script>alert('Incorrect email or password'); location.assign('login.php');</script>";
        }
    } else {
        echo "<script>alert('Incorrect email or password'); location.assign('login.php');</script>";
    }
}



// add employee
if(isset($_POST['registeremployee'])){
    // Check if the 'employeeimage' key exists in the $_FILES array
    if(isset($_FILES['employeeimage'])){
        $name = $_POST['fullname'];
        $username = $_POST['name'];
        $employeeEmail = $_POST['email'];
        $employeePassword = $_POST['password'];
        $homeAddress = $_POST['address'];
        $phoneNumber = $_POST['phoneNumber'];
        $city = $_POST['city'];
        $cImageName = $_FILES['employeeimage']['name'];
        $cImageTmpName = $_FILES['employeeimage']['tmp_name'];
        $extension = pathinfo($cImageName, PATHINFO_EXTENSION);
        $destination = "../assets/img/employee-image/" . $cImageName;
        
        // Check if the email or username already exists in the database
        $checkQuery = $pdo->prepare("SELECT * FROM users WHERE (name = :userName OR email = :userEmail) AND role_id = 2");
        $checkQuery->bindParam(':userEmail', $employeeEmail);
        $checkQuery->bindParam(':userName', $username);
        $checkQuery->execute();
        $existingUser = $checkQuery->fetch(PDO::FETCH_ASSOC);
        // print_r($existingUser);
        if($existingUser ){
            echo "<script>alert('User already exists.');</script>";
        } else {
            // Check if the image extension is valid
            if( $extension == "png" || $extension == "jpeg"){
                // Move uploaded image to destination folder
                if(move_uploaded_file($cImageTmpName, $destination)){
                    try {
                        // Insert employee information into users table
                        $userQuery = $pdo->prepare("INSERT INTO users (name, email, password, role_id) VALUES (:stdName, :employeeEmail, :employeePassword, 2)");
                        $userQuery->bindParam(':stdName', $username);
                        $userQuery->bindParam(':employeeEmail', $employeeEmail);
                        $userQuery->bindParam(':employeePassword', $employeePassword);
                        $userQuery->execute();

                        // Get the user ID of the inserted employee
                        $userId = $pdo->lastInsertId();

                        // Insert employee information into employee_information table
                        $employeeQuery = $pdo->prepare("INSERT INTO employees_information (fullname, phoneno, address, city, image, users_id) VALUES (:stdName, :phoneNumber, :homeAddress, :city, :cImageName, :userId)");
                        $employeeQuery->bindParam(':stdName', $name);
                        $employeeQuery->bindParam(':phoneNumber', $phoneNumber);
                        $employeeQuery->bindParam(':homeAddress', $homeAddress);
                        $employeeQuery->bindParam(':city', $city);
                        $employeeQuery->bindParam(':cImageName', $cImageName);
                        $employeeQuery->bindParam(':userId', $userId);
                        $employeeQuery->execute();

                        echo "<script>alert('Employee added successfully');
                        location.assign('index.php')
                        </script>";
                    } catch(PDOException $e) {
                        // Handle database errors
                        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
                    }
                } else {
                    echo "<script>alert('Failed to upload image');</script>";
                }
            } else {
                echo "<script>alert('Invalid image extension');</script>";
            }
        }
    } else {
        echo "<script>alert('No image uploaded');</script>";
    }
}

// update employee

// update employee
if(isset($_POST['editemployee'])){
    $employeeId = $_GET['id'];
    $name = $_POST['name'];
    $employeeEmail = $_POST['email']; // corrected variable name
    $password = $_POST['password']; // corrected variable name
    $homeAddress = $_POST['address']; // corrected variable name
    $phoneNumber = $_POST['phoneNumber']; // corrected variable name
    $city = $_POST['city'];

    $updateUserQuery = $pdo->prepare("UPDATE users SET name = :name, email = :employeeEmail, password = :password WHERE id = :employeeId");
    $updateUserQuery->bindParam(':name', $name);
    $updateUserQuery->bindParam(':employeeEmail', $employeeEmail);
    $updateUserQuery->bindParam(':password', $password);
    $updateUserQuery->bindParam(':employeeId', $employeeId);

    if($updateUserQuery->execute()){
        $updateEmployeeInfoQuery = $pdo->prepare("UPDATE employees_information SET fullname = :name, address = :homeAddress, city = :city, phoneno = :phoneNumber WHERE users_id = :employeeId");
        $updateEmployeeInfoQuery->bindParam(':name', $name);
        $updateEmployeeInfoQuery->bindParam(':homeAddress', $homeAddress);
        $updateEmployeeInfoQuery->bindParam(':city', $city);
        $updateEmployeeInfoQuery->bindParam(':phoneNumber', $phoneNumber);
        $updateEmployeeInfoQuery->bindParam(':employeeId', $employeeId);

        if($updateEmployeeInfoQuery->execute()){
            // Check if a new image has been uploaded
            if(isset($_FILES['employeeimage']) && $_FILES['employeeimage']['error'] === UPLOAD_ERR_OK){
                $cImageName = $_FILES['employeeimage']['name'];
                $cImageTmpName = $_FILES['employeeimage']['tmp_name'];
                $extension = pathinfo($cImageName, PATHINFO_EXTENSION);
                $destination = "../assets/img/employee-image/" . $cImageName;

                // Check if the image extension is valid
                if( $extension == "png" || $extension == "jpeg"){
                    // Move uploaded image to destination folder
                    if(move_uploaded_file($cImageTmpName, $destination)){
                        $updateEmployeeImageQuery = $pdo->prepare("UPDATE employees_information SET image = :image WHERE users_id = :employeeId");
                        $updateEmployeeImageQuery->bindParam(':image', $cImageName);
                        $updateEmployeeImageQuery->bindParam(':employeeId', $employeeId);
                        
                        if($updateEmployeeImageQuery->execute()){
                            echo "<script>alert('Employee information and image updated successfully');
                            location.assign('view-employee.php');</script>";
                        } else {
                            echo "<script>alert('Error updating employee image');</script>";
                        }
                    } else {
                        echo "<script>alert('Failed to upload image');</script>";
                    }
                } else {
                    echo "<script>alert('Invalid image extension');</script>";
                }
            } else {
                echo "<script>alert('Employee information updated successfully');</script>";
            }
        } else {
            echo "<script>alert('Error updating employee information');</script>";
        }
    } else {
        echo "<script>alert('Error updating employee information');</script>";
    }
}

// delete employee
if(isset($_GET['eid'])){
    $id  = $_GET['eid'];
    $query2 = $pdo->prepare("DELETE FROM users WHERE id = :userId");
    $query2->bindParam(':userId', $id);
    $query2->execute();
    echo "<script>alert('Employee deleted successfully');
          location.assign('view-employee.php');
          </script>";
}

// Add Category
if(isset($_POST['addcategory'])){
    $categoryName = $_POST['categoryname'];
    $categoryDescription = $_POST['categorydescription'];
    $categoryImageName = $_FILES['employeeimage']['name'];
    $categoryImageTmpName = $_FILES['employeeimage']['tmp_name'];
    $extension = pathinfo($categoryImageName, PATHINFO_EXTENSION);
    $destination = "../assets/img/category-image/" . $categoryImageName;
    
    // Check if the uploaded file has a valid extension
    if($extension == "jpg" || $extension == "png" || $extension == "jpeg") {
        // Move the uploaded file to the destination folder
        if(move_uploaded_file($categoryImageTmpName, $destination)){
            // Prepare and execute the SQL query to insert the new category into the database
            $query = $pdo->prepare("INSERT INTO category (category_name, category_des, category_image) VALUES (:categoryName, :categoryDescription, :categoryImageName)");
            $query->bindParam(':categoryName', $categoryName);
            $query->bindParam(':categoryDescription', $categoryDescription);
            $query->bindParam(':categoryImageName', $categoryImageName);
            $query->execute();
            
            // Redirect back to index.php after successfully adding the category
            echo "<script>alert('Category added successfully'); location.assign('index.php');</script>";
        } else {
            echo "<script>alert('Failed to move uploaded file');</script>";
        }
    } else {
        echo "<script>alert('Invalid file extension');</script>";
    }
}

// Update Category
if(isset($_POST['updatecategory'])){
    $id = $_GET['id'];
    $categoryName = $_POST['categoryname'];
    $categoryDescription = $_POST['categorydescription'];
    
    // Check if a new image is uploaded
    if(isset($_FILES['employeeimage']) && $_FILES['employeeimage']['error'] === UPLOAD_ERR_OK){
        $categoryImageName = $_FILES['employeeimage']['name'];
        $categoryImageTmpName = $_FILES['employeeimage']['tmp_name'];
        $extension = pathinfo($categoryImageName, PATHINFO_EXTENSION);
        $destination = "../assets/img/category-image/" . $categoryImageName;
        
        // Check if the uploaded file has a valid extension
        if($extension == "jpg" || $extension == "png" || $extension == "jpeg") {
            // Move the uploaded file to the destination folder
            if(move_uploaded_file($categoryImageTmpName, $destination)){
                // Prepare and execute the SQL query to update the category in the database
                $query = $pdo->prepare("UPDATE category SET category_name = :categoryName, category_des = :categoryDescription, category_image = :categoryImageName WHERE category_id = :id");
                $query->bindParam(':categoryName', $categoryName);
                $query->bindParam(':categoryDescription', $categoryDescription);
                $query->bindParam(':categoryImageName', $categoryImageName);
                $query->bindParam(':id', $id);
                $query->execute();
                
                // Redirect back to index.php after successfully updating the category
                echo "<script>alert('Category updated successfully'); location.assign('index.php');</script>";
            } else {
                echo "<script>alert('Failed to move uploaded file');</script>";
            }
        } else {
            echo "<script>alert('Invalid file extension');</script>";
        }
    } else {
        // If no new image is uploaded, update only category name and description
        $query = $pdo->prepare("UPDATE category SET category_name = :categoryName, category_des = :categoryDescription WHERE category_id = :id");
        $query->bindParam(':categoryName', $categoryName);
        $query->bindParam(':categoryDescription', $categoryDescription);
        $query->bindParam(':id', $id);
        $query->execute();
        
        // Redirect back to index.php after successfully updating the category
        echo "<script>alert('Category updated successfully'); location.assign('index.php');</script>";
    }
}

// Delete Category
if(isset($_GET['cid'])){
    $categoryId = $_GET['cid'];
    $query = $pdo->prepare("DELETE FROM category WHERE category_id = :categoryId");
    $query->bindParam(':categoryId', $categoryId);
    $query->execute();
    echo "<script>alert('Category deleted successfully'); location.assign('view-categories.php');</script>";
}

// Add Brand
if(isset($_POST['addbrand'])){
    $brandName = $_POST['brandname'];
    $brandDescription = $_POST['branddescription'];
    $brandImageName = $_FILES['brandimage']['name'];
    $brandImageTmpName = $_FILES['brandimage']['tmp_name'];
    $extension = pathinfo($brandImageName, PATHINFO_EXTENSION);
    $destination = "../assets/img/brand-image/" . $brandImageName;
    
    // Check if the uploaded file has a valid extension
    if($extension == "jpg" || $extension == "png" || $extension == "jpeg") {
        // Move the uploaded file to the destination folder
        if(move_uploaded_file($brandImageTmpName, $destination)){
            // Prepare and execute the SQL query to insert the new brand into the database
            $query = $pdo->prepare("INSERT INTO brands (brands_name, brands_des, brands_logo) VALUES (:brandName, :brandDescription, :brandImageName)");
            $query->bindParam(':brandName', $brandName);
            $query->bindParam(':brandDescription', $brandDescription);
            $query->bindParam(':brandImageName', $brandImageName);
            $query->execute();
            
            // Redirect back to index.php after successfully adding the brand
            echo "<script>alert('Brand added successfully'); location.assign('index.php');</script>";
        } else {
            echo "<script>alert('Failed to move uploaded file');</script>";
        }
    } else {
        echo "<script>alert('Invalid file extension');</script>";
    } 
}

// Update Brand
if(isset($_POST['updatebrand'])){
    $id = $_GET['id'];
    $brandName = $_POST['brandname'];
    $brandDescription = $_POST['branddescription'];
    
    // Check if a new image is uploaded
    if(isset($_FILES['brandimage']) && $_FILES['brandimage']['error'] === UPLOAD_ERR_OK){
        $brandImageName = $_FILES['brandimage']['name'];
        $brandImageTmpName = $_FILES['brandimage']['tmp_name'];
        $extension = pathinfo($brandImageName, PATHINFO_EXTENSION);
        $destination = "../assets/img/brand-image/" . $brandImageName;
        
        // Check if the uploaded file has a valid extension
        if($extension == "jpg" || $extension == "png" || $extension == "jpeg") {
            // Move the uploaded file to the destination folder
            if(move_uploaded_file($brandImageTmpName, $destination)){
                // Prepare and execute the SQL query to update the brand in the database
                $query = $pdo->prepare("UPDATE brands SET brands_name = :brandName, brands_des = :brandDescription, brands_logo = :brandImageName WHERE brands_id = :id");
                $query->bindParam(':brandName', $brandName);
                $query->bindParam(':brandDescription', $brandDescription);
                $query->bindParam(':brandImageName', $brandImageName);
                $query->bindParam(':id', $id);
                $query->execute();
                
                // Redirect back to index.php after successfully updating the brand
                echo "<script>alert('Brand updated successfully'); location.assign('index.php');</script>";
            } else {
                echo "<script>alert('Failed to move uploaded file');</script>";
            }
        } else {
            echo "<script>alert('Invalid file extension');</script>";
        }
    } else {
        // If no new image is uploaded, update only brand name and description
        $query = $pdo->prepare("UPDATE brands SET brands_name = :brandName, brands_des = :brandDescription WHERE brands_id = :id");
        $query->bindParam(':brandName', $brandName);
        $query->bindParam(':brandDescription', $brandDescription);
        $query->bindParam(':id', $id);
        $query->execute();
        
        // Redirect back to index.php after successfully updating the brand
        echo "<script>alert('Brand updated successfully'); location.assign('index.php');</script>";
    }
}

// Delete Brand
if(isset($_GET['bid'])){
    $brandId = $_GET['bid'];
    $query = $pdo->prepare("DELETE FROM brands WHERE brands_id = :brandId");
    $query->bindParam(':brandId', $brandId);
    $query->execute();
    echo "<script>alert('Brand deleted successfully'); location.assign('view-brands.php');</script>";
}

// Add Junior Category
if(isset($_POST['addjuniorcategory'])){
    $juniorCategoryName = $_POST['juniorcategoryname'];
    $categoryId = $_POST['cId']; // Assuming the category ID is obtained from the form
    
    // Upload image
    $juniorCategoryImageName = $_FILES['juniorcategoryimage']['name'];
    $juniorCategoryImageTmpName = $_FILES['juniorcategoryimage']['tmp_name'];
    $extension = pathinfo($juniorCategoryImageName, PATHINFO_EXTENSION);
    $destination = "../assets/img/junior-category-image/" . $juniorCategoryImageName;
    
    // Check if the uploaded file has a valid extension
    if($extension == "jpg" || $extension == "png" || $extension == "jpeg") {
        // Move the uploaded file to the destination folder
        if(move_uploaded_file($juniorCategoryImageTmpName, $destination)){
            // Prepare and execute the SQL query to insert the new junior category into the database
            $query = $pdo->prepare("INSERT INTO jonior_category (jonior_category_name, jonior_category_image, jonior_category_category_id) VALUES (:juniorCategoryName, :juniorCategoryImageName, :categoryId)");
            $query->bindParam(':juniorCategoryName', $juniorCategoryName);
            $query->bindParam(':juniorCategoryImageName', $juniorCategoryImageName);
            $query->bindParam(':categoryId', $categoryId);
            $query->execute();
            
            // Redirect back to index.php after successfully adding the junior category
            echo "<script>alert('Junior category added successfully'); location.assign('index.php');</script>";
        } else {
            echo "<script>alert('Failed to move uploaded file');</script>";
        }
    } else {
        echo "<script>alert('Invalid file extension');</script>";
    }
}

// Update Junior Category
if(isset($_POST['updatejuniorcategory'])){
    $id = $_GET['id'];
    $juniorCategoryName = $_POST['juniorcategoryname'];
    $categoryId = $_POST['cId']; // Assuming the category ID is obtained from the form
    
    // Check if a new image is uploaded
    if(isset($_FILES['junior_category_image']) && $_FILES['junior_category_image']['error'] === UPLOAD_ERR_OK){
        $juniorCategoryImageName = $_FILES['junior_category_image']['name'];
        $juniorCategoryImageTmpName = $_FILES['junior_category_image']['tmp_name'];
        $extension = pathinfo($juniorCategoryImageName, PATHINFO_EXTENSION);
        $destination = "../assets/img/junior-category-image/" . $juniorCategoryImageName;
        
        // Check if the uploaded file has a valid extension
        if(in_array($extension, array("jpg", "jpeg", "png"))) {
            // Move the uploaded file to the destination folder
            if(move_uploaded_file($juniorCategoryImageTmpName, $destination)){
                // Prepare and execute the SQL query to update the junior category in the database
                $query = $pdo->prepare("UPDATE jonior_category SET jonior_category_name = :juniorCategoryName, jonior_category_image = :juniorCategoryImageName, jonior_category_category_id = :categoryId WHERE jonior_category_id = :id");
                $query->bindParam(':juniorCategoryName', $juniorCategoryName);
                $query->bindParam(':juniorCategoryImageName', $juniorCategoryImageName);
                $query->bindParam(':categoryId', $categoryId);
                $query->bindParam(':id', $id);
                $query->execute();
                
                // Redirect back to index.php after successfully updating the junior category
                echo "<script>alert('Junior category updated successfully'); location.assign('index.php');</script>";
            } else {
                echo "<script>alert('Failed to move uploaded file');</script>";
            }
        } else {
            echo "<script>alert('Invalid file extension');</script>";
        }
    } else {
        // If no new image is uploaded, update only junior category name and category ID
        $query = $pdo->prepare("UPDATE jonior_category SET jonior_category_name = :juniorCategoryName, jonior_category_category_id = :categoryId WHERE jonior_category_id = :id");
        $query->bindParam(':juniorCategoryName', $juniorCategoryName);
        $query->bindParam(':categoryId', $categoryId);
        $query->bindParam(':id', $id);
        $query->execute();
        
        // Redirect back to index.php after successfully updating the junior category
        echo "<script>alert('Junior category updated successfully'); location.assign('index.php');</script>";
    }
}

// Delete Junior Category
if(isset($_GET['jcid'])){
    $juniorCategoryId = $_GET['jcid'];
    $query = $pdo->prepare("DELETE FROM jonior_category WHERE jonior_category_id = :juniorCategoryId");
    $query->bindParam(':juniorCategoryId', $juniorCategoryId);
    $query->execute();
    echo "<script>alert('Junior category deleted successfully'); location.assign('view-junior-category.php');</script>";
}

// Add Product
if(isset($_POST['addproduct'])){
    $productName = $_POST['productname'];
    $productDescription = $_POST['description'];
    $productCode = $_POST['productcode'];
    $productNumber = $_POST['productnumber'];
    $productBrandId =$_POST['bId']; 
    $price = $_POST['price'];
    $productQuantity = $_POST['productquantity'];
    $categoryId = $_POST['cId']; // Assuming the category ID is obtained from the form
    
    // Upload image
    $productImageName = $_FILES['productimage']['name'];
    $productImageTmpName = $_FILES['productimage']['tmp_name'];
    $extension = pathinfo($productImageName, PATHINFO_EXTENSION);
    $destination = "../assets/img/product-image/" . $productImageName;
    
    // Check if the uploaded file has a valid extension
    if(in_array($extension, array("jpg", "jpeg", "png", "gif", "webp"))) {
        // Move the uploaded file to the destination folder
        if(move_uploaded_file($productImageTmpName, $destination)){
            // Prepare and execute the SQL query to insert the new product into the database
            $productId = $productCode . str_pad($productNumber, 5, '0', STR_PAD_LEFT); // Concatenate product code with zero-padded product number
            $query = $pdo->prepare("INSERT INTO product (product_id, product_code, product_number, product_name, description, price, product_qty, product_image, product_brand_id , product_jonior_category_id) VALUES (:productId, :productCode, :productNumber, :productName, :productDescription, :price, :productQuantity ,:productImageName, :product_brand_id, :categoryId)");
            $query->bindParam(':productId', $productId);
            $query->bindParam(':productCode', $productCode);
            $query->bindParam(':productNumber', $productNumber);
            $query->bindParam(':productName', $productName);
            $query->bindParam(':productDescription', $productDescription);
            $query->bindParam(':price', $price);
            $query->bindParam(':productQuantity', $productQuantity);
            $query->bindParam(':productImageName', $productImageName);
            $query->bindParam(':product_brand_id', $productBrandId);
            $query->bindParam(':categoryId', $categoryId);
            $query->execute();
            
            // Redirect back to index.php after successfully adding the product
            echo "<script>alert('Product added successfully'); location.assign('view-product.php');</script>";
        } else {
            echo "<script>alert('Failed to move uploaded file');</script>";
        }
    } else {
        echo "<script>alert('Invalid file extension');</script>";
    }
}

// Update Product
if(isset($_POST['updateproduct'])){
    $id = $_GET['id']; // Assuming the product ID is obtained from the URL query parameter
    $productName = $_POST['productname'];
    $productDescription = $_POST['description'];
    $productCode = $_POST['productcode'];
    $productNumber = $_POST['productnumber'];
    $productBrandId = $_POST['bId']; // Assuming the brand ID is obtained from the form
    $price = $_POST['price'];
    $productQuantity = $_POST['productquantity'];
    $categoryId = $_POST['cId']; // Assuming the category ID is obtained from the form
    
    // Check if a new image is uploaded
    if(isset($_FILES['productimage']) && $_FILES['productimage']['error'] === UPLOAD_ERR_OK){
        $productImageName = $_FILES['productimage']['name'];
        $productImageTmpName = $_FILES['productimage']['tmp_name'];
        $extension = pathinfo($productImageName, PATHINFO_EXTENSION);
        $destination = "../assets/img/product-image/" . $productImageName;
        
        // Check if the uploaded file has a valid extension
        if(in_array($extension, array("jpg", "jpeg", "png", "gif", "webp"))) {
            // Move the uploaded file to the destination folder
            if(move_uploaded_file($productImageTmpName, $destination)){
                // Prepare and execute the SQL query to update the product in the database
                $query = $pdo->prepare("UPDATE product SET product_code = :productCode, product_number = :productNumber, product_name = :productName, description = :productDescription, price = :price, product_qty = :productQuantity, product_image = :productImageName, product_brand_id = :productBrandId, product_jonior_category_id = :categoryId WHERE product_id = :id");
                $query->bindParam(':productCode', $productCode);
                $query->bindParam(':productNumber', $productNumber);
                $query->bindParam(':productName', $productName);
                $query->bindParam(':productDescription', $productDescription);
                $query->bindParam(':price', $price);
                $query->bindParam(':productQuantity', $productQuantity);
                $query->bindParam(':productImageName', $productImageName);
                $query->bindParam(':productBrandId', $productBrandId);
                $query->bindParam(':categoryId', $categoryId);
                $query->bindParam(':id', $id);
                $query->execute();
                
                // Redirect back to view-product.php after successfully updating the product
                echo "<script>alert('Product updated successfully'); location.assign('view-product.php');</script>";
            } else {
                echo "<script>alert('Failed to move uploaded file');</script>";
            }
        } else {
            echo "<script>alert('Invalid file extension');</script>";
        }
    } else {
        // If no new image is uploaded, update product without changing the image
        $query = $pdo->prepare("UPDATE product SET product_code = :productCode, product_number = :productNumber, product_name = :productName, description = :productDescription, price = :price, product_qty = :productQuantity, product_brand_id = :productBrandId, product_jonior_category_id = :categoryId WHERE product_id = :id");
        $query->bindParam(':productCode', $productCode);
        $query->bindParam(':productNumber', $productNumber);
        $query->bindParam(':productName', $productName);
        $query->bindParam(':productDescription', $productDescription);
        $query->bindParam(':price', $price);
        $query->bindParam(':productQuantity', $productQuantity);
        $query->bindParam(':productBrandId', $productBrandId);
        $query->bindParam(':categoryId', $categoryId);
        $query->bindParam(':id', $id);
        $query->execute();
        
        // Redirect back to view-product.php after successfully updating the product
        echo "<script>alert('Product updated successfully'); location.assign('view-product.php');</script>";
    }
}

// Add Carousel
if(isset($_POST['addCarousel'])){
    $categoryName = $_POST['categoryname'];
    $categoryDescription = $_POST['categorydescription'];
    $categoryImageName = $_FILES['employeeimage']['name'];
    $categoryImageTmpName = $_FILES['employeeimage']['tmp_name'];
    $extension = pathinfo($categoryImageName, PATHINFO_EXTENSION);
    $destination = "../assets/img/Carousel_image/" . $categoryImageName;
    
    // Check if the uploaded file has a valid extension
    if($extension == "jpg" || $extension == "png" || $extension == "jpeg"|| $extension == "avif") {
        // Move the uploaded file to the destination folder
        if(move_uploaded_file($categoryImageTmpName, $destination)){
            // Prepare and execute the SQL query to insert the new category into the database
            $query = $pdo->prepare("INSERT INTO carousel (Carousel_heading, Carousel_paragraph, Carousel_image) VALUES (:categoryName, :categoryDescription, :categoryImageName)");
            $query->bindParam(':categoryName', $categoryName);
            $query->bindParam(':categoryDescription', $categoryDescription);
            $query->bindParam(':categoryImageName', $categoryImageName);
            $query->execute();
            
            // Redirect back to index.php after successfully adding the category
            echo "<script>alert('Carousel added successfully'); location.assign('view_Carousel.php');</script>";
        } else {
            echo "<script>alert('Failed to move uploaded file');</script>";
        }
    } else {
        echo "<script>alert('Invalid file extension');</script>";
    }
}
?>