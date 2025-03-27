<?php

namespace App\Service;

interface IbookService
{

    public function create($book,$title);

    public function getList();

    public function update($book,$bookId);

    public function search($keyword);

    public function filterBook($title,$author);
}
