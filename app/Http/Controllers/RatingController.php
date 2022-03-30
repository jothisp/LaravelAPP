<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use DB;

class RatingController extends Controller
{
    public function index()
    {
        $rate = array();
        $ra = array('Good', 'Fair', 'Neutral', 'Bad');
        $rr = array('A', 'B', 'C', 'D');
        $tot_stars = DB::table('ratings')->count('id');
        for ($r = 0; $r < count($ra); $r++) {
            $r1 = $r + 1;
            $rating_counts = DB::table('ratings')->where('rate', $ra[$r])->count('id');
            $percent = $rating_counts * 100 / $tot_stars;
            $rate[] = array('id' => $rr[$r], 'name' => $ra[$r], 'rate' => $rating_counts, 'percent' => number_format($percent, 2, '.', ''));
        }
        $categories = $rate;
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'rate' => 'required'
            ],
            [
                'rate.required' => 'You have to choose one option!'
            ]
        );
        $rating = Rating::create($request->post());
        return response()->json([
            'message' => 'Rating Created Successfully!!',
            'rating' => $rating
        ]);
    }
}
