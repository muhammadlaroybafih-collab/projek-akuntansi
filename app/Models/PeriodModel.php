<?php

namespace App\Models;

use CodeIgniter\Model;

class PeriodModel extends Model
{
    // Nama tabel yang lo buat tadi di migration
    protected $table            = 'periods';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    // Field yang boleh diisi (mass assignment) [cite: 2025-11-01]
    protected $allowedFields    = [
        'period_name', 
        'start_date', 
        'end_date', 
        'is_closed', 
        'created_at'
    ];

    // Aktifkan timestamp otomatis buat created_at [cite: 2025-11-01]
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = ''; // Kita nggak butuh updated_at [cite: 2025-11-01]
}