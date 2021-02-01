<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AddEditAuthorsController extends Controller
{
	public function show(Request $request)
	{
		$id = intval($request->input('id'));
		$name = DB::table('authors')->where('id', $id)->value('name');
		return view('add_edit_authors',['id'=>$id,'name'=>$name]);
	}
	public function add(Request $request)
	{
		//проверка введенного имени
		$this->validate($request, [
			'name' => 'required|regex:/^[\pL\s\-]+$/u'
		]);
		//добавление автора
		$name = $request->input('name');
		DB::table('authors')->insert(
			['name' => $name]
		);
		//показ авторов с выводом сообщения об успешном добавлении
		$authors = DB::table('authors')->orderBy('name', 'asc')->get();
		$books_numbers = [];
		$counter = 0;
		foreach($authors as $author)
		{
			$books_numbers[$counter] = DB::table('authors_books')->where('authors_id', $author->id)->count();
			$counter++;
		}
		return view('Authors', ['authors' => $authors, 'books_numbers' => $books_numbers, 'done_message'=>'The author is successfully added!']);
	}
	public function edit(Request $request)
	{
		//проверка введенного имени
		$this->validate($request, [
			'name' => 'required|regex:/^[\pL\s\-]+$/u'
		]);
		//редактирование автора
		$id = intval( $request->input('id') );
		$name = $request->input('name');
		DB::table('authors')->where('id', $id)->update(['name' => $name]);
		//показ авторов с выводом сообщения об успешном редактировании
		$authors = DB::table('authors')->orderBy('name', 'asc')->get();
		$books_numbers = [];
		$counter = 0;
		foreach($authors as $author)
		{
			$books_numbers[$counter] = DB::table('authors_books')->where('authors_id', $author->id)->count();
			$counter++;
		}
		return view('Authors', ['authors' => $authors, 'books_numbers' => $books_numbers, 'done_message'=>'The author is successfully saved!']);
	}
}
?>