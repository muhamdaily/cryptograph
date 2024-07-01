<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return view('dashboard');
            } elseif ($user->role === 'user') {
                return view('dashboard');
            }
        }
    }

    public function enkripsi()
    {
        return view('home.enkripsi');
    }

    public function deskripsi()
    {
        return view('home.deskripsi');
    }

    public function encrypt(Request $request)
    {
        $input = $request->validate([
            'message' => 'required|string',
            'key' => 'required|string',
        ]);

        $message = $input['message'];
        $key = $input['key'];

        // Menggabungkan pesan dengan key untuk enkripsi
        $encrypted = Crypt::encryptString($message . '::' . $key);

        return view('home.enkripsi', [
            'encryptedMessage' => $encrypted,
        ]);
    }


    public function decrypt(Request $request)
    {
        $input = $request->validate([
            'encrypted_message' => 'required|string',
            'key' => 'required|string',
        ]);

        $encryptedMessage = $input['encrypted_message'];
        $key = $input['key'];

        try {
            $decrypted = Crypt::decryptString($encryptedMessage);
            list($message, $originalKey) = explode('::', $decrypted);

            if ($key === $originalKey) {
                return view('home.deskripsi', [
                    'decryptedMessage' => $message,
                ]);
            } else {
                return view('home.deskripsi', [
                    'decryptedMessage' => 'Key tidak cocok',
                ]);
            }
        } catch (\Exception $e) {
            return view('home.deskripsi', [
                'decryptedMessage' => 'Pesan terenkripsi tidak valid',
            ]);
        }
    }
}
