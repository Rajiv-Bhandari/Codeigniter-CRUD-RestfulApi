<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Names - RestAPI</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Fetching Data From Rest API</h2>
        </div>
        <div class="col-md-6 text-right">
            <button type="button" class="btn btn-success" style="margin-top:20px;" data-toggle="modal" data-target="#userModal">Create</button>
        </div>
    </div>
    <hr>
    <span id="success-message"></span>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">First Name</th>
                <th class="text-center">Last Name</th>
                <th class="text-center">Edit</th>
                <th class="text-center">Delete</th>
            </tr>
        </thead>
        <tbody>
 
        </tbody>
    </table>
</div>

<!-- Create Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="user_form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="createModalLabel">Create User</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name">
                            <span id="first_name_error" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name">
                            <span id="last_name_error" class="text-danger"></span>
                        </div>
                
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" id="user_id">
                    <input type="hidden" name="data_action" id="data_action" value="Insert">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="action" name="action">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
    function fetch_data() {
        $.ajax({
            url: "<?php echo base_url(); ?>test_api/action",
            method: "POST",
            data: { data_action: 'fetch_all' },
            success: function(data) {
                $('tbody').html(data);
            }
        });
    }
    // for loading users data
    $(document).ready(function(){
        // function fetch_data()
        // {
        //     $.ajax({
                
        //         url: "<?php echo base_url(); ?>test_api/action",
        //         method:"POST",
        //         data: {data_action: 'fetch_all'},
        //         success: function(data){
        //             $('tbody').html(data);
        //         }
        //     });
        // }
        fetch_data();
    });

    // for creating the user
    $(document).on('submit','#user_form', function(event){
        event.preventDefault();

        $.ajax({
            url: "<?php echo base_url(); ?>test_api/action",
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(data)
            {
                console.log(data)
                if(data.success)
                {
                    $('#user_form')[0].reset();
                    $('#userModal').modal('hide');
                    fetch_data();
                    if($('#data_action').val() == "Insert")
                    {
                        $('#success-message').html('<div class="alert alert-success">Data Inserted</div>');
                    }
                }
                if(data.error)
                {
                    $('#first_name_error').html(data.first_name_error);
                    $('#last_name_error').html(data.last_name_error);
                }
            }
        });
    });

    // for editing user
    $(document).on('click', '.edit' , function(){
        var user_id = $(this).attr('id');
        console.log(user_id)
       
        $.ajax({
            url: "<?php echo base_url(); ?>test_api/action",
            method:"POST",
            data: {user_id:user_id, data_action:'fetch_single'},
            dataType: 'json',
            success:function(data)
            {
                $('#userModal').modal('show');
                $('#first_name').val(data.first_name);
                $('#last_name').val(data.last_name);
                $('#createModalLabel').text('Edit User');
                $('#user_id').val(user_id);
                // $('#action').val('Update');
                $('#data_action').val('Edit');
            }
        });
    });
</script>

</body>
</html>
