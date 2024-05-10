<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin') {
            $items = Item::all();
            $users = User::where('role', '<>', 'superadmin')->get();
            $activities = Activity::whereHas('user', function ($query) {
                $query->where('role', '<>', 'superadmin');
            })->get();
            $topFiveByDate = Activity::orderBy('created_at', 'desc')->take(5)->get();
            $topFiveLoaners = Activity::select('users.id', 'users.name', 'users.avatar', 'users.email', DB::raw('SUM(activities.quantity) as total_quantity'))
                ->join('users', 'activities.user_id', '=', 'users.id')
                ->where('activities.type', 'loan')
                ->where(function ($query) {
                    $query->where('users.role', '<>', 'superadmin');
                })
                ->groupBy('users.id', 'users.name', 'users.avatar', 'users.email')
                ->orderByDesc('total_quantity')
                ->take(5)
                ->get();

            return view('dashboard.index', compact('items', 'users', 'activities', 'topFiveByDate', 'topFiveLoaners'));
        } else {
            $userId = auth()->user()->id;

            $activities = Activity::where('user_id', $userId)->whereHas('user', function ($query) {
                $query->where('role', '<>', 'superadmin');
            })->get();

            $loans = Activity::where('user_id', $userId)
                ->where('type', 'loan')
                ->whereHas('user', function ($query) {
                    $query->where('role', '<>', 'superadmin');
                })
                ->get();

            $returns = Activity::where('user_id', $userId)
                ->where('type', 'return')
                ->whereHas('user', function ($query) {
                    $query->where('role', '<>', 'superadmin');
                })
                ->get();

            $topFiveByDate = Activity::where('user_id', $userId)
                ->whereHas('user', function ($query) {
                    $query->where('role', '<>', 'superadmin');
                })
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('dashboard.index', compact('userId', 'activities', 'loans', 'returns', 'topFiveByDate'));
        }
    }

    public function items(Request $request)
    {
        if ($request->has('search')) {
            $itemPerPage = 5;
            $items = Item::where('name', 'like', '%' . $request->search . '%')->paginate($itemPerPage);
            return view('dashboard.items', compact('items'));
        }

        $itemPerPage = 5;
        $items = Item::paginate($itemPerPage);

        return view('dashboard.items', compact('items'));
    }

    public function profile()
    {
        return view('dashboard.profile');
    }

    public function profilePostUpdate(Request $request)
    {
        $rules = [];
        $messages = [];

        if ($request->has('update_image')) {
            $rules['avatar'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
            $messages['avatar.required'] = 'Avatar is required';
            $messages['avatar.image'] = 'Avatar must be an image';
            $messages['avatar.max'] = 'Avatar size must not exceed 2MB';
        } else {
            $rules['email'] = 'required|email';
            $rules['name'] = 'required|min:3|max:255';
            $rules['address'] = 'required';
            $rules['phone'] = 'required';
            $messages['name.required'] = 'Name is required';
            $messages['name.min'] = 'Name must be at least 3 characters';
            $messages['name.max'] = 'Name must not exceed 255 characters';
            $messages['email.unique'] = 'Email already exists';
            $messages['email.email'] = 'Email is not valid';
            $messages['email.required'] = 'Email is required';
            $messages['address.required'] = 'Address is required';
            $messages['phone.required'] = 'Phone is required';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($request->update_image) {
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return response()->json(['success' => false, 'message' => $errors], 422);
            }
        } else {
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $notification = array(
                    'message' => $errors[0],
                    'alert-type' => 'error',
                );

                return redirect()->back()->with($notification);
            }
        }

        if ($request->update_image) {
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

            $user->save();

            return response()->json(['success' => true, 'message' => 'Image updated successfully'], 200);
        } else {
            $user = User::find($request->user_id);

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->phone = $request->phone;

            $user->save();

            if ($user) {
                $notification = array(
                    'message' => 'Profile updated successfully',
                    'alert-type' => 'success'
                );

                return redirect()->back()->with($notification);
            } else {
                $notification = array(
                    'message' => 'Failed to update profile',
                    'alert-type' => 'error'
                );

                return redirect()->back()->with($notification);
            }
        }
    }

    public function profilePasswordPostUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:8|max:255',
            'confirm_password' => 'required|same:new_password',
        ], [
            'new_password.required' => 'New password is required',
            'new_password.min' => 'New password must be at least 8 characters',
            'new_password.max' => 'New password must not exceed 255 characters',
            'confirm_password.required' => 'Confirm password is required',
            'confirm_password.same' => 'New password and confirm password must match',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $notification = array(
                'message' => $errors[0],
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        $user = User::find($request->user_id);

        if (!$user) {

            $notification = array(
                'message' => 'User not found',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        $notification = array(
            'message' => 'Password updated successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function activities(Request $request)
    {
        $itemPerPage = 5;
        $userId = auth()->user()->id;

        $query = Activity::query();

        if ($request->has('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($query) use ($searchTerm) {
                $query->whereHas('user', function ($query) use ($searchTerm) {
                    $query->where('role', '<>', 'superadmin');
                    $query->where('name', 'like', $searchTerm);
                });
                $query->orWhereHas('item', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', $searchTerm);
                });
            });
        }

        if (auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin') {
            $activities = $query->whereHas('user', function ($query) {
                $query->where('role', '<>', 'superadmin');
            })->paginate($itemPerPage);
        } else {
            $activities = $query->where('user_id', $userId)->whereHas('user', function ($query) {
                $query->where('role', '<>', 'superadmin');
            })->paginate($itemPerPage);
        }

        return view('dashboard.activities', compact('activities'));
    }
}
