<?php
namespace App\Http\Controllers;
use App\Models\Magazine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MagazineController extends Controller
{
    public function index()
    {
        $magazines = DB::table('magazines')->get();
        return response()->json($magazines);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issn' => 'required|string|unique:magazines',
            'founded' => 'required|integer|min:1800|max:' . date('Y'),
        ]);
        $magazine = DB::table('magazines')->insertGetId($validated);
        return response()->json(DB::table('magazines')->find($magazine), 201);
    }
    public function show($id)
    {
        $magazine = DB::table('magazines')->find($id);
        if (!$magazine) {
            return response()->json(['message' => 'Magazine not found'], 404);
        }
        return response()->json($magazine);
    }
    public function update(Request $request, $id)
    {
        $magazine = DB::table('magazines')->find($id);
        if (!$magazine) {
            return response()->json(['message' => 'Magazine not found'], 404);
        }
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'issn' => 'sometimes|string|unique:magazines,issn,' . $id,
            'founded' => 'sometimes|integer|min:1800|max:' . date('Y'),
        ]);
        DB::table('magazines')->where('id', $id)->update($validated);
        return response()->json(DB::table('magazines')->find($id));
    }
    public function destroy($id)
    {
        $magazine = DB::table('magazines')->find($id);
        if (!$magazine) {
            return response()->json(['message' => 'Magazine not found'], 404);
        }
        DB::table('magazines')->where('id', $id)->delete();
        return response()->json(['message' => 'Magazine deleted']);
    }
}
