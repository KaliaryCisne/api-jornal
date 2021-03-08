<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class TypeNews extends Model
{
    /** The attributes that are mass assignable. */
    protected $fillable = ['user_id', 'type'];

    /**
     * Retorna todas as notícias daquele tipo
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function news()
    {
        return $this->hasMany(News::class);
    }

}
