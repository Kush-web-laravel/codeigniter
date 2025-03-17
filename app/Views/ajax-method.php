<button type="button" id="btn-click">Click me</button>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '#btn-click', function(){
            $.ajax({
                url : '<?= site_url('handle-myajax') ?>',
                type : 'POST',
                data : {
                    name: "Kush Chhatbar",
                    email : "abc@gmail.com"
                },
                dataType: "JSON",
                success: function(response){
                    console.log(response);
                }
            })
        });
    });
</script>