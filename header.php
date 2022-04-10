<nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./test-project.php">Online Shopping</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="test-project.php">Home</a></li>
                    <?php
                        require('./db.create_database.php');
                        $select = "SELECT * FROM item_cat";
                        $result = $connect->prepare($select);
                        $result->execute();
                        foreach($result as $value){
                            $cat_name = ucwords($value['cat_name']);
                            if($value['cat_slug'] == ''){
                                $cat_slug = $value['cat_name'];
                            }else{
                                $cat_slug = $value['cat_slug'];
                            }
                            echo "<li><a href='./category.php?category=$cat_slug'>$cat_name</a></li>";
                        }
                    ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">LogOut</a></li>
                    <li><a href="Add_Items.php">Add Items</a></li>
                </ul>
            </div>
        </nav>