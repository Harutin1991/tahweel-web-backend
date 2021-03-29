<?php

namespace App\Admin;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['ordering'];
    const TYPE = [
        'newsletter' => 1,
        'pressRelease' => 2
    ];
    public function setDateAttribute($value)
    {
        $this->attributes['date'] =  Carbon::parse($value);
    }
    protected $guarded = [];

    public function images()
    {
        return $this->hasMany('App\Admin\MediaImage', "media_id", "id");
    }
}
