<?php

namespace App\Service;

use App\Models\Book;
use App\Repository\BookDetailRepository;
use App\Repository\BookRepository;
use Illuminate\Support\Collection;
use mysql_xdevapi\Exception;

class BookService implements IbookService
{
    protected $bookRepository;
    protected $BookDetailRepository;
    public function __construct(BookRepository $book,BookDetailRepository $BookDetailRepository)
    {
        $this->bookRepository = $book;
        $this->BookDetailRepository = $BookDetailRepository;
    }

    public function create($book,$title)
    {
        $BookItem=$this->bookRepository->getBookByTitle($title);
        if($BookItem!=null){
            $bookDetail=[
                'book_id'=>$BookItem->id,
                'Day_set'=>now(),
                'amount_set'=>$book["amount"],
            ];
            $BookItem->amount+=$book["amount"];
            $BookItem->save();
            $this->BookDetailRepository->create($bookDetail);
        }
        $NewBook= $this->bookRepository->create($book);
        $NewBookDetail=[
            'book_id'=>$NewBook->id,
            'Day_set'=>now(),
            'amount_set'=>$book["amount"],
        ];
        $this->BookDetailRepository->create($NewBookDetail);
    }

    public function getList()
    {
        return $this->bookRepository->getAll();
    }

    public function update($book, $bookId)
    {
        $BookItem=$this->bookRepository->findById($bookId);
        if($BookItem==null){
            throw new Exception("not found Book");
        }
        $DataUpdate=[
            'title'=>$book['title'],
            'author'=>$book['author'],
            'create_year'=>$book['create_year'],
        ];
        $user=$this->bookRepository->update($BookItem->id,$DataUpdate);
        if ($user==false) throw new Exception("update fail");
        return $user;
    }

    public function search($keyword)
    {
        return $this->bookRepository->getBookByKeyword($keyword);
    }

    public function filterBook($title,$author)
    {
        return $this->bookRepository->getBookByFilter($title,$author);
    }
}
