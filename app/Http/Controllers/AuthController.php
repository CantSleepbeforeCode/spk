<?php

namespace App\Http\Controllers;

use App\Models\CalonPeserta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('auth.login');
        } else if ($request->method() == 'POST') {
            $user = User::where('username', $request->username)->first();
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                if ($user->level == 'admin') {
                    Auth::login($user);
                    return redirect('/admin/beranda');
                } elseif ($user->level == 'customer') {
                    Auth::login($user);
                    return redirect('/beranda');
                } else {
                    return back()->with('error', 'Akun anda tidak dapat diidentifikasi, silahkan hubungi Admin!');
                }
            } else {
                return back()->with('error', 'Username atau Password salah!');
            }
        }
    }

    public function register(Request $request) {
        if($request->method() == 'GET') {
            return view('auth.register');
        }else if($request->method() == 'POST') {
            $check = CalonPeserta::where([
                'nama_lengkap' => strtoupper($request->nama_lengkap),
                'jenis_kelamin' => strtoupper($request->jenis_kelamin),
                'tanggal_lahir' => $request->tanggal_lahir,
            ])->first();

            if($check == null) {
                $lastUser = CalonPeserta::orderBy('id', 'desc')->first()->nomor_peserta;
                $nextUser = "060." . sprintf('%0' . 4 . 's', intval(explode('.', explode('/',$lastUser)[0])[1]+1)) . "/CATA II-R/" . date('Y');

                $newUser = new CalonPeserta();
                $newUser->nomor_peserta = $nextUser;
                $newUser->nama_lengkap = $request->nama_lengkap;
                $newUser->jenis_kelamin = $request->jenis_kelamin;
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
                $newUser->save();
                
                return back()->with('success', 'Berhasil mendaftar. Berikut Nomor Peserta anda: ' . $newUser->nomor_peserta);
            } else {
                return back()->with('error', 'Akun anda telah terdaftar sebelumnya. Berikut Nomor Peserta anda: ' . $check->nomor_peserta);
            }
        }
    }

    
    public function logout()
    {
        Auth::logout();
        return redirect('/admin');
    }
}
