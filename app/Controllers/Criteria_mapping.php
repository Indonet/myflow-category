<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Criteria_mapping extends ResourceController
{
    protected $modelName = 'App\Models\CriteriaMappingModel';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //
    }

    /*get all criteria By sub category ID */
    public function get_criteria_mapping() {
        $decoded = $this->verifyHeader();
        if (!$decoded['result']) {
            return $this->respond([
                'result' => $decoded['result'],
                'message' => $decoded['message'],
            ])->setStatusCode(401);
        }

        $where = [];
        if (!$this->request->getVar("ctgr_id")) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'required Category ID'
                ]
            ], 400);
        }

        if ($this->request->getVar("ctgr_id") == '') {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Category ID is empty'
                ]
            ], 400);
        }
        
        $where['a.ctgr_id'] = $this->request->getVar("ctgr_id");
        
        if ($this->request->getVar("sub_ctgr_id")) {
            if ($this->request->getVar("sub_ctgr_id") != '' || $this->request->getVar("sub_ctgr_id") > 0) {
                $where['a.sub_ctgr_id'] = $this->request->getVar("sub_ctgr_id");
            }
        }
        
        $criteria = new $this->modelName();
        $data = [
            'result'=> true,
            'data' => $criteria->getCriteriaMapping($where)
        ];

        return $this->respond($data,200);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $decoded = $this->verifyHeader();
        if (!$decoded['result']) {
            return $this->respond([
                'result' => $decoded['result'],
                'message' => $decoded['message'],
            ])->setStatusCode(401);
        }

        if (!$this->request->getVar("ctgr_id")) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'required Category ID'
                ]
            ], 400);
        }

        if ($this->request->getVar("ctgr_id") == '') {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Category ID is empty'
                ]
            ], 400);
        }

        if (!$this->request->getVar("crtr_id")) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'required Criteria ID'
                ]
            ], 400);
        }

        if ($this->request->getVar("crtr_id") == '') {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Criteria ID is empty'
                ]
            ], 400);
        }
        
        if ($this->request->getVar("sub_ctgr_id")) {
            if ($this->request->getVar("sub_ctgr_id") == '') {
                return $this->respond([
                    'status' => 400,
                    'error' => true,
                    'messages' => [
                        'error' => 'Sub Category ID is empty'
                    ]
                ], 400);
            } else {
                $data['sub_ctgr_id'] = $this->request->getVar('sub_ctgr_id');
            }
        }

        $data['ctgr_id'] = $this->request->getVar('ctgr_id');
        $data['crtr_id'] = $this->request->getVar('crtr_id');
        $data['status'] = 'Y';

        if ($this->request->getVar("notes")) {
            if ($this->request->getVar("notes") == '') {
                return $this->respond(array('message'=>"Notes is empty"));
            } else {
                $data['notes'] = $this->request->getVar('notes');
            }
        }

        $criteriaMapping = new $this->modelName();
        $criteriaMapping->insert($data);

        return $this->respondCreated(['message' => 'Criteria Mapping created successfully']);
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $decoded = $this->verifyHeader();
        if (!$decoded['result']) {
            return $this->respond([
                'result' => $decoded['result'],
                'message' => $decoded['message'],
            ])->setStatusCode(401);
        }

        if ($this->request->getVar("ctgr_id")) {
            if ($this->request->getVar("ctgr_id") == '') {
                return $this->respond([
                    'status' => 400,
                    'error' => true,
                    'messages' => [
                        'error' => 'Category ID is empty'
                    ]
                ], 400);
            } else {
                $data['ctgr_id'] = $this->request->getVar('ctgr_id');
            }
        }

        if ($this->request->getVar("sub_ctgr_id")) {
            if ($this->request->getVar("sub_ctgr_id") == '') {
                return $this->respond([
                    'status' => 400,
                    'error' => true,
                    'messages' => [
                        'error' => 'Sub Category ID is empty'
                    ]
                ], 400);
            } else {
                $data['sub_ctgr_id'] = $this->request->getVar('sub_ctgr_id');
            }
        }

        if ($this->request->getVar("crtr_id")) {
            if ($this->request->getVar("crtr_id") == '') {
                return $this->respond([
                    'status' => 400,
                    'error' => true,
                    'messages' => [
                        'error' => 'Criteria ID is empty'
                    ]
                ], 400);
            } else {
                $data['crtr_id'] = $this->request->getVar('crtr_id');
            }
        }

        if ($this->request->getVar("status")) {
            $data['status'] = $this->request->getVar("status");
        }
        
        if ($this->request->getVar("notes")) {
            $data['notes'] = $this->request->getVar("notes");
        }

        $SubCategory = new $this->modelName();
        $SubCategory->update($id, $data);

        return $this->respond(['message' => 'Criteria Mapping Updated successfully'],200);
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     *
     * @return ResponseInterface
     */
    public function disable()
    {
        $decoded = $this->verifyHeader();
        if (!$decoded['result']) {
            return $this->respond([
                'result' => $decoded['result'],
                'message' => $decoded['message'],
            ])->setStatusCode(401);
        }
        
        if (!$this->request->getVar("id")) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'required ID'
                ]
            ], 400);
        }

        if ($this->request->getVar("id") == '') {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'ID is empty'
                ]
            ], 400);
        }
        $id = $this->request->getVar("id");
        
        $data['status'] = 'N';
        
        $criteriaMapping = new $this->modelName();
        $criteriaMapping->update($id, $data);

        return $this->respond(['message' => 'Criteria Mapping disabled successfully'],200);
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
