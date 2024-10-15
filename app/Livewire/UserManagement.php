<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserManagement extends Component
{
    public $name, $email, $code, $password, $role;
    public $users; // Propriété pour stocker les utilisateurs

    protected $rules = [
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:20',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:4',
        'role' => 'required',
    ];

    public function mount()
    {
        // Initialiser les utilisateurs lors du montage du composant
        $this->users = User::with('roles')->get();
    }

    public function createUser()
    {
        $this->validate();

        // Créer l'utilisateur
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'code' => $this->code,
            'password' => Hash::make($this->password),
        ]);

        // Assigner le rôle
        $user->assignRole($this->role);

        // Mettre à jour la liste des utilisateurs après création
        $this->users = User::with('roles')->get();

        // Réinitialiser le formulaire
        $this->reset(['name', 'email', 'code', 'password', 'role']);

        // Afficher un message de succès
        session()->flash('message', 'Utilisateur créé avec succès.');
    }

    public function render()
    {
        $roles = Role::all(); // Obtenir tous les rôles

        // Retourner la vue sans utiliser 'compact' pour 'users' car c'est une propriété publique
        return view('livewire.user-management', compact('roles'));
    }
}
