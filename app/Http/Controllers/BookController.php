<?php

namespace App\Http\Controllers;

use App\Imports\BookImport;
use App\Models\Book;
use App\Models\BookDetail;
use App\Service\BookService;
use App\Service\IbookService;
use Illuminate\Http\Request;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    protected $BookSerivce;
    public function __construct(IbookService $BooSerivce){
        $this->BookSerivce=$BooSerivce;
    }
    public function create(Request $request){
        try {
            $Book=$request->validate([
                'title'=>'required',
                'author'=>'required',
                'create_year'=>'required',
                'amount'=>'required|integer',
            ]);
            $this->BookSerivce->create($Book,$Book['title']);

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
        $books=$this->BookSerivce->getList();
        return response()->json([
            "data"=>$books,
            "pagination" => [
                "total" => $books->total(),
                "per_page" => $books->perPage(),
                "current_page" => $books->currentPage(),
                "last_page" => $books->lastPage(),
            ],
        ]);
    }
    public function Update(Request $request)
    {
        try {
            $bookId=$request->query("bookId");
            $BookRequest=$request->validate([
                'title'=>'required',
                'author'=>'required',
                'create_year'=>'required',
                'amount'=>'required|integer',
            ]);
            $Book=$this->BookSerivce->Update($BookRequest,$bookId);
            return response()->json([
                "success"=>true,
                "message"=>"Book updated successfully",
            ],http_response_code(200));

        }catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
            ], http_response_code(500));
        }
    }

    public function search(Request $request)
    {
        $keyword=$request->query("keyword");
        $books=$this->BookSerivce->search($keyword);
        return response()->json([
            "data"=>$books,
            "pagination" => [
                "total" => $books->total(),
                "per_page" => $books->perPage(),
                "current_page" => $books->currentPage(),
                "last_page" => $books->lastPage(),
            ]
        ]);
    }
    public function filterBook(Request $request)
    {
        $title=$request->query("title");
        $author=$request->query("author");
        $book=$this->BookSerivce->filterBook($title,$author);
        return response()->json([
            "data"=>$book,
            "pagination" => [
                "total" => $book->total(),
                "per_page" => $book->perPage(),
                "current_page" => $book->currentPage(),
                "last_page" => $book->lastPage(),
            ]
        ]);
    }
    public function import(Request $request)
    {
        try {
            $book=new BookImport();
            $collection=Excel::toCollection($book, 'book.xlsx');
            Excel::import($book, $request->file('file'));
            return response()->json([
                "success" => true,
                "message" => "Book added successfully",
                "data" => $collection
            ]);
        }catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
        }

    }
}
