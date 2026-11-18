<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Member;
use App\Models\User;
use RuntimeException;

class AuthController
{
    private string $dataFile;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dataFile = DATA_PATH . '/users.json';

        // Membuat file JSON jika belum tersedia
        if (!file_exists($this->dataFile)) {
            file_put_contents(
                $this->dataFile,
                json_encode([], JSON_PRETTY_PRINT),
                LOCK_EX
            );
        }
    }

    /**
     * Membaca seluruh data pengguna
     */
    private function getUsers(): array
    {
        $content = file_get_contents($this->dataFile);

        if ($content === false) {
            throw new RuntimeException(
                'Gagal membaca data pengguna.'
            );
        }

        $users = json_decode($content, true);

        if (!is_array($users)) {
            throw new RuntimeException(
                'Format data pengguna tidak valid.'
            );
        }

        return $users;
    }

    /**
     * Menyimpan data pengguna ke JSON
     */
    private function saveUsers(array $users): void
    {
        $json = json_encode(
            $users,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        if ($json === false) {
            throw new RuntimeException(
                'Gagal mengubah data menjadi JSON.'
            );
        }

        $result = file_put_contents(
            $this->dataFile,
            $json,
            LOCK_EX
        );

        if ($result === false) {
            throw new RuntimeException(
                'Gagal menyimpan data pengguna.'
            );
        }
    }

    /**
     * Membuat objek berdasarkan role pengguna
     */
    private function createUserObject(array $data): User
    {
        $requiredFields = [
            'id',
            'name',
            'email',
            'password'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new RuntimeException(
                    'Data pengguna tidak lengkap.'
                );
            }
        }

        $role = $data['role'] ?? 'member';

        return match ($role) {
            'admin' => new Admin(
                $data['id'],
                $data['name'],
                $data['email'],
                $data['password'],
                $data['created_at'] ?? null
            ),

            default => new Member(
                $data['id'],
                $data['name'],
                $data['email'],
                $data['password'],
                $data['created_at'] ?? null
            )
        };
    }

    /**
     * Proses Register
     */
    public function register(
        string $name,
        string $email,
        string $password
    ): array {

        $name = trim($name);
        $email = strtolower(trim($email));

        if ($name === '') {
            return [
                'success' => false,
                'message' => 'Nama tidak boleh kosong.'
            ];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => 'Format email tidak valid.'
            ];
        }

        if (strlen($password) < 8) {
            return [
                'success' => false,
                'message' => 'Password minimal 8 karakter.'
            ];
        }

        $users = $this->getUsers();

        // Memeriksa email duplikat
        foreach ($users as $user) {
            if (
                isset($user['email'])
                && strtolower($user['email']) === $email
            ) {
                return [
                    'success' => false,
                    'message' => 'Email sudah terdaftar.'
                ];
            }
        }

        // Membuat objek Member baru
        $member = new Member(
            uniqid('USR_'),
            $name,
            $email,
            ''
        );

        // Mengatur password menggunakan hash
        $member->setPassword($password);

        // Menyimpan data pengguna
        $users[] = $member->toArray();

        $this->saveUsers($users);

        return [
            'success' => true,
            'message' => 'Registrasi berhasil. Silakan login.'
        ];
    }

    /**
     * Proses Login
     */
    public function login(
        string $email,
        string $password
    ): array {

        $email = strtolower(trim($email));

        if ($email === '' || $password === '') {
            return [
                'success' => false,
                'message' => 'Email dan password wajib diisi.'
            ];
        }

        $users = $this->getUsers();

        foreach ($users as $data) {

            if (
                !isset($data['email'])
                || strtolower($data['email']) !== $email
            ) {
                continue;
            }

            $user = $this->createUserObject($data);

            if (!$user->verifyPassword($password)) {
                return [
                    'success' => false,
                    'message' => 'Email atau password salah.'
                ];
            }

            // Mencegah session fixation
            session_regenerate_id(true);

            // Menyimpan identitas pengguna ke session
            $_SESSION['user'] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'role' => $user->getRole()
            ];

            return [
                'success' => true,
                'message' => 'Login berhasil.',
                'redirect' => $user->getDashboardPath()
            ];
        }

        return [
            'success' => false,
            'message' => 'Email atau password salah.'
        ];
    }

    /**
     * Memeriksa status login
     */
    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Mendapatkan data pengguna yang sedang login
     */
    public function getCurrentUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Memeriksa hak akses berdasarkan role
     */
    public function hasRole(string $role): bool
    {
        return $this->isLoggedIn()
            && ($_SESSION['user']['role'] ?? '') === $role;
    }

    /**
     * Memastikan pengguna sudah login
     */
    public function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
            redirect('login.php');
        }
    }

    /**
     * Memastikan pengguna memiliki role tertentu
     */
    public function requireRole(string $role): void
    {
        $this->requireLogin();

        if (!$this->hasRole($role)) {
            http_response_code(403);
            exit('403 - Anda tidak memiliki akses ke halaman ini.');
        }
    }

    /**
     * Proses Logout
     */
    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }
}
