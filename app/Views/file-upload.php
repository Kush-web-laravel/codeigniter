<?php if (session()->getFlashdata('success')): ?>
    <p style="color: green;"><?= session()->getFlashdata('success'); ?></p>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <p style="color: red;"><?= session()->getFlashdata('error'); ?></p>
<?php endif; ?>
<form action = "<?= site_url('my-file') ?>" method="POST" enctype="multipart/form-data">
    <p>File Upload : <input type="file" name="file"></p>
    <p><button type="submit">Submit</button></p>
</form>