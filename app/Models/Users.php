<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $connection = 'mysql'; // Menentukan koneksi yang akan digunakan (mengarah ke database lokal)

    // Tentukan nama tabel yang sesuai jika tidak sesuai dengan default (users)
    protected $table = 'users';

    // Tentukan kolom yang boleh diisi (mass assignment)
    protected $fillable = ['email', 'username', 'password'];

    // Jika menggunakan timestamp
    public $timestamps = true;
}
