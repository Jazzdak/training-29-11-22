<?php

use App\Entity\Book;
use Symfony\Contracts\EventDispatcher\Event;

class BookEvent extends Event
{
    public function __construct(private Book $book)
    {
    }

    public function getBook()
    {
        return $this->book;
    }

    public static function getSubscribedEvents()
    {
        return [
            BookEvent::class => 'onBookEvent'
        ];
    }
}