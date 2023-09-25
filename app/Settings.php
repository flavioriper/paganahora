<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['chance','yt_chance', 'promo_sum', 'promo_percent', 'fk_id', 'fk_secret1', 'fk_secret2', 'min_bet', 'min_with',
        'tefway_token','tefway_pix','tefway_test','tefway_active'];
}
