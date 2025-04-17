<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Category extends ResourceController
{
    protected $modelName = 'App\Models\CategoryModel';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function get_category()
    {
        $decoded = $this->verifyHeader();
        if (!$decoded['result']) {
            return $this->respond([
                'result' => $decoded['result'],
                'message' => $decoded['message'],
            ])->setStatusCode(401);
        }
        $cmpyId = 1;
        if (!$this->request->getVar("cmpy_name")) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Company Name is empty'
                ]
            ], 400);
        }
        
        if ($this->request->getVar("cmpy_name")) {
            $cmpyName = $this->request->getVar("cmpy_name");
        }

        $category = new $this->modelName();
        $data = [
            'result'=> true,
            'data' => $category
                    ->where('status','Y')
                    ->where('cmpy_name',$cmpyName)->findAll()
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

        if (!$this->request->getVar("ctgr_name")) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'required Category Name'
                ]
            ], 400);
        }

        if ($this->request->getVar("ctgr_name") == '') {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Category Name is empty'
                ]
            ], 400);
        }

        if (!$this->request->getVar("cmpy_name")) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'required Company Name'
                ]
            ], 400);
        }

        if ($this->request->getVar("cmpy_name") == '') {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Company Name is empty'
                ]
            ], 400);
        }
        $category = new $this->modelName();
        //checkData
        $categoryData = $category->where(['LOWER(ctgr_name)'=>strtolower($this->request->getVar('ctgr_name')),
                                            'LOWER(cmpy_name)'=>strtolower($this->request->getVar('cmpy_name'))])
                                            ->findAll();
        
        if (sizeof($categoryData) > 0) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Category in company already Exist'
                ]
            ], 400);
        }

        $data = [
            'ctgr_name' => strtoupper($this->request->getVar('ctgr_name')),
            'status' => 'Y',
            'cmpy_name' => strtolower($this->request->getVar('cmpy_name')),
            'notes' => $this->request->getVar('notes'),
        ];
        
        $category->insert($data);

        return $this->respondCreated(['message' => 'Category created successfully']);
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

        if (!$this->request->getVar("ctgr_name")) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Category Name is empty'
                ]
            ], 400);
        }

        if ($this->request->getVar("ctgr_name") == '') {
            return $this->respond(array('message'=>"Category Name is empty"));
        }

        $data['ctgr_name'] = $this->request->getVar('ctgr_name');

        if ($this->request->getVar("cmpy_name")) {
            $data['cmpy_name'] = strtolower($this->request->getVar('cmpy_name'));
        }

        if ($this->request->getVar("status")) {
            $data['status'] = $this->request->getVar("status");
        }
        
        if ($this->request->getVar("notes")) {
            $data['notes'] = $this->request->getVar("notes");
        }

        $category = new $this->modelName();
        $category->update($id, $data);

        return $this->respond(['message' => 'Category Updated successfully'],200);
    }

    public function detail($id)
    {
        $decoded = $this->verifyHeader();
        if (!$decoded['result']) {
            return $this->respond([
                'result' => $decoded['result'],
                'message' => $decoded['message'],
            ])->setStatusCode(401);
        }
        $cmpyId = 1;
        if (!$id) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'ID is empty'
                ]
            ], 400);
        }
        
        $category = new $this->modelName();
        $data = [
            'result'=> true,
            'data' => $category
                    ->where('status','Y')
                    ->where('id',$id)->findAll()
        ];

        return $this->respond($data,200);
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

        if ($this->request->getVar("id") == '' || $this->request->getVar("id") == 0) {
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
        
        $category = new $this->modelName();
        $category->update($id, $data);

        return $this->respond(['message' => 'Category disabled successfully'],200);
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
