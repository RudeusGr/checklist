<?php

namespace Yosimar\Corona\Service;

use Dompdf\Dompdf;

class PdfService
{

    public static function generatePdfReview(string $idReview): void
    {
        if ($idReview != '') {
            $GLOBALS["reviewId"] = $idReview;
            if (isset($GLOBALS["reviewId"])) {
                $dompdf = new Dompdf();
                ob_start();
                include "src/model/pdfreview.php";
                $html = ob_get_clean();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A5', 'landscape');
                $dompdf->render();
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename=revision-" . $idReview . ".pdf");
                echo $dompdf->output();
            } else {
                error_log('PDFSERVICE::generatePdfReview -> No se ha generado la revision en pdf');
            }
        } else {
            error_log('PDFSERVICE::generatePdfReview -> No se ha generado la revision en pdf');
        }
    }

    public static function generatePdfInvoice(string $idReview): void
    {
        if ($idReview != '') {
            $GLOBALS["reviewId"] = $idReview;
            if (isset($GLOBALS["reviewId"])) {
                $dompdf = new Dompdf();
                ob_start();
                include "src/model/pdfinvoice.php";
                $html = ob_get_clean();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A6', 'portrait');
                $dompdf->render();
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename=cargo-" . $idReview . ".pdf");
                echo $dompdf->output();
            } else {
                error_log('PDFSERVICE::generatePdfReview -> No se ha generado la revision en pdf');
            }
        } else {
            error_log('PDFSERVICE::generatePdfInvoice -> No se ha generado el cargo en pdf');
        }
    }

    public static function generatePdfReviewForMail(string $idReview): string
    {
        if ($idReview != '') {
            $GLOBALS["reviewId"] = $idReview;
            if (isset($GLOBALS["reviewId"])) {
                $dompdf = new Dompdf();
                ob_start();
                include "src/model/pdfreview.php";
                $html = ob_get_clean();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A5', 'landscape');
                $dompdf->render();
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename=revision-" . $idReview . ".pdf");
                return $dompdf->output();
            } else {
                error_log('PDFSERVICE::generatePdfReview -> No se ha generado el pdf para enviar');
                return '';
            }
        } else {
            error_log('PDFSERVICE::generatePdfReview -> No se ha generado el pdf para enviar');
            return '';
        }
    }

    public static function generatePdfInvoiceForMail(string $idReview): string
    {
        if ($idReview != '') {
            $GLOBALS["reviewId"] = $idReview;
            if (isset($GLOBALS["reviewId"])) {
                $dompdf = new Dompdf();
                ob_start();
                include "src/model/pdfinvoice.php";
                $html = ob_get_clean();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A6', 'portrait');
                $dompdf->render();
                header("Content-type: application/pdf");
                header("Content-Disposition: inline; filename=cargo-" . $idReview . ".pdf");
                return $dompdf->output();
            } else {
                error_log('PDFSERVICE::generatePdfReview -> No se ha generado el pdf de cargo por correo');
                return '';
            }
        } else {
            error_log('PDFSERVICE::generatePdfInvoice -> No se ha generado el pdf de cargo por correo');
            return '';
        }
    }
}
