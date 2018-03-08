<?php

namespace App\Models;

use Bootstrapper\Interfaces\TableInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subscription
 * @package App\Models
 */
class Subscription extends Model implements TableInterface
{
    /**
     * @var array
     */
    protected $fillable = [
        'expires_at', 'canceled_at', 'plan_id', 'order_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return (new Carbon($this->expires_at))->lt(new Carbon()) ? true : false;
    }

    /**
     * A list of headers to be used when a table is displayed
     *
     * @return array
     */
    public function getTableHeaders()
    {
        return [
            'Usuário', 'Plano', 'Expira em'
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
            case 'Usuário':
                return $this->order->user->name;
            case 'Plano':
                return $this->plan->name;
            case 'Expira em':
                return \Carbon\Carbon::parse($this->expires_at)->format('d/m/Y');
        }
    }
}
