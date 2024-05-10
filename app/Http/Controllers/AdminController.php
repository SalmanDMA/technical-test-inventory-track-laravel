<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function users(Request $request)
    {
        $itemPerPage = 5;
        if ($request->has('search')) {
            $users = User::where('name', 'like', '%' . $request->search . '%')
                ->where('role', '<>', 'superadmin')
                ->paginate($itemPerPage);
            return view('dashboard.admin.users.index', compact('users'));
        }
        $users = User::where('role', '<>', 'superadmin')
            ->paginate($itemPerPage);

        return view('dashboard.admin.users.index', compact('users'));
    }

    public function usersAdd()
    {
        return view('dashboard.admin.users.add');
    }
    public function usersPostUpdate(Request $request)
    {

        $rules = [
            'name' => 'required|min:3|max:255',
            'avatar' => 'image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required',
            'phone' => 'required',
        ];

        $messages = [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 3 characters',
            'name.max' => 'Name must not exceed 255 characters',
            'avatar.image' => 'Avatar must be an image',
            'avatar.max' => 'Avatar size must not exceed 2MB',
            'address.required' => 'Address is required',
            'phone.required' => 'Phone is required',
        ];

        if (auth()->user()->role == 'superadmin' && $request->has('user_id')) {
            $rules['role'] = 'required';
            $messages['role.required'] = 'Role is required';
        }

        if (!$request->has('user_id')) {
            $rules['password'] = 'required|min:8|max:255';
            $rules['email'] = 'required|email|unique:users,email';
            $messages['password.required'] = 'Password is required';
            $messages['password.min'] = 'Password must be at least 8 characters';
            $messages['password.max'] = 'Password must not exceed 255 characters';
            $messages['email.unique'] = 'Email already exists';
            $messages['email.email'] = 'Email is not valid';
            $messages['email.required'] = 'Email is required';
        } else {
            $rules['email'] = 'required|email';
            $messages['email.email'] = 'Email is not valid';
            $messages['email.required'] = 'Email is required';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['success' => false, 'message' => $errors], 422);
        }

        if ($request->user_id) {
            $user = User::find($request->user_id);

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            if ($request->hasFile('avatar')) {
                $oldAvatarPath = 'photo-users/' . $request->oldAvatar;
                if (Storage::disk('public')->exists($oldAvatarPath)) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }

                $avatar = $request->file('avatar');
                $avatarName = time() . '-' . $avatar->getClientOriginalName();
                $path = 'photo-users/' . $avatarName;
                Storage::disk('public')->put($path, file_get_contents($avatar));
                $user->avatar = $avatarName;
            }

            $role = auth()->user()->role == 'superadmin' ? $request->role : 'user';

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $role;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->save();

            return response()->json(['success' => true, 'message' => 'User updated successfully'], 200);
        } else {
            $avatarName = null;
            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = time() . '.' . $avatar->getClientOriginalName();
                $path = 'photo-users/' . $avatarName;
                Storage::disk('public')->put($path, file_get_contents($avatar));
            }

            $role = auth()->user()->role == 'superadmin' ? $request->role : 'user';

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $role,
                'address' => $request->address,
                'phone' => $request->phone,
                'avatar' => $avatarName,
            ]);

            if ($user) {
                return response()->json(['success' => true, 'message' => 'User created successfully'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to create user'], 500);
            }
        }
    }


    public function usersUpdate(int $id)
    {
        $user = User::find($id);
        return view('dashboard.admin.users.update', compact('user'));
    }

    public function usersDelete(int $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $oldAvatarPath = 'photo-users/' . $user->avatar;

        if ($oldAvatarPath != null) {
            if (Storage::disk('public')->exists($oldAvatarPath)) {
                Storage::disk('public')->delete($oldAvatarPath);
            }
        }

        if ($user) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User deleted successfully'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
    }

    public function itemsAdd()
    {
        return view('dashboard.admin.items.add');
    }
    public function itemsPostUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'quantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['success' => false, 'message' => $errors], 422);
        }

        if ($request->item_id) {
            $item = Item::find($request->item_id);

            if (!$item) {
                return response()->json(['success' => false, 'message' => 'Item not found'], 404);
            }

            if ($request->hasFile('image')) {
                $oldImagePath = 'photo-items/' . $request->oldImage;
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                $image = $request->file('image');
                $imageName = time() . '-' . $image->getClientOriginalName();
                $path = 'photo-items/' . $imageName;
                Storage::disk('public')->put($path, file_get_contents($image));
                $item->image = $imageName;
            }

            $item->name = $request->name;
            $item->quantity = $request->quantity;
            $item->save();

            return response()->json(['success' => true, 'message' => 'Item updated successfully'], 200);
        } else {
            $imageName = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalName();
                $path = 'photo-items/' . $imageName;
                Storage::disk('public')->put($path, file_get_contents($image));
            }

            $item = Item::create([
                'name' => $request->name,
                'quantity' => $request->quantity,
                'image' => $imageName,
            ]);

            if ($item) {
                return response()->json(['success' => true, 'message' => 'Item created successfully'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to create item'], 500);
            }
        }
    }


    public function itemsUpdate(int $id)
    {
        $item = Item::find($id);
        return view('dashboard.admin.items.update', compact('item'));
    }

    public function itemsDelete(int $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }

        $oldImagePath = 'photo-items/' . $item->image;

        if ($oldImagePath != null) {
            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        if ($item) {
            $item->delete();
            return response()->json(['success' => true, 'message' => 'Item deleted successfully'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        }
    }
}
