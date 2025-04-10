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
                'poster' => '/images/client/poster1.jpg',
                'price_vip' => 500.00,
                'price_regular' => 300.00,
            ],
            [
                'title' => 'Миссия выполнима',
                'description' => 'Агент Итан Хант снова выполняет невозможное.',
                'duration' => 120,
                'country' => 'Россия',
                'poster' => '/images/client/poster2.jpg',
                'price_vip' => 450.00,
                'price_regular' => 280.00,
            ],
            [
                'title' => 'Серая пантера',
                'description' => 'История героя, который борется за справедливость.',
                'duration' => 90,
                'country' => 'Россия',
                'poster' => '/images/client/poster1.jpg',
                'price_vip' => 400.00,
                'price_regular' => 250.00,
            ],
            [
                'title' => 'Движение вбок',
                'description' => 'Комедия о жизни обычных людей.',
                'duration' => 95,
                'country' => 'Россия',
                'poster' => '/images/client/poster2.jpg',
                'price_vip' => 380.00,
                'price_regular' => 230.00,
            ],
            [
                'title' => 'Кот Да Винчи',
                'description' => 'Приключения кота-гения.',
                'duration' => 100,
                'country' => 'Россия',
                'poster' => '/images/client/poster1.jpg',
                'price_vip' => 420.00,
                'price_regular' => 260.00,
            ],
            [
                'title' => 'Супергерои будущего',
                'description' => 'Битва за выживание человечества.',
                'duration' => 110,
                'country' => 'Россия',
                'poster' => '/images/client/poster2.jpg',
                'price_vip' => 520.00,
                'price_regular' => 320.00,
            ],
            [
                'title' => 'Тайна старого замка',
                'description' => 'Детективная история с элементами ужаса.',
                'duration' => 105,
                'country' => 'Россия',
                'poster' => '/images/client/poster1.jpg',
                'price_vip' => 470.00,
                'price_regular' => 290.00,
            ],
            [
                'title' => 'Путешествие во времени',
                'description' => 'Научно-фантастический триллер.',
                'duration' => 115,
                'country' => 'Россия',
                'poster' => '/images/client/poster2.jpg',
                'price_vip' => 550.00,
                'price_regular' => 350.00,
            ],
            [
                'title' => 'Легенда о рыцаре',
                'description' => 'История храброго рыцаря.',
                'duration' => 125,
                'country' => 'Россия',
                'poster' => '/images/client/poster1.jpg',
                'price_vip' => 530.00,
                'price_regular' => 330.00,
            ],
            [
                'title' => 'Последний рубеж',
                'description' => 'Финальная битва за свободу.',
                'duration' => 135,
                'country' => 'Россия',
                'poster' => '/images/client/poster2.jpg',
                'price_vip' => 600.00,
                'price_regular' => 380.00,
            ],
        ];

        // Добавление данных в таблицу через модель
        foreach ($movies as $movieData) {
            Movie::create($movieData);
        }
    }
}