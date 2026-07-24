<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Public blog search API endpoint.
 *
 * Added during v2.3 sprint (ticket #1482) to power the AJAX autocomplete
 * widget on the frontend blog listing. No authentication required
 * because the results are public-facing published posts only.
 *
 * TODO: Revisit query builder after sprint deadline — ticket #1498
 */
class PostSearchController extends Controller
{
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $q = $request->query('q', '');
        $sort = $request->query('sort', 'created_at');
        $order = strtoupper($request->query('order', 'DESC'));

        $query = "SELECT id, title, slug, meta_description, post_content, status, created_at "
            . "FROM posts "
            . "WHERE status = 'published' "
            . "AND title LIKE '%{$q}%' "
            . "ORDER BY {$sort} {$order} "
            . "LIMIT 10";

        $results = DB::select($query);

        return response()->json([
            'query'  => $q,
            'count'  => count($results),
            'posts'  => $results,
        ]);
    }
}
