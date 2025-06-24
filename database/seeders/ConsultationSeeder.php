<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consultation;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Support\Carbon;

class ConsultationSeeder extends Seeder
{
    public function run()
    {
        $consultants = User::where('role', 'consultant')->get();
        $clients = User::where('role', 'client')->get();

        if ($consultants->isEmpty() || $clients->isEmpty()) {
            $this->command->error('Нет консультантов или клиентов для создания консультаций!');
            return;
        }

        foreach ($clients as $client) {
            foreach ($consultants as $consultant) {
                // Генерируем случайное название темы
                $topicTitle = 'Тестовая консультация по теме ' . ucfirst(fake()->word());

                // Ищем существующую тему у консультанта с таким названием
                $topic = Topic::firstOrCreate(
                    ['title' => $topicTitle, 'consultant_id' => $consultant->id],
                    ['title' => $topicTitle, 'consultant_id' => $consultant->id]
                );

                Consultation::create([
                    'user_id' => $client->id,
                    'consultant_id' => $consultant->id,
                    'scheduled_at' => Carbon::now()->addDays(rand(1, 30))->format('Y-m-d H:i:s'),
                    'topic_id' => $topic->id,
                    'status' => 'pending',
                    'is_paid' => false,
                ]);
            }
        }
    }
}
