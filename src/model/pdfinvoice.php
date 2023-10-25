<?php

use Yosimar\Corona\Service\ReviewService;
use Yosimar\Corona\Service\RouteService;
use Yosimar\Corona\Service\ProductService;

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
    $products = $productService->findAllMissingDetails($reviewId);

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
            font-family: Helvetica;
            font-size: 9.8pt;
        }

        .title {
            font-weight: 600;
            font-size: 11.8pt;
        }

        .head {
            text-align: center;
        }

        .head p:last-of-type {
            margin-bottom: 18pt;
        }

        table {
            margin: 2pt 0 12pt 0;
            border-collapse: collapse;
        }

        td {
            padding: 5pt;
        }

        td:first-of-type {
            width: 158pt;
        }

        table .title {
            font-size: 11pt;
            width: 38pt;
        }

        hr {
            margin: 48pt auto 0;
            width: 138pt;
            background-color: #000;
        }

        p {
            text-align: center;
        }
    </style>

    <head>
        <title>Recibo de cobro
            <?php echo $route->getName(); ?>
        </title>
    </head>

    <div class="head">
        <label class="title">EVENTOS PARA FIESTAS DE LOS TUXTLAS</label>
        <p>RFC: EFT0704307X0</p>
        <p>Carretera Costera del Golgo km 584</p>
        <p>San Andres Tuxtla, Ver.</p>
        <p>(294) 9420498 / 21247</p>
        <label class="title">RECIBO DE COBRO</label>
    </div>

    <table>
        <tr>
            <td class="title">Ruta:</td>
            <td><?php echo $route->getName(); ?></td>
        </tr>
        <tr>
            <td class="title">Folio: </td>
            <td><?php echo $review->getFolio() ?></td>
        </tr>
        <tr>
            <td class="title">Fecha: </td>
            <td><?php echo substr($review->getDate(), 0, 10) ?></td>
        </tr>
        <tr>
            <td class="title">Cliente: </td>
            <td><?php echo $route->getOperador(); ?></td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="title">Concepto</td>
            <td class="title">Importe</td>
        </tr>
        <?php
        $amount = 0.00;
        foreach ($products as $produc) {
        ?>
        <tr>
            <td>
                <?php echo $produc['quantity'] . ' envases de ' . $produc['name'];?>
            </td>
            <td>
                <?php echo '$' . (float) $produc['price_bottle'] * (int) $produc['quantity'];?>
            </td>
        </tr>
        <?php
            $amount += (float) $produc['price_bottle'] * (int) $produc['quantity'];
        }
        ?>
        <tr>
            <td class="title">Total general</td>
            <td>
                <?php echo '$' . $amount ?>
            </td>
        </tr>
    </table>
    <hr>
    <p>Firma</p>


<?php

} catch (Exception $e) {
    echo "Error al crear el pdf";
}

?>