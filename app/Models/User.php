<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nik',
        'nik_hash',
        'no_kk',
        'rt',
        'rw',
        'no_hp',
    ];

    protected $appends = [
        'role_label',
        'role_names',
        'avatar_initials',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'nik',
        'no_kk',
        'no_hp',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'no_kk' => 'encrypted',
            'no_hp' => 'encrypted',
        ];
    }

    public static function hashNik(string $nik): string
    {
        return hash('sha256', $nik.config('app.key'));
    }

    public static function findByNik(string $nik): ?self
    {
        return static::where('nik_hash', static::hashNik($nik))->first();
    }

    public function setNikAttribute(string $value): void
    {
        $this->attributes['nik'] = $value;
        $this->attributes['nik_hash'] = static::hashNik($value);
    }

    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class);
    }

    public function pengajuanSurat(): HasMany
    {
        return $this->hasMany(PengajuanSurat::class);
    }

    public function eventPeserta(): HasMany
    {
        return $this->hasMany(EventPeserta::class);
    }

    public function approvalHistories(): HasMany
    {
        return $this->hasMany(ApprovalHistory::class);
    }

    public function dashboardLayouts(): HasMany
    {
        return $this->hasMany(DashboardLayout::class);
    }

    public function userSettings(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }

    public function getRoleLabelAttribute(): ?string
    {
        $role = $this->roles()->first();

        return $role?->name;
    }

    public function isAdmin(): bool
    {
        return $this->roles()->where('name', '!=', 'Warga')->exists();
    }

    public function isWarga(): bool
    {
        return $this->hasRole('Warga');
    }

    public function getRoleNamesAttribute(): string
    {
        return $this->roles->pluck('name')->implode(', ');
    }

    public function getAvatarInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= mb_strtoupper(mb_substr($word, 0, 1));
        }

        return $initials;
    }
}
