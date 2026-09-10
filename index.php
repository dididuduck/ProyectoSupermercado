<?php include('conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Michigangas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="logo">
            <img src="imagenes/logo.png" alt="Logo">
            <h2>Michigangas</h2>
        </div>

        <div class="buscador">
            <input type="text" placeholder="Estoy buscando...">
            <button class="btn-icon"><img src="imagenes/lupa.png" alt="Buscar"></button>
        </div>

        <div class="menu-iconos">
            <span>
                <div class="circulo"><img src="imagenes/carrito.png" alt="Súper"></div>
            </span>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="contenedor">

        <!-- BANNER AMARILLO -->
        <section class="banner">
            <div class="texto-banner">
                <h1>MICHIDESCUENTO</h1>
                <h3>PARA USUARIOS NUEVOS</h3>
                <p>*Consulte los michitérminos y condiciones.</p>
            </div>
            <img src="imagenes/promodibujo.png" alt="Caja">
        </section>

        <!-- AVISO VERDE -->
        <div class="aviso">
             <b>Envío gratis y rápido</b> en tu primera compra
        </div>

        <!-- CATEGORÍAS CON TUS IMÁGENES -->
        <section class="categorias">
            <div class="item-cat">
                <div class="circulo"><img src="imagenes/carrito.png" alt="Súper"></div>
                <span>Súper</span>
            </div>
            <div class="item-cat">
                <div class="circulo"><img src="imagenes/avion.png" alt="Internacional"></div>
                <span>Internacional</span>
            </div>
            <div class="item-cat">
                <div class="circulo"><img src="imagenes/vestido.png" alt="Moda"></div>
                <span>Moda</span>
            </div>
            <div class="item-cat">
                <div class="circulo"><img src="imagenes/carro.png" alt="Vehículos"></div>
                <span>Vehículos</span>
            </div>
            <div class="item-cat">
                <div class="circulo"><img src="imagenes/estrella.png" alt="Más vendidos"></div>
                <span>Más vendidos</span>
            </div>
            <div class="item-cat">
                <div class="circulo"><img src="imagenes/laptop.png" alt="Computación"></div>
                <span>Computación</span>
            </div>
            <div class="item-cat">
                <div class="circulo"><img src="imagenes/tele.png" alt="Televisores"></div>
                <span>Televisores</span>
            </div>
            <div class="item-cat">
                <div class="circulo"><img src="imagenes/hogar.png" alt="Hogar"></div>
                <span>Hogar</span>
            </div>
        </section>

        <!-- TARJETAS DE BENEFICIOS CON IMÁGENES -->
        <section class="tarjetas">
            <div class="tarjeta">
                <div class="icono"><img src="imagenes/enviogratis.png" alt="Envío Gratis"></div>
                <h4>ENVÍO GRATIS</h4>
                <p>Beneficio por ser tu primera compra.</p>
            </div>
            <div class="tarjeta">
                <div class="icono"><img src="imagenes/menosde.png" alt="Menos de $500"></div>
                <h4>MENOS DE $500</h4>
                <p>Descubre productos con precios bajos.</p>
            </div>
            <div class="tarjeta">
                <div class="icono"><img src="imagenes/compraprotegida.png" alt="Compra Protegida"></div>
                <h4>COMPRA PROTEGIDA</h4>
                <p>Nosotros te cuidamos</p>
            </div>
            <div class="tarjeta">
                <div class="icono"><img src="imagenes/tiendas.png" alt="Tiendas Oficiales"></div>
                <h4>TIENDAS OFICIALES</h4>
                <p>Encuentra tus marcas preferidas.</p>
            </div>
        </section>

        <!-- FILTROS Y BÚSQUEDA -->
        <section class="seccion-filtros">
            <h3>Filtros de Búsqueda</h3>
            <form method="GET" action="index.php" class="filtros-box">
                <input type="text" name="nombre" placeholder="Buscar por nombre..." value="<?php echo isset($_GET['nombre']) ? $_GET['nombre'] : ''; ?>">
                
                <select name="categoria">
                    <option value="">Todas las categorías</option>
                    <option value="Súper" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 'Súper') ? 'selected' : ''; ?>>Súper</option>
                    <option value="Moda" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 'Moda') ? 'selected' : ''; ?>>Moda</option>
                    <option value="Computación" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 'Computación') ? 'selected' : ''; ?>>Computación</option>
                    <option value="Hogar" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 'Hogar') ? 'selected' : ''; ?>>Hogar</option>
                </select>

                <input type="number" name="precio_max" placeholder="Precio máx. ($)" value="<?php echo isset($_GET['precio_max']) ? $_GET['precio_max'] : ''; ?>">

                <button type="submit" class="btn-filtrar">
                    Filtrar <img src="imagenes/lupa.png" alt="Buscar" class="img-btn">
                </button>
            </form>
        </section>

        <!-- LISTA DE PRODUCTOS DESDE PHP / BASE DE DATOS -->
        <section class="productos-grid">
            <?php
            // Capturar datos del formulario GET
            $nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
            $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
            $precio_max = (isset($_GET['precio_max']) && $_GET['precio_max'] != '') ? $_GET['precio_max'] : 0;

            // Ejecutar el Procedimiento Almacenado con el CTE
            $sql = "CALL sp_filtrar_productos('$nombre', '$categoria', $precio_max)";
            $resultado = mysqli_query($conexion, $sql);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                while ($prod = mysqli_fetch_assoc($resultado)) {
            ?>
                    <div class="tarjeta-producto">
                        <img src="imagenes/<?php echo $prod['imagen']; ?>" alt="<?php echo $prod['producto']; ?>">
                        <h5><?php echo $prod['producto']; ?></h5>
                        <p class="categoria-tag"><?php echo $prod['categoria']; ?></p>
                        <p class="precio">$<?php echo number_format($prod['precio'], 2); ?></p>
                        <button class="btn-comprar">
                            Agregar <img src="imagenes/carrito.png" alt="Carrito" class="img-btn">
                        </button>
                    </div>
            <?php
                }
            } else {
                echo "<p style='grid-column: 1/-1; text-align: center; color: #5c4333;'>No se encontraron productos.</p>";
            }
            ?>
        </section>

    </div>

</body>
</html>