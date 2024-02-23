<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Auth;
use Illuminate\Http\Request;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $books = Book::orderBy('created_at', 'asc')->paginate(3);
        return view('books.index', [
            'books' => $books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'item_name' => 'required|min:3|max:255',
            'item_area' => 'required|min:1|max:10',
            'item_number' => 'required | min:1 | max:3',
            'item_amount' => 'required | max:6',
            'published'   => 'required',
          ]);
         
    
       //以下に登録処理を記述（Eloquentモデル）
   
     // Eloquentモデル
     $books = new Book;
     $books->item_name   = $request->item_name;
     $books->item_area   = $request->item_area;
     $books->item_number = $request->item_number;
     $books->item_amount = $request->item_amount;
     $books->published   = $request->published;
     $books->save(); 
     return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
        //{books}id 値を取得 => Book $books id 値の1レコード取得
        return view('books.edit', ['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
        //バリデーション
        $request->validate([
            'item_name' => 'required|min:3|max:255',
            'item_area' => 'required|min:1|max:10',
            'item_number' => 'required | min:1 | max:3',
            'item_amount' => 'required | max:6',
            'published'   => 'required',
          ]);
       
       //データ更新
       $books = Book::find($request->id);
       $books->item_name   = $request->item_name;
       $books->item_area   = $request->item_area;
       $books->item_number = $request->item_number;
       $books->item_amount = $request->item_amount;
       $books->published   = $request->published;
       $books->save();
       return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
        $book->delete();       //追加
        return redirect('/');  //追加
    }

    public function __construct()
 {
      $this->middleware('auth');
 }

}
