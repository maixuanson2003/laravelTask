<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookDetail;
use Illuminate\Http\Request;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;

class BookController extends Controller
{
    public function create(Request $request){
        try {
            $Request=$request->all();
            $BookFind=Book::with("bookDetails")->where('title',$Request['title'])->first();
            if($BookFind!=null){
                $bookdetail=BookDetail::create([
                    'book_id'=>$BookFind->id,
                    'Day_set'=>now(),
                    'amount_set'=>$request['amount'],
                ]);
                $BookFind->amount+=$request['amount'];
                $BookFind->save();
                return response()->json([
                    "success"=>true,
                    "message"=>"Book added successfully",
                ]);
            }
            $Book=$request->validate([
                'title'=>'required',
                'author'=>'required',
                'create_year'=>'required',
                'amount'=>'required|integer',
            ]);
            echo $Book['amount'];
            $NewBook=Book::create([
                'title'=>$Book['title'],
                'author'=>$Book['author'],
                'create_year'=>$Book['create_year'],
                'amount'=>$Book['amount'],
            ]);
            $bookdetail=BookDetail::create([
                'book_id'=>$NewBook->id,
                'Day_set'=>now(),
                'amount_set'=>$request['amount'],
            ]);
            return response()->json([
                "success"=>true,
                "message"=>"Book added successfully",
            ]);
        }catch (\Exception $e){
            $log=new IncomingEntry([
                "Message" =>$e->getMessage(),
                "File" =>$e->getFile(),
                "Line" =>$e->getLine(),
            ]);
            Telescope::recordLog($log);
            return response()->json([
                "success"=>false,
                 "message"=>$e->getMessage(),
                "Line" =>$e->getLine(),

            ]);
        }
    }
    public function getList(){
        $books=Book::with("bookDetails")->get();
        return response()->json([
            "data"=>$books,
        ]);
    }
}
