<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'descripcion', 'imagen', 'activo'
    ];

    public function windows()
    {
        return $this->hasMany(Window::class);
    }
}
