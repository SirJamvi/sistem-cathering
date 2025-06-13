<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shift;
use Illuminate\Support\Facades\DB;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shifts')->delete(); // Kosongkan tabel terlebih dahulu

        Shift::create([
            'nama_shift' => 'Shift 1',
            'jam_mulai' => '07:00',
            'jam_selesai' => '15:00',
            'jam_makan_mulai' => '11:30',
            'jam_makan_selesai' => '12:30'
        ]);

        Shift::create([
            'nama_shift' => 'Shift 2',
            'jam_mulai' => '15:00',
            'jam_selesai' => '23:00',
            'jam_makan_mulai' => '19:00',
            'jam_makan_selesai' => '20:00'
        ]);

        Shift::create([
            'nama_shift' => 'Shift 3',
            'jam_mulai' => '23:00',
            'jam_selesai' => '07:00',
            'jam_makan_mulai' => '03:00',
            'jam_makan_selesai' => '04:00'
        ]);
    }
}