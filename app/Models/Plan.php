<?php

namespace App\Models;

use Bootstrapper\Interfaces\TableInterface;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model implements TableInterface
{
    const DURATION_YEARLY = 1;
    const DURATION_MONTHLY = 2;

    protected $fillable = [
        'name', 'description', 'value', 'duration', 'web_profile_id'
    ];

    protected $casts = [
        'duration' => 'integer'
    ];

    /**
     * @var array
     */
    public static $duration = [
        self::DURATION_YEARLY => 'Anual',
        self::DURATION_MONTHLY => 'Mensal'
    ];

    /**
     * @param $id
     * @return mixed
     */
    public static function duration($id)
    {
        return self::$duration[$id];
    }

    public function getSkuAttribute()
    {
        return "plan-{$this->id}";
    }

    public static function getIdFromSku($sku)
    {
        return str_replace('plan-', '', $sku);
    }

    public function webProfile()
    {
        return $this->belongsTo(WebProfile::class/*, 'web_profile_id'*/);
    }


    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */
    public function getTableHeaders()
    {
        return [
            '#', 'Nome', 'Descrição', 'Duração'
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
            case 'Descrição':
                return $this->description;
            case 'Duração':
                return $this->duration($this->duration);

        }
    }
}
