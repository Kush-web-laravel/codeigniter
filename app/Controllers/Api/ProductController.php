<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use SebastianBergmann\Type\TrueType;

class ProductController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */

    protected $modelName = "App\Models\ProductModel";
    protected $format = "json"; 
    public function index()
    {
        //
        $products = $this->model->findAll();

        return $this->respond([
            'status' => true,
            'message' => "Products found.",
            'products' => $products,
        ]);
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
        $product = $this->model->find($id);

        if($product){
            return $this->respond([
                'status' => true,
                'message' => "Product details found.",
                'data' => $product
            ]);
        }else{
            return $this->respond([
                'status' => false,
                'message' => "Product not found",
            ]);
        }
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
        //
        $validateionRules = [
            "title" => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => "Product title is required",
                    'min_length' => "Title must be greater than 3 characters"
                ]
            ],
            "cost" => [
                'rules' => 'required|integer|greater_than[0]',
                'errors' => [
                    "required" => "Please provide product cost",
                    "integer" => "Cost must be an integer value",
                    "greater_than" => "Cost must be greater than zero(0) value"
                ]
            ]

        ];

        if(!$this->validate($validateionRules)){
            return $this->fail($this->validator->getErrors());
        }

        $imageFile = $this->request->getFile("image");
        $productImageUrl = "";

        if($imageFile){
            $newProductImageName = $imageFile->getRandomName();

            $imageFile->move(FCPATH . "uploads/" . $newProductImageName);
            $productImageUrl = "uploads/" . $newProductImageName;
        }

        $data =  $this->request->getPost();

        $title = $data['title'];
        $cost = $data['cost'];
        $description = isset($data['description']) ? $data['description'] : "";

       if($this->model->insert([
            'title' => $title,
            'cost' => $cost,
            'description' => $description,
            'image' => $productImageUrl,
        ])){
            return $this->respond([
                'status' => true,
                'message' => "Product added successfully."
            ]);
        }else{
            return $this->respond([
                'status' => false,
                'message' => "Failed to add product"
            ]);
        }
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
        //
        $product = $this->model->find($id);
        
        if($product){
            $updated_data = json_decode(file_get_contents("php://input"), true);

            $product_title = isset($updated_data['title']) && !empty($updated_data['title']) ? $updated_data['title'] : $product['title'];
            $product_cost = isset($updated_data['cost']) && !empty($updated_data['cost']) ? $updated_data['cost'] : $product['cost'];
            $product_description = isset($updated_data['description']) && !empty($updated_data['description']) ? $updated_data['description'] : $product['description'];
        
            if($this->model->update($id, [
                'title' => $product_title,
                'cost' => $product_cost,
                'description' => $product_description
            ])){
                $product_data = $this->model->find($id); 
                return $this->respond([
                    'status' => true,
                    'message' => "Product data updated successfully.",
                    'data' => $product_data
                ]);
            }else{
                return $this->respond([
                    'status' => false,
                    'message' => "Failed to update product details."
                ]);
            }
        }else{
            return $this->respond([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }
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
        $product = $this->model->find($id);

        if($product){
            if($this->model->delete($id)){
                return $this->respond([
                    'status' => true,
                    'message' => 'Product deleted successfully.'
                ]);
            }else{
                return $this->respond([
                    'status' => false,
                    'message' => 'Failed to delete product.'
                ]);
            }
        }else{
            return $this->respond([
                'status' => false,
                'message' => 'Product not found.'
            ]);
        }
    }
}
