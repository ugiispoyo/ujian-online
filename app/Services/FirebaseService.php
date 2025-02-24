<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\Auth\UserNotFound; // Tambahkan namespace ini!

class FirebaseService
{
    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));
        $this->auth = $factory->createAuth();
    }

    /**
     * Verifikasi ID Token dari Firebase
     */
    public function verifyIdToken($idToken)
    {
        if (!$idToken) {
            throw new \Exception('ID Token tidak valid atau null');
        }

        try {
            return $this->auth->verifyIdToken($idToken);
        } catch (\Throwable $e) {
            throw new \Exception('Gagal memverifikasi ID Token: ' . $e->getMessage());
        }
    }


    /**
     * Mendapatkan Pengguna Berdasarkan Email di Firebase
     */
    public function getUserByEmail($email)
    {
        try {
            return $this->auth->getUserByEmail($email);
        } catch (UserNotFound $e) { // Pastikan ini sesuai namespace!
            return null;
        }
    }
}
