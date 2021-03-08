<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /** The attributes that are mass assignable. */
    protected $fillable = [
        'user_id', 'type_news_id', 'title', 'description', 'body', 'image_link'
    ];

    /**
     * Retorna o jornalista que criou a notícia
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function journalist()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Retorna o tipo da noticia
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(TypeNews::class);
    }
}
