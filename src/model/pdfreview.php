<?php

use Yosimar\Corona\Service\ReviewService;
use Yosimar\Corona\Service\RouteService;
use Yosimar\Corona\Service\ProductService;
use Yosimar\Corona\Service\ShelterService;

try {
    $reviewId = (int) $GLOBALS["reviewId"];

    /** revision */
    $reviewService = new ReviewService();
    $review = $reviewService->findById($reviewId);

    /** ruta */
    $routeService = new RouteService();
    $route = $routeService->findById($review->getIdRoute());

    /** productos */
    $productService = new ProductService();
    $products = $productService->findAllDetails($reviewId);

    /** resguardo */
    $shelterService = new ShelterService();
    $shelters = $shelterService->findAllByIdReview($reviewId);
    
    $amount = 0;
?>

    <style>
        html {
            margin: 15pt 15pt;
        }

        * {
            margin: 0px;
            padding: 0px;
        }

        body {
            font-family: Helvetica, sans-serif;
            font-size: 9.8pt;
        }

        .title {
            font-weight: 600;
            font-size: 11.8pt;
        }

        .head {
            text-align: center;
            margin-bottom: 8pt;
        }

        table {
            margin: 8pt 4pt;
            border-collapse: collapse;
        }
        
        .observation {
            position: absolute;
            top: 77pt;
            left: 398pt;
        }

        .observation td {
            max-width: 148pt;
        }

        .observation tr:last-of-type td:last-of-type {
            min-height: 48pt;
        }

        td {
            padding: 2pt;
        }

        .envase {
            width: 294pt;
        }

        .shelter .envase {
            width: 204pt;
        }

        .tienda {
            width: 154pt;
        }

        .cantidad {
            width: 50pt;
        }

        .total {
            width: 30pt;
        }

        .center {
            text-align: center;
        }

        .justify {
            text-align: justify;
        }

        table:first-of-type td:first-of-type {
            width: 142pt;
        }

        table:first-of-type td:nth-child(2) {
            width: 258pt;
        }
        


    </style>

    <head>
        <title>Revision Ruta <?php echo $route->getName(); ?></title>
    </head>

    <div class="head">
        <div class="title">COMERCIALIZADORA DE CERVEZA DE LOS TUXTLAS, S.A DE CV</div>
    </div>

    <table class="basic">
        <tr>
            <td>
                <label class="title">Fecha:</label>
                <?php echo substr($review->getDate(), 0, 10) ?>
            </td>
            <td>
                <label class="title">Hora:</label>
                <?php echo substr($review->getDate(), -8) ?>
            </td>
            <td rowspan="2">
                <label class="title">Firma:</label>
            </td>
            <td rowspan="2">
                <?php $imagenlogo = 'data:image/png;base64,' . base64_encode(file_get_contents($review->getSignature())); ?>
                <img src="<?php echo $imagenlogo ?>" alt="firma" width="100px" />
            </td>
        </tr>
        <tr>
            <td>
                <label class="title">Ruta:</label>
                <?php echo $route->getName(); ?>
            </td>
            <td>
                <label class="title">Operador:</label>
                <?php echo $route->getOperador(); ?>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="envase"><label class="title">Envase entregado</label></td>
            <td class="center cantidad"><label class="title">Cantidad</label></td>
            <td class="center total"><label class="title">Total</label></td>
        </tr>
        <?php
            $textName = '';
            $textQuant = '';
            $amount1 = 0;
            foreach ($products as $product) {
                if ($product['type'] == 'envase') {
                    $textName .= $product['name'] . '<br>';
                    $textQuant .= $product['quantity'] . '<br>';
                    $amount1 += (int)$product['quantity'];
                }
            }
            $amount += $amount1;
        ?>
        <tr>
            <td class="envase"><?php echo substr( $textName, 0, strlen($textName) - 2); ?></td>
            <td class="center cantidad"><?php echo substr($textQuant, 0, strlen($textQuant) - 2); ?></td>
            <td class="center total"><?php echo $amount1; ?></td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="envase"><label class="title">Envase faltante</label></td>
            <td class="center cantidad"><label class="title">Cantidad</label></td>
            <td class="center total"><label class="title">Total</label></td>
        </tr>
        <?php
            $textName = '';
            $textQuant = '';
            $amount1 = 0;
            foreach ($products as $product) {
                if ($product['type'] == 'faltante') {
                    $textName .=  $product['name'] . '<br>';
                    $textQuant .= $product['quantity'] . '<br>';
                    $amount1 += (int)$product['quantity'];
                }
            }
            $amount += $amount1;
        ?>
        <tr>
            <td class="envase"><?php echo substr( $textName, 0, strlen($textName) - 2); ?></td>
            <td class="center cantidad"><?php echo substr($textQuant, 0, strlen($textQuant) - 2); ?></td>
            <td class="center total"><?php echo $amount1; ?></td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="envase"><label class="title">Producto devuelto</label></td>
            <td class="center cantidad"><label class="title">Cantidad</label></td>
            <td class="center total"><label class="title">Total</label></td>
        </tr>
        <?php
            $textName = '';
            $textQuant = '';
            $amount1 = 0;
            foreach ($products as $product) {
                if ($product['type'] == 'devolucion') {
                    $textName .=  $product['name'] . '<br>';
                    $textQuant .= $product['quantity'] . '<br>';
                    $amount1 += (int)$product['quantity'];
                }
            }
            $amount += $amount1;
        ?>
        <tr>
            <td class="envase"><?php echo substr( $textName, 0, strlen($textName) - 2); ?></td>
            <td class="center cantidad"><?php echo substr($textQuant, 0, strlen($textQuant) - 2); ?></td>
            <td class="center total"><?php echo $amount1; ?></td>
        </tr>
        <tr>
            <td class="center"><label class="title">Total neto:</label></td>
            <td></td>
            <td class="center">
                <label class="title">
                    <?php
                        echo $amount;
                    ?>
                </label>
            </td>
        </tr>
    </table>
    <table class="shelter">
        <tr>
            <td class="envase"><label class="title">Envase de resguardo</label></td>
            <td class="center tienda"><label class="title">Tienda</label></td>
            <td class="center cantidad"><label class="title">Cantidad</label></td>
            <td class="center total"><label class="title">Total</label></td>
        </tr>
        <?php
            $textName = '';
            $textStore = '';
            $textQuant = '';
            $amount1 = 0;
            foreach ($shelters as $shelters) {
                $textName .= $shelters['product'] . '<br>';
                $textStore .= $shelters['store'] . '<br>';
                $textQuant .= $shelters['quantity'] . '<br><br>';
                $amount1 += (int)$shelters['quantity'];
            }
        ?>
        <tr>
            <td class="envase"><?php echo substr( $textName, 0, strlen($textName) - 2);?></td>
            <td class="center tienda"><?php echo substr( $textStore, 0, strlen($textStore) - 2);?></td>
            <td class="center cantidad"><?php echo substr($textQuant, 0, strlen($textQuant) - 2);?></td>
            <td class="center total"><?php echo $amount1;?></td>
        </tr>
    </table>

    <table class="observation">
        <tr>
            <td class="center"><label class="title">Observaciones</label></td>
        </tr>
        <tr>
            <td class="justify"><?php echo $review->getObservation();?></td>
        </tr>
    </table>
<?php

} catch (Exception $e) {
    echo "Error al crear el pdf";
}

?>