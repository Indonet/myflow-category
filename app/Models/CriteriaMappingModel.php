<?php

namespace App\Models;

use CodeIgniter\Model;

class CriteriaMappingModel extends Model
{
    protected $table            = 'm_criteria_mapping';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['ctgr_id','sub_ctgr_id','crtr_id','status','notes'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    public function getCriteriaMapping($where = array()) {
        $builder = $this->db->table("$this->table as a")
                    ->select("a.id,crtr.id as criteria_id,
                              subctgr.id as sub_ctgr_id,
                              crtr.crtr_name,crtr.crtr_code,
                              subctgr.type_amount,
                              subctgr.sub_ctgr_name,subctgr.sub_ctgr_code,a.notes");
        $builder->join('m_criteria as crtr',"crtr.id = a.crtr_id");
        $builder->join('m_sub_category as subctgr',"subctgr.id = a.sub_ctgr_id","LEFT");
        if (sizeof($where) > 0) {
                foreach($where as $key => $value) {
                    $builder->where($key, $value);
                }
            }
            
        $builder->where('a.status', 'Y');
        $result = $builder->get()->getResult();

        return $result;
    }
}
