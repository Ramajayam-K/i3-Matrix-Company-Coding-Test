<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\EncryptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    protected $encryptionService;

    public function __construct(EncryptionService $EncryptionService)
    {
        $this->encryptionService = $EncryptionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard');
    }


    public function GetAllUsers()
    {
        $GetAllUsers = [];

        if(Auth::user()->role="admin"){
            $GetAllUsers = User::orderBy('status', 'ASC')->get();
       
            // if (count($GetAllUsers) > 0) {
            //     foreach ($GetAllUsers as $user) {
            //         $content .= '<tr>';
            //         $content .= '<td class="align-middle">' . $user->username . '</td>';
            //         $content .= '<td class="align-middle">' . $this->EncryptionService->decrypt($user->recover_password) . '</td>';
    
    
            //         $content .= '<td class="text-start align-middle">' . $user->phone_number . '</td>';
            //         $content .= '<td class="align-middle">' . $user->gender . '</td>';
            //         $content .= '<td class="align-middle">' . $user->address . '</td>';
            //         $content .= '<td style="text-align: -webkit-center;">
            //                         <img src="/storage/' . $user->photo . '" alt="User Photo" width="50">
            //                     </td>';
            //         $content .= '<td class="align-middle">' . $user->status . '</td>';
            //         $content .= '<td class="text-center align-middle">
            //                         <div class="button-group flex justify-center items-center gap-2">';
    
            //         if ($user->status === 'active') {
            //             $content .= '<button onclick="editUser(' . $user->id . ');">
            //                             <i class="fa-solid fa-pen-to-square text-success text-2xl"></i>
            //                         </button>';
            //             $content .= '<button onclick="deleteUser(' . $user->id . ');">
            //                             <i class="fa-solid fa-trash text-danger text-2xl"></i>
            //                         </button>';
            //             $content .= '<button onclick="viewUser(' . $user->id . ');">
            //                             <i class="fa-solid fa-eye text-info text-2xl"></i>
            //                         </button>';
            //         } else {
            //             $content .= '<button onclick="restoreUser(' . $user->id . ');">
            //                             <i class="fa-solid fa-trash-arrow-up text-danger text-2xl"></i>
            //                         </button>';
            //         }
    
            //         $content .= '</div></td></tr>';
            //     }
            // }
        }

        return response()->json($GetAllUsers);
    }

        /**
     * Display the specified resource.
     */
    public function create(Request $request)
    {

        if(Auth::user()->role=="admin"){
            $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
                'phone_number' => ['required', 'string'],
                'gender' => ['required', 'string'],
                'address' => ['required', 'string'],
                'role' => ['required', 'string'],
                'status' => ['required', 'string'],
                'photo' => ['required', 'file', 'mimes:jpg,png,jpeg'],
            ]);

            if ($request->hasFile('photo')) {
                $fileData = $request->file('photo');
                $user = User::create([
                    'username' => $request->username,
                    'phone_number' => $request->phone_number,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'photo' => 'Path',
                    'password' => Hash::make($request->password),
                    'recover_password' => $this->encryptionService->encrypt($request->password),
                ]);

                $fileName = $fileData->getClientOriginalName() . time() . '.' . $fileData->getClientOriginalExtension();
                $filePath = $fileData->storeAs('uploads/'.$user->id, $fileName, 'public');

                $updateUser=User::where('id',$user->id)->update(['photo'=>$filePath]);

                if ($updateUser == 0) {
                    return response()->json(['status' => $updateUser, 'message' => 'Data is not inserted.']);
                }
                return response()->json(['status' => $updateUser, 'message' => 'User data is inserted successfully.']);
            }
        }else{
            return response()->json(['status' => 0, 'message' => 'You did not have access to creat new user.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $signleUser = [];
        if (isset($request->id)) {
            $signleUser = User::where('id', '=', $request->id)->get();
        }

        return response()->json((isset($signleUser[0])) ? $signleUser[0] : $signleUser);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $updateUser = 0;

        // dd([
        //     'all' => $request->all(),
        //     'post' => $_POST,
        //     'files' => $_FILES,
        //     'method' => $request->method(),
        // ]);

        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'address' => ['required', 'string'],
            'role' => ['required', 'string'],
            'status' => ['required', 'string'],
        ]);

        $checkUsername = User::where('username', '=', $request->username)->where('id', '!=', $request->id)->get();
        if (count($checkUsername) > 0) {
            return response()->json(['status' => 0, 'message' => 'The username has already been taken.']);
        }


        if (isset($request->id) && $request->id != 0) {
            $username = $request->username;
            $phone_number = $request->phone_number;
            $gender = $request->gender;
            $address = $request->address;
            $role = $request->role;
            $status = $request->status;
            $userPassword=$request->userPassword;


            $updateData = [];

            if(!empty($userPassword) && Auth::user()->role=="admin"){
                $updateData['password'] = $userPassword;
            }

            if (!empty($username)) {
                $updateData['username'] = $username;
            }

            if (!empty($phone_number)) {
                $updateData['phone_number'] = $phone_number;
            }

            if (!empty($gender)) {
                $updateData['gender'] = $gender;
            }

            if (!empty($address)) {
                $updateData['address'] = $address;
            }

            if (!empty($status)) {
                $updateData['status'] = $status;
            }

            if (!empty($role)) {
                $updateData['role'] = $role;
            }


            // Handle photo upload
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                if (in_array(strtolower($file->getClientOriginalExtension()), ['jpg', 'jpeg', 'png'])) {
                    $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
                        . '_' . time() . '.' . $file->getClientOriginalExtension();

                    $filePath = $file->storeAs('uploads/' . Auth::user()->id, $fileName, 'public');

                    if (!empty($filePath)) {
                        $updateData['photo'] = $filePath;
                    }
                } else {
                    return response()->json(['status' => 0, 'message' => 'Invalid image. Supported formats are PNG, JPG, and JPEG.']);
                }
            }

            // Update only if there's data to update
            if (!empty($updateData)) {
                $updateUser = User::where('id', $request->id)->update($updateData);
            }
        } else {
            return response()->json(['status' => $updateUser, 'message' => 'You are not able to update the user data.']);
        }
        if ($updateUser == 0) {
            return response()->json(['status' => $updateUser, 'message' => 'Data is not updated.']);
        }
        return response()->json(['status' => $updateUser, 'message' => 'User data is updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $deleteUser = 0;

        if (isset($request->id)) {
            $deleteUser = User::where('id', $request->id)->update(['status' => 'inactive']);
        }

        return response()->json([
            'success' => $deleteUser ? true : false,
            'message' => $deleteUser ? 'User deleted successfully.' : 'User not found or already deleted.',
            'status' => $deleteUser
        ]);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(Request $request)
    {
        $restoreUser = 0;

        if (isset($request->id)) {
            $restoreUser = User::where('id', $request->id)->update(['status' => 'active']);
        }

        return response()->json([
            'success' => $restoreUser ? true : false,
            'message' => $restoreUser ? 'User restored successfully.' : 'User not found or already restored.',
            'status' => $restoreUser
        ]);
    }
}
