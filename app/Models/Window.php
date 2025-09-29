<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Window extends Model
{
    // Eliminar $fillable, dejar solo $guarded = [] para asignación masiva segura
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_window');
    }
}
