<?php

namespace App\Http\Controllers;

use App\Models\SavedReceiver;
use Illuminate\Http\Request;

class SavedReceiverController extends Controller
{
    
  public function index()
  {
      $receivers = \App\Models\SavedReceiver::latest()->get();

      return view('saved-receivers.index', compact('receivers'));
  }


    public function create()
    {
        return view('saved-receivers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|min:6|max:34',
            'nickname' => 'nullable|string|max:100',
        ]);

        $request->user()->savedReceivers()->create($data);

        return redirect()->route('saved-receivers.index')
            ->with('success', 'Receiver added successfully!');
    }

    public function edit(Request $request, $id)
    {
        $receiver = $request->user()
            ->savedReceivers()
            ->findOrFail($id);

        return view('saved-receivers.edit', compact('receiver'));
    }

    public function update(Request $request, $id)
    {
        $receiver = $request->user()
            ->savedReceivers()
            ->findOrFail($id);

        $data = $request->validate([
            'receiver_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'nullable|string|min:6|max:34',
            'nickname' => 'nullable|string|max:100',
        ]);

        if (empty($data['account_number'])) {
            unset($data['account_number']);
        }

        $receiver->update($data);

        return redirect()->route('saved-receivers.index')
            ->with('success', 'Receiver updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $receiver = $request->user()
            ->savedReceivers()
            ->findOrFail($id);

        $receiver->delete();

        return redirect()->route('saved-receivers.index')
            ->with('success', 'Receiver deleted successfully!');
    }
}
