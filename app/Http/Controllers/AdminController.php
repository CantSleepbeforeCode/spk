<?php

namespace App\Http\Controllers;

use App\Models\CalonPeserta;
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
        $participants = CalonPeserta::all();
        return view('admin.participant', ['participants' => $participants]);
    }

    public function spk() {
        $participants = CalonPeserta::where([
            ['status_kelulusan', '=', null],
            ['nilai_jas', '!=', null],
            ['nilai_kes', '!=', null],
            ['nilai_min', '!=', null],
        ])->orderBy('nilai_uan', 'desc')->get();
        return view('admin.spk', ['participants' => $participants]);
    }

    public function grade(Request $request) {
        $participant = CalonPeserta::find($request->id);
        $participant->nilai_jas = $request->nilai_jas;
        $participant->nilai_kes = $request->nilai_kes;
        $participant->nilai_min = $request->nilai_min;
        $participant->keterangan_jas = $request->keterangan_jas;
        $participant->keterangan_kes = $request->keterangan_kes;
        $participant->keterangan_min = $request->keterangan_min;

        if($request->nilai_jas == 'L') {
            $participant->status_jas = 'Lulus';
        } else {
            $participant->status_jas = 'Tidak Lulus';
        }

        $participant->status_kes = 'STAKES ' . $request->nilai_kes;

        if($request->nilai_min == 'MS') {
            $participant->status_min = 'Memenuhi Syarat';
        } else {
            $participant->status_min = 'Tidak Memenuhi Syarat';
        }

        $participant->save();
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
