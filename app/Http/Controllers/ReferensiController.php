<?php

namespace App\Http\Controllers;

use App\Models\JurnalTarget;
use App\Models\Referensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ReferensiController extends Controller
{
    public function index(Request $request)
    {
        $base = Referensi::where('user_id', auth()->id());
        $counts = (clone $base)->selectRaw('status, count(*) as n')->groupBy('status')->pluck('n', 'status');

        $items = $base->with('jurnalTarget')
            ->when($request->filled('q'), function ($query) use ($request) {
                $like = '%'.$request->q.'%';
                $query->where(function ($w) use ($like) {
                    foreach (['judul', 'penulis', 'kata_kunci', 'metode', 'permasalahan', 'temuan', 'catatan', 'tags'] as $col) {
                        $w->orWhere($col, 'like', $like);
                    }
                });
            })
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('tag'), fn ($q) => $q->where('tags', 'like', '%'.$request->tag.'%'))
            ->latest()
            ->simplePaginate(15)
            ->withQueryString();

        return view('referensi.index', compact('items', 'counts'));
    }

    public function create()
    {
        return view('referensi.form', [
            'referensi' => new Referensi(['status' => 'belum_dibaca']),
            'jurnals' => $this->jurnals(),
        ]);
    }

    public function store(Request $request)
    {
        $referensi = Referensi::create($this->data($request) + ['user_id' => auth()->id()]);

        return redirect()->route('referensi.show', $referensi)->with('ok', 'Referensi disimpan.');
    }

    public function show(Referensi $referensi)
    {
        return view('referensi.show', ['referensi' => $this->own($referensi)->load('jurnalTarget')]);
    }

    public function edit(Referensi $referensi)
    {
        return view('referensi.form', ['referensi' => $this->own($referensi), 'jurnals' => $this->jurnals()]);
    }

    public function update(Request $request, Referensi $referensi)
    {
        $this->own($referensi)->update($this->data($request, $referensi));

        return redirect()->route('referensi.show', $referensi)->with('ok', 'Perubahan disimpan.');
    }

    public function destroy(Referensi $referensi)
    {
        $this->own($referensi);

        if ($referensi->file_pdf) {
            Storage::disk('public')->delete($referensi->file_pdf);
        }
        $referensi->delete();

        return redirect()->route('referensi.index')->with('ok', 'Referensi dihapus.');
    }

    private function own(Referensi $referensi): Referensi
    {
        abort_unless($referensi->user_id === auth()->id(), 404);

        return $referensi;
    }

    private function jurnals()
    {
        return JurnalTarget::where('user_id', auth()->id())->orderBy('nama')->get(['id', 'nama']);
    }

    private function data(Request $request, ?Referensi $current = null): array
    {
        $d = $request->validate([
            'judul' => 'required|string|max:500',
            'penulis' => 'nullable|string|max:300',
            'tahun' => 'nullable|integer|between:1900,2100',
            'url_artikel' => 'nullable|url|max:500',
            'pdf' => 'nullable|file|mimes:pdf|max:20480',
            'status' => ['required', Rule::in(array_keys(Referensi::STATUS))],
            'metode' => 'nullable|string',
            'kelengkapan_metode' => 'nullable|in:lengkap,cukup,kurang',
            'permasalahan' => 'nullable|string',
            'temuan' => 'nullable|string',
            'keterbatasan' => 'nullable|string',
            'catatan' => 'nullable|string',
            'relevansi' => 'nullable|integer|between:1,5',
            'tags' => 'nullable|string|max:300',
            'kata_kunci' => 'nullable|string|max:500',
            'jurnal_target_id' => ['nullable', Rule::exists('jurnal_targets', 'id')->where('user_id', auth()->id())],
        ]);

        // BRL-01: status selesai/dipakai butuh minimal satu sumber (PDF atau tautan).
        $hasSource = $request->hasFile('pdf') || filled($d['url_artikel'] ?? null) || filled($current?->file_pdf);
        if (in_array($d['status'], ['selesai', 'dipakai'], true) && ! $hasSource) {
            throw ValidationException::withMessages([
                'status' => 'Tambahkan file PDF atau tautan artikel sebelum menandai referensi ini selesai dibaca.',
            ]);
        }

        $d['tags'] = collect(explode(',', (string) ($d['tags'] ?? '')))
            ->map(fn ($t) => trim($t))->filter()->unique()->join(', ') ?: null;

        unset($d['pdf']);
        if ($request->hasFile('pdf')) {
            if ($current?->file_pdf) {
                Storage::disk('public')->delete($current->file_pdf);
            }
            $d['file_pdf'] = $request->file('pdf')->store('pdf', 'public');
        }

        return $d;
    }
}
