<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        return view('dashboard');
    }


    public function GetAllUsers(){
        $GetAllUsers = User::orderBy('status', 'ASC')->get();

        return response()->json($GetAllUsers);
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

        if (isset($request->id) && $request->id == 0) {
            $username = $request->username;
            $phone_number = $request->phone_number;
            $gender = $request->gender;
            $address = $request->address;
            $role = $request->role;
            $status = $request->status;


            $updateData = [];

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
