<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['title', 'status', 'due_date', 'image_url'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
