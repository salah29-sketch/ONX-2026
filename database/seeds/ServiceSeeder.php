<?php

namespace Database\Seeders;

use App\Models\ServiceHome;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           $services = [
            [
                'title' => 'Production Audiovisuelle',
                'icon' => 'bi-camera-reels',
                'features' => json_encode([
                    'Tournage de vidéos promotionnelles',
                    'Captation d’événements',
                    'Production de courts-métrages',
                    'Montage professionnel',
                    'Streaming en direct',
                ], JSON_UNESCAPED_UNICODE),
            ],
            [
                'title' => 'Organisation d’Événements',
                'icon' => 'bi-calendar2-event',
                'features' => json_encode([
                    'Organisation et couverture d’événements',
                    'Création de contenu visuel pour l’événement',
                    'Diffusion en direct des événements',
                ], JSON_UNESCAPED_UNICODE),
            ],
            [
                'title' => 'Conception de Logos et Graphisme',
                'icon' => 'bi-easel',
                'features' => json_encode([
                    'Développement d’une identité visuelle complète',
                    'Création de logos uniques',
                    'Conception d’annonces imprimées et numériques',
                    'Création de supports spécifiques pour les événements',
                ], JSON_UNESCAPED_UNICODE),
            ],
            [
                'title' => 'Gestion des Réseaux Sociaux',
                'icon' => 'bi-bounding-box-circles',
                'features' => json_encode([
                    'Élaboration de stratégie de marketing digital',
                    'Création de contenu créatif',
                    'Gestion quotidienne des comptes',
                    'Lancement de campagnes publicitaires',
                    'Analyse des performances',
                ], JSON_UNESCAPED_UNICODE),
            ],
            [
                'title' => 'Développement Web',
                'icon' => 'bi-laptop',
                'features' => json_encode([
                    'Conception de sites web personnalisés',
                    'Optimisation de l’expérience utilisateur (UX/UI)',
                    'Référencement naturel (SEO)',
                    'Gestion et maintenance de sites',
                ], JSON_UNESCAPED_UNICODE),
            ],
        ];

        foreach ($services as $service) {
            ServiceHome::create($service);
        }
    }
}
