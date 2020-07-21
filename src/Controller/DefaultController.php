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
     */
    public function index(StructuredTreeDeserializerService $treeDeserializer)
    {
        return $this->render('index.html.twig', [
            'page_title' => 'Tree representation',
            'branches' => $treeDeserializer->deserializeTreeFromFile(__DIR__ . "/../DataFile/InputData.txt"),
        ]);
    }
}
