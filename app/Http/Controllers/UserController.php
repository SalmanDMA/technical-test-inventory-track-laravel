<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function loan()
    {
        $itemPerPage = 5;
        $userId = auth()->id();

        if (request()->has('search')) {
            $activities = Activity::where('user_id', $userId)
                ->where('type', 'loan')
                ->where('name', 'like', '%' . request()->search . '%')
                ->paginate($itemPerPage);
            return view('dashboard.users.loan.index', compact('activities'));
        }

        $activities = Activity::where('user_id', $userId)->where('type', 'loan')->paginate($itemPerPage);
        return view('dashboard.users.loan.index', compact('activities'));
    }

    public function loanAdd()
    {
        $items = Item::where('quantity', '>', 0)->where('availability', 'available')->get();
        return view('dashboard.users.loan.add', compact('items'));
    }
    public function loanPostUpdate()
    {
        $user_id = auth()->id();
        $type = 'loan';

        $validator = Validator::make(request()->all(), [
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|numeric|min:1',
        ], [
            'item_id.required' => 'Item is required',
            'item_id.exists' => 'Item not found',
            'quantity.required' => 'Quantity is required',
            'quantity.numeric' => 'Quantity must be a number',
            'quantity.min' => 'Quantity must be at least 1',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $notification = array(
                'message' => $errors[0],
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        $item = Item::findOrFail(request()->item_id);

        if ($item->quantity < request()->quantity) {
            $notification = [
                'message' => 'You are trying to loan more than available quantity.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        if ($item->availability == 'unavailable') {
            $notification = [
                'message' => 'Item is unavailable.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $item->quantity -= request()->quantity;
        $item->availability = 'unavailable';
        $item->save();

        Activity::create([
            'user_id' => $user_id,
            'type' => $type,
            'item_id' => request()->item_id,
            'quantity' => request()->quantity
        ]);


        $notification = [
            'message' => 'Loan added successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('dashboard.loan')->with($notification);
    }
    public function return()
    {
        $itemPerPage = 5;
        $userId = auth()->id();

        if (request()->has('search')) {
            $activities = Activity::where('user_id', $userId)
                ->where('type', 'return')
                ->where('name', 'like', '%' . request()->search . '%')
                ->paginate($itemPerPage);
            return view('dashboard.users.return.index', compact('activities'));
        }

        $activities = Activity::where('user_id', $userId)->where('type', 'return')->paginate($itemPerPage);
        return view('dashboard.users.return.index', compact('activities'));
    }

    public function returnAdd()
    {
        $user_id = auth()->id();
        $userActivities = Activity::where('user_id', $user_id)->where('type', 'loan')->whereHas('item', function ($query) {
            $query->where('availability', 'unavailable');
        })->with('item')->get();

        if ($userActivities->isEmpty()) {
            $notification = [
                'message' => 'No data loan found, please add loan first.',
                'alert-type' => 'error'
            ];
            return redirect()->route('dashboard.loan')->with($notification);
        }

        $items = collect();
        foreach ($userActivities as $activity) {
            $items->push($activity->item);
        }
        return view('dashboard.users.return.add', compact('items'));
    }
    public function returnPostUpdate()
    {
        $user_id = auth()->id();
        $type = 'return';

        $validator = Validator::make(request()->all(), [
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|numeric|min:1',
        ], [
            'item_id.required' => 'Item is required',
            'item_id.exists' => 'Item not found',
            'quantity.required' => 'Quantity is required',
            'quantity.numeric' => 'Quantity must be a number',
            'quantity.min' => 'Quantity must be at least 1',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $notification = array(
                'message' => $errors[0],
                'alert-type' => 'error',
            );
            return redirect()->back()->with($notification);
        }

        $activity = Activity::where('user_id', $user_id)
            ->where('item_id', request()->item_id)
            ->where('type', 'loan')
            ->whereHas('item', function ($query) {
                $query->where('availability', 'unavailable');
            })
            ->first();

        if (!$activity) {
            $notification = [
                'message' => 'You have not borrowed this item.',
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($notification);
        }

        if ($activity->quantity != request()->quantity) {
            $notification = [
                'message' => 'You need to return all items you borrowed.',
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($notification);
        }


        $item = Item::findOrFail(request()->item_id);

        $item->quantity += request()->quantity;
        $item->availability = 'available';
        $item->save();


        Activity::create([
            'user_id' => $user_id,
            'type' => $type,
            'item_id' => request()->item_id,
            'quantity' => request()->quantity
        ]);


        $notification = [
            'message' => 'Return added successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('dashboard.return')->with($notification);
    }
}
