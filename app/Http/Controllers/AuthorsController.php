<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorsController extends BaseController
{
	public function show()
	{
		$authors = DB::table('authors')->orderBy('name', 'asc')->get();
		
		$books_numbers = [];
		$counter = 0;
		foreach($authors as $author)
		{
			$books_numbers[$counter] = DB::table('authors_books')->where('authors_id', $author->id)->count();
			$counter++;
		}
		return view('Authors', ['authors' => $authors, 'books_numbers' => $books_numbers]);
	}
	
	public function del(Request $request)
	{
		$id = $request->input('id');
		DB::table('authors')->where('id', '=', $id)->delete();
		
		$authors = DB::table('authors')->orderBy('name', 'asc')->get();
		
		$books_numbers = [];
		$counter = 0;
		foreach($authors as $author)
		{
			$books_numbers[$counter] = DB::table('authors_books')->where('authors_id', $author->id)->count();
			$counter++;
		}
		
		return view('Authors',['authors' => $authors, 'books_numbers' => $books_numbers, 'done_message'=>'The author is successfully deleted!']);
	}
}
?>