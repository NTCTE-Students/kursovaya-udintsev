<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ConsultantSeeder extends Seeder
{
    public function run()
    {
        
        $consultantsData = [
            [
                'name' => 'Анна Петрова',
                'email' => 'anna.petrov@example.com',
                'password' => Hash::make('password'),
                'description' => 'Психолог с 10-летним опытом, специалист по тревоге и стрессу.',
                'photo' => 'consultants/anna.jpg',
            ],
            [
                'name' => 'Иван Смирнов',
                'email' => 'ivan.smirnov@example.com',
                'password' => Hash::make('password'),
                'description' => 'Клинический психолог, эксперт в семейных отношениях.',
                'photo' => 'consultants/ivan.jpg',
            ],
            [
                'name' => 'Ольга Кузнецова',
                'email' => 'olga.kuznetsova@example.com',
                'password' => Hash::make('password'),
                'description' => 'Психотерапевт, помогает справляться с депрессией и выгоранием.',
                'photo' => 'consultants/olga.jpg',
            ],
            [
                'name' => 'Дмитрий Новиков',
                'email' => 'dmitry.novikov@example.com',
                'password' => Hash::make('password'),
                'description' => 'Специалист по детской психологии и развитию личности.',
                'photo' => 'consultants/dmitry.jpg',
            ],
            [
                'name' => 'Елена Морозова',
                'email' => 'elena.morozova@example.com',
                'password' => Hash::make('password'),
                'description' => 'Психолог-консультант, фокусируется на личностном росте.',
                'photo' => 'consultants/elena.jpg',
            ],
        ];

        foreach ($consultantsData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'description' => $data['description'],
                'photo' => $data['photo'],
                'role' => 'consultant',
            ]);
            
        }
    }
}
