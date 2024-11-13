<?php
namespace App\Http\Controllers;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['pasien'] = \App\Models\Pasien::latest()->paginate(10);
        return view('pasien_index', $data);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create_pasien');

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'no_pasien' => 'required|unique:pasiens,no_pasien',
            'nama' => 'required|min:3',
            'umur' => 'required|numeric',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'alamat' => 'nullable',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5000',
        ]);
        $pasien = new \App\Models\Pasien();
        $pasien->fill($requestData);
        $pasien->foto = $request->file('foto')->store('public');
        $pasien->save();
        return back()->with('pesan', 'Horee.. Data sudah disimpan');

    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $data['pasien'] = \App\Models\Pasien::findOrFail($id);
        return view('pasien_edit', $data);
    }
    /**
     * Update the specified resource in storage.
     ** @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, string $id): Redirector|RedirectResponse
    {
        $requestData = $request->validate(rules: [
            'no_pasien' => 'required|unique:pasiens,no_pasien,' . $id,
            'nama' => 'required',
            'umur' => 'required|numeric',
            'jenis kelamin' => 'required|in:laki-laki, perempuan',
            'foto' => 'nullable|image|mimes: jpeg,png,jpg|max: 5000', //foto boleh null
            'alamat' => 'nullable',
        ]);
        $pasien = \App\Models\Pasien::findOrFail(id: $id);
        $pasien->fill(attributes: $requestData);
        //karena di validasi foto boleh null, maka perlu pengecekan apakah ada file foto yang diupload //jika ada maka file foto lama dihapus dan diganti dengan file foto yang baru
        if ($request->hasFile(key: 'foto')) {
            Storage::delete(paths: $pasien->foto);
            $pasien->foto = $request->file(key: 'foto')->store(path: 'public');
        }

        $pasien->save();
        flash('Data sudah diupdate')->success();
        return redirect(to: '/pasien');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(string $id)
    {
        $pasien = \App\Models\Pasien::findOrFail($id);
        if ($pasien->daftar->count() > 0) {
            flash('Data tidak bisa dihapus karena sudah ada data pendaftaran')->error();
            return back();
        }
        if ($pasien->foto != null && Storage::exists($pasien->foto)) {
            Storage::delete($pasien->foto);
        }
        $pasien->delete();
        flash('Data sudah dihapus')->success();
        return back();
    }
}