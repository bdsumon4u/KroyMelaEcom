<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'name', 'phone', 'email', 'address', 'status', 'products', 'note', 'data',
    ];

    public function getProductsAttribute($products)
    {
        return json_decode($products);
    }

    public function getDataAttribute($data)
    {
        return json_decode($data);
    }

    public function setDataAttribute($data)
    {
        $this->attributes['data'] = json_encode(array_merge((array)$this->data, $data));
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
