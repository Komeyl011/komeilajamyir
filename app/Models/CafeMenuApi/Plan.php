<?php

namespace App\Models\CafeMenuApi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Plan extends ApiModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'billing_interval',
        'features',
    ];

    public $interval_translator = [
        'monthly' => 'ماهانه',
        'quarterly' => 'سه ماهه',
        'yearly' => 'سالانه',
    ];

    public function setFeaturesAttribute($value)
    {
        $this->attributes['features'] = json_encode($value);
    }
}
