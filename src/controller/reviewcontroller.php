<?php

namespace Yosimar\Corona\Controller;

use Yosimar\Corona\Service\ReviewService;
use Yosimar\Corona\Service\PdfService;
use Yosimar\Corona\Service\MailService;

class ReviewController
{
    public static function findAllReviewData(): array
    {
        $reviewService = new ReviewService();
        return $reviewService->findAll();
    }

    public static function findReviewsByDate(string $date): array
    {
        $reviewService = new ReviewService();
        return $reviewService->findByDate($date);
    }

    public static function generatePdfReview(string $idReview): void
    {
        PdfService::generatePdfReview($idReview);
    }

    public static function sendPdfInvoice(string $idReview): bool
    {
        return MailService::sendMailCash($idReview);
    }

    public static function sendPdfForMail(string $idReview): bool
    {
        return MailService::sendMail($idReview);
    }
}
