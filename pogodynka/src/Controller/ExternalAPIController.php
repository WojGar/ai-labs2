<?php

namespace App\Controller;

use App\Form\ExternalAPIType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExternalAPIController extends AbstractController
{
    public function __construct(private HttpClientInterface $httpClient)
    {
    }

    #[Route('/external-api', name: 'app_external_api')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(ExternalAPIType::class);
        $form->handleRequest($request);

        $forecast = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $latitude = $form->get('latitude')->getData();
            $longitude = $form->get('longitude')->getData();

            $apiUrl = sprintf(
                'https://api.open-meteo.com/v1/forecast?latitude=%s&longitude=%s&daily=temperature_2m_max,temperature_2m_min,precipitation_sum&timezone=UTC',
                $latitude,
                $longitude
            );

            $response = $this->httpClient->request('GET', $apiUrl);
            $forecast = $response->toArray();
        }

        return $this->render('external_api/index.html.twig', [
            'form' => $form->createView(),
            'forecast' => $forecast
        ]);
    }
}
