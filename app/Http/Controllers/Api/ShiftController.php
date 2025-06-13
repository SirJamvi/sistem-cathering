<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    // Mengembalikan daftar shift aktif untuk form
    public function index()
    {
        $shifts = Shift::where('is_active', true)->get(['id', 'nama_shift']);
        return response()->json($shifts);
    }
}