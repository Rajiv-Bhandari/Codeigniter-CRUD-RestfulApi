<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ItemModel;

class ItemController extends BaseController
{
    use ResponseTrait;

    protected $itemModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
    }

    // Create a new item
    public function create()
    {
        $data = $this->request->getJSON();
        $insertedId = $this->itemModel->insert($data);
        return $this->respondCreated(['id' => $insertedId]);
    }

    // Get all items
    public function index()
    {
        $items = $this->itemModel->findAll();
        return $this->respond($items);
    }

    // Get a single item by ID
    public function show($id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            return $this->failNotFound('Item not found');
        }
        return $this->respond($item);
    }

    // Update an item by ID
    public function update($id)
    {
        $data = $this->request->getJSON();
        $item = $this->itemModel->find($id);
        if (!$item) {
            return $this->failNotFound('Item not found');
        }
        $this->itemModel->update($id, $data);
        return $this->respondUpdated(['id' => $id]);
    }

    // Delete an item by ID
    public function delete($id)
    {
        $item = $this->itemModel->find($id);
        if (!$item) {
            return $this->failNotFound('Item not found');
        }
        $this->itemModel->delete($id);
        return $this->respondDeleted(['id' => $id]);
    }
}
