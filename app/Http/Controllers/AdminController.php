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

    public function home()
    {
        $registered = CalonPeserta::where('status_kelulusan', null)->count();
        $rejected = CalonPeserta::where('status_kelulusan', 'tidak_lulus')->count();
        $accepted = CalonPeserta::where('status_kelulusan', 'lulus')->count();
        return view('admin.home', ['registered' => $registered, 'rejected' => $rejected, 'accepted' => $accepted]);
    }

    public function participant()
    {
        $participants = CalonPeserta::with('penilaian.bobot_min', 'penilaian.bobot_kes', 'penilaian.bobot_jas')->get();
        $bobots = Bobot::all();
        return view('admin.participant', ['participants' => $participants, 'bobots' => $bobots]);
    }

    public function bobot()
    {
        $bobots = Bobot::all();
        return view('admin.bobot', ['bobots' => $bobots]);
    }

    public function spk()
    {
        // $participants = CalonPeserta::with('penilaian.bobot_min','penilaian.bobot_kes','penilaian.bobot_jas')->where([
        //     ['status_kelulusan', '=', null],
        //     ['nilai_jas', '!=', null],
        //     ['nilai_kes', '!=', null],
        //     ['nilai_min', '!=', null],
        // ])->orderBy('nilai_uan', 'desc')->get();
        $participants = CalonPeserta::with('penilaian.bobot_min', 'penilaian.bobot_kes', 'penilaian.bobot_jas')->whereHas('penilaian', function ($query) {
            return $query->where([
                ['nilai_jas', '!=', null],
                ['nilai_kes', '!=', null],
                ['nilai_min', '!=', null],
            ]);
        })->get();
        return view('admin.spk', ['participants' => $participants]);
    }

    public function grade(Request $request)
    {
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

    public function graduate(Request $request)
    {
        $participant = CalonPeserta::find($request->id);
        $participant->status_kelulusan = $request->status_kelulusan;
        $participant->save();
        if ($participant->status_kelulusan == 'lulus') {
            return redirect()->back()->with('success', 'Berhasil meluluskan ' . $participant->nama_lengkap);
        } else {
            return redirect()->back()->with('error', 'Berhasil mentidak luluskan ' . $participant->nama_lengkap);
        }
    }

    public function addBobot(Request $request)
    {
        $bobot = new Bobot();
        $bobot->kategori = $request->kategori;
        $bobot->sub_kategori = $request->sub_kategori;
        $bobot->deskripsi = $request->deskripsi;
        $bobot->nilai = $request->nilai;
        $bobot->save();
        return redirect()->back()->with('success', 'Berhasil menambah bobot! ');
    }

    public function editBobot(Request $request)
    {
        $bobot = Bobot::find($request->bobot);
        $bobot->kategori = $request->kategori;
        $bobot->sub_kategori = $request->sub_kategori;
        $bobot->deskripsi = $request->deskripsi;
        $bobot->nilai = $request->nilai;
        $bobot->save();
        return redirect()->back()->with('success', 'Berhasil mengubah bobot! ');
    }

    public function deleteBobot($id)
    {
        $penilaianMins = Penilaian::where('nilai_min', $id)->get();
        $penilaianKess = Penilaian::where('nilai_kes', $id)->get();
        $penilaianJass = Penilaian::where('nilai_jas', $id)->get();

        foreach ($penilaianMins as $penilaianMin) {
            $penilaianMin->nilai_min = null;
            $penilaianMin->save();
        }

        foreach ($penilaianKess as $penilaianKes) {
            $penilaianKes->nilai_kes = null;
            $penilaianKes->save();
        }

        foreach ($penilaianJass as $penilaianJas) {
            $penilaianJas->nilai_jas = null;
            $penilaianJas->save();
        }

        $bobot = Bobot::find($id);
        $bobot->delete();
        return redirect()->back()->with('error', 'Berhasil menghapus bobot! ');
    }

    public function addParticipant(Request $request)
    {
        $check = CalonPeserta::where([
            'nama_lengkap' => strtoupper($request->nama_lengkap),
            'jenis_kelamin' => strtoupper($request->jenis_kelamin),
            'tanggal_lahir' => $request->tanggal_lahir,
        ])->first();

        if ($check == null) {
            $lastUser = CalonPeserta::orderBy('id', 'desc')->first()->nomor_peserta;
            $nextUser = "060." . sprintf('%0' . 4 . 's', intval(explode('.', explode('/', $lastUser)[0])[1] + 1)) . "/CATA II-R/" . date('Y');

            $newUser = new CalonPeserta();
            $newUser->nomor_peserta = $nextUser;
            $newUser->nama_lengkap = strtoupper($request->nama_lengkap);
            $newUser->jenis_kelamin = strtoupper($request->jenis_kelamin);
            $newUser->tempat_lahir = $request->tempat_lahir;
            $newUser->tanggal_lahir = $request->tanggal_lahir;
            $newUser->tinggi_badan = $request->tinggi_badan;
            $newUser->berat_badan = $request->berat_badan;
            $newUser->agama = $request->agama;
            $newUser->suku = $request->suku;
            $newUser->pendidikan = $request->pendidikan;
            $newUser->tahun_kelulusan = $request->tahun_kelulusan;
            $newUser->alamat = $request->alamat;
            $newUser->nomor_telepon = $request->nomor_telepon;
            $newUser->nama_ortu = $request->nama_ortu;
            $newUser->alamat_ortu = $request->alamat_ortu;
            $newUser->nama_wali = $request->nama_wali;
            $newUser->sumber_info = $request->sumber_info;
            $newUser->pekerjaan_ortu = $request->pekerjaan_ortu;
            $newUser->jurusan_dikum = $request->jurusan_dikum;
            $newUser->nama_sekolah = $request->nama_sekolah;
            $newUser->nilai_uan = $request->nilai_uan;
            $newUser->kodim = $request->kodim;
            $newUser->save();

            $newPenilaian = new Penilaian();
            $newPenilaian->calon_peserta_id = $newUser->id;
            $newPenilaian->save();

            return back()->with('success', 'Berhasil mendaftar. Berikut Nomor Peserta untuk '.$newUser->nama_lengkap.': ' . $newUser->nomor_peserta);
        } else {
            return back()->with('error', 'Akun '.$check->nama_lengkap.' telah terdaftar sebelumnya. Berikut Nomor Peserta '.$check->nama_lengkap.': ' . $check->nomor_peserta);
        }
    }

    public function editParticipant(Request $request)
    {

            $user = CalonPeserta::find($request->id);
            $user->nama_lengkap = strtoupper($request->nama_lengkap);
            $user->jenis_kelamin = strtoupper($request->jenis_kelamin);
            $user->tempat_lahir = $request->tempat_lahir;
            $user->tanggal_lahir = $request->tanggal_lahir;
            $user->tinggi_badan = $request->tinggi_badan;
            $user->berat_badan = $request->berat_badan;
            $user->agama = $request->agama;
            $user->suku = $request->suku;
            $user->pendidikan = $request->pendidikan;
            $user->tahun_kelulusan = $request->tahun_kelulusan;
            $user->alamat = $request->alamat;
            $user->nomor_telepon = $request->nomor_telepon;
            $user->nama_ortu = $request->nama_ortu;
            $user->alamat_ortu = $request->alamat_ortu;
            $user->nama_wali = $request->nama_wali;
            $user->sumber_info = $request->sumber_info;
            $user->pekerjaan_ortu = $request->pekerjaan_ortu;
            $user->jurusan_dikum = $request->jurusan_dikum;
            $user->nama_sekolah = $request->nama_sekolah;
            $user->nilai_uan = $request->nilai_uan;
            $user->kodim = $request->kodim;
            $user->save();

            return back()->with('success', 'Berhasil mengubah data '.$user->nama_lengkap);
        
    }

    public function deleteParticipant($id)
    {
            $user = CalonPeserta::find($id);
            $penilaian = Penilaian::where('calon_peserta_id', $user->id)->first();
            $penilaian->delete();
            $user->delete();

            return back()->with('error', 'Berhasil menghapus peserta '.$user->nama_lengkap);
        
    }
}
