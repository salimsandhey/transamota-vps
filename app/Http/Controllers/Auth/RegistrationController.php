<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\GroupChat;

class RegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Get the current step
        $step = $request->input('step', 1);

        // Validate based on the current step
        switch ($step) {
            case 1:
                return $this->handleStep1($request);
            case 2:
                return $this->handleStep2($request);
            case 3:
                return $this->handleStep3($request);
            default:
                return redirect()->route('register');
        }
    }

    private function handleStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:buyer,seller'],
        ], [
            'name.required' => 'Please enter your full name.',
            'name.max' => 'Your name must not exceed 150 characters.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Your email must not exceed 150 characters.',
            'email.unique' => 'This email address is already registered. Please use a different email or log in.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Your password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
            'role.required' => 'Please select an account type (Buyer or Seller).',
            'role.in' => 'Please select a valid account type.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Store step 1 data in session
        $request->session()->put('registration_data', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => $request->role,
        ]);

        // Redirect to step 2
        return redirect()->route('register', ['step' => 2]);
    }

    private function handleStep2(Request $request)
    {
        // Retrieve data from session
        $registrationData = $request->session()->get('registration_data', []);
        
        // Validate step 2 data
        $rules = [
            'phone' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
        ];

        $messages = [
            'phone.required' => 'Please enter your phone number.',
            'phone.max' => 'Your phone number must not exceed 20 characters.',
            'city.required' => 'Please enter your city.',
            'city.max' => 'Your city must not exceed 100 characters.',
            'country.required' => 'Please enter your country.',
            'country.max' => 'Your country must not exceed 100 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update session data
        $registrationData = array_merge($registrationData, [
            'phone' => $request->phone,
            'city' => $request->city,
            'country' => $request->country,
        ]);

        $request->session()->put('registration_data', $registrationData);

        // Redirect to step 3
        return redirect()->route('register', ['step' => 3]);
    }

    private function handleStep3(Request $request)
    {
        // Retrieve data from session
        $registrationData = $request->session()->get('registration_data', []);
        
        // Validate step 3 data based on role
        $rules = [
            'terms' => ['required'],
        ];

        $messages = [
            'terms.required' => 'You must agree to the Terms of Service and Privacy Policy to register.',
        ];

        if ($registrationData['role'] === 'seller') {
            $rules['business_type'] = ['required', 'string', 'max:100'];
            $rules['products_offered'] = ['required', 'string', 'max:500'];
            
            $messages['business_type.required'] = 'Please enter your business type.';
            $messages['business_type.max'] = 'Business type must not exceed 100 characters.';
            $messages['products_offered.required'] = 'Please describe the products you offer.';
            $messages['products_offered.max'] = 'Products offered description must not exceed 500 characters.';
        } else {
            $rules['products_interested'] = ['required', 'string', 'max:500'];
            $rules['buying_frequency'] = ['required', 'string', 'max:100'];
            
            $messages['products_interested.required'] = 'Please describe the products you are interested in.';
            $messages['products_interested.max'] = 'Products interested description must not exceed 500 characters.';
            $messages['buying_frequency.required'] = 'Please enter your buying frequency.';
            $messages['buying_frequency.max'] = 'Buying frequency must not exceed 100 characters.';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Merge step 3 data
        $step3Data = [
            'company_name' => $request->company_name,
        ];

        if ($registrationData['role'] === 'seller') {
            $step3Data['business_type'] = $request->business_type;
            $step3Data['products_offered'] = $request->products_offered;
            $step3Data['website'] = $request->website ?? null;
            $step3Data['gst_no'] = $request->gst_no ?? null;
        } else {
            $step3Data['products_interested'] = $request->products_interested;
            $step3Data['buying_frequency'] = $request->buying_frequency;
        }

        $registrationData = array_merge($registrationData, $step3Data);

        // Create the user
        $user = User::create([
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
            'password' => Hash::make($registrationData['password']),
            'role' => $registrationData['role'],
            'company_name' => $registrationData['company_name'],
            'phone' => $registrationData['phone'],
            'city' => $registrationData['city'],
            'country' => $registrationData['country'],
        ]);

        // Create user profile
        $userProfile = new UserProfile();
        $userProfile->user_id = $user->id;
        
        if ($registrationData['role'] === 'seller') {
            $userProfile->business_type = $registrationData['business_type'];
            $userProfile->products_offered = $registrationData['products_offered'];
            $userProfile->website = $registrationData['website'] ?? null;
            $userProfile->gst_no = $registrationData['gst_no'] ?? null;
        } else {
            $userProfile->products_interested = $registrationData['products_interested'];
            $userProfile->buying_frequency = $registrationData['buying_frequency'];
        }
        
        $userProfile->save();

        // Automatically add user to all existing group chats
        $this->assignUserToAllGroupChats($user);

        // Clear session data
        $request->session()->forget('registration_data');

        // Log the user in
        Auth::login($user);

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        // Redirect to email verification notice
        return redirect()->route('verification.notice');
    }

    /**
     * Assign a user to all existing group chats
     *
     * @param User $user
     * @return void
     */
    private function assignUserToAllGroupChats(User $user)
    {
        // Get all existing group chats
        $groupChats = GroupChat::all();
        
        // Assign user to each group chat
        foreach ($groupChats as $groupChat) {
            // Check if user is already assigned to this group chat
            $existingAssignment = $groupChat->users()->where('user_id', $user->id)->first();
            
            // If not assigned, create the assignment
            if (!$existingAssignment) {
                $groupChat->users()->attach($user->id, ['is_admin' => false]);
            }
        }
    }
}