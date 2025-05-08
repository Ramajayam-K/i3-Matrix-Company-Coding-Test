<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EncryptionService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    protected $encryptionService;
    public function __construct(EncryptionService $encryptionService)
    {
        $this->encryptionService = $encryptionService;
    }
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'phone_number' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'address' => ['required', 'string'],
            'photo' => ['required', 'file', 'mimes:jpg,png,jpeg'],
            'password' => ['required', Rules\Password::defaults()],
            // 'password' => ['required', Rules\Password::defaults()],
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

            $user->photo = $filePath;
            
            $user->save();

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        }

        return redirect()->back();
    }
}
