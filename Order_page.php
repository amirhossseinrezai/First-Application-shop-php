<!DOCTYPE html>
<html>
    <head>
        <title>Order</title>
        <link rel='stylesheet' href='css/bootstrap-v4.css'>
        <script src='js/jquery.js'></script>
        <script src="js/bootstrap.bundle.js"></script>
        <script>
            var xhr = new XMLHttpRequest();
            function getOrderedData(){
                xhr.open('GET', './Order_list_process.php', true);
                xhr.onreadystatechange = function(){
                    if(xhr.readyState == 4 && xhr.status== 200){
                        document.getElementById('order_list_container').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            }
            function status(id, status){
                if(status == 0){
                    status = 1;
                }else{
                    status = 0;
                }
                $(document).ready(function(){
                    $.ajax({url:'./Order_list_process.php?order_id='+id+'&status='+status,
                                async:true,
                                type:'GET',
                                success: function(data){
                                    $('#order_list_container').html(data);
                                }
                            });
                });
            }
        </script>
    </head>
    <body onload='getOrderedData();'>
        <?php require('./include/header.php');?>
        <div class='container' style='padding:0;'>
            <div id='order_list_container'></div><br><br><br><br><br>
        </div>
        <?php require('./include/footer.html');?>
    </body>
</html>