<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index(){
        $wishlist = Wishlist::all();
        return view('dashboard.wishlist',compact('wishlist'));
    }

    public function userSpecificWishlist(){
        $userId = Auth::id();
        $wishlist = WishList::where('user_id',$userId);
        return view('home.wishlist',compact('wishlist'));
    }
}
