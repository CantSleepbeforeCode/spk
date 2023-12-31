<?php

namespace App\Http\Controllers;

use App\Models\CalonPeserta;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home(Request $request)
    {
        $result = null;
        $query = null;
        if ($request->method() == 'POST') {
            $calonPeserta = CalonPeserta::with('penilaian.bobot_min','penilaian.bobot_kes','penilaian.bobot_jas')->where('nomor_peserta', $request->nomor_peserta)->first();

            if($calonPeserta != null) {
                $result = $calonPeserta;
            } else {
                $result = 'not_found';
            }
            $query = $request->nomor_peserta;
        }
        return view('welcome', ['result' => $result, 'query' => $query]);
    }
}
