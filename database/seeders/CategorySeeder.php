<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // [type, slug, en_name, rw_name, sort_order]
        $categories = [
            // Ideas
            ['idea', 'agriculture',   'Agriculture',        'Ubuhinzi',           10],
            ['idea', 'livestock',     'Livestock',          'Ubworozi',           20],
            ['idea', 'retail',        'Retail & Trade',     'Ubucuruzi',          30],
            ['idea', 'services',      'Services',           'Serivisi',           40],
            ['idea', 'manufacturing', 'Manufacturing',      'Inganda',            50],
            ['idea', 'technology',    'Technology',         'Ikoranabuhanga',     60],

            // Skills
            ['skill', 'tailoring',    'Tailoring',          'Gutora',             10],
            ['skill', 'cooking',      'Cooking & Baking',   'Guteka no Gukora',   20],
            ['skill', 'carpentry',    'Carpentry',          'Ububaji',            30],
            ['skill', 'digital',      'Digital Skills',     'Ubumenyi bw\'Ikoranabuhanga', 40],
            ['skill', 'farming',      'Farming Techniques', 'Ubuhinzi bw\'Ikoranabuhanga', 50],

            // Opportunities
            ['opportunity', 'grants',   'Grants',              'Inkunga',            10],
            ['opportunity', 'training', 'Training Programs',   'Amahugurwa',         20],
            ['opportunity', 'jobs',     'Job Openings',        'Akazi',              30],
            ['opportunity', 'tenders',  'Tenders',             'Amasoko',            40],

            // Articles
            ['article', 'guides',       'Guides',              'Ubuyobozi',          10],
            ['article', 'tips',         'Tips & Advice',       'Inama',              20],
            ['article', 'news',         'News',                'Amakuru',            30],
        ];

        foreach ($categories as [$type, $slug, $en, $rw, $sort]) {
            $cat = Category::updateOrCreate(
                ['slug' => $slug, 'type' => $type],
                ['sort_order' => $sort, 'is_active' => true]
            );

            $cat->translations()->updateOrCreate(
                ['locale' => 'en'],
                ['name' => $en]
            );

            $cat->translations()->updateOrCreate(
                ['locale' => 'rw'],
                ['name' => $rw]
            );
        }

        $this->command->info('Categories seeded: ' . count($categories));
    }
}
