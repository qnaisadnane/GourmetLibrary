<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $fillable = ['user_id', 'copy_book_id', 'borrowed_at', 'returned_at'];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function copyBook()
    {
        return $this->belongsTo(CopyBook::class);
    }
}
