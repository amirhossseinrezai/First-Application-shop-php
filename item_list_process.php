<?php
    require('./db.create_database.php');
    if(isset($_REQUEST['item_id'])){
        $delete_sql = "DELETE FROM item WHERE item_id='$_REQUEST[item_id]'";
        $connect->exec($delete_sql);
    }
    if(isset($_REQUEST['up_item_id'])){
        $title = $_REQUEST['title'];
        $description = $_REQUEST['description'];
        $category = $_REQUEST['category'];
        $qty = $_REQUEST['qty'];
        $cost = $_REQUEST['cost'];
        $price = $_REQUEST['price'];
        $discount = $_REQUEST['discount'];
        if($_REQUEST['image']){
            $img_dir = "images/";
            $dir = $img_dir.$_REQUEST['image'];
            $operation = move_uploaded_file($_REQUEST['image'], $dir);
            if ($operation){
                $insert_add_items = "UPDATE item SET item_image='$dir', item_title='$title', item_description='$description', item_qty='$qty', item_cost='$cost',
                 item_price='$price', item_discount='$discount',item_cat='$cat'";
                $connect->exec($insert_add_items);
            }
            else{
                $insert_add_items = "UPDATE item SET item_image='$dir', item_title='$title', item_description='$description', item_qty='$qty', item_cost='$cost',
                item_price='$price', item_discount='$discount',item_cat='$cat'";
                $connect->exec($insert_add_items);
            }
        }
    }
    if(isset($_REQUEST['edit_item_id'])){

    }

?>
<!DOCTYPE html>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Image</th>
                            <th>Item Title</th>
                            <th>Item Decription</th>
                            <th>Item Category</th>
                            <th>Item Qty</th>
                            <th>Item Cost</th>
                            <th>Item Price</th>
                            <th>Item Discount</th>
                            <th>Item Deliver</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $c = 1;
                            $select_items = "SELECT * FROM item";
                            $result = $connect->prepare($select_items);
                            $result->execute();
                            foreach($result as $val){
                                $discounted_price = $val['item_price'] - $val['item_discount'];
                                echo "
                                    <tr>
                                        <td>$c</td>
                                        <td><img src='$val[item_image]' style='width: 50px;'></td>
                                        <td>$val[item_title]</td>
                                        <td>$val[item_description]</td>
                                        <td>$val[item_qty]</td>
                                        <td>$val[item_cost]</td>
                                        <td>$val[item_price]</td>
                                        <td>$discounted_price</td>
                                        <td>$val[item_cat]</td>
                                        <td>10</td>
                                        <td>
                                            <div class='dropdown'>
                                                <button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown'>Edit</button>
                                                <div class='dropdown-menu'>";?>
                                                    <a class='dropdown-item'  href='#test_modal<?=$val['item_id']?>' data-toggle='modal'>Edit</a>
                                                    <a class='dropdown-item' href="javascript:;" onclick="deleteItem(<?php echo $val['item_id'];?>);">Delete</a>

                                                </div>
                                                <div class='modal fade show' id="test_modal<?=$val['item_id']?>"><?php echo "
                                                    <div class='modal-dialog'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <div class='col-md-6 float-left'>
                                                                    <h3 class=''>Edit Item</h3>
                                                                </div>
                                                                <div class='col-md-6' float-tight>
                                                                    <button class='close' data-dismiss='modal'>&times;</button>
                                                                </div>
                                                            </div>
                                                            <div id='modal_body' class='modal-body'>
                                                                <form method='post' enctype='multipart/form-data'>
                                                                    <div class='form-group'>
                                                                        <div class='col-md-9 float-left' style='padding-left: 0;'>
                                                                            <label for='image'>Change Image</label>
                                                                            <input type='file' name='image' id='image' class='form-control'>
                                                                        </div>
                                                                        <div class='col-md-3 float-right' style='padding-right: 0;'><img src='$val[item_image]' style='width: 100px;'></div>
                                                                        <div class='clearfix'></div>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <label for='title'>Edit Title</label>
                                                                        <input type='text' name='title' id='title' class='form-control' value='$val[item_title]'>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <label for='description'>Edit Description</label>
                                                                        <textarea name='description' id='description' class='form-control'>$val[item_description]</textarea>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <label for='cat'>Edit Category</label>
                                                                        <select name='cat' id='category' class='form-control' value='$val[item_cat]'>
                                                                            <option>Select Category</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                    <label for='qty'>Edit Cost</label>
                                                                        <input type='number' name='qty' id='qty' class='form-control' value='$val[item_qty]'>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <label for='cost'>Edit Cost</label>
                                                                        <input type='number' name='cost' id='cost' class='form-control' value='$val[item_cost]'>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <label for='price'>Edit Price</label>
                                                                        <input type='number' name='price' id='price' class='form-control' value='$val[item_price]'>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <label for='discount'>Edit Discount</label>
                                                                        <input type='number' name='discount' id='discount' class='form-control' value='$discounted_price'>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                        <input type='hidden' id='edit_id' value='$val[item_id]'>";?>
                                                                        <button type='button'  id='btn_edit_save' class='btn btn-success btn-block form-control' onclick="edit_save_btn_item(<?php echo $val['item_id'];?>);" >Save</button>
                                                                    <?php echo "
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button class='btn btn-danger' data-dismiss='modal'>Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                ";
                                $c++;
                            }
                        ?>
                </tbody>
            </table>
        </div>