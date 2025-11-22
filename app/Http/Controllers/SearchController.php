<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function search(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (empty($query)) {
            return redirect()->route('home');
        }

        $results = $this->searchService->search($query);

        $totalResults = $results['events']->count()
            + $results['notices']->count()
            + $results['pages']->count()
            + $results['staff']->count();

        // Check if using Scout (inferred from config, or could be exposed by service)
        $usingScout = config('scout.driver') !== null
            && config('scout.driver') !== 'null'
            && config('scout.driver') !== 'collection';

        return view('pages.search', [
            'query' => $query,
            'results' => $results,
            'totalResults' => $totalResults,
            'usingScout' => $usingScout,
        ]);
    }

    public function autocomplete(Request $request)
    {
        $query = trim($request->get('q', ''));

        $suggestions = $this->searchService->autocomplete($query);

        return response()->json([
            'suggestions' => $suggestions->values(),
            'query' => $query
        ]);
    }
}

