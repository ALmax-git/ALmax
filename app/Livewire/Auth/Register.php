<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Register extends Component
{
    public $name_status, $email_status, $password_status, $confirm_password_status, $name, $email, $password, $confirm_password, $valid = false;

    // Validate the name
    public function validate_name()
    {
        // Ensure name meets the criteria
        $this->name_status = null;

        $validator = Validator::make(['name' => $this->name], [
            'name' => ['required', 'min:3', 'regex:/^[a-zA-Z][a-zA-Z0-9]*$/', Rule::unique(User::class)],
        ]);

        if ($validator->fails()) {
            $this->name_status = $validator->errors()->first();
            return;
        }

        $this->name_status = 'name is valid!';
    }



    // Validate the email
    public function validate_email()
    {
        // Ensure email meets the criteria
        $this->email_status = null;

        // Check if email is unique
        $emailValidator = Validator::make(['email' => $this->email], [
            'email' => ['required', 'email', Rule::unique(User::class)],
        ]);

        // Validate email domain
        if (!system_support_emails($this->email)) {
            $this->email_status = 'The email domain is not supported.';
            $this->valid = false;
            return;
        }

        if ($emailValidator->fails()) {
            $this->email_status = $emailValidator->errors()->first();
            return;
        }

        $this->email_status = 'Email is valid!';
    }


    // Validate the password
    public function validate_password()
    {
        $this->password_status = null;

        $validator = Validator::make(['password' => $this->password], [
            'password' => ['required', 'min:8', 'regex:/[!@#$%^&*(),.?":{}|<>]/', function ($attribute, $value, $fail) {
                if (in_array($value, system_vulnerable_password())) {
                    $fail('This password is too weak.');
                }
            }],
        ]);

        if ($validator->fails()) {
            $this->password_status = $validator->errors()->first();
            $this->valid = false;
            return;
        }

        $this->password_status = 'Password is valid!';
    }

    // Validate the confirm password field
    public function validate_confirm_password()
    {
        $this->password_status = null;

        if ($this->password !== $this->confirm_password) {
            $this->password_status = 'Passwords do not match.';
            $this->valid = false;
            return;
        }

        $this->password_status = 'Passwords match!';
    }

    // Final validation before form submission
    public function validate_form()
    {
        $this->validate_name();
        $this->validate_email();
        $this->validate_password();
        // $this->validate_confirm_password();

        // If no validation errors, set $valid to true
        if (is_null($this->name_status) && is_null($this->email_status) && is_null($this->password_status)) {
            $this->valid = true;
        }
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
