<?php
namespace App\Http\Controllers;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PublicationController extends Controller
{
    public function index()
    {
        $publications = DB::table('publications')
            ->join('magazines', 'publications.magazine_id', '=', 'magazines.id')
            ->select('publications.*', 'magazines.name as magazine_name')
            ->get();
        return response()->json($publications);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'magazine_id' => 'required|exists:magazines,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'required|date',
        ]);
        $publication = DB::table('publications')->insertGetId($validated);
        return response()->json(DB::table('publications')->find($publication), 201);
    }
    public function show($id)
    {
        $publication = DB::table('publications')
            ->join('magazines', 'publications.magazine_id', '=', 'magazines.id')
            ->select('publications.*', 'magazines.name as magazine_name')
            ->where('publications.id', $id)
            ->first();
        if (!$publication) {
            return response()->json(['message' => 'Publication not found'], 404);
        }
        return response()->json($publication);
    }
    public function update(Request $request, $id)
    {
        $publication = DB::table('publications')->find($id);
        if (!$publication) {
            return response()->json(['message' => 'Publication not found'], 404);
        }
        $validated = $request->validate([
            'magazine_id' => 'sometimes|exists:magazines,id',
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'published_at' => 'sometimes|date',
        ]);
        DB::table('publications')->where('id', $id)->update($validated);
        return response()->json(DB::table('publications')->find($id));
    }
    public function destroy($id)
    {
        $publication = DB::table('publications')->find($id);
        if (!$publication) {
            return response()->json(['message' => 'Publication not found'], 404);
        }
        DB::table('publications')->where('id', $id)->delete();
        return response()->json(['message' => 'Publication deleted']);
    }
}

