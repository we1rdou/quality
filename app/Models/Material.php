<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'tipo', 'descripcion', 'longitud_pieza', 'precio_pieza', 'unidad', 'color'
    ];

    public function windows()
    {
        return $this->belongsToMany(Window::class, 'material_window');
    }
}
