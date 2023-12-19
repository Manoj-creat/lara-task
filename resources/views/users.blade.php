<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laravel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://malsup.github.io/jquery.form.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="container">
    <h2 class="text-center">User</h2>
    <form id="yourForm" enctype="multipart/form-data" action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="name" placeholder="Enter Name"
                   Value="{{old('name')}}" require>
            <span style="text:red;">@error('name'){{message}}@enderror</span>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="email" placeholder="Enter Email"
                   Value="{{old('email')}}" require>
            <span style="text:red;">@error('email'){{message}}@enderror</span>
        </div>
        <div class="form-group">
            <label for="phoneNo">Phone</label>
            <input type="text" class="form-control" id="phoneNo" name="phoneNo" aria-describedby="phoneNo" placeholder="Enter Phone Number"
                   Value="{{old('phoneNo')}}" require>
            <span style="text:red;">@error('phoneNo'){{message}}@enderror</span>
        </div>
        <div class="form-group">
            <label for="phoneNo">Select Image</label>
            <input type="file" class="form-control" id="image" name="image" Value="">
        </div>
        <div class="form-group">
            <label for="textarea1">Description</label>
            <textarea class="form-control" id="textarea1" name="textarea1" value="{{old('textarea1')}}" rows="3"></textarea>
        </div>

        <div class="form-group">
            <select id="role" class="form-control" name="role" require>
                <option value="">Select Role</option>
                <option value="1">Admin</option>
                <option value="2">Manager</option>
                <option value="3">Developer</option>
            </select>
        </div>
        <button class="btn btn-primary submit" type="submit" id="on-submit">Save</button>
    </form>
</div>

<table class="table table-bordered data-table">
    <thead>
    <tr>
        <th>No</th>
        <th>Title</th>
        <th>Description</th>
        <th>Image</th>
        <th width="280px">Action</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</body>
</html>

<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'imageUrl', name: 'imageUrl'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        console.log('tablee::',table);

        $("body").on("click", ".submit", function (e) {
            $(this).parents("form").ajaxForm(options);
        });
        var options = {
            complete: function (response) {
                console.log('response:::',response);
                if ($.isEmptyObject(response.status == 200)) {
                    console.log('Image Upload Successfully.');
                    $("#yourForm")[0].reset(); // Using [0] to access the actual DOM form element
                    table.ajax.reload(); // This will re-fetch and redraw the table with updated data
                } else {
                    printErrorMsg(response);
                }
            }
        };

        function printErrorMsg(msg) {
            console.log('msggg::', msg);
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function (key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }
    });
</script>
