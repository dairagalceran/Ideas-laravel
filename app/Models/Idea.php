<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Idea extends Model
{
    use HasFactory;

    /**
     * Add [user_id] to fillable property to allow mass assignment on [App\Models\Idea].
     * seguridad al sistema
     */

    protected $fillable = ['user_id' , 'title', 'description', 'likes'];
    protected $casts = ['created_at' => 'datetime'];    // en index se agrega por ejemplo formato {{$idea->created_at->format('d/m/Y')}}

    /**
     * la relación es de muchos a uno
     * una Idea pertenece a un User
     * nombre de la funcion en singular
     *
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * la relación es de muchos  a muchos
     * varias  ideas  pueden gustar a  muchas usera
     * nombre de la funcion en plural por muchos se puede usar porque la otra funcion es singular
     *
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeMyIdeas(Builder $query , $filter): void
    {
        if(!empty($filter) && $filter == 'mis-ideas'){
            $query->where('user_id' , auth()->id());
        }

    }

    public function scopeTheBests(Builder $query , $filter): void
    {
        if(!empty($filter) && $filter == 'las-mejores'){
            $query->where('likes' , '>', 1)->orderBy('likes' , 'desc')->orderBy('created_at' , 'desc');
        }

    }

}
