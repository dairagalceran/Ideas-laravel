<?php

namespace App\Models; //donde se encuentra almacenado -> en composer.json se encuentra "autoload"  donde se aclara la convención que app -> App
                        //siempre hay que aclarar donde se encuentra para ser encontrado porotras paginas.

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory; //carpetas en vendor -> NUNCA se edita  ni se comparte.
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.  CASTEOS
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    /**
     * la relación es de uno a muchos
     * un User muchas ideas
     * nombre de la funcion en pluralpor muchos
     *
     */
    public function ideas(): HasMany
    {
        return $this->hasMany(Idea::class);
    }

    /**
     * la relación es de muchos  a muchos
     * a varios  User les pueden gustar muchas ideas
     * nombre de la funcion en plural por muchos adaptar nombre
     *
     */
    public function ideasLiked(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}
