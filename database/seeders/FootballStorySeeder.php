<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Choice;
use App\Models\Story;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class FootballStorySeeder extends Seeder
{
    public function run(): void
    {
        // Créer l'histoire
        $story = Story::create([
            'title' => 'Le Chemin vers la Gloire',
            'description' => 'Une histoire interactive sur le parcours d\'un jeune footballeur talentueux, de son quartier jusqu\'à la finale de la Coupe du Monde.',
            'is_published' => true,
        ]);

        // Charger les données depuis le fichier JSON
        $jsonPath = database_path('data/story.json');
        $storyData = json_decode(File::get($jsonPath), true);

        // Créer les chapitres
        $chapters = [];
        foreach ($storyData['chapters'] as $index => $chapterData) {
            $isEnding = !isset($chapterData['choices']) || empty($chapterData['choices']);
            
            $chapters[$index + 1] = Chapter::create([
                'story_id' => $story->id,
                'title' => $chapterData['title'],
                'content' => $chapterData['content'],
                'is_ending' => $isEnding,
            ]);
        }

        // Créer les choix
        foreach ($storyData['chapters'] as $index => $chapterData) {
            if (isset($chapterData['choices'])) {
                foreach ($chapterData['choices'] as $choiceData) {
                    Choice::create([
                        'chapter_id' => $chapters[$index + 1]->id,
                        'text' => $choiceData['text'],
                        'next_chapter_id' => $chapters[$choiceData['next_chapter']]->id,
                    ]);
                }
            }
        }

        $this->command->info('Histoire "Le Chemin vers la Gloire" créée avec succès!');
        $this->command->info('Nombre de chapitres : ' . count($chapters));
    }
}