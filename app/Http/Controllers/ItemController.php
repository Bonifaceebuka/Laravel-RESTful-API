<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Item;
use App\Http\Resources\ItemCollection;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
    public function index()
    {
        $categories = Item::OrderBy('item_name','ASC')->groupBy('category')->get('category');        
        return view('index',['categories'=>$categories]);
    }
    public function list_items()
    {
        $items = Item::get();
        return new ItemCollection($items);
    }
    public function category($category)
    {
        $categories = Item::OrderBy('item_name','ASC')->groupBy('category')->get('category');
        $items = Item::where('category',$category)->get();
        return view('category',['categories'=>$categories,'items'=>$items,'category'=>$category]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Item::OrderBy('item_name','ASC')->groupBy('category')->get('category');        
        return view('create',['items'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                //
         $validator =  Validator::make($request->all(), [
            'item_name' => 'required|string|max:255', 
            'category' => 'required|string|max:255', 
            'available_unit' => 'required|int', 
            'unit_price' => 'required|int', 
            'normal_price'=> 'required|int'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => 'validation_error',
                "message" => $validator->errors(),
            ], 280);
        }

        $item = new Item([
            'item_name'=> $request->item_name, 
            'category'=> $request->category, 
            'available_unit'=> $request->available_unit, 
            'unit_price'=> $request->unit_price, 
            'normal_price'=> $request->normal_price
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
    public function cart($id)
    {
      $item = Item::find($id);
      $categories = Item::OrderBy('item_name','ASC')->groupBy('category')->get('category');        
      return view('cart',['item'=>$item,'categories'=>$categories]);
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            $item_detail = Item::findOrfail($id);
        if ($item_detail !=null) {
            $item_authors = explode(',',$item_detail->authors);
            $total_authors = count($item_authors);
            $authors = [];
            foreach ($item_authors as $author) {
                $authors[] = $author;
            }
            // return $item_authors;
             return response()->json([
                    'status_code'=> 200,
                    'status_message'=> 'suceess',
                    'data'=>[
                                'item'=>[
                                            'id'=>$item_detail->id,
                                            'name'=>$item_detail->name,
                                            'isbn'=>$item_detail->isbn,
                                            'authors'=>[
                                                        $authors
                                                        ],
                                            'number_of_pages'=>$item_detail->number_of_pages,
                                            'publisher'=>$item_detail->publisher,
                                            'country'=>$item_detail->country,
                                            'release_date'=>$item_detail->release_date

                                        ]
                            ]
                    ],201);
        }
        else{
            return response()->json([
                    'message'=> 'Invalid Item ID'
                ]);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        if($item != null){
            return response()->json([
                'status_code'=>200,
                'status_message'=>'success',
                'data'=>[
                    'unit_price'=>$item->unit_price,
                    'item_name'=>$item->item_name,
                    'id'=>$item->id
                ]
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator =  Validator::make($request->all(), [
            'unit_price' => 'required|int'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "error" => 'validation_error',
                "message" => $validator->errors(),
            ], 280);
        }
        $item_detail = Item::findOrfail($id);
        if ($item_detail != null) {
            $item_detail->unit_price = $request->unit_price;
            // return $item_authors;
            if ($item_detail->save()) {
                return response()->json([
                    'status_code'=> 200,
                    'status_message'=> 'suceess',
                    'message'=>$item_detail->item_name.' was updated successfully',
                    ]);
        }
        else{
            response()->json([
                'message'=> 'We are unable to save your requests'
                ],501);
        }
        }
        else{
            return response()->json([
                    'message'=> 'Invalid Item ID'
                ],501);
        }
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        if ($item !=null) {
            $item->delete();
                return response()->json([
                        'status_code'=>204,
                        'status'=>'success',
                        'message'=>'The item '.$item->name.' was deleted successfully',
                        'data'=>[]
                    ]);
        }else{
            return response()->json([
                    'message'=> 'Invalid Item ID'
                ]);
        }
    }
}
