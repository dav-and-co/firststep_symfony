<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class pokerController  extends AbstractController
{
    #[Route('/', name: 'index')]
    public function pok(){

        $request = Request::createfromGlobals();

        $age = $request->query->get('age');

        if (empty($age)) {
            return $this->render('page/index.html.twig');
        } else {
            if ($age > 17) {
                return $this->render('page/okEntry.html.twig');
            } else {
                return $this->render('page/noEntry.html.twig');
            }
        }
    }
}