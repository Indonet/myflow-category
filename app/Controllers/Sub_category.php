<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Sub_category extends ResourceController
{
    protected $categoryModelName = 'App\Models\CategoryModel';
    protected $modelName = 'App\Models\SubCategoryModel';
    protected $format = 'json';
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $decoded = $this->verifyHeader();
        if (!$decoded['result']) {
            return $this->respond([
                'result' => $decoded['result'],
                'message' => $decoded['message'],
            ])->setStatusCode(401);
        }
        
        $ctgrId = $this->request->getVar("ctgr_id");
        if (!$ctgrId) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'required Category ID'
                ]
            ], 400);
        }

        if ($ctgrId == '') {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Category ID is empty'
                ]
            ], 400);
        }

        $subCategory = new $this->modelName();
        $subCtgrData = $subCategory
                    ->where('ctgr_id',$ctgrId)
                    ->where('status','Y')->findAll();
        $data = [
            'result'=> true,
            'data' => $subCtgrData
        ];

        return $this->respond($data,200);
    }

    /*get all sub category By category ID */
    public function get_sub_category() {
        $decoded = $this->verifyHeader();
        if (!$decoded['result']) {
            return $this->respond([
                'result' => $decoded['result'],
                'message' => $decoded['message'],
            ])->setStatusCode(401);
        }

        $ctgrId = $this->request->getVar("ctgr_id");
        if (!$ctgrId) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'required Category ID'
                ]
            ], 400);
        }

        if ($ctgrId == '') {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Category ID is empty'
                ]
            ], 400);
        }

        $subCategory = new $this->modelName();
        $subCtgrData = $subCategory->where('ctgr_id',$ctgrId)->findAll();
        $data = [
            'result'=> true,
            'data' => $subCtgrData
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
        $category = new $this->categoryModelName();
        $categoryData = $category->where(['id'=>strtolower($this->request->getVar('ctgr_id'))])
                                            ->findAll();
        
        if (sizeof($categoryData) == 0) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Category is not Exist'
                ]
            ], 400);
        }

        if (!$this->request->getVar("sub_ctgr_name")) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'required Sub Category Name'
                ]
            ], 400);
        }

        if ($this->request->getVar("sub_ctgr_name") == '') {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'Sub Category Name is empty'
                ]
            ], 400);
        }

        $data = [
            'ctgr_id' => $this->request->getVar('ctgr_id'),
            'sub_ctgr_name' => strtoupper($this->request->getVar('sub_ctgr_name')),
            'status' => 'Y',
            'notes' => $this->request->getVar('notes'),
        ];
        $subCategory = new $this->modelName();
        $subCategory->insert($data);

        return $this->respondCreated(['message' => 'Sub Category created successfully']);
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

        $data['ctgr_id'] = $this->request->getVar('ctgr_id');

        if ($this->request->getVar("sub_ctgr_name")) {
            $data['sub_ctgr_name'] = strtoupper($this->request->getVar('sub_ctgr_name'));
        }

        if ($this->request->getVar("status")) {
            $data['status'] = $this->request->getVar("status");
        }
        
        if ($this->request->getVar("notes")) {
            $data['notes'] = $this->request->getVar("notes");
        }

        $SubCategory = new $this->modelName();
        $SubCategory->update($id, $data);

        return $this->respond(['message' => 'Sub Category Updated successfully'],200);
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
        
        if (!$id) {
            return $this->respond([
                'status' => 400,
                'error' => true,
                'messages' => [
                    'error' => 'required ID'
                ]
            ], 400);
        }

        $subCategory = new $this->modelName();
        $subCtgrData = $subCategory
                    ->where('id',$id)
                    ->where('status','Y')->findAll();
        $data = [
            'result'=> true,
            'data' => $subCtgrData
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
        
        $category = new $this->modelName();
        $category->update($id, $data);

        return $this->respond(['message' => 'Sub Category disabled successfully'],200);
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
