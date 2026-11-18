<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Class Admin
 *
 * Class Admin mewarisi User.
 * Digunakan untuk pengguna dengan hak akses administrator.
 */
class Admin extends User
{
    public function __construct(
        string $id,
        string $name,
        string $email,
        string $passwordHash,
        ?string $createdAt = null
    ) {
        parent::__construct(
            $id,
            $name,
            $email,
            $passwordHash,
            $createdAt
        );
    }

    /**
     * Menentukan role sebagai Admin.
     */
    public function getRole(): string
    {
        return 'admin';
    }

    /**
     * Mendapatkan path dashboard Admin.
     */
    public function getDashboardPath(): string
    {
        return 'admin/dashboard.php';
    }
}
