<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShiftRequest;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftWebController extends Controller
{
    public function index()
    {
        $shifts = Shift::latest()->paginate(10);
        return view('hrga.manajemen.shift.index', compact('shifts'));
    }

    public function create()
    {
        return view('hrga.manajemen.shift.create');
    }

    public function store(ShiftRequest $request)
    {
        Shift::create($request->validated());
        return redirect()->route('hrga.manajemen.shift.index')->with('success', 'Shift baru berhasil ditambahkan.');
    }

    public function show(Shift $shift)
    {
        return view('hrga.manajemen.shift.show', compact('shift'));
    }

    public function edit(Shift $shift)
    {
        return view('hrga.manajemen.shift.edit', compact('shift'));
    }

    public function update(ShiftRequest $request, Shift $shift)
    {
        $shift->update($request->validated());
        return redirect()->route('hrga.manajemen.shift.index')->with('success', 'Data shift berhasil diperbarui.');
    }

    public function destroy(Shift $shift)
    {
        // Cek apakah ada karyawan yang masih menggunakan shift ini
        if ($shift->karyawan()->exists()) {
            return back()->with('error', 'Gagal menghapus! Shift ini masih digunakan oleh beberapa karyawan.');
        }

        $shift->delete();
        return redirect()->route('hrga.manajemen.shift.index')->with('success', 'Data shift berhasil dihapus.');
    }
}