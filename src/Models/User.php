<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Abstract Class User
 *
 * Class User mewarisi Person.
 * Digunakan sebagai dasar untuk Admin dan Member.
 */
abstract class User extends Person
{
    protected string $passwordHash;
    protected string $createdAt;

    /**
     * Constructor
     */
    public function __construct(
        string $id,
        string $name,
        string $email,
        string $passwordHash,
        ?string $createdAt = null
    ) {
        parent::__construct($id, $name, $email);

        $this->passwordHash = $passwordHash;
        $this->createdAt = $createdAt ?? date('Y-m-d H:i:s');
    }

    /**
     * Mengatur password baru
     */
    public function setPassword(string $password): void
    {
        if (strlen($password) < 8) {
            throw new \InvalidArgumentException(
                'Password minimal 8 karakter.'
            );
        }

        $this->passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT
        );
    }

    /**
     * Memverifikasi password pengguna
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify(
            $password,
            $this->passwordHash
        );
    }

    /**
     * Mengambil tanggal pembuatan akun
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Mengambil halaman dashboard sesuai role.
     */
    abstract public function getDashboardPath(): string;

    /**
     * Mengambil data akun untuk penyimpanan JSON.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->passwordHash,
            'role' => $this->getRole(),
            'created_at' => $this->createdAt
        ];
    }
}
