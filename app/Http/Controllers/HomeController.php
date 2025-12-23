<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use App\Models\StaffProfile;
use App\Models\Book;
use App\Models\SiteContent;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Fetch site content as key-value pairs
        $content = SiteContent::all()->pluck('value', 'key');

        $news = NewsItem::orderBy('sort_order')->orderBy('published_date', 'desc')->take(3)->get();
        $staff = StaffProfile::orderBy('sort_order')->orderBy('id')->get();
        $books = Book::where('status', 'available')->orderBy('sort_order')->latest()->take(6)->get();

        return view('welcome', compact('content', 'news', 'staff', 'books'));
    }
}
