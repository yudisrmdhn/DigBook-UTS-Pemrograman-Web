<?php

declare(strict_types=1);

namespace App\Models;

/**
 * Abstract Class Person
 *
 * Class induk untuk seluruh pengguna DigBook.
 * Menerapkan Encapsulation dan Abstraction.
 */
abstract class Person
{
    // Properti dasar pengguna
    protected string $id;
    protected string $name;
    protected string $email;

    /**
     * Constructor
     */
    public function __construct(
        string $id,
        string $name,
        string $email
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Mengambil ID pengguna
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Mengambil nama pengguna
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Mengubah nama pengguna
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Mengambil email pengguna
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Mengubah email pengguna
     */
    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(
                'Format email tidak valid.'
            );
        }

        $this->email = $email;
    }

    /**
     * Abstract method untuk menentukan role pengguna.
     * Wajib diimplementasikan oleh class turunan.
     */
    abstract public function getRole(): string;
}
