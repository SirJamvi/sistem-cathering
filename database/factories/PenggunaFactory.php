<?php
// database/factories/PenggunaFactory.php
namespace Database\Factories;

use App\Models\Pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PenggunaFactory extends Factory
{
    protected $model = Pengguna::class;

    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => fake()->optional(0.8)->dateTime(),
            'password' => Hash::make('password123'),
            'nama_lengkap' => fake()->name(),
            'role' => fake()->randomElement(['karyawan', 'koki', 'admin_hrga']),
            'is_active' => fake()->boolean(90), // 90% aktif
            'phone' => fake()->optional(0.7)->phoneNumber(),
            'remember_token' => Str::random(10),
        ];
    }

    public function karyawan(): static
    {
        return $this->state(['role' => 'karyawan']);
    }

    public function koki(): static
    {
        return $this->state(['role' => 'koki']);
    }

    public function adminHrga(): static
    {
        return $this->state(['role' => 'admin_hrga']);
    }

    public function active(): static
    {
        return $this->state(['is_active' => true]);
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}