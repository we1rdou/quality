<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialWindow extends Model
{
    protected $table = 'material_window';
    protected $fillable = [
        'material_id',
        'window_id',
        'cantidad',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function window()
    {
        return $this->belongsTo(Window::class);
    }
}
