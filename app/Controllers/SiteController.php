<?php

namespace App\Controllers;
use App\Models\UserModel;

class SiteController extends BaseController{

    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function welcomeCountryMessage()
    {
        echo "<h1>Welcome user to This page</h1>";
    }

    public function handleAjaxRequest()
    {
        $data = $this->request->getVar();
        
        echo json_encode(array(
            'status' => 1,
            'message' => "Successful request",
            'data' => $data
        ));
    }


    public function ajaxMethod()
    {
        return view('ajax-method');
    }

    public function myFormData()
    {
        if($this->request->getMethod() === 'POST'){
            // print_r($this->request->getVar());
            $rules = [
                'name' => 'required|min_length[5]|max_length[10]',
                'email' => 'required',
                'mobile' => 'required'
            ];

            $messages=[
                'name' => [
                    'required' => 'Name is needed',
                    'min_length' => 'We need atleast 5 characters'
                ],
                'email' => [
                    'required' => 'Email is needed'
                ]
                ];

            $validation = \Config\Services::validation();

            if(!$this->validate($rules, $messages)){
                return view('my-form-data', [
                    'validation' => $this->validator
                ]);
            }else{
                print_r($this->request->getVar());
            }
            return view('my-form-data');
        }
        
    }

    public function fileUpload()
    {
        if (strtoupper($this->request->getMethod() === 'POST')) {
            $file = $this->request->getFile('file');
    
            // ✅ Check if a file was actually uploaded
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName(); // Generate a unique name
    
                if (!is_dir('images')) {
                    mkdir('images', 0777, true); // Ensure directory exists
                }
    
                if ($file->move('images', $newName)) {
                    session()->setFlashdata('success', 'File has been uploaded successfully.');
                } else {
                    session()->setFlashdata('error', 'Error while moving the file.');
                }
            } else {
                session()->setFlashdata('error', 'No file selected or invalid file.');
            }
        }
    
