<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class BookController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */

    protected $modelName = "App\Models\BookModel";
    protected $format = "json";

    public function createBook()
    {
        $validationRules = [
            "name" => [
                "rules" => "required"
            ],
            "cost" => [
                "rules" => "required"
            ]
        ];

        if(!$this->validate($validationRules)){
            return $this->respond([
                'status' => false,
                'message' => "Please provide the required fields.",
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $tokenInformation = $this->request->userData;
        $userId = $tokenInformation['user']->id;
        $bookData = [
            'author_id' => $userId,
            'name' => $this->request->getVar('name'),
            'publication' => $this->request->getVar('publication'),
            'cost' => $this->request->getVar('cost')
        ];

        if($this->model->save($bookData)){
            return $this->respond([
                'status' => true,
                'message' => "Book created successfully"
            ]);
        }else{
            return $this->respond([
                'status' => false,
                'message' => "Failed to create book"
            ]);
        }
    }

    public function authorBooks()
    {
        $tokenInformation = $this->request->userData;
        $userId = $tokenInformation['user']->id;

        $books = $this->model->where('author_id', $userId)->findAll();

        if($books){
            return $this->respond([
                'status' => true,
                'message' => "Books found..",
                'books' => $books
            ]);
        }else{
            return $this->respond([
                'status' => false,
                'message' => "No Books found for this author..",
            ]);
        }
        
    }

    public function deleteAuthorBook($id)
    {
        $tokenInformation = $this->request->userData;
        $authorId = $tokenInformation['user']->id;

        $book = $this->model->where(array(
            'id' => $id,
            'author_id' => $authorId
        ))->first();

        if($book){
            if($this->model->delete($id)){
               return $this->respond([
                    'status' => true,
                    'message' => 'Book deleted successfully.'
                ]);
            }else{
                return $this->respond([
                    'status' => false,
                    'message' => 'Failed to delete book.'
                ]);
            }
        }else{
            return $this->respond([
                'status' => false,
                'message' => 'Book not found.'
            ]);
        }

    }

}
