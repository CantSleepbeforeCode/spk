<?php

namespace App\Http\Controllers;

use App\Models\Bobot;
use App\Models\CalonPeserta;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::guest()) {
                Redirect::to("/")->send();
            }

            if (Auth::user()->level != 'admin') {
                Redirect::to("/logout")->send();
            }

            return $next($request);
        });
    }

    public function home() {
        $registered = CalonPeserta::where('status_kelulusan', null)->count();
        $rejected = CalonPeserta::where('status_kelulusan', 'tidak_lulus')->count();
        $accepted = CalonPeserta::where('status_kelulusan', 'lulus')->count();
        return view('admin.home', ['registered' => $registered, 'rejected' => $rejected, 'accepted' => $accepted]);
    }

    public function participant() {
        $participants = CalonPeserta::with('penilaian.bobot_min','penilaian.bobot_kes','penilaian.bobot_jas')->get();
        $bobots = Bobot::all();
        return view('admin.participant', ['participants' => $participants, 'bobots' => $bobots]);
    }

    public function spk() {
        // $participants = CalonPeserta::with('penilaian.bobot_min','penilaian.bobot_kes','penilaian.bobot_jas')->where([
        //     ['status_kelulusan', '=', null],
        //     ['nilai_jas', '!=', null],
        //     ['nilai_kes', '!=', null],
        //     ['nilai_min', '!=', null],
        // ])->orderBy('nilai_uan', 'desc')->get();
        $participants = CalonPeserta::with('penilaian.bobot_min','penilaian.bobot_kes','penilaian.bobot_jas')->whereHas('penilaian', function($query) {
            return $query->where([
                ['nilai_jas', '!=', null],
                ['nilai_kes', '!=', null],
                ['nilai_min', '!=', null],
            ]);
        })->get();
        return view('admin.spk', ['participants' => $participants]);
    }

    public function grade(Request $request) {
        $participant = CalonPeserta::find($request->id);
        $penilaian = Penilaian::where('calon_peserta_id', $participant->id)->first();
        $penilaian->nilai_jas = $request->nilai_jas;
        $penilaian->nilai_kes = $request->nilai_kes;
        $penilaian->nilai_min = $request->nilai_min;
        $penilaian->keterangan_jas = $request->keterangan_jas;
        $penilaian->keterangan_kes = $request->keterangan_kes;
        $penilaian->keterangan_min = $request->keterangan_min;

        $penilaian->save();
        return redirect()->back()->with('success', 'Berhasil memberi nilai kepada ' . $participant->nama_lengkap);
    }

    public function graduate(Request $request) {
        $participant = CalonPeserta::find($request->id);
        $participant->status_kelulusan = $request->status_kelulusan;
        $participant->save();
        if($participant->status_kelulusan == 'lulus') {
            return redirect()->back()->with('success', 'Berhasil meluluskan ' . $participant->nama_lengkap);
        } else {
            return redirect()->back()->with('error', 'Berhasil mentidak luluskan ' . $participant->nama_lengkap);
        }
    }
}