        return view('file-upload');
    }
    

    public function userSession()
    {
        $session = \Config\Services::session();
        // $session->set('username', 'Kush Chhatbar');

        // echo $session->get('username');
        // $session->remove('username');

        // $session->set('userdata', array(
        //     'id' => 1,
        //     'name' => 'Jack Reacher',
        //     'email' => 'jack@gmail.com',
        // ));

        // $session->push('userdata', array(
        //     'post' => 'Ex-military major',
        // ));

        $userData = $session->get('userdata');
        echo "<pre>";
        print_r($userData);

        $session->destroy();
    }

    public function getUserData()
    {
        $user =  new UserModel();
        // $data = $user->findAll();

        // echo"<pre>";
        // print_r($data);

        return view('user-data', [
            'users' => $user->paginate(3),
            'pager' => $user->pager,
        ]);
    }

    public function listCall(){
        print_my_message("CodeIgniter first app");
        echo"<br><br>";
        $string = "CodeIginter first app";
        $length = find_my_length($string);
        echo "Length: ". $length;
        echo"<br><br>";
        get_users();
    }


    public function myForm()
    {
        if (strtolower($this->request->getMethod()) === 'post'){
            $data = $this->request->getVar();

            $userModel = new UserModel();

            $form_data = [
                'name' => $data['txt_name'],
                'email' => $data['txt_email'],
                'phone_no' => $data['txt_phone_no']
            ];

            $session = session();

            if($userModel->insert($form_data)){
                $session->setFlashdata('success', 'Form data has been saved successfully');
            }else{
                $session->setFlashdata('error', 'Failed to save data');
            }

            return redirect()->to(site_url('my-form'));
        }
        return view("/site/myForm");
    }

    public function getData4()
    {
        $user = new UserModel();

        //find all data

        // $data = $user->findAll();
        // $data = $user->where('id', 2)->first();
        // $data = $user->select('name, email')->where('id', 2)->first();
        // $data = $user->select('id,name, email')->orderBy('id', 'desc')->findAll(); //Also known as method chaining.
        $data = $user->select('id,name, email')->whereIn('id', array(1,2,3,4,5))->orderBy('id', 'desc')->findAll();
        echo "<pre>";

        print_r($data);
    }

    public function updateData3()
    {
        $user = new UserModel();

        $updated_data = array(
            'name' => 'lioness', 
            'email' => 'lioness@gmail.com',
            'phone_no' => '7777999966'
        );

        $update_id = 8;

        // $return_updated_data = $user->where([
        //     'id' => $update_id
        // ])->set($updated_data)->update();

        $return_updated_data = $user->update($updated_data,[
            'id' => $update_id
        ]);

        echo "<pre>";
        print_r($return_updated_data);
    }

    public function insertData3()
    {
        $user = new UserModel();

        //create some data

        $data = array(
            array(
                'name' => 'Tiger',
                'email' => 'tiger@gmail.com',
                'phone_no' => '55656565456'
            ),
            array(
                'name' => 'leopard',
                'email' => 'leopard@gmail.com',
                'phone_no' => '55652265656'
            ),
            array(
                'name' => 'heyna',
                'email' => 'heyna@gmail.com',
                'phone_no' => '52216565656'
            )
        );

        //insert data
        $return_data = $user->insertBatch($data);
        echo "<pre>";
        print_r($return_data);
    }

    public function getData3()
    {
        $user = new UserModel();
        $data = $user->findAll();

        echo "<pre>";
        print_r($data);

    }

    public function updateData2()
    {
        $builder = $this->db->table('tbi_users');
    
        $data = [
            [
                'id'       => 5,
                'name'     => 'Kush J Chhatbar',
                'email'    => 'kush.j.chhatbar@gmail.com',
                'phone_no' => '8780324352'
            ],
            [
                'id'       => 6,  // Make sure this ID exists
                'name'     => 'Abc J Chhatbar',
                'email'    => 'aba.j.chhatbar@gmail.com',
                'phone_no' => '8740324352'
            ]
        ];
    
        $builder->updateBatch($data, 'id'); // 'id' is the unique column used for updating
    
        echo "Updated successfully";
    }
    

    public function insertData2()
    {
        $builder = $this->db->table('tbi_users');
        $data = [
            [
                'name' => 'aca',
                'email' => 'aaacc@gmail.com',
                'phone_no' => '7788888888'
            ],
            [
                'name' => 'ada',
                'email' => 'adfa@gmail.com',
                'phone_no' => '8884488888'
            ],
            [
                'name' => 'daa',
                'email' => 'fda@gmail.com',
                'phone_no' => '8800888888'
            ],
        ];

        print_r($builder->insertBatch($data));
    }

    public function getData2()
    {
        // $builder = $this->db->table("tbi_users");
        // $data = $builder->get()->getResultArray();
        $builder = $this->db->table("tbi_users")->where(array('id' => 1 , 'email' => 'aabbaa@gmail.com'));
        // $data = $builder->get()->getResult('array');
        $data = $builder->get()->getRowArray();
        echo $this->db->getLastQuery();
        echo"<pre>";
        print_r($data);
    }

    //Insert data using raw query

    public function insertRaw()
    {
        $insert_query = "INSERT INTO tbi_users(name, email, phone_no) values('Kush', 'abc@gmail.com', '9999999999')";

        if($this->db->query($insert_query)){
            echo "<h3>Values has been inserted</h3>";
        }else{
            echo "<h3>Failed to insert value.</h3>";
        }
    }

    public function updateRawQuery()
    {
        $query = "UPDATE tbi_users SET name= 'Kush Chhatbar', email='aabbaa@gmail.com', phone_no='9999988888' WHERE id = 1";

        if($this->db->query($query)){
            echo "<h3>Values has been updated</h3>";
        }else{
            echo "<h3>Failed to update value.</h3>";
        }
    }


    public function getData()
    {
        // $data = $this->db->query('SELECT * FROM tbi_users')->getResult('array');
        $data = $this->db->query('SELECT * FROM tbi_users')->getResultArray();
        // $data = $this->db->query('SELECT * FROM tbi_users WHERE name="Kush"')->getRowArray();
        echo "<pre>";
        print_r($data);
    }

    public function simple()
    {
        return view('/site/simple');
    }

    public function aboutUs()
    {
        return view('/site/aboutUs');
    }

    public function contactUs()
    {
        return view('/site/contactUs');
    }

    public function callMe($value1 = null, $value2 = null)
    {
        echo "<h3>Welcome to the callMe funtion ". $value1 ." & ". $value2 ."</h3>";
    }
}