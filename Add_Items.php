<!DOCTYPE html>
<html>
    <head>
        <title> Add Items</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="style-test-project.css">
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <script defer src="js/all.js"></script>

        <style>
            #submit{
                padding-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <?php require('./header.php');?>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form action="Add_Items.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="image">Upload Item Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="qty">Quantity</label>
                            <input type="number" name="qty" id="qty" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="cost">Cost</label>
                            <input type="number" name="cost" id="cost" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" id="price" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" name="category" id="category" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="discount">Discount</label>
                            <input type="number" name="discount" id="discount" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Submit" id="submit" class="form-control btn btn-success btn-lg">
                        </div>
                    </form>
                </div>
                <?php
                    require('./db.create_database.php');
                    if(isset($_POST['submit'])){
                        $img_dir = "images/";
                        $dir = $img_dir.$_FILES['image']['name'];
                        $operation = move_uploaded_file($_FILES['image']['tmp_name'], $dir);
                        $title = $_POST['title'];
                        $description = $_POST['description'];
                        $qty = $_POST['qty'];
                        $cost = $_POST['cost'];
                        $price = $_POST['price'];
                        $category = $_POST['category'];
                        $discount = $_POST['discount'];
                        if($operation){
                            $insert_query = "INSERT INTO item(item_image, item_title, item_description, item_qty, item_cost, item_price, item_cat, item_discount)
                            VALUES('$dir', '$title', '$description', '$qty', '$cost', '$price', '$category', '$discount');";
                            $connect->exec($insert_query);
                        }
                        $id = $connect->lastInsertId();
                        $result = $connect->prepare("SELECT item_image FROM item WHERE item_id='$id'");
                        $result->execute();
                        $img_path = "";
                        foreach($result as $value){
                            $img_path = $value[0];
                        }
                    }
                ?>
                <div class='col-md-3'>
                    <img src='<?php echo $img_path;?>' id='img' class='img-responsive img-thumbnail pull-right' style='width: 200px; height:200px; margin-top: 22px;'>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div><br><br><br><br><br>
        <?php require('./footer.php');?>
    </body>
</html>