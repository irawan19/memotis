<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Master_unit_kerja extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'master_unit_kerjas';
    protected $primaryKey = 'id_unit_kerjas';

    protected $fillable = [
        'nama_unit_kerjas',
        'lokasi_unit_kerjas',
    ];

    /**
     * Relasi ke users.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'unit_kerjas_id', 'id_unit_kerjas');
    }
}
