<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WeatherController extends AbstractController
{
    #[Route('/weather/{city}', name: 'app_weather_city')]
    public function city(
        string $city,
        LocationRepository $locationRepository,
        MeasurementRepository $measurementRepository
    ): Response {

        $location = $locationRepository->findOneBy(['city' => $city]);

        if (!$location) {
            throw $this->createNotFoundException("Nie znaleziono miasta: $city");
        }

        $measurements = $measurementRepository->findByLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
