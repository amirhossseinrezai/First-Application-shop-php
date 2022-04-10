<?php
    require('./db.create_database.php');
    session_start();
    if(isset($_GET['item_id'])){
        $date = date('y-m-d h:m:s');
        $rand_num = bin2hex(mt_rand());
        $select_checking_existing = "SELECT chk_item FROM checkout";
        $result = $connect->prepare($select_checking_existing);
        $result->execute();
        $result = $result->fetchAll();
        try{
            $_SESSION['ref'] = $date ."_". $rand_num;
            $sql_insert = "INSERT INTO checkout(chk_item, chk_ref, chk_timing, chk_qty) VALUES('$_GET[item_id]', '$_SESSION[ref]', '$date', 1);";
            $connect->exec($sql_insert);
        }catch(EXCEPTION $e){
            // echo "<script type='text/javascript'>alert('Dont refresh the page!');</script>";
        }
    }

    if(isset($_POST['order_submit'])){
        $sql_insert_order = "INSERT INTO orders(order_name, order_email, order_contact, order_state, order_delivery_address, order_checkout_ref, order_total)
         VALUES('$_POST[name]', '$_POST[email]', '$_POST[contact_number]', '$_POST[state]', '$_POST[delivery_address]', '$_SESSION[ref]', '$_SESSION[total]')";
        $connect->exec($sql_insert_order);
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <title> Buy Page</title>
        <link rel="stylesheet" href="style-test-project.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.js"></script>
        <script defer  src="js/all.js"></script>
        <style>
            .btn-proceed{
                margin-top: 10px;
                width: 200px;
            }
        </style>
        <script>
            function  showResponse(value){
                var tBody = document.getElementById('item_details');
                tBody.innerHTML = value;
            }
            function readData(){
                var xhr = new XMLHttpRequest();
                xhr.open('GET', './buy_process.php', true);
                xhr.onreadystatechange = function(){
                    if(xhr.readyState == 4 && xhr.status == 200){
                        var response = this.responseText;
                        showResponse(response);
                    }
                };
                xhr.send();
            }
            function deleteResponse(value){
                document.getElementById('item_details').innerHTML = value;
            }
            function deleteItems(chk_id){
                // alert('Are You sure you want to delete that?');
                var xhr = new XMLHttpRequest();
                xhr.open('GET', './buy_process.php?item_id='+ chk_id, true);
                xhr.onreadystatechange = function(){
                    if(xhr.readyState == 4 && xhr.status == 200){
                        deleteResponse(xhr.responseText);
                    }
                };
                xhr.send();
            }
            function up_chk_qty(chk_qty, chk_id){
                var xhr = new XMLHttpRequest();
                xhr.open('GET', './buy_process.php?qty_chk=' + chk_qty + '&&chk_id=' + chk_id, true);
                xhr.onreadystatechange = function(){
                    if(xhr.readyState == 4 && xhr.status == 200){
                        document.getElementById('item_details').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            }
        </script>
    </head>
    <body onload='readData();'>
        <?php require('./header.php');?>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li><a href="test-project.php">Home</a></li>
                        <li><a href="product.php">product</a></li>
                        <li class="active">Buy</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="pull-left"><h3>Order Details</h3></div>
                            <div class="pull-right"><a class="btn btn-success btn-lg btn-proceed" data-toggle="modal" href="#proceed_modal" data-backdrop="static" data-keyboard="false">Proceed</a></div>
                            <div id="proceed_modal" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header"><button class="close" data-dismiss="modal">&times;</button></div>
                                        <div class="modal-body">
                                            <form method="POST">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" id="name" name="name" class="form-control"><br>
                                                    <label for="email">Email Address</label>
                                                    <input type="email" id="email" name="email" class="form-control"><br>
                                                    <label for="contact">Contact Number</label>
                                                    <input type="number" id="contact" name="contact_number" class="form-control"><br>
                                                    <label for="state">State</label>
                                                    <input list="state" name="state" class="form-control">
                                                    <datalist id="state">
                                                        <option>Washington</option>
                                                        <option>New York</option>
                                                        <option>Florida</option>
                                                        <option>Kansas</option>
                                                        <option>Nebraska</option>
                                                        <option>Origon</option>
                                                        <option>Indiana</option>
                                                        <option>Ohio</option>
                                                    </datalist><br>
                                                    <label for="delivery">Delivery Address</label>
                                                    <textarea id="delivery" name="delivery_address" class="form-control"></textarea><br>
                                                    <input type="submit" name="order_submit" class="btn btn-danger btn-lg btn-block" value="OK">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer"><button class="btn btn-default" data-dismiss="modal">Close</button></div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div id="item_details"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div><br><br><br><br><br>
        <?php require('footer.php');?>
    </body>
</html>