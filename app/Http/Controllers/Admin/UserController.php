<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Daftar user + pencarian nama/email.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $users = User::with('roles')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q'));
    }

    /**
     * Form tambah user.
     */
    public function create()
    {
        return view('admin.users.create', [
            'user' => new User(),
            'roles' => $this->roles(),
            'currentRole' => null,
        ]);
    }

    /**
     * Simpan user baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules(), [], $this->labels());

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'], // di-hash otomatis oleh cast 'hashed'
        ]);

        $this->simpanRole($user, $data['role'] ?? null);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Detail user.
     */
    public function show(User $user)
    {
        $user->load('roles');
        $jumlahSekolah = Sekolah::where('user_id', $user->id)->count();

        return view('admin.users.show', compact('user', 'jumlahSekolah'));
    }

    /**
     * Form edit user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $this->roles(),
            'currentRole' => $user->roles()->first()?->name,
        ]);
    }

    /**
     * Perbarui user. Password boleh dikosongkan (tidak diubah).
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate($this->rules($user), [], $this->labels());

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (! empty($data['password'])) {
            $payload['password'] = $data['password'];
        }

        $user->update($payload);
        $this->simpanRole($user, $data['role'] ?? null);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user.
     * Tabel sekolahs memakai onDelete('cascade') ke users, jadi menghapus user
     * yang masih punya sekolah akan ikut menghapus data sekolah tersebut.
     * Karena itu penghapusan diblokir sampai datanya dipindahkan/dihapus.
     */
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun yang sedang dipakai login.');
        }

        if (Sekolah::where('user_id', $user->id)->exists()) {
            return back()->with('error', "User {$user->name} masih memiliki data sekolah, jadi tidak bisa dihapus.");
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    private function rules(?User $user = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'password' => [$user ? 'nullable' : 'required', 'confirmed', Password::min(8)],
            'role' => ['nullable', 'string', Rule::exists('roles', 'name')],
        ];
    }

    private function labels(): array
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role',
        ];
    }

    private function roles()
    {
        return Role::orderBy('name')->pluck('name');
    }

    private function simpanRole(User $user, ?string $role): void
    {
        $user->syncRoles($role ? [$role] : []);
    }
}
