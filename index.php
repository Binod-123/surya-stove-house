<?php include 'header.php';?>


    <!-- Product Display -->
    <div class="container">
        <div class="product-container">
            <img src="images/prestige-stove.jpg" alt="Product Image"  class="product-image">
            <h1 class="product-name">Prestige Magic plus Toughened Glass-Top 3</h1>
            <p class="product-description">
            Spill-Proof Design-Stylish design with attractive finish
            Ergonomic Knob Design-The knobs are elegantly designed and are easy to use
            </p>
            <div class="product-price">₹ 4999</div>
            <button id="myButton" class="btn add-to-cart-btn" data-id="1" data-name="Prestige Magic plus Toughened Glass-Top 3" data-image="prestige-stove.jpg" data-price="4999" onclick="addToCart()"><i class="fas fa-cart-plus"></i> Add to Cart</button>
        </div>
    </div>
    <footer class="bg-dark text-white" style="position: absolute; bottom:0px; width:100%;">
  <p class="text-center p-2 m-0">surya stove house</p>
</footer>
    <!-- Bootstrap JS and Dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
    <script src="js/cart.js"></script>
    <script>
       
        // function addToCart() {
        //     // Get the cart counter element
        //     const cartCounter = document.querySelector('.cart-counter');
        //     // Increment the cart count
        //     let count = parseInt(cartCounter.textContent);
        //     cartCounter.textContent = count + 1;
        // }
  
    </script>
</body>
</html>
