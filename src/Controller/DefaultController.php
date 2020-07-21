<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\StructuredTreeDeserializer\StructuredTreeDeserializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     * @param StructuredTreeDeserializerService $treeDeserializer
     * @param string $fullDataFileName
     * @return Response
     */
    public function index(StructuredTreeDeserializerService $treeDeserializer, string $fullDataFileName)
    {
        return $this->render('index.html.twig', [
            'page_title' => 'Tree representation',
            'branches' => $treeDeserializer->deserializeTreeFromFile($fullDataFileName),
        ]);
    }
}
