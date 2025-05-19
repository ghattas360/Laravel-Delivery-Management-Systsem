<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    // Show all packages for the authenticated client
    public function index()
    {
        $packages = Auth::user()->client->packages;
        return view('packages.index', compact('packages'));
    }

    // Show form to create a package
    public function create()
    {
        return view('packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'height' => 'required|numeric',
            'width' => 'required|numeric',
            'depth' => 'required|numeric',
            'weight' => 'required|numeric',
            'weight_unit' => 'required|string',
            'measurement_unit' => 'required|string',
            'is_breakable' => 'nullable|boolean',
            'is_flammable' => 'nullable|boolean',
            'has_fluid' => 'nullable|boolean',
        ]);

        // Get the authenticated client
        $client = Auth::user()->client;

        // Prepare data
        $data = $request->only([
            'height', 'width', 'depth', 'weight',
            'weight_unit', 'measurement_unit'
        ]);
        $data['client_id'] = $client->id;

        // Handle checkboxes
        $data['is_breakable'] = $request->has('is_breakable');
        $data['is_flammable'] = $request->has('is_flammable');
        $data['has_fluid'] = $request->has('has_fluid');

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('pictures', $filename, 'public');
            $data['picture'] = 'pictures/' . $filename;
        }

        // Create the package
        Package::create($data);

        return redirect()->route('packages.index')->with('success', 'Package created successfully.');
    }

    public function edit($id)
    {
        $package = Package::where('client_id', Auth::user()->client->id)
                        ->findOrFail($id);
        return view('packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::where('client_id', Auth::user()->client->id)
                         ->findOrFail($id);

        $request->validate([
            'image' => 'nullable|image',
            'height' => 'required|numeric',
            'width' => 'required|numeric',
            'depth' => 'required|numeric',
            'weight' => 'required|numeric',
            'weight_unit' => 'required|string',
            'measurement_unit' => 'required|string',
        ]);

        // Handle boolean fields
        $package->is_breakable = $request->has('is_breakable');
        $package->is_flammable = $request->has('is_flammable');
        $package->has_fluid = $request->has('has_fluid');

        // Update package details
        $package->fill($request->only([
            'height', 'width', 'depth', 'weight',
            'weight_unit', 'measurement_unit'
        ]));

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            // Delete old picture if exists
            if ($package->picture) {
                Storage::disk('public')->delete($package->picture);
            }

            $path = $request->file('image')->store('pictures', 'public');
            $package->picture = $path;
        }

        $package->save();

        return redirect()->route('packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy($id)
    {
        $package = Package::where('client_id', Auth::user()->client->id)
                        ->findOrFail($id);

        if ($package->picture) {
            Storage::disk('public')->delete($package->picture);
        }

        $package->delete();

        return redirect()->route('packages.index')->with('success', 'Package deleted successfully.');
    }
}