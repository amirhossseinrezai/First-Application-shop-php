<?php
    require('./db.create_database.php');
    if(isset($_REQUEST['order_id'])){
        $up_select = "UPDATE orders SET order_status='$_REQUEST[status]'  WHERE order_id='$_REQUEST[order_id]'";
        $connect->exec($up_select);
    }
?>
<!DOCTYPE html>
<table class='table table-responsive table-striped ' style='margin-top: 40px; width:100%;'>
    <thead>
        <tr style='white-space:nowrap; text-align:center;' >
            <th>S.No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>State</th>
            <th style='white-space:nowrap;'>Delivery Address</th>
            <th >Checkout Reference</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
            require('./db.create_database.php');
            $select = "SELECT * FROM orders";
            $ex_query = $connect->prepare($select);
            $ex_query->execute();
            $s_no = 0;
            foreach($ex_query as $value){
                $s_no +=1;
                $id = $value['order_id'];
                $name = $value['order_name'];
                $email = $value['order_email'];
                $contact = $value['order_contact'];
                $state = $value['order_state'];
                $delivery_adddress = $value['order_delivery_address'];
                $checkout_ref = $value['order_checkout_ref'];
                $total = $value['order_total'];
                $status = $value['order_status'];
        ?>
                <tr>
                    <td class='text-center'><?=$s_no;?></td>
                    <td><?=$name?></td>
                    <td><?=$email?></td>
                    <td><?=$contact?></td>
                    <td><?=$state?></td>
                    <td><?=$delivery_adddress?></td>
                    <td><?=$checkout_ref?></td>
                    <td><?=$total?></td>
                    <?php
                        if($status == 0){
                            $status_value = 'Sent';
                            $btnClass = 'btn-success';
                        }else{
                            $status_value = 'Pending';
                            $btnClass = 'btn-warning';
                        }
                        ?><td><button id='status<?=$id?>' class='btn <?=$btnClass;?> btn-block' onclick='status(<?php echo $id.",".$status;?>);'><?=$status_value?></button></td><?php
                    ?>
                </tr>
        <?php
        }
        ?>
    </tbody>
</table>