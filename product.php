<?php
    $src;
    if(isset($_REQUEST['src'])){
        $src=$_REQUEST['src'];
    }
?>
<!DOCTYPE html>
<html>
    <header>
        <title>Product Details</title>
        <link rel="stylesheet" href="./style-test-project.css">
        <link rel="stylesheet" href="./css/bootstrap.css">
        <script src="./js/bootstrap.js"></script>
        <script src="./js/jquery.js"></script>
        <script defer  src="./js/all.js"></script>
        <style>
            .btn{
                font-size: 25px;
                width: 96%;
                padding: 10px;
                margin-top:40px;
            }
            .list-group .list-group-item{
                padding-top: 20px;
                padding-bottom: 20px;
                border-right: 0;
                border-left: 0;
            }
            .list-group .list-group-item:hover{
                background-color: #eefbbb;
            }
            .no-padding{
                padding: 0;
            }
            hr {
                margin-bottom: 20px;
                margin-top: 20px;
            }
        </style>
        <?php require('./header.php');?>
    </header>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ol class='breadcrumb'>
                        <li><a href='./test-project.php'>Home</a></li>
                        <?php
                            if(isset($_GET['item_id'])){
                                $select = "SELECT * FROM item WHERE item_id='$_GET[item_id]'";
                                $result = $connect->prepare($select);
                                $result->execute();
                                foreach($result as $value){
                                    echo "
                                        <li><a href='./category.php?category=$value[item_cat]'>$value[item_cat]</a></li>
                                        <li class='active'>$value[item_title]</li>
                                    ";
                                }
                            }
                        ?>
                    </ol>
                </div>
                <div class="col-md-4">
                    <?php
                        $select = "SELECT * FROM item WHERE item_id='$_GET[item_id]'";
                        $result = $connect->prepare($select);
                        $result->execute();
                        foreach($result as $value){
                            echo "
                                <h2>$value[item_title]</h2>
                                <img src='./$value[item_image]' class='product-image img-responsive'>
                                <h4>Description</h4>
                                <div class='pp-desc'>$value[item_description]</div>
                            ";
                        }
                    ?>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <?php
                        echo "<a href='./Buy.php?item_id=$_GET[item_id]' class='btn btn-success btn-lg btn-block'>Buy</a>";
                    ?>
                    <br>
                    <ul class="list-group col-md-11 table">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3"><i class="fas fa-truck fa-2x"></i></div>
                                <div class="col-md-9">Delivered Within 5 Days</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3"><i class="fas fa-sync-alt fa-2x"></i></div>
                                <div class="col-md-9">Delivered Within 5 Days</div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-3"><i class="fas fa-phone fa-2x"></i></div>
                                <div class="col-md-9">Call at 1223435</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <h2>Recomended</h2>
                </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                                $select_related_item = "SELECT * FROM item LIMIT 4";
                                $result = $connect->prepare($select_related_item);
                                $result->execute();
                                foreach($result as $value){
                                    echo "
                                        <a href='./product.php?category=$value[item_cat]&item_id=$value[item_id]'>
                                            <div class='col-md-3'>
                                                <div class='col-md-12 item no-padding'>
                                                    <div class='top'>
                                                        <img src='$value[item_image]'>
                                                    </div>
                                                    <div class='bottom'>
                                                        <h4 class='item-title'>$value[item_title]</h4>
                                                        <div class='pull-right cutted-price text-muted'><del>$ $value[item_cost]</del></div>
                                                        <div class='clearfix'></div>
                                                        <div class='pull-right discounted-price'>$ $value[item_price]</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    ";
                                }
                            ?>
                    </div>
                </div>
            </div>

    </body>
    <footer>
        <br><br><br><br><br>
        <?php require('./footer.php');?>
    </footer>
</html>

