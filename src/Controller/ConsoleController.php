<?php

// permet de déclarer des types pour chacune des variables INT ...
declare(strict_types=1);

// localhost/piscine-2207-symfonyBase/public/consoles

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class ConsoleController extends AbstractController
{
    private $products;

    function __construct()
    {
        $this->products = [
            [
                'id' => 1,
                'title' => 'Playstation 5',
                'price' => 499.99,
                'price_reduction' => 0,
                'image' => 'img/Playstation5.jpeg',
                'categories' => ['console', 'sony']
            ],
            [
                'id' => 2,
                'title' => 'Xbox Series X',
                'price' => 499.99,
                'price_reduction' => 0,
                'image' => 'img/microsoft-xbox-series-x.jpg',
                'categories' => ['console', 'microsoft']
            ],
            [
                'id' => 3,
                'title' => 'Nintendo Switch',
                'price' => 299.99,
                'price_reduction' => 0,
                'image' => 'img/1229-nintendo-switch-edicion-mario-oled-roja.webp',
                'categories' => ['console', 'nintendo']
            ],
            [
                'id' => 4,
                'title' => 'Playstation 4',
                'price' => 299.99,
                'price_reduction' => 199.99,
                'image' => 'img/sony-playstation-4-ps4-slim-500go-d-chassis-italie.webp',
                'categories' => ['console', 'sony']
            ],
            [
                'id' => 5,
                'title' => 'Xbox One',
                'price' => 299.99,
                'price_reduction' => 199.99,
                'image' => 'img/xbox.jpeg',
                'categories' => ['console', 'microsoft']
            ],
        ];
    }

    #[Route('/consoles', name: 'list_consoles')]
    public function listConsole()
    {

        return $this->render('page/Consoles.html.twig', [
            'consoles' => $this->products
        ]);
    }

    #[Route('/console/{id}', name: 'one_console')]
    public function oneconsole($id): Response
    {
        $consoleFound = null;

        foreach ($this->products as $product) {
            if ($product['id'] ===(INT)$id) {
                $consoleFound = $product;
            }
        }
        return $this->render('page/Console.html.twig', [
            'console' => $consoleFound
        ]);
    }
}

