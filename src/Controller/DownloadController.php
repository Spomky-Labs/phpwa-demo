<?php

namespace App\Controller;

use App\Form\ItemHandler;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/download')]
class DownloadController extends AbstractController
{
    #[Route('/success', name: 'download_success', methods: [Request::METHOD_GET])]
    public function success(): Response
    {
        return new JsonResponse(['message' => 'Download successful']);
    }
    #[Route('/progress', name: 'download_progress', methods: [Request::METHOD_GET])]
    public function progress(): Response
    {
        return new JsonResponse(['message' => 'Download in progress']);
    }
    #[Route('/{filename}', name: 'download_file', methods: [Request::METHOD_GET])]
    public function filename(string $filename): Response
    {
        $fileSize = random_int(10, 100) * 1024 * 1024;
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '.foo"');
        $response->headers->set('Content-Length', $fileSize);
        $response->setCallback(function () use ($fileSize): void {
            $chunkSize = 1024 * 1024;
            $chunkCount = $fileSize / $chunkSize;
            for ($i = 0; $i < $chunkCount; $i++) {
                echo str_repeat('.', $chunkSize);
                flush();
                sleep(2);
            }
        });

        return $response;
    }
}
