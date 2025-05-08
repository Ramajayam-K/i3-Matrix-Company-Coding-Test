<x-app-layout>
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900 dark:text-gray-100">
                    <div class="header p-2">
                        <h2 class="text-2xl font-bold">Welcome back, <span id="userName" class="capitalize">{{Auth::user()->role}}</span>! 👋</h2>
                        <p class="text-lg mt-3">
                          We're thrilled to have you on board again. Your dashboard is all set to help you manage your account with ease.
                          From profile updates to user insights and quick access to key features, everything is just a few clicks away.
                          If you need help, feel free to reach out to our support team at any time.
                          Thanks for being part of our journey!
                        </p>
                    </div>
                    <div class="row p-3 w-100">
                        <div class="col-12 col-md-12 col-lg-3 mb-3">
                            <div class="flex items-center w-full justify-center mb-5 mt-2">
                                <div class="max-w-xs">
                                    <div class="bg-white shadow-xl rounded-lg py-3">
                                        <div class="photo-wrapper p-2">
                                            <img class="w-32 h-32 rounded-full mx-auto" src="/storage/{{Auth::user()->photo}}" alt="John Doe">
                                        </div>
                                        <div class="p-2">
                                            <h3 class="text-center text-xl text-gray-900 font-medium leading-8">{{Auth::user()->username}}</h3>
                                            <div class="text-center text-gray-400 text-sm font-semibold mt-1">
                                                <p class="text-uppercase">{{Auth::user()->role}}</p>
                                            </div>
                                            <table class="text-sm my-3">
                                                <tbody>
                                                    <tr>
                                                        <td class="px-2 py-2 text-gray-500 font-semibold">Gender</td>
                                                        <td class="px-2 py-2 capitalize">{{Auth::user()->gender}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-2 py-2 text-gray-500 font-semibold">Phone</td>
                                                        <td class="px-2 py-2">{{Auth::user()->phone_number}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="px-2 py-2 text-gray-500 font-semibold">Address</td>
                                                        <td class="px-2 py-2 capitalize">{{Auth::user()->address}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                            
                                            <div class="text-center my-3 p-1 bg-success rounded">
                                                <button class="text-sm text-white" onclick="editUser({{Auth::user()->id}});">
                                                    Update
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-9 mb-3">
                            <div class="card w-full mt-2">
                                <div class="card-header flex justify-content-between">
                                    User List View
                                    @if (Auth::user()->role=='admin')
                                        <button class="btn btn-primary text-white ps-2 pe-2 pt-1 pb-1" id="CreateUser" onclick="CreateUser()"><i class="fa-solid fa-plus"></i></button>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped table-bordered table-hover" id="UserListsView">
                                        <thead>
                                            <tr>
                                                <td>Name</td>
                                                {{-- <td class="text-start">Password</td> --}}
                                                <td class="text-start">Phone</td>
                                                <td>Gender</td>
                                                <td>Address</td>
                                                <td>Photo</td>
                                                <td>Status</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody id="usersTableBody">
        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="UpdateViewUserModal" class="modal" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="bg-light modal-header justify-content-between">
                              <h5 class="modal-title" id="UpdateModalTitle">Update User</h5>
                              <button type="button" data-bs-dismiss="modal" class="bg-dark text-white rounded p-1 ps-3 pe-3">
                                <span>&times;</span>
                              </button>
                            </div>
                            <div class="modal-body" style="overflow: auto;height: 450px;">
                                <!-- Username -->
                                <div>
                                    <x-input-label for="username" :value="__('Username : ')" />
                                    <x-text-input placeholder="Enter the username..."  id="username" class="block mt-1 w-full" type="text" name="username" />
                                </div>
                                @if (Auth::user()->role=='admin')
                                    <div class="mt-4">
                                        <x-input-label for="userPassword" :value="__('Password : ')" />
                                        <x-text-input placeholder="Enter the password..."  id="userPassword" class="block mt-1 w-full" type="text" name="userPassword" />
                                    </div>
                                @endif
                                <!-- phone numder -->
                                <div class="mt-4">
                                    <x-input-label for="phone_number" :value="__('Phone Number : ')" />
                                    <x-text-input placeholder="Enter the phone number..." id="phone_number" class="block mt-1 w-full" type="text" name="phone_number"/>
                                </div>

                                <!-- gender -->
                                <div class="mt-4">
                                    <div class="radio-group inline-flex gap-2 border w-full p-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-black">
                                        <x-input-label for="gender" :value="__('Gender : ')" />

                                        <input type="radio"  class="text-black mt-1 gender" type="radio" name="gender" value="male"/>
                                        <span class="pl-2">Male</span>
                            
                                        <input type="radio"  class="text-black mt-1 gender" type="radio" name="gender" value="female"/>
                                        <span class="pl-4"> Female</span>

                                    </div>
                                </div>
                                
                                <!-- address -->
                                <div class="mt-4">
                                    <x-input-label for="address" :value="__('Address : ')" />
                                    <x-text-input  placeholder="Enter the address..." id="address" class="block mt-1 w-full" type="text" name="address"/>
                                </div>

                                <!-- photo-->
                                <div class="mt-4">
                                    <x-input-label for="photo" :value="__('Photo : ')" />
                                    <div class="user_profile_image flex gap-2">
                                        <x-text-input id="file" accept="image/jpeg, image/png, image/jpg" class="block mt-1 w-full border" style="padding: 1vw;" type="file" id="user-photo" name="photo"/>
                                        <img :src="" width="60" alt="User Photo" id="PreviewUserPhoto"/>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <x-input-label for="user-role" :value="__('Role : ')" />
                                    <select class="form-control" name="user-role" id="user-role">
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <x-input-label for="user-status" :value="__('Status : ')" />
                                    <select class="form-control" name="user-status" id="user-status">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" id="UpdateUserData" UserId="0" class="btn btn-primary">Save changes</button>
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                window.role='user';
                @if(Auth::check() && Auth::user()->role == 'admin')
                    loadUsers();
                    window.role='admin';
                @endif
              
                $('#user-photo').on('change', function () {
                    const file = this.files[0];
                    if (file) {
                        $('#PreviewUserPhoto').attr('src', URL.createObjectURL(file));
                    }
                });

                $('#UpdateUserData').on('click',function(e){
                    let username= $('#username').val().trim();
                    let phone_number=$('#phone_number').val().trim();
                    let address=$('#address').val().trim();
                    let photo=$('#user-photo')[0].files[0];
                    let gender=$('.gender:checked').val().trim();
                    let status=$('#user-status').val().trim();
                    let role=$('#user-role').val().trim();
                    let id=$(this).attr('UserId');
                    let userPassword=$('#userPassword').val();

                    const form = new FormData();
                    console.log(username,phone_number,address,photo,gender,role,status);
                    form.append('username', username);
                    form.append('phone_number', phone_number);
                    form.append('address', address);
                    form.append('photo', photo);
                    form.append('gender', gender);
                    form.append('role', role);
                    form.append('status', status);
                    form.append('id', id);
                    form.append('userPassword', userPassword);

                    

                    $('.backgroundLoarding').show();
                    $.ajax({
                        type: "post",
                        url: ($(this).text().toLowerCase()=='save')?'userCreate':'userUpdate',
                        data: form,
                        dataType: "json",
                        processData:false,
                        contentType:false,
                        success: async function (response) {
                            $('.backgroundLoarding').hide();
                            if(response['status']==0){
                                swal.fire({
                                    icon:'error',
                                    text:response['message'],
                                    allowOutsideClick:false,
                                })
                            }else{
                                swal.fire({
                                    icon:'success',
                                    text:response['message'],
                                    allowOutsideClick:false,
                                })
                                $('#UpdateViewUserModal').modal('hide');
                                loadUsers();
                            }
                        }
                    })
                })  
            });

            // Function to load users
            function loadUsers() {
                $('.backgroundLoarding').show();
                $.ajax({
                    url: 'GetAllUsers', // Your API endpoint to fetch users
                    type: 'post',       // Use GET method to retrieve users
                    dataType: 'json',  // Expecting JSON data from the server
                    success: function(users) {
                        let tableContent = '';

                        // Check if there are users
                        if (users.length > 0) {
                            // Loop through each user to generate the table rows
                            $.each(users, function(index, user) {
                                tableContent += `
                                    <tr>
                                        <td class="align-middle">${user.username}</td>
                                        <td class="text-start align-middle">${user.phone_number}</td>
                                        <td class="align-middle">${user.gender}</td>
                                        <td class="align-middle">${user.address}</td>
                                        <td style="text-align: -webkit-center;">
                                            <img src="/storage/${user.photo}" alt="User Photo" width="50">
                                        </td>
                                        <td class="align-middle">${user.status}</td>
                                        <td class="text-center align-middle">
                                            <div class="button-group flex justify-center items-center gap-2">
                                                ${(user.status === 'active'  && window.role=='admin') ? `
                                                    <button onclick="editUser(${user.id});">
                                                        <i class="fa-solid fa-pen-to-square text-success text-2xl"></i>
                                                    </button>
                                                    <button onclick="deleteUser(${user.id});">
                                                        <i class="fa-solid fa-trash text-danger text-2xl"></i>
                                                    </button>
                                                    <button onclick="viewUser(${user.id});">
                                                        <i class="fa-solid fa-eye text-info text-2xl"></i>
                                                    </button>
                                                ` : `
                                                    <button onclick="restoreUser(${user.id});">
                                                        <i class="fa-solid fa-trash-arrow-up text-danger text-2xl"></i>
                                                    </button>
                                                `}
                                            </div>
                                        </td>
                                    </tr>
                                `;
                            });
                        }

                        // Insert the table content into the tbody (with id 'usersTableBody')

                        $('#usersTableBody').html(tableContent);
                        $('#UserListsView').DataTable();  // Initialize DataTable
                        $('.backgroundLoarding').hide();
                    }
                });
            }

            function CreateUser(id=1){
                $('#UpdateUserData').show();
                $('#UpdateUserData').attr('UserId',0);
                $('#UpdateUserData').text('Save');
                $('#UpdateViewUserModal input,#UpdateViewUserModal select').prop('disabled',false);
                $('#UpdateModalTitle').text('Create User Data');
                $('#username').val('');
                $('#phone_number').val('');
                $('#address').val('');
                $('#user-photo').val('');
                $('.gender').prop('checked',false);
                $('#PreviewUserPhoto').attr('src','');
                $('#user-status').val('active');
                $('#user-role').val('user');
                $('#UpdateViewUserModal').modal({
                    backdrop: false,
                    keyboard: false
                }).modal('show');
            }
            async function editUser(id=1){
                await GetAllUserData(id);
                $('#UpdateUserData').attr('UserId',id);
                $('#UpdateUserData').text('Update');
                $('#UpdateViewUserModal input,#UpdateViewUserModal select').prop('disabled',false);
                $('#UpdateUserData').show();
                $('#UpdateModalTitle').text('Update User Data');
                $('#UpdateViewUserModal').modal({
                    backdrop: false,
                    keyboard: false
                }).modal('show');
            }

            async function viewUser(id){
                await GetAllUserData(id);
                $('#UpdateUserData').hide();
                $('#UpdateUserData').attr('UserId',0);
                $('#UpdateViewUserModal input,#UpdateViewUserModal select').prop('disabled',true);
                $('#UpdateModalTitle').text('View User Data');
                $('#UpdateViewUserModal').modal({
                    backdrop: false,
                    keyboard: false
                }).modal('show');
            }

            async function GetAllUserData(id){
                let _token=$('meta[name="csrf-token"]').attr('content');
                $('.backgroundLoarding').show();
                $.ajax({
                    type: "post",
                    url: "user",
                    data: {id,_token},
                    dataType: "json",
                    success: async function (response) {
                        console.log(response);
                        $('#username').val(response['username']);
                        $('#phone_number').val(response['phone_number']);
                        $('#address').val(response['address']);
                        $('#user-photo').val('');
                        $('.gender[value="'+response['gender']+'"]').prop('checked',true);
                        $('#PreviewUserPhoto').attr('src','/storage/'+response['photo']);
                        $('#user-status').val(response['status']);
                        $('#user-role').val(response['role']);
                        $('.backgroundLoarding').hide();
                    }
                });
            }

            function deleteUser(id){
                let _token=$('meta[name="csrf-token"]').attr('content');
                $('.backgroundLoarding').show();
                $.ajax({
                    type: "delete",
                    url: "user",
                    data: {id,_token},
                    dataType: "json",
                    success: function (response) {
                        $('.backgroundLoarding').hide();
                        if(response['status']==0){
                            swal.fire({
                                icon:'error',
                                text:response['message'],
                                allowOutsideClick:false,
                            })
                        }else{
                            swal.fire({
                                icon:'success',
                                text:response['message'],
                                allowOutsideClick:false,
                            })
                            loadUsers();
                        }
                    }
                });
            }

            function restoreUser(id){
                $('.backgroundLoarding').show();
                let _token=$('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "post",
                    url: "RestoreUser",
                    data: {id,_token},
                    dataType: "json",
                    success: function (response) {
                        $('.backgroundLoarding').hide();
                        if(response['status']==0){
                            swal.fire({
                                icon:'error',
                                text:response['message'],
                                allowOutsideClick:false,
                            })
                        }else{
                            swal.fire({
                                icon:'success',
                                text:response['message'],
                                allowOutsideClick:false,
                            })
                            loadUsers();
                        }
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
