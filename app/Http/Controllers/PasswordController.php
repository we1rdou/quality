<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                function ($attribute, $value, $fail) use ($user) {
                    if (Hash::check($value, $user->password)) {
                        $fail('La nueva contraseña no puede ser igual a la anterior.');
                    }
                },
            ],
        ], [
            'current_password.required' => 'Debes ingresar tu contraseña actual.',
            'new_password.required' => 'Debes ingresar una nueva contraseña.',
            'new_password.string' => 'La nueva contraseña debe ser texto.',
            'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'new_password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ]);

        if ($validator->fails()) {
            // Mostrar todos los errores en el modal
            return redirect()->back()->with('password_error', $validator->errors()->all())->withInput();
        }

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->with('password_error', ['La contraseña actual es incorrecta.'])->withInput();
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->back()->with('password_success', 'Contraseña actualizada correctamente.');
    }
}
