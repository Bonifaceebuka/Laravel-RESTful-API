<?php

namespace App\Http\Controllers;
use App\Models\Purchase;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
class PurchaseController extends Controller
{
    public function index(){
        $purchases = Purchase::OrderBy('profit','DESC')->get();
        $categories = Item::OrderBy('category','ASC')->groupBy('category')->get('category');        
        return view('purchases',['purchases'=>$purchases,'categories'=>$categories]);
    }
    public function category(){
        $purchases = DB::select('SELECT sum(purchases.profit) as profit,
        sum(purchases.total_price) as amount_paid,
         items.category FROM items, purchases WHERE 
        purchases.item_id = items.id GROUP BY items.category;');
        // return $purchases;
        $categories = Item::OrderBy('category','ASC')->groupBy('category')->get('category');        
        return view('purchases-category',['purchases'=>$purchases,'categories'=>$categories]);
    }
    public function buy(Request $request,$id)
    {
                //
         $validator =  Validator::make($request->all(), [
            'quantity' => 'required|int', 
            'total_price' => 'required|int', 
            'payment_type' => 'required|string', 
            'buyer_name'=> 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => 'validation_error',
                "message" => $validator->errors(),
            ], 280);
        }
        ///calculation of the profit made from the purchase
        $item = Item::find($id);
        $unit_price = $item->unit_price;
        $total_unit_price = $unit_price * $request->quantity; //total unit price of the purchase
        ////find the profit
        $profit = $request->total_price - $total_unit_price;
        $item = new Purchase([
            'item_id' =>$id,
            'quantity' =>$request->quantity,
            'total_price' =>$request->total_price,
            'payment_type' =>$request->payment_type,
            'buyer_name'=>$request->buyer_name,
            'profit'=>$profit
            ]);
        // return $item_authors;
        if ($item->save()) {
            return response()->json([
                'status_code'=> 200,
                'status_message'=> 'suceess',
                ],201);
        }
        else{
            response()->json([
                'message'=> 'We are unable to save your requests'
                ],501);
        }
    }
}
