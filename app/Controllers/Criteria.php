<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Criteria extends ResourceController
{
    protected $modelName = 'App\Models\CriteriaModel';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function get_criteria()
    {
        $decoded = $this->verifyHeader();
        if (!$decoded['result']) {
            return $this->respond([
                'result' => $decoded['result'],
                'message' => $decoded['message'],
            ])->setStatusCode(401);
        }
        
        $criteria = new $this->modelName();
        $data = [
            'result'=> true,
            'data' => $criteria->where('status','Y')->findAll()
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

        if (!$this->request->getVar("crtr_name")) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'required Criteria Name'
                ]
            ], 400);
        }

        if ($this->request->getVar("crtr_name") == '') {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Criteria Name is empty'
                ]
            ], 400);
        }

        $data = [
            'crtr_name' => strtoupper($this->request->getVar('crtr_name')),
            'status' => 'Y'
        ];
        $criteria = new $this->modelName();
        $criteria->insert($data);

        return $this->respondCreated(['message' => 'Criteria created successfully']);
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

        if (!$this->request->getVar("crtr_name")) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'required Criteria Name'
                ]
            ], 400);
        }

        if ($this->request->getVar("crtr_name") == '') {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Criteria Name is empty'
                ]
            ], 400);
        }

        $data['crtr_name'] = $this->request->getVar('crtr_name');

        if ($this->request->getVar("status")) {
            $data['status'] = $this->request->getVar("status");
        }
        
        $criteria = new $this->modelName();
        $criteria->update($id, $data);

        return $this->respond(['message' => 'Criteria Updated successfully'],200);
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
        
        $criteria = new $this->modelName();
        $criteria->update($id, $data);

        return $this->respond(['message' => 'Criteria disabled successfully'],200);
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
