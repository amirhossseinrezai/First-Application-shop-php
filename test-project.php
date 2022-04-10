<?php
    require('./db.create_database.php');
?>
<!DOCTYPE html>
<html>
    <title> Test Project</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="style-test-project.css">
    <script src="js/bootstrap.js"></script>

    <style>
        .no-padding{
            padding: 0;
        }
        .item{
            background-color: lightblue;
            height: 300px;
            box-shadow: 0px 3px 15px lightgray;
            margin-bottom: 20px;
            margin-top: 20px;
            transition: transform 250ms;
            border-radius: 10px;

        }
        .item:hover{
            box-shadow: 4px 3px 25px lightgray;
            transform: scale(102%);
        }
        .top{
            background-color: tomato;
            height: 200px;
            border-radius: 10px 10px 0 0;
        }
            .top img{
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 10px 10px 0 0;
            }
        .bottom{
            background-color: white;
            height: 100px;
            margin: 0;
            padding: 5px 10px 0 10px ;
            border-radius: 0 0 10px 10px;
        }
        .discounted-price{
            font-style: italic;
            font-size: 20px;
            margin-right: 10px;
        }
        .cutted-price{
            font-size: 20px;
            margin-right: 10px;
        }
        .item-title{
            margin-bottom: 0;
        }
    </style>
    <body>
        <?php require('./header.php'); ?>
        <div class="container">
            <?php
                require('./db.create_database.php');
                $select = "SELECT * FROM item";
                $select = $connect->prepare($select);
                $select->execute();
                foreach($select as $value){
                    echo "
                        <a href='product.php?category=$value[item_cat]&item_id=$value[item_id]'>
                            <div class='col-md-3'>
                                <div class='col-md-12 item no-padding'>
                                    <div class='top'>
                                        <img src='$value[item_image]'>
                                    </div>
                                    <div class='bottom'>
                                        <h4 class='item-title'>$value[item_title]</h4>
                                        <div class='pull-right cutted-price text-muted'><del>$ $value[item_price]</del></div>
                                        <div class='clearfix'></div>
                                        <div class='pull-right discounted-price'>$ $value[item_cost]</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        ";
                }
            ?>
        </div>
        <br><br><br><br><br>
        <?php require('./footer.php');?>
    </body>
</html>
