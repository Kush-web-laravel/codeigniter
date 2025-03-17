

<form action="<?= site_url('my-form-data') ?>" method="POST">
    <p>
        Name: <input type="text" name="name" />
        <?php 
            if(isset($validation)){
                if($validation->hasError('name')){
                    echo $validation->getError("name");
                }
            }
        ?>
    </p>
    <p>
        Email: <input type="email" name="email" />
        <?php 
            if(isset($validation)){
                if($validation->hasError('email')){
                    echo $validation->getError("email");
                }
            }
        ?>
    </p>
    <p>
        Mobile: <input type="text" name="mobile" />
        <?php 
            if(isset($validation)){
                if($validation->hasError('mobile')){
                    echo $validation->getError("mobile");
                }
            }
        ?>
    </p>
    <p>
       <input type="submit" value="Submit" />
    </p>
</form>