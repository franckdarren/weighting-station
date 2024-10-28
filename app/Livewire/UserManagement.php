<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    public $name, $email, $code, $password, $role;
    public $users;
    public $selectedUserId = null; // Pour stocker l'ID de l'utilisateur en cours d'édition
    public $status;
    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:20',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:4',
        'role' => 'required',
        'status' => 'required|in:Actif,Désactivé,Suspendu',
    ];

    public function mount()
    {
        $this->users = User::with('roles')->get();
    }

    public function createUser()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'code' => $this->code,
            'password' => Hash::make($this->password),
            'status' => $this->status,
        ]);

        $user->assignRole($this->role);

        $this->users = User::with('roles')->get();
        $this->reset(['name', 'email', 'code', 'password', 'status', 'role']);
        session()->flash('message', 'Utilisateur créé avec succès.');
    }

    public function editUser($userId)
    {
        $user = User::findOrFail($userId);

        // Pré-remplir les champs avec les informations de l'utilisateur
        $this->selectedUserId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->code = $user->code;
        $this->role = $user->roles->first()->name ?? null;
        $this->status = $user->status;
    }

    public function updateUser()
    {
        // Validation en prenant en compte l'ID de l'utilisateur en cours
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $this->selectedUserId,
            'password' => 'nullable|min:4', // Rendre le mot de passe optionnel lors de la mise à jour
            'role' => 'required',
            'status' => 'required|in:Actif,Désactivé,Suspendu',
        ]);

        $user = User::findOrFail($this->selectedUserId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'code' => $this->code,
            'password' => $this->password ? Hash::make($this->password) : $user->password,
            'status' => $this->status,
        ]);

        $user->syncRoles([$this->role]);

        $this->users = User::with('roles')->get();
        $this->reset(['name', 'email', 'code', 'password', 'role', 'status', 'selectedUserId']);
        session()->flash('message', 'Utilisateur mis à jour avec succès.');
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'code', 'password', 'role', 'selectedUserId']);
    }

    public function confirmDelete($userId)
    {
        $this->dispatchBrowserEvent('confirm-delete', [
            'id' => $userId,
            'message' => 'Êtes-vous sûr de vouloir supprimer cet utilisateur ?'
        ]);
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->delete(); // Suppression avec soft delete
            $this->users = User::with('roles')->get(); // Rafraîchit la liste des utilisateurs
            session()->flash('message', 'Utilisateur supprimé avec succès.');
        }
    }


    public function render()
    {
        $roles = Role::all();
        return view('livewire.user-management', compact('roles'));
    }
}
