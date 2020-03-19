<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of HomeController.
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
class HomeController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('homePage.html.twig');
    }
}
