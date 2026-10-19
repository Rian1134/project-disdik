<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    private const UKURAN = 400; // sisi logo (px), hasil persegi

    private const FOLDER = 'storage/uploads/logo'; // relatif terhadap folder public

    /**
     * Halaman profil (hanya tampilan).
     */
    public function index(Request $request)
    {
        return view('user.profile.index', ['user' => $request->user()]);
    }

    /**
     * Halaman form edit: logo, data akun, dan password.
     */
    public function edit(Request $request)
    {
        return view('user.profile.edit', ['user' => $request->user()]);
    }

    /**
     * Update nama, email, dan password (password boleh dikosongkan).
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'current_password' => ['required_with:password', 'nullable', 'current_password'],
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ], [], [
            'name' => 'Nama',
            'email' => 'Email',
            'current_password' => 'Password saat ini',
            'password' => 'Password baru',
        ]);

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (! empty($data['password'])) {
            $payload['password'] = $data['password']; // di-hash otomatis oleh cast 'hashed'
        }

        $user->update($payload);

        return redirect()->route('user.profile.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Upload logo: crop persegi, resize, simpan sebagai webp di public/uploads/logo.
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [], ['logo' => 'Logo']);

        $user = $request->user();
        $this->hapusFile($user->logo);

        $folder = public_path(self::FOLDER);
        $nama = 'logo-'.$user->id.'-'.time().'.webp';

        File::ensureDirectoryExists($folder);
        $this->simpanWebp($request->file('logo')->getPathname(), $folder.DIRECTORY_SEPARATOR.$nama);

        $user->update(['logo' => $nama]);

        return back()->with('success', 'Logo berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $this->hapusFile($user->logo);
        $user->update(['logo' => null]);

        return back()->with('success', 'Logo berhasil dihapus.');
    }

    /**
     * Crop persegi dari tengah, resize, simpan sebagai webp.
     */
    private function simpanWebp(string $sumber, string $tujuan): void
    {
        [$w, $h, $tipe] = getimagesize($sumber);

        $gambar = match ($tipe) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($sumber),
            IMAGETYPE_PNG => imagecreatefrompng($sumber),
            IMAGETYPE_WEBP => imagecreatefromwebp($sumber),
        };

        $sisi = min($w, $h);
        $kanvas = imagecreatetruecolor(self::UKURAN, self::UKURAN);
        imagealphablending($kanvas, false);
        imagesavealpha($kanvas, true);

        imagecopyresampled(
            $kanvas, $gambar,
            0, 0, intdiv($w - $sisi, 2), intdiv($h - $sisi, 2),
            self::UKURAN, self::UKURAN, $sisi, $sisi
        );

        imagewebp($kanvas, $tujuan, 80);
    }

    private function hapusFile(?string $nama): void
    {
        if ($nama) {
            File::delete(public_path(self::FOLDER.'/'.$nama));
        }
    }
}
