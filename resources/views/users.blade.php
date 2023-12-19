<!DOCTYPE html>
<html lang="en">
<head>
  <title>Laravel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://malsup.github.io/jquery.form.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="container">
  <h2 class="text-center">User</h2>
  <form id="yourForm" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name = "name" aria-describedby="name" placeholder="Enter Name" Value = "{{old('name')}}"require>
        <span style= "text:red;">@error('name'){{message}}@enderror</span>
    </div>
        <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name = "email"aria-describedby="email" placeholder="Enter Email" Value = "{{old('email')}}"require>
        <span style= "text:red;">@error('email'){{message}}@enderror</span>
    </div>
    <div class="form-group">
    <label for="phoneNo">Phone</label>
        <input type="text" class="form-control" id="phoneNo" name= "phoneNo" aria-describedby="phoneNo" placeholder="Enter Phone Number" Value = "{{old('phoneNo')}}"require>
        <span style= "text:red;">@error('phoneNo'){{message}}@enderror</span>
    </div>
    <div class="form-group">
    <label for="phoneNo">Select Image</label>
        <input type="file" class="form-control" id="image" name= "image" Value = "">
    </div>
    <div class="form-group">
        <label for="textarea1">Description</label>
        <textarea class="form-control" id="textarea1"  name ="textarea1" value ="{{old('textarea1')}}" rows="3"></textarea>
    </div>
    
    <div class="form-group">
        <select id="role" class="form-control"name="role"require>
            <option value="">Select Role</option>
            <option value="1">Admin</option>
            <option value="2">Manager</option>
            <option value="3">Developer</option>
        </select>
    </div>
    <button class="btn btn-primary"type="button" onclick="saveData()">Save</button>

   

</form>
 <!-- Display Section -->
 <div id="displayData">
        <!-- Display the saved data here -->
    </div>
</div>

<table class = "table table-striped"id="myTable" border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Photo</th>
            <th>Discription</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody id="tableBody">
        <!-- Table body content will be dynamically added here -->
    </tbody>
</table>
</body>
</html>

<script type="text/javascript">
    function saveData() {
            var formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('phoneNo', document.getElementById('phoneNo').value);
            formData.append('textarea1', document.getElementById('textarea1').value);
            formData.append('role', document.getElementById('role').value);
            formData.append('image', document.getElementById('image').files[0]);

            var csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
            // Send a POST request to save data
            for (var pair of formData.entries()) {
                // console.log(pair[0] + ', ' + pair[1]);
                var formDetail = pair[0] + ', ' + pair[1];
                console.log("f",formDetail);
            }
            // var requestOptions = {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': csrfToken
            //     },
            //     body: formData
            // };
            // console.log('data====>',requestOptions);
            fetch('/saveData', {
                method: 'POST',
                 headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Display the saved data
                document.getElementById('displayData').innerHTML = data.message;
            })
            .catch(error => {
                alert(error);
                console.error('Error:', error);
            });
        }
</script>
