 <?php

include '../../config/constant.php';
include './myfunctions.php';

if(isset($_POST['add_category_btn'])) {
    
    $query = "SELECT * FROM categories ORDER BY catId desc limit 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $lastId = $row['catId'];
    if($lastId == "") {
        $catId = "C1001";
    } else {
        $catId = substr($lastId, 1);
        $catId = intval($catId);
        $catId = "C".($catId + 1);
    }
    
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1':'0';
    $popular = isset($_POST['popular']) ? '1':'0';
    
    $image = $_FILES['image']['name'];
    $path = "../Images";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_ext;
    
    $query = "INSERT INTO categories (catId,catName,slug,description,meta_title,meta_description,meta_keywords,status,popular,image)"
            . "VALUES ('$catId','$name','$slug','$description','$meta_title','$meta_description','$meta_keywords','$status','$popular','$filename')";
    
    $cate_query_run = mysqli_query($conn, $query);
    if ($cate_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$filename);
        redirect("../main.php?add-category", "Category Added Successfully");
    } else {
        errorRedirect("../main.php?add-category", "Something Went Wrong");
    }
} 
else if(isset($_POST['update_category_btn'])) {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description = $_POST['description'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $meta_keywords = $_POST['meta_keywords'];
    $status = isset($_POST['status']) ? '1':'0';
    $popular = isset($_POST['popular']) ? '1':'0';
    
    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];
    
    if($new_image != "") {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time().'.'.$image_ext;
    } else {
        $update_filename = $old_image;
    }
    $path = "../Images";
    
    $update_query = "UPDATE categories SET catName='$name',slug='$slug',description='$description',meta_title='$meta_title',"
            . "meta_description='$meta_description',meta_keywords='$meta_keywords',status='$status',popular='$popular',"
            . "image='$update_filename' WHERE catId='$category_id'";
    
    $update_query_run = mysqli_query($conn, $update_query);
    if($update_query_run) {
        if($_FILES['image']['name'] != "") {
            move_uploaded_file($_FILES['image']['tmp_name'], $path.'/'.$update_filename);
            if(file_exists("../Images/".$old_image)) {
                unlink("../Images/".$old_image);
            }
        }
        redirect("../main.php?edit-category&id=$category_id", "Category Updated Successfully");
    } else {
        errorRedirect("../main.php?edit-category&id=$category_id", "Something Went Wrong");
    }
}
else if(isset($_POST['delete_category_btn'])) {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    
    $category_query = $conn->query("SELECT * FROM categories WHERE catId='$category_id'");
    $category_data = mysqli_fetch_array($category_query);
    $image = $category_data['image'];
    
    $delete_query = $conn->query("DELETE FROM categories WHERE catId='$category_id'");
    
    if($delete_query) {
        if(file_exists("../Images/".$image)) {
            unlink("../Images/".$image);
        }
        redirect("../main.php?categories", "Category Deleted Successfully");
    } else {
        errorRedirect("../main.php?categories", "Something Went Wrong");
    }
} 
else {
    header("Location: ../main.php");
}

?>