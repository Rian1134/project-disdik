<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LinkIjazah;

class LinkIjazahController extends Controller
{
    public function index()
    {
        $links = LinkIjazah::orderByDesc('tahun')->get();

        return view('user.link-ijazah.index', compact('links'));
    }
}
