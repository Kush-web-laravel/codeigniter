<!-- <?= form_open("site/myForm", "class='my-form', id='my-form'") ?>

<?php 

    $name_attributes = [
        'name' => 'txt_name',
        'value' => 'Kush',
        'placeholder' => 'Enter name',
        'class' => 'my-name',
        'id' => 'my-name'
    ];

    $textarea_attributes = [
        'name' => 'txt_address',
        'placeholder' => 'Enter address',
        'class' => 'my-addr',
        'id' => 'my-addr',
    ];
?>

<?= form_input($name_attributes); ?>

<?= form_textarea($textarea_attributes); ?>

<?= form_button('btn_submit', 'Submit'); ?>

<?= form_close() ?> -->
<?php

    if(session()->get('success')){
        ?>
        <p><?php echo session()->get('success'); ?></p>
        <?php
        
    }
    if(session()->get('error')){
        ?>
        <p><?php echo session()->get('error'); ?></p>
        <?php
    }
   
?>
<form action="<?php echo site_url('my-form') ?>" method="post" class="my-form" id="my-form">
    <p>
        Name : <input type="text" name="txt_name" class="my-name" id="my-name" placeholder="Enter name" />
    </p>
    <p>
        Email : <input type="email" name="txt_email" class="my-email" id="my-email" placeholder="Enter email" />
    </p>
    <p>
        Phone Number : <input type="text" name="txt_phone_no" class="my-phone-no" id="my-phone-no" placeholder="Enter Phone Number" />
    </p>
    <p>
        <input type="submit" name="btn_submit" value="Submit" />
    </p>
</form>