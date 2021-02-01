<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\DB;


//use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;


class BooksController extends BaseController
{
	public function show()
	{
		$books = DB::table('books')->orderBy('title', 'asc')->get();
		$counter = 0;
		//$authors_id = [];
		$authors = [];
		foreach($books as $book)
		{
			$authors[$counter] = DB::table('authors')
				->where('books_id', $book->id)
				->join('authors_books','authors_books.authors_id','=','authors.id')
				->get();
			$counter++;
		}

		$authors_list = DB::table('authors')->orderBy('name', 'asc')->get();
		
		return view('Books', ['books' => $books, 'authors' => $authors, 'authors_list' => $authors_list]);
	}
	
	public function del(Request $request)
	{
		$id = $request->input('id');
		DB::table('books')->where('id', '=', $id)->delete();				//удаление книги
		DB::table('authors_books')->where('books_id', '=', $id)->delete();	//удаление связей книги с написавшими её авторами
		
		//обновление страницы с удаленной книгой и показ сообщения об успешном удалении
		$books = DB::table('books')->orderBy('title', 'asc')->get();
		$counter = 0;
		$authors_id = [];
		$authors = [];
		foreach($books as $book)
		{
			$authors[$counter] = DB::table('authors')
				->where('books_id', $book->id)
				->join('authors_books','authors_books.authors_id','=','authors.id')
				->get();
			$counter++;
		}
		$authors_list = DB::table('authors')->orderBy('name', 'asc')->get();
		return view('Books', ['books' => $books, 'authors' => $authors, 'done_message'=>'The book is successfully deleted!', 'authors_list' => $authors_list]);
	}
	
	public function showWithFilter(Request $request)
	{
		$aut_id = $request->input('aut_id');
		$books = DB::table('books')
			->orderBy('title', 'asc')
			->join('authors_books','authors_books.books_id','=','books.id')
			->where('authors_books.authors_id', $aut_id)
			->get();
		$counter = 0;
		$authors = [];
		foreach($books as $book)
		{
			$authors[$counter] = DB::table('authors')
				->where('books_id', $book->id)
				->join('authors_books','authors_books.authors_id','=','authors.id')
				->get();
			$counter++;
		}
		$authors_list = DB::table('authors')->orderBy('name', 'asc')->get();
		return view('Books', ['books' => $books, 'authors' => $authors, 'authors_list' => $authors_list]);
	}
}
?>