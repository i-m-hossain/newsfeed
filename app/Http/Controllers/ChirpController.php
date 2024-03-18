<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChirpRequest;
use App\Models\Chirp;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;

use Illuminate\View\View;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // return response('hello world');
        return view("chirps.index", [
            'chirps'=> Chirp::with('user')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChirpRequest $request)
    {
        $message = $request->message;
        $request->user()->chirps()->create(["message" => $message]);
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp):View
    {
        $this->authorize('update', $chirp);
        return view('chirps.edit')->with(['chirp'=>$chirp]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChirpRequest $request, Chirp $chirp):RedirectResponse
    {
        $this->authorize('update', $chirp);

        $chirp->update(['message'=>$request->message]);
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp):RedirectResponse
    {
        $this->authorize('delete', $chirp);
        $chirp->delete();
        return redirect(route("chirps.index"));
    }
}
