<?php
    session_start();
    require('./db.create_database.php');
    if(isset($_REQUEST['item_id'])){
        $delete_sql = "DELETE FROM checkout where chk_item='$_REQUEST[item_id]'";
        $connect->exec($delete_sql);
    }
    if(isset($_REQUEST['qty_chk']) && isset($_REQUEST['chk_id'])){
        $delete_sql = "UPDATE checkout SET  chk_qty='$_REQUEST[qty_chk]' where chk_id='$_REQUEST[chk_id]'";
        $connect->exec($delete_sql);
    }
    echo "
        <div class='panel-body'>
            <div class='col-md-12'>
                <table class='table table-striped table-hover'>
                    <thead>
                        <tr>
                            <th class='text-left'>S.No</th>
                            <th class='text-center'>Item</th>
                            <th class='text-center'>qty</th>
                            <th class='text-center'>Price</th>
                            <th class='text-cente'>Total</th>
                            <th class='text-right'>Delete</th>
                        </tr>
                    </thead>
                    <tbody>";
                    $total = 0;
                    $c = 0;
                    $select = "SELECT * FROM checkout c JOIN item i ON c.chk_item = i.item_id";
                    $result = $connect->prepare($select);
                    $result->execute();
                    foreach($result as $value){
                        $sub_total = $value['chk_qty'] * $value['item_price'];
                        $total += $sub_total;
                        echo "
                            <tr>
                            <td class='text-left'>$c</td>
                            <td class='text-center'>$value[item_title]</td>
                            <td class='text-center'><input type='number' style='width:40px; border:none; margin-left:30px;'  onblur='up_chk_qty(this.value, ".$value['chk_id'].");' value=".$value['chk_qty']."></td>
                            <td class='text-center'>$value[item_price]</td>
                            <td class='text-center'>$sub_total</td>";?>
                            <td class="text-right"><a href="#" class="btn btn-danger" onclick="deleteItems(<?php  echo $value['item_id'];?>);">Delete</a></td>
                            <?php
                            echo "</tr>
                            ";
                            $c++;
                    }
                    $_SESSION['total'] = $total;
                    echo "
                        </tbody>
                            </table>
                            <table class='table table-striped table-hover'>
                                <thead>
                                    <tr>
                                        <th class='text-center' colspan='2'>Order Sumary</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>SubTotal</td>
                                        <td class='text-right'>".$total."/=</td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Charges</td>
                                        <td class='text-right'>Free</td>
                                    </tr>
                                    <tr>
                                        <td>Grand Total</td>
                                        <td class='text-right'>".$_SESSION['total']."/=</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    ";
 ?>