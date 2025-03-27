<?php

namespace App\Repository;

use App\Models\Book;

class BookRepository
{

    public function getAll()
    {
        return Book::with("bookDetails")->paginate(10);

    }
    public function findById(int $id): ?Book
    {
        return Book::find($id);
    }
    public function getBookByTitle($title):?Book
    {
        return Book::with("bookDetails")->where('title',$title)->first();
    }
    public function getBookByKeyword($keyword)
    {
        return Book::with("bookDetails")->where('title','like','%'.$keyword.'%')->paginate(10);
    }
    public function getBookByFilter($title,$author){
        return Book::with("bookDetails")->where('title',$title)->where('author',$author)->paginate(10);
    }
    public function create(array $data): Book
    {
        return Book::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $book = $this->findById($id);

        if ($book) {
            return $book->update($data);
        }

        return false;
    }
    public function delete(int $id): ?bool
    {
        $book = $this->findById($id);

        if ($book) {
            return $book->delete();
        }

        return false;
    }
}
