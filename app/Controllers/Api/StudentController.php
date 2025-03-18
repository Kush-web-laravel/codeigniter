<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\StudentModel;

class StudentController extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    protected $modelName = "App\Models\StudentModel";
    protected $format = "json";

    public function index()
    {
        //
        $students = $this->model->findAll();
        return $this->respond([
            'status' => true,
            'message' => 'Students Data',
            'data' => $students
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
        $student_data = $this->model->find($id);

        if(!empty($student_data)){
            return $this->respond([
                'status' => true,
                'message' => "Student data",
                'data' => $student_data
            ]);
        }else{
            return $this->respond([
                'status' => false,
                'message' => "Student data with the provided id does not exist."
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
        $data = $this->request->getPost();

        $name = isset($data['name']) ? $data['name'] : "";
        $email = isset($data['email']) ? $data['email'] : "";
        $gender = isset($data['gender']) ? $data['gender'] : "";
        $phone_no = isset($data['phone_no']) ? $data['phone_no'] : "";

        if(empty($name) || empty($email)){
            return $this->respond([
                'status' => false,
                'message' => 'Please provide the required fields (name, email)'
            ]);
        }

        $student_data = $this->checkStudentByEmail($email);
        $student_data_2 = $this->checkStudentByPhoneNumber($phone_no);
        
        if(!empty($student_data)){
            return $this->respond([
                'status' => false,
                'message' => 'Entered email already used. Please enter unique email address'
            ]);
        }

        if(!empty($student_data_2)){
            return $this->respond([
                'status' => false,
                'message' => 'Entered phone number already used. Please enter unique phone number'
            ]);
        }

        if($this->model->insert([
            'name' => $name,
            'email' => $email,
            'gender' => $gender,
            'phone_no' => $phone_no
        ])){
            return $this->respond([
                'status' => true,
                'message' => 'Student Details added successfully.'
            ]);
        }else{
            return $this->respond([
                'status' => false,
                'message' => 'Failed to add student details.'
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
        $student = $this->model->find($id);
        if(!empty($student)){
            $data = json_decode(file_get_contents('php://input'), true);

            $updated_data = [
                'name' => isset($data['name']) && !empty($data['name']) ? $data['name'] : $student['name'],
                'email' => isset($data['email']) && !empty($data['email']) ? $data['email'] : $student['email'],
                'phone_no' => isset($data['phone_no']) && !empty($data['phone_no']) ? $data['phone_no'] : $student['phone_no'],
                'gender' => isset($data['gender']) && !empty($data['gender']) ? $data['gender'] : $student['gender']
            ];

            if($this->model->update($id, $updated_data)){
                $updatedStudent = $this->model->find($id);
                return $this->respond([
                    'status' => true,
                    'message' => 'Student data updated successfully.',
                    'data' => $updatedStudent
                ]);
            }else{
                return $this->respond([
                    'status' => false,
                    'message' => 'Failed to update data',
                ]);
            }
            
        }else{
            return $this->respond([
                'status' => false,
                'message' => 'No record found with the provided value.'
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
        $student = $this->model->find($id);
        if(!empty($student)){
            if($this->model->delete($id)){
                return $this->respond([
                    'status' => true,
                    'message' => 'Student record deleted successfully'
                ]);
            }else{
                return $this->respond([
                    'status' => false,
                    'message' => 'Falied to delete record.'
                ]);
            }
        }else{
            return $this->respond([
                'status' => false,
                'message' => 'No record found with the provided detail.'
            ]);
        }
    }

    private function checkStudentByEmail($email){
        return $this->model->where('email', $email)->first();
    }

    private function checkStudentByPhoneNumber($phone_no){
        return $this->model->where('phone_no', $phone_no)->first();
    }
}
