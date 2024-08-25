<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{

    public function userSpecificWishlist(Request $request){
        $userId = auth()->id();
        $wishlist = WishList::where('user_id',$userId);
        return view('home.wishlist',compact('wishlist'));
    }

    public function addToWishlist(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = $request->input('product_id');
        $userId = Auth::id();

        $existingWishlistItem = Wishlist::where('user_id', $userId)
                                        ->where('product_id', $productId)
                                        ->first();

        if ($existingWishlistItem) {
            return response()->json([
                'message' => 'Product already in wishlist',
                'success' => false
            ]);
        }

        $wishlist = new Wishlist();
        $wishlist->user_id = $userId;
        $wishlist->product_id = $productId;

        if ($wishlist->save()) {
            return response()->json([
                'message' => 'Product added to wishlist',
                'success' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to add product to wishlist',
                'success' => false
            ]);
        }
    }

    public function removeFromWishlist()
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);
        $productId = $request->input('product_id');
        $userId = Auth::id();

        $wishlistItem = Wishlist::where('user_id',$userId)
                                ->where('product_id',$productId)
                                ->first();

        if($wishlistItem){
            $wishlistItem->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product Removed from Wishlist'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Product not found in wishlist'
            ]);
        }


    }



}
