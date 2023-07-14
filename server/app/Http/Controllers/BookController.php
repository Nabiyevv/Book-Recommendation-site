<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    //
    public function addBook(Request $request)
    {
        // dd($request->all());
        $validation = $request->validate([
            'title' => 'required',
            'author' => 'required | min:3',
            'category' => 'required',
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $image = $request->file('image');

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'category_id' => $request->category,
            'image' => $image->hashName(),
            'description' => $request->description,
            'link' => $request->link,
            'featured' => $request->featured ? '1' : '0',
        ]);

        Storage::putFileAs('public/images', $image, $image->hashName());
        return response()->json([
            'message' => 'Book added successfully',
        ]);
    }
    
}
