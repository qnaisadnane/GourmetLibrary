<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CopyBook extends Model
{
    protected $fillable = ['book_id', 'is_degraded', 'degradation_details'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }
}
