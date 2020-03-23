<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\PersonType;
use App\Service\DetectingDisposableEmailAddressesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PersonController.
 *
 * @author Radosław Skrzypczak <radoslaw.skrzypczak@pearfly.pl>
 */
class PersonController extends AbstractController
{
    public function new(): Response
    {
        $form = $this->createForm(PersonType::class);

        return $this->render('person/newPersonForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function add(Request $request, DetectingDisposableEmailAddressesService $detectEmailService): JsonResponse
    {
        $data = $request->request->get('person');

        return new JsonResponse(['data' => $detectEmailService->isDisposableEmail($data['email'])]);
    }
}
