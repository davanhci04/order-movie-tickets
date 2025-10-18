<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMovieController extends Controller
{
    protected $cloudinaryService;

    public function __construct(CloudinaryService $cloudinaryService)
    {
        $this->cloudinaryService = $cloudinaryService;
    }

    /**
     * Display a listing of movies.
     */
    public function index()
    {
        $movies = Movie::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    /**
     * Show the form for creating a new movie.
     */
    public function create()
    {
        return view('admin.movies.create');
    }

    /**
     * Store a newly created movie in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'poster_url' => 'nullable|url',
            'poster_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240', // 10MB max
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'genre' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'director' => 'nullable|string|max:255',
        ]);

        // Check file size and provide feedback
        if ($request->hasFile('poster_file')) {
            $file = $request->file('poster_file');
            $fileSizeInMB = $file->getSize() / 1024 / 1024;
            
            if ($fileSizeInMB > 10) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['poster_file' => 'File quá lớn (' . round($fileSizeInMB, 1) . 'MB). Kích thước tối đa là 10MB.']);
            }
            
            if ($fileSizeInMB > 5) {
                session()->flash('warning', 'File hình ảnh khá lớn (' . round($fileSizeInMB, 1) . 'MB). Đang xử lý...');
            }
        }

        // Handle poster upload
        $posterUrl = $validated['poster_url'] ?? null;
        $cloudinaryPublicId = null;

        if ($request->hasFile('poster_file')) {
            $uploadResult = $this->cloudinaryService->uploadPoster($request->file('poster_file'));
            
            if ($uploadResult['success']) {
                $posterUrl = $uploadResult['url'];
                $cloudinaryPublicId = $uploadResult['public_id'];
            } else {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['poster_file' => 'Lỗi khi upload ảnh: ' . $uploadResult['error']]);
            }
        }

        // Remove poster_file from validated data and add processed poster_url
        unset($validated['poster_file']);
        $validated['poster_url'] = $posterUrl;
        $validated['cloudinary_public_id'] = $cloudinaryPublicId;

        Movie::create($validated);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Phim đã được tạo thành công!');
    }

    /**
     * Display the specified movie.
     */
    public function show(Movie $movie)
    {
        return view('admin.movies.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified movie.
     */
    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    /**
     * Update the specified movie in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'poster_url' => 'nullable|url',
            'poster_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
            'release_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'genre' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'director' => 'nullable|string|max:255',
        ]);

        // Handle poster upload
        $posterUrl = $validated['poster_url'] ?? $movie->poster_url;
        $cloudinaryPublicId = $movie->cloudinary_public_id;

        if ($request->hasFile('poster_file')) {
            // Delete old poster from Cloudinary if exists
            if ($movie->cloudinary_public_id) {
                $this->cloudinaryService->deletePoster($movie->cloudinary_public_id);
            }

            $uploadResult = $this->cloudinaryService->uploadPoster($request->file('poster_file'));
            
            if ($uploadResult['success']) {
                $posterUrl = $uploadResult['url'];
                $cloudinaryPublicId = $uploadResult['public_id'];
            } else {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['poster_file' => 'Lỗi khi upload ảnh: ' . $uploadResult['error']]);
            }
        }

        // Remove poster_file from validated data and add processed poster_url
        unset($validated['poster_file']);
        $validated['poster_url'] = $posterUrl;
        $validated['cloudinary_public_id'] = $cloudinaryPublicId;

        $movie->update($validated);

        return redirect()->route('admin.movies.index')
            ->with('success', 'Phim đã được cập nhật thành công!');
    }

    /**
     * Remove the specified movie from storage.
     */
    public function destroy(Movie $movie)
    {
        // Delete poster from Cloudinary if exists
        if ($movie->cloudinary_public_id) {
            $this->cloudinaryService->deletePoster($movie->cloudinary_public_id);
        }

        $movie->delete();

        return redirect()->route('admin.movies.index')
            ->with('success', 'Phim đã được xóa thành công!');
    }
}
