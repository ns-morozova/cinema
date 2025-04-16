<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Массив данных для фильмов
        $movies = [
            [
                'title' => 'Звёздные войны XXIII: Атака клонированных клонов',
                'description' => 'Эпическая битва за галактику.',
                'duration' => 130,
                'country' => 'Россия',
                'poster' => 'images/client/poster1.jpg',
                'color' => '#6C8EA4',
            ],
            [
                'title' => 'Миссия выполнима',
                'description' => 'Агент Итан Хант снова выполняет невозможное.',
                'duration' => 120,
                'country' => 'Россия',
                'poster' => '/images/client/poster2.jpg',
                'color' => '#A47C6C',
            ],
            [
                'title' => 'Серая пантера',
                'description' => 'История героя, который борется за справедливость.',
                'duration' => 90,
                'country' => 'Россия',
                'poster' => 'images/client/poster1.jpg',
                'color' => '#7B9E74',
            ],
            [
                'title' => 'Движение вбок',
                'description' => 'Комедия о жизни обычных людей.',
                'duration' => 95,
                'country' => 'Россия',
                'poster' => 'images/client/poster2.jpg',
                'color' => '#B78EAA',
            ],
            [
                'title' => 'Кот Да Винчи',
                'description' => 'Приключения кота-гения.',
                'duration' => 100,
                'country' => 'Россия',
                'poster' => 'images/client/poster1.jpg',
                'color' => '#A5A97B',
            ],
            [
                'title' => 'Супергерои будущего',
                'description' => 'Битва за выживание человечества.',
                'duration' => 110,
                'country' => 'Россия',
                'poster' => 'images/client/poster2.jpg',
                'color' => '#8C7BA5',
            ],
            [
                'title' => 'Тайна старого замка',
                'description' => 'Детективная история с элементами ужаса.',
                'duration' => 105,
                'country' => 'Россия',
                'poster' => 'images/client/poster1.jpg',
                'color' => '#A48D7B',
            ],
            [
                'title' => 'Путешествие во времени',
                'description' => 'Научно-фантастический триллер.',
                'duration' => 115,
                'country' => 'Россия',
                'poster' => 'images/client/poster2.jpg',
                'color' => '#6C9EA4',
            ],
            [
                'title' => 'Легенда о рыцаре',
                'description' => 'История храброго рыцаря.',
                'duration' => 125,
                'country' => 'Россия',
                'poster' => 'images/client/poster1.jpg',
                'color' => '#A47B94',
            ],
            [
                'title' => 'Последний рубеж',
                'description' => 'Финальная битва за свободу.',
                'duration' => 135,
                'country' => 'Россия',
                'poster' => 'images/client/poster2.jpg',
                'color' => '#7B8EA5',
            ],
        ];

        // Добавление данных в таблицу через модель
        foreach ($movies as $movieData) {
            Movie::create($movieData);
        }
    }
}