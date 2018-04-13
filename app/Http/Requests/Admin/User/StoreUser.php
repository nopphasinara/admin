<?php namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return  bool
     */
    public function authorize()
    {
        return Gate::allows('admin.user.create');
    }

/**
     * Get the validation rules that apply to the request.
     *
     * @return  array
     */
    public function rules()
    {
        $rules = [
            'email' => ['required', 'email', Rule::unique('users', 'email'), 'string'],
            'password' => ['required', 'confirmed', 'min:7', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'string'],
            'first_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'forbidden' => ['required', 'boolean'],
            'language' => ['required', 'string'],
                
            'roles' => ['array'],
                
        ];

        if(Config::get('admin-auth.activations.enabled')) {
            $rules['activated'] = ['required', 'boolean'];
        }

        return $rules;
    }

    /**
     * Modify input data
     *
     * @return  array
     */
    public function getModifiedData()
    {
        $data = $this->only(collect($this->rules())->keys()->all());
        //TODO: is this ok?
        if(!Config::get('admin-auth.activations.enabled')) {
            $data['activated'] = true;
        }
        if(!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $data;
    }
}
