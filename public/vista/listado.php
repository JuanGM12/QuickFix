  <style>

    .product {
      display: flex;
      margin-bottom: 20px;
    }

    .product-image {
      width: 200px;
      height: 200px;
      margin-right: 20px;
    }

    .product-details {
      flex-grow: 1;
    }

    .product-title {
      font-weight: bold;
      font-size: 20px;
      margin-bottom: 5px;
    }

    .product-description {
      margin-bottom: 10px;
    }

    .product-seller {
      font-style: italic;
      margin-bottom: 5px;
    }

    .product-rating {
      color: #ff9900;
      margin-bottom: 5px;
    }

    .product-price {
      font-weight: bold;
    }

    .pagination {
      text-align: center;
      margin-top: 20px;
    }

    .pagination-link {
      display: inline-block;
      margin: 5px;
      padding: 5px 10px;
      background-color: #f2f2f2;
      text-decoration: none;
      color: #333;
    }

    .pagination-link.active {
      background-color: #ccc;
    }
  </style>
    <body class="app">
    <div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
  <div id="product-list">
    <div class="product">
      <img class="product-image" src="/plantilla/images/mecanico.jpg" alt="Producto 1">
      <div class="product-details">
        <h2 class="product-title">Mecánico a domicilio</h2>
        <p class="product-description">Presto servicio de mecánico especializado para cualquier tipo de vehículo</p>
        <p class="product-seller"><a href="catalogo">Ramiro Perez</a></p>
        <p class="product-price">$200.000</p>
      </div>
    </div>
    <div class="product">
      <img class="product-image" src="/plantilla/images/mecanico.jpg" alt="Producto 1">
      <div class="product-details">
        <h2 class="product-title">Mecánico a domicilio</h2>
        <p class="product-description">Presto servicio de mecánico especializado para cualquier tipo de vehículo</p>
        <p class="product-seller"><a href="catalogo">Ramiro Perez</a></p>
        <p class="product-price">$200.000</p>
      </div>
    </div>

    <!-- Agrega más productos aquí -->

  </div>

  <div class="pagination d-block">
    <a class="pagination-link" href="#">1</a>
    <a class="pagination-link" href="#">2</a>
    <a class="pagination-link" href="#">3</a>
    <a class="pagination-link" href="#">Siguiente</a>
    <!-- Agrega más enlaces de paginación aquí -->
  </div>

  <script>
    const productList = document.getElementById('product-list');
    const paginationLinks = document.querySelectorAll('.pagination-link');

    for (let i = 0; i < paginationLinks.length; i++) {
      paginationLinks[i].addEventListener('click', function (event) {
        event.preventDefault();
        const pageNumber = parseInt(this.textContent);

        // Oculta todos los productos
        const products = productList.getElementsByClassName('product');
        for (let j = 0; j < products.length; j++) {
          products[j].style.display = 'none';
        }

        // Muestra los productos correspondientes a la página seleccionada
        const startIndex = (pageNumber - 1) * 10;
        const endIndex = startIndex + 10;
        for (let k = startIndex; k < endIndex; k++) {
          if (products[k]) {
            products[k].style.display = 'flex';
          }
        }

        // Actualiza la clase 'active' en los enlaces de paginación
        for (let l = 0; l < paginationLinks.length; l++) {
          paginationLinks[l].classList.remove('active');
        }
        this.classList.add('active');
      });
    }
  </script>
</div>
</div>
</body>
