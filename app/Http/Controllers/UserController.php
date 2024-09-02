<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $users = User::Paginate($perPage);
        return view('dashboard.users', compact('users'));
    }


    public function chartData()
    {
        $users = User::all();


        $labels = $users->groupBy(function($date) {
            return $date->created_at->format('Y-m-d'); // Group by month and year
        })->keys();

        $values = $users->groupBy(function($date) {
            return $date->created_at->format('Y-m-d');
         })->map->count()->values();
        return response()->json([
            'success'=> true,
            'labels' => $labels,
            'values' => $values
        ]);
    }


    public function activeUsers(Request $request)
    {
        $users = Auth::user();
        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }


    public function show(Request $request ,string $id)
    {
        $user = User::findOrFail($id);

        return view('home.profile', compact('user'));
    }

    public function destroy(Request $request)
    {
        $data = $request->all();
        $userId = $data['user_id'];
        $user = User::where('id',$userId);
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'user is deleted successfully',
            'user' => $user
        ]);
    }

    public function multipleDelete(Request $request)
    {
        $data = $request->all();
        $userIds = $data['user_ids'];

        if (is_array($userIds) && !empty($userIds)) {
            $users = User::destroy($userIds); // Destroy method takes an array of IDs directly

            if ($users > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Users deleted successfully.',
                    'users' => $users,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete users.',
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid user IDs.',
        ]);
    }


    public function usersSearch(Request $request)
    {
        $query = $request->input('query');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $users = User::query();
        if ($query) {
            $users->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%$query%")
                ->orWhere('email', 'LIKE', "%$query%")
                ->orWhere('role', 'LIKE', "%$query%");
            });
        }

        if ($startDate && $endDate) {
            $endDate = \Carbon\Carbon::parse($endDate)->endOfDay()->toDateString();
            $users->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $users->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $endDate = \Carbon\Carbon::parse($endDate)->endOfDay()->toDateString();
            $users->whereDate('created_at', '<=', $endDate);
        }

        $users = $users->paginate(10);

        return response()->json([
            'success' => true,
            'users' => $users->items(),
            'current_page' => $users->currentPage(),
            'total_pages' => $users->lastPage(),
            'total_users' => $users->total()
        ]);
    }

    public function addressStore(Request $request)
    {
        $data = $request->all();

        $rules = [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|digits:10',
            'postal_code' => 'required|digits:6',
            'locality' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string',
            'alternate_phone_number' => 'nullable|digits:10',
            'type' => 'required|in:home,work',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all(),
            ]);
        }

        $userId = Auth::id();

        // Create the address
        $address = new Address();
        $address->user_id = $userId;
        $address->name = $data['name'];
        $address->phone_number = $data['phone_number'];
        $address->postal_code = $data['postal_code'];
        $address->locality = $data['locality'];
        $address->address = $data['address'];
        $address->city = $data['city'];
        $address->state = $data['state'];
        $address->alternate_phone_number = $data['alternate_phone_number'];
        $address->type = $data['type'];
        $address->save();


        $addressCount = Address::count();

        if ($address) {
            return response()->json([
                'success' => true,
                'address' => $address,
                'addressCount' => $addressCount
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Address could not be saved. Please try again later.',
            ]);
        }
    }


    public function userAddresses(){
        $userId = Auth::id();

        $addesses = Address::where('user_id',$userId)->get();

        $addressCount  = Address::count();

        if($addesses){
            return response()->json([
                'success' => true,
                'addresses' => $addesses,
                'addressCount' => $addressCount
            ]);
        }
    }

    public function userAddress(Request $request){
        $data = $request->all();

        // Validation rules
        $rules = [
            'address_id' => 'required|integer', // Corrected 'intenger' to 'integer'
        ];

        // Validate the request data
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ]);
        }

        $addressId = $data['address_id'];
        $userId = Auth::id();

        // Retrieve the address
        $address = Address::where('id', $addressId)
                          ->where('user_id', $userId)
                          ->first(); // Execute the query and get the first result

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found or not authorized'
            ]);
        }

        return response()->json([
            'success' => true,
            'address' => $address
        ]);
    }

    public function addressUpdate(Request $request){
        $data = $request->all();

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|digits:10',
            'postal_code' => 'required|digits:6',
            'locality' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string',
            'alternate_phone_number' => 'nullable|digits:10',
            'type' => 'required|in:home,work',
        ];

        // Validate the request data
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        // Validation passed, proceed with updating the address
        $addressId = $data['address_id']; // Assuming you send the address ID to update
        $userId = Auth::id();

        $address = Address::where('id', $addressId)->where('user_id', $userId)->first();

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found'
            ]);
        }

        // Update the address
        $address->name = $data['name'];
        $address->phone_number = $data['phone_number'];
        $address->postal_code = $data['postal_code'];
        $address->locality = $data['locality'];
        $address->address = $data['address'];
        $address->city = $data['city'];
        $address->state = $data['state'];
        $address->alternate_phone_number = $data['alternate_phone_number'];
        $address->type = $data['type'];

        $address->save();

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully'
        ]);
    }

    public function sort(Request $request)
{
    // Define validation rules
    $rules = [
        'column' => 'required|string|in:id,name,email,is_active,role,phone_number', // Ensure column is one of the allowed values
        'action' => 'required|in:asc,desc'
    ];

    // Validate the request data
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        // Log validation errors or handle them internally
        \Log::error('Validation failed for sorting: ', $validator->errors()->toArray());

        // Return a generic error response if needed
        return response()->json([
            'message' => 'Invalid sorting parameters',
            'success' => false
        ], 400); // HTTP status 400 for bad request
    }

    // Retrieve validated inputs
    $column = $request->input('column');
    $direction = $request->input('action');

    // Perform the sorting and paginate
    $users = User::orderBy($column, $direction)->paginate(10); // Adjust the number of items per page as needed

    return response()->json([
        'users' => $users->items(), // Return only the items for the current page
        'current_page' => $users->currentPage(),
        'last_page' => $users->lastPage(),
        'total' => $users->total(),
        'success' => true
    ]);
}


}
