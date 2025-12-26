<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use App\Models\StaffProfile;
use App\Models\Book;
use App\Models\Page;
use App\Models\SiteContent;
use Illuminate\View\View;

use App\Models\Menu;

class HomeController extends Controller
{
    public function index(): View
    {
        // Fetch site content as key-value pairs
        $content = SiteContent::all()->pluck('value', 'key');
        $menus = Menu::visible()->orderBy('order')->get();

        $news = NewsItem::orderBy('sort_order')->orderBy('published_date', 'desc')->take(3)->get();
        $staff = StaffProfile::orderBy('sort_order')->orderBy('id')->get();

        // Prioritize featured books, then sort order, then latest. Limit to 4.
        $books = Book::orderBy('is_featured', 'desc')->orderBy('sort_order')->latest()->take(4)->get();

        // Fetch published pages for navigation (respects scheduled publishing)
        $pages = Page::published()->topLevel()->orderBy('sort_order')->orderBy('title')->get();

        // Fetch published resources
        $resources = \App\Models\Resource::published()->ordered()->latest()->get();

        return view('welcome', compact('content', 'news', 'staff', 'books', 'menus', 'pages', 'resources'));
    }
}
