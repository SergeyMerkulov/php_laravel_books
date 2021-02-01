<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddEditBooksController extends Controller
{
	public function showToEdit(Request $request)
	{
		$id = $request->input('id');
		$title = $request->input('title');
		$date = $request->input('date');
		$selected_authors = explode( ",", $request->input('selected_authors') );
		$authors = DB::table('authors')->get();
		return view('add_edit_books',[ 'id'=>$id, 'title'=>$title, 'date'=>$date, 'authors'=>$authors, 'selected_authors'=>$selected_authors ]);
	}
	
	public function show(Request $request)
	{
		$aut = $request->input('authors');
		$books = DB::table('books')->get();
		$authors = DB::table('authors')->get();
		return view('add_edit_books', ['books' => $books, 'authors' => $authors, 'aut' => $aut ] );
	}
	public function add(Request $request)
	{
		//проверка введенных данных
		$this->validate($request, [
			'book_title' => 'required',
			'book_date' => 'required|date',
			'authors' => 'required'
		]);
		//добавление
		$aut = $request->input('authors');
		$title = $request->input('book_title');
		$date = $request->input('book_date');
		$book_id = DB::table('books')->insertGetId(
			['title' => $title, 'date' => $date]
		);
		foreach($aut as $id)
		{
			DB::table('authors_books')->insert(
				['authors_id' => $id, 'books_id' => $book_id]
			);
		}
		//показ страницы с книгами
		$books = DB::table('books')->orderBy('title', 'asc')->get();
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
		return view('Books', ['books' => $books, 'authors' => $authors, 'authors_list' => $authors_list, 'done_message'=>'The book is successfully added!']);
	}
	public function edit(Request $request)
	{	
		//проверка введенных данных
		$this->validate($request, [
			'book_title' => 'required',
			'book_date' => 'required|date',
			'authors' => 'required'
		]);
		//редактирование
		$book_id = $request->input('id');
		$aut = $request->input('authors');
		$title = $request->input('book_title');
		$date = $request->input('book_date');
		DB::table('books')->where('id', $book_id)->update(['title' => $title, 'date' => $date]);	//обновление книги
		DB::table('authors_books')->where('books_id', '=', $book_id)->delete();	//удаление связей книги с написавшими её авторами
		foreach($aut as $aut_id)	//установка связей книги с написавшими её авторами
		{
			DB::table('authors_books')->insert(
				['authors_id' => $aut_id, 'books_id' => $book_id]
			);
		}
		//показ страницы с книгами
		$books = DB::table('books')->orderBy('title', 'asc')->get();
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
		return view('Books', ['books' => $books, 'authors' => $authors, 'authors_list' => $authors_list, 'done_message'=>'The book is successfully edited!']);
	}
}
?>