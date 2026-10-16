<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LinkIjazah;
use Illuminate\Http\Request;

class LinkIjazahController extends Controller
{
    public function index()
    {
        $links = LinkIjazah::latest()->paginate(20);

        return view('admin.link-ijazah.index', compact('links'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tahun' => ['required', 'integer', 'digits:4'],
            'url' => ['required', 'string', 'max:255'],
        ]);

        LinkIjazah::create($data);

        return back()->with('success', 'Link berhasil ditambahkan.');
    }

    public function destroy(LinkIjazah $link_ijazah)
    {
        $link_ijazah->delete();

        return back()->with('success', 'Link berhasil dihapus.');
    }
}
