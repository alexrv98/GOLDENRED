<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Account;
use App\Models\ProfileAssignment;
use Illuminate\Http\Request;

class AccountProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::with('account.platform')->get();
        return view('account_profiles.index', compact('profiles'));
    }

    public function create()
    {
        $accounts = Account::with('platform')->get();
        return view('account_profiles.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'name' => 'required|string|max:100',
            'status' => 'required|in:available,assigned,blocked',
            'current_holder' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'assigned_since' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        Profile::create($data);

        return redirect()->route('account-profiles.index')->with('success', 'Perfil creado correctamente.');
    }

    public function show(Profile $account_profile)
    {
        $account_profile->load('account.platform', 'assignments');
        return view('account_profiles.show', ['profile' => $account_profile]);
    }

    public function edit(Profile $account_profile)
    {
        $accounts = Account::all();
        return view('account_profiles.edit', [
            'profile' => $account_profile,
            'accounts' => $accounts,
        ]);
    }

    public function update(Request $request, Profile $account_profile)
    {
        $data = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'name' => 'required|string|max:100',
            'status' => 'required|in:available,assigned,blocked',
            'current_holder' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'assigned_since' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $account_profile->update($data);

        return redirect()->route('account-profiles.show', $account_profile)
            ->with('success', 'Perfil actualizado.');
    }

    public function destroy(Profile $account_profile)
    {
        $account_profile->delete();
        return back()->with('success', 'Perfil eliminado correctamente.');
    }

    public function byAccount(Account $account)
    {
        $profiles = $account->profiles()->get();

        return response()->json([
            'id' => $account->id,
            'profiles' => $profiles,
            'password_plain' => $account->password_plain,
            'email' => $account->email,
        ]);
    }

    public function assign(Request $request, Profile $profile)
{
    $data = $request->validate([
        'current_holder' => 'required|string|max:100',
        'telefono' => 'nullable|string|max:20',
        'assigned_since' => 'required|date',
        'notes' => 'nullable|string',
    ]);

    // Actualiza perfil
    $profile->update([
        'status' => 'assigned',
        'current_holder' => $data['current_holder'],
        'telefono' => $data['telefono'],
        'assigned_since' => $data['assigned_since'],
        'notes' => $data['notes'],
    ]);

    // Creamos el registro en historial
    $assignment = ProfileAssignment::create([
        'profile_id' => $profile->id,
        'customer_name' => $data['current_holder'],
        'telefono' => $data['telefono'],
        'sold_by_user_id' => auth()->id(),
        'type' => 'sale',
        'started_at' => $data['assigned_since'],
        'notes' => $data['notes'],
    ]);

    // 🔥 Guardar en sesión para imprimir
    session()->put('assignment_to_print', $assignment->id);

    return redirect()->back()->with('success', 'Perfil asignado correctamente y registrado en historial.');
}


    public function unassign(Profile $profile)
    {
        $profile->update([
            'status' => 'available',
            'current_holder' => null,
            'telefono' => null,
            'assigned_since' => null,
            'notes' => null,
        ]);

        $assignment = ProfileAssignment::where('profile_id', $profile->id)
            ->whereNull('ended_at')
            ->latest()
            ->first();

        if ($assignment) {
            $assignment->update([
                'ended_at' => now(),
                'type' => 'release',
                'sold_by_user_id' => auth()->id(),
                'notes' => 'Perfil liberado',
            ]);
        }

        return redirect()->back()->with('success', 'Perfil desasignado y registrado en historial.');
    }
}
