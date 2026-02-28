<?php

use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'حفل زفاف راقٍ',
                'description' => 'لقطة من حفل زفاف في وهران.',
                'image_path' => 'img/gallery/photo1.jpg',
                'category' => 'wedding',
            ],
            [
                'title' => 'خطوبة في الطبيعة',
                'description' => 'جلسة خطوبة في الهواء الطلق.',
                'image_path' => 'img/gallery/photo2.jpg',
                'category' => 'engagement',
            ],
            [
                'title' => 'صور أطفال مبهجة',
                'description' => 'صور لطيفة لأطفال في عيد ميلاد.',
                'image_path' => 'img/gallery/photo3.jpg',
                'category' => 'baby',
            ],
            [
                'title' => 'مناسبة عائلية',
                'description' => 'تصوير لحفل عائلي بسيط.',
                'image_path' => 'img/gallery/photo4.jpg',
                'category' => 'event',
            ],
            [
                'title' => 'عرس تقليدي',
                'description' => 'حفل زفاف تقليدي جزائري.',
                'image_path' => 'img/gallery/photo5.jpg',
                'category' => 'wedding',
            ],
        ];

        foreach ($items as $item) {
             \App\Models\GalleryItem::create($item);
        }
    }
}
