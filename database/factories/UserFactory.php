<?php

namespace Database\Factories;

use App\Models\Position;
use App\Services\ImageProcessing\ImageProcessorService;
use App\Services\ImageProcessing\Strategies\UrlImageSourceService;
use App\Services\UkrainianPhoneNumberGeneratorService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => $this->generateUkrainianPhoneNumber(),
            'position_id' => Position::inRandomOrder()->first()->id,
            'photo' => $this->generateRandomUserPhoto(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    private function generateUkrainianPhoneNumber(): string
    {
        return UkrainianPhoneNumberGeneratorService::generate();
    }

    private function generateRandomUserPhoto(): string
    {
        $imageSource = new UrlImageSourceService('https://thispersondoesnotexist.com/');
        $processor = new ImageProcessorService($imageSource);

        try {
            return $processor->processAndStoreImage();
        } catch (\Exception $e) {
            \Log::error('Error generating user photo: ' . $e->getMessage());
            return 'images/users/default.jpeg';
        }
    }
}
