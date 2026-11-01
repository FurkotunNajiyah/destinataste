public function wisataIndex(Request $request)
{
    $query = Place::where('type', 'wisata');

    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $places = $query->with('category', 'photos')->paginate(9);
    return view('frontend.wisata.index', compact('places'));
}