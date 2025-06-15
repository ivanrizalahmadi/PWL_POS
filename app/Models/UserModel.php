<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\LevelModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravolt\Avatar\Avatar;


class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username', 'avatar', 'password', 'nama', 'level_id', 'created_at', 'updated_at'
    ];

    protected $hidden = ['password']; // agar password tidak muncul saat select

    protected $casts = [
        'password' => 'hashed', // otomatis hash saat disimpan
    ];

    /**
     * Relasi ke tabel level
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    public function getRoleName(): string
    {
        return $this->level->level_nama;
    }

    public function hasRole($role): bool
    {
        return $this->level->level_kode == $role;
    }
    public function getRole()
    {
        return $this->level->level_kode;
    }
      public function getAvatarUrl(): string
    {
        if ($this->avatar && file_exists(public_path($this->avatar))) {
            return asset($this->avatar);
        } else {
            $avatar = new Avatar();
            return $avatar->create($this->nama)->toBase64();
        }
    }
}