<?php

namespace App\Http\Controllers;

use App\Models\JurnalTarget;
use Illuminate\Http\Request;

class JurnalTargetController extends Controller
{
    public function index()
    {
        $items = JurnalTarget::where('user_id', auth()->id())->withCount('referensis')->orderBy('nama')->get();

        return view('jurnal.index', compact('items'));
    }

    public function create()
    {
        return view('jurnal.form', ['jurnal' => new JurnalTarget(['jenis_biaya' => 'belum_diketahui'])]);
    }

    public function store(Request $request)
    {
        JurnalTarget::create($this->data($request) + ['user_id' => auth()->id()]);

        return redirect()->route('jurnal.index')->with('ok', 'Jurnal target disimpan.');
    }

    public function edit(JurnalTarget $jurnal)
    {
        return view('jurnal.form', ['jurnal' => $this->own($jurnal)]);
    }

    public function update(Request $request, JurnalTarget $jurnal)
    {
        $this->own($jurnal)->update($this->data($request));

        return redirect()->route('jurnal.index')->with('ok', 'Perubahan disimpan.');
    }

    public function destroy(JurnalTarget $jurnal)
    {
        $this->own($jurnal)->delete();

        return redirect()->route('jurnal.index')->with('ok', 'Jurnal target dihapus.');
    }

    private function own(JurnalTarget $jurnal): JurnalTarget
    {
        abort_unless($jurnal->user_id === auth()->id(), 404);

        return $jurnal;
    }

    private function data(Request $request): array
    {
        $d = $request->validate([
            'nama' => 'required|string|max:200',
            'url' => 'nullable|url|max:500',
            'jenis_biaya' => 'required|in:gratis,berbayar,belum_diketahui',
            'biaya' => 'nullable|integer|min:0|required_if:jenis_biaya,berbayar',
            'periode_terbit' => 'nullable|string|max:100',
            'indeks' => 'nullable|string|max:50',
            'catatan' => 'nullable|string',
        ]);

        $d['biaya'] = match ($d['jenis_biaya']) {
            'gratis' => 0,
            'berbayar' => $d['biaya'],
            default => null,
        };
        $d['indeks_terverifikasi'] = $request->boolean('indeks_terverifikasi');

        return $d;
    }
}
