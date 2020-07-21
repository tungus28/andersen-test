<?php

namespace App\Controller;

use App\Service\StructuredTreeRenderer\StructuredTreeDeserializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     * @param StructuredTreeDeserializerService $treeDeserializer
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(StructuredTreeDeserializerService $treeDeserializer)
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'fileContent' => $treeDeserializer->getFileContent(__DIR__ . "/../DataFile/InputData.txt"),
        ]);
    }
}
