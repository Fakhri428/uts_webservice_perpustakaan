<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\EnsureUserRole;
use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return response()->json(Loan::with('book','user')->paginate(15));
        }

        return response()->json(Loan::with('book','user')->where('user_id', $user->id)->paginate(15));
    }

    public function store(Request $request)
    {
        $data = $request->only(['book_id','user_id','borrowed_at','due_at']);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $validator = Validator::make($data, [
            'book_id' => 'required|exists:books,id',
            'user_id' => 'nullable|exists:users,id',
            'borrowed_at' => 'nullable|date',
            'due_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $book = Book::findOrFail($data['book_id']);

        if ($book->stock <= 0) {
            return response()->json(['message' => 'Book out of stock'], 400);
        }

        // default to authenticated user
        $data['user_id'] = $data['user_id'] ?? $user->id;

        $loan = Loan::create(array_merge($data, ['borrowed_at' => $data['borrowed_at'] ?? now(), 'status' => 'borrowed']));

        // decrement stock
        $book->decrement('stock');

        return response()->json($loan, 201);
    }

    public function show($id)
    {
        $loan = Loan::with('book','user')->findOrFail($id);

        $user = Auth::user();
        if ($user->role !== 'admin' && $loan->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($loan);
    }

    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        $user = Auth::user();
        if ($user->role !== 'admin' && $loan->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->only(['returned_at','status','due_at']);

        $loan->update($data);

        if (!empty($data['returned_at'])) {
            // increment book stock when returned
            $loan->book->increment('stock');
            $loan->status = $data['status'] ?? 'returned';
            $loan->save();
        }

        return response()->json($loan);
    }

    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->delete();

        return response()->json(['message' => 'Loan deleted']);
    }
}
