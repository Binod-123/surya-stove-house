<?php 

 include("header.php");
 ?>

<!--breadcrumb area end-->
<?php if(!empty($_SESSION['product'])){?>
<form id="mycartForm" action="booking.php" method="POST">
    <div class="container cart-container ">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($_SESSION['product'] as $product):?>
                <tr data-product-id="<?=$product['id']?>">
                    <td><?=$product['name']?>
                    </td>
                    <td><img class="cart-image" src="images/<?=$product['image']?>" alt="Product 1">  </td>
                    <td class="quantity-controls">
                        <button type="button" onclick="updateQuantity(-1,this)">-</button>
                        <input type="text" name="quantity[]" id="quantity" value="<?=$product['quantity']?>" readonly>
                        <button type="button" onclick="updateQuantity(1,this)">+</button>
                    </td>
                    <td class="price"><?=$product['price']?></td>
                    <td class="total-price"><?php echo $product['price']* $product['quantity'];?> </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>

        <div class="summary">
            <h3>Order Summary</h3>
            <div class="summary-item">
                <span>Subtotal:</span>
                <span id="subtotal">00.00</span>
            </div>
            <div class="summary-item">
                <span>GST (18%):</span>
                <span id="gst">00.00</span>
            </div>
            <div class="summary-item total">
                <span>Grand Total (Including GST):</span>
                <span id="grandtotal">00.00</span>
            </div>
            <div class="summary-item total">
                <button type="submit" class="book-now" >Book Now</button>
            </div>
        </div>


    </div>
</form>
<?php } else{?>
<div class="empty-cart text-center">
    <img src="assets/img/empty-cart.png" class="img-fluid" style="height:200px;" alt="" />
    <h2>Your Cart is empty.</h2>
</div>
<?php }?>

<footer class="bg-dark text-white" style="position: absolute; bottom:0px; width:100%;">
    <p class="text-center p-2 m-0">surya stove house</p>
</footer>
<!-- Bootstrap JS and Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="js/cart.js"></script>
<script src="js/main.js"></script>
<script>


</script>
</body>

</html>