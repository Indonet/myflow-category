<?php

namespace App\Models;

use CodeIgniter\Model;

class SubCategoryModel extends Model
{
    protected $table            = 'm_sub_category';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    // protected $protectFields    = true;
    protected $allowedFields    = ['ctgr_id','sub_ctgr_name','sub_ctgr_code','status','notes'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    
}
