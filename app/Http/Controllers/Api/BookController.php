<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\EnsureUserRole;
use App\Models\Book;
use App\Services\GroqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    protected GroqService $groq;

    public function __construct(GroqService $groq)
    {
        $this->groq = $groq;

        // require auth for mutating actions, allow public index/show/recommend
        $this->middleware('auth:sanctum')->except(['index','show','recommend']);

        // only admin can create/update/delete books
        $this->middleware(EnsureUserRole::class . ':admin')->only(['store','update','destroy']);
    }

    public function index(Request $request)
    {
        return response()->json(Book::paginate(15));
    }

    public function store(Request $request)
    {
        $data = $request->only(['title','author','description','category','published_year','isbn','stock']);

        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'published_year' => 'nullable|integer',
            'isbn' => 'nullable|string|max:100',
            'stock' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $book = Book::create($data);

        return response()->json($book, 201);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $data = $request->only(['title','author','description','category','published_year','isbn','stock']);

        $book->update($data);

        return response()->json($book);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Book deleted']);
    }

    /**
     * Recommend books using Groq AI. Accepts 'query' (title or category).
     */
    public function recommend(Request $request)
    {
        $query = $request->input('query');

        $catalog = Book::limit(10)->get()->map(function ($b) {
            return "- {$b->title} by {$b->author} (category: {$b->category})";
        })->implode("\n");

        $system = "You are a helpful library recommender. Use the library catalog to suggest 5 relevant books or general recommendations when not available in catalog.";

        $user = "User query: {$query}\n\nCatalog:\n{$catalog}\n\nProvide short list of 5 recommended titles with brief reason each.";

        $result = $this->groq->chatWithContext($system, $user);

        return response()->json($result);
    }
}
