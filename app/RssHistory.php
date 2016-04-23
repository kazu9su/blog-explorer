<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RssHistory extends Model
{
    protected $fillable = [
        'title',
        'description',
        'link',
        'date',
        'user',
        'server',
        'entry_number',
    ];

    /**
     * user, server, entry_numberが一緒のものが存在すれば、一意であるとする
     * @return bool
     */
    public function exists()
    {
        return self::where('user', $this->user)->where('server', $this->server)->where('entry_number', $this->entry_number)->exists();
    }
}
