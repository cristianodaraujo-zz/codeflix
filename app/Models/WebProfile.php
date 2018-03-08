<?php

namespace App\Models;

use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Database\Eloquent\Model;

class WebProfile extends Model implements TableInterface
{
    protected $fillable = [
        'name', 'logo_url', 'code'
    ];


    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */
    public function getTableHeaders()
    {
        return [
            '#', 'Nome', 'Logo'
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
            case 'Nome':
                return $this->name;
            case 'Logo':
                return \Image::thumbnail($this->logo_url, 'thumbnail');
        }
    }

}
