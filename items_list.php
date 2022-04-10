<?php
    require('./db.create_database.php');
    if(isset($_POST['btn_save'])){
        if($_FILES['image']['name']){
            $img_dir = "images/";
            $dir = $img_dir.$_FILES['image']['name'];
            $operation = move_uploaded_file($_FILES['image']['tmp_name'], $dir);
            if ($operation){
                $insert_add_items = "INSERT INTO item(item_image, item_title, item_description, item_qty, item_cost, item_price, item_discount,item_cat)
                VALUES('$dir', '$_POST[title]', '$_POST[decription]', '$_POST[qty]', '$_POST[cost]', '$_POST[price]', '$_POST[discount]', '$_POST[cat]');";
                $connect->exec($insert_add_items);
                ?><script>window.location = "./items_list.php"</script><?php
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin Page</title>
        <link rel='stylesheet' href='css/bootstrap-v4.css'>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.bundle.js"></script>
        <style>
            #add_button{
                margin-bottom:20px;
                margin-top:20px;
            }
        </style>
    </head>

    <body onload='listItemsContent();'>
       <?php require("./include/header.php");?>
        <div class="container-fluid">
            <div class='col-md-4'>
                <button id='add_button' class='btn btn-success btn-block btn-lg' data-toggle='modal' data-target='#add_item_modal'>Add Items</button>
            </div>
            <div class='modal fade' id='add_item_modal' >
                    <div class='modal-dialog modal-lg'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <div class="col-md-6">
                                <h4 class="float-left">Add Items</h4>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" class="float-right close" data-dismiss="modal">&times;</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class='modal-body' >
                                <form  method='POST' enctype='multipart/form-data'>
                                    <div class="form-group">
                                        <input type="file" name="image" id="image" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Item Title</label>
                                        <input type="text" name="title" id="title" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="textarea">Item Description</label>
                                        <textarea id="textarea" name="decription" class="form-control ">Hello, World!</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="qty">Item Quantity</label>
                                        <input type="number" name="qty" id="qty" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="cost">Item Cost</label>
                                        <input type="number" name="cost" id="cost" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Item Price</label>
                                        <input type="number" name="price" id="price" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="discount">Item Discount</label>
                                        <input type="number" name="discount" id="discount" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="cat">Item Category</label>
                                        <select id="cat" name="cat" class='form-control'>
                                            <option>Select Category</option>
                                        <?php
                                            $select_cat = "SELECT cat_name FROM item_cat";
                                            $result = $connect->prepare($select_cat);
                                            $result->execute();
                                            foreach($result as $val){
                                            echo "<option>$val[cat_name]</option>";
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="btn_save" id="btn_save" value="Save" class="btn btn-success form-control">
                                    </div>
                                </form>
                            </div>
                            <div class='modal-footer'>
                                <button class="btn btn-danger" data-dismiss='modal'>Close</button>
                            </div>
                        </div>
                    </div>
            </div>

            <div id='content_item_list'>

            </div>
        </div><br><br><br><br>
        <?php require("./include/footer.html");?>
        <script>
            var xhr = new XMLHttpRequest();
            function listItemsContent(){
                xhr.open('GET', './item_list_process.php', true);
                xhr.onreadystatechange = function(){
                    if(xhr.readyState == 4 && xhr.status == 200){
                        document.getElementById('content_item_list').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            }
            function deleteItem(item_id){
                xhr.open('GET', './item_list_process.php?item_id='+ item_id, true);
                xhr.onreadystatechange = function(){
                    if (xhr.readyState == 4 && xhr.status == 200){
                        document.getElementById('content_item_list').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            }
            function edit_save_btn_item(){
                var up_item_id = document.getElementById('item_id').value;
                var image = document.getElementById('image').value;
                var title = document.getElementById('title').value;
                var description = document.getElementById('description').value;
                var category = document.getElementById('category').value;
                var qty = document.getElementById('qty').value;
                var cost = document.getElementById('cost').value;
                var price = document.getElementById('price').value;
                var discount = document.getElementById('discount').value;
                xhr.open('GET', './item_list_process.php?up_item_id='+up_item_id+'&image='+image+'&title='+title+'&description='+description+
                '&category='+category+'&qty='+qty+'&cost='+cost+'&price='+price+'&discount='+discount, true);
                xhr.onreadystatechange = function (){
                    if(xhr.readyState == 4 && xhr.status == 200){

                        document.getElementById('content_item_list').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            }

        </script>
    </body>
</html>