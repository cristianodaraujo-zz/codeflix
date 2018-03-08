<?php

namespace App\Models;

use App\Media\VideoPathTrait;
use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model implements TableInterface
{
    use VideoPathTrait, SoftDeletes;

    protected $fillable = [
        'title', 'description', 'duration', 'published', 'playlist_id'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */
    public function getTableHeaders()
    {
        return [
            '#'
        ];
    }

    /**
     * Get the value for a given header. Note that this will be the value
     * passed to any callback functions that are being used.
     *
     * @param string $header
     * @return mixed
     */
    public function getValueForHeader($header)
    {
        switch ($header) {
            case '#':
                return $this->id;
        }
    }
}
