<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    protected $pages = [
        'about'   => 'About Us',
        'contact' => 'Contact',
        'privacy' => 'Privacy Policy',
        'terms'   => 'Terms of Service',
    ];

    public function index()
    {
        $pages = [];
        foreach ($this->pages as $slug => $title) {
            $page = Page::where('slug', $slug)->first();
            $pages[$slug] = [
                'title'   => $title,
                'content' => $page->content ?? '',
                'exists'  => (bool) $page,
            ];
        }
        return view('admin.pages.index', compact('pages'));
    }

    public function edit($slug)
    {
        if (!array_key_exists($slug, $this->pages)) {
            abort(404);
        }
        $page    = Page::where('slug', $slug)->first();
        $title   = $this->pages[$slug];
        $content = $page->content ?? '';
        return view('admin.pages.edit', compact('slug', 'title', 'content'));
    }

    public function update($slug, \Illuminate\Http\Request $request)
    {
        if (!array_key_exists($slug, $this->pages)) {
            abort(404);
        }
        $request->validate(['content' => 'required|string']);

       Page::updateOrCreate(
        ['slug' => $slug],
        ['title' => $this->pages[$slug], 'content' => $request->input('content')]
    );

        return redirect()->route('admin.pages.index')
            ->with('success', $this->pages[$slug] . ' updated successfully.');
    }
}
