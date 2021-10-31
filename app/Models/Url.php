<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'urls';

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
        'hit_count' => 'integer',
    ];

    public function getRediractionPath(): string
    {
        $this->increment('hit_count', 1);
        return $this->redirect_url;
    }
}
