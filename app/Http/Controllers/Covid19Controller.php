<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Statistics;
use Illuminate\Http\Request;

class Covid19Controller extends Controller
{
    public function dashboard()
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:code,confirmed,recovered,death']
        ]);

        $statistics = Statistics::whereDate('created_at', now()->today());

        $statistics->with('country')
            ->when(request('search'), function ($query) {
                $query->whereHas('country', function ($query2) {
                    $query2->where('code', 'LIKE', '%' . request('search') . '%')
                        ->orWhere('name->en', 'LIKE', '%' . request('search') . '%')
                        ->orWhere('name->ka', 'LIKE', '%' . request('search') . '%');
                });
            })
            ->when(request()->has(['field', 'direction']) && request('field') !== 'code', function ($query3) {

                $query3->orderBy(request('field'), request('direction'));
            })
            ->when(request()->has(['field', 'direction']) && request('field') === 'code', function ($query3) {
                $query3->orderBy(Country::select(request('field'))->whereColumn('statistics.country_id', 'countries.id'), request('direction'));
            });
        $statistics = $statistics->get();
        $confirmed = $statistics->sum('confirmed');
        $recovered = $statistics->sum('recovered');
        $death = $statistics->sum('death');


        return inertia('Dashboard', [
            'statistics' => $statistics,
            'confirmed' => $confirmed,
            'recovered' => $recovered,
            'death' => $death,
            'filters' => request()->all([
                'search',
                'field',
                'direction'
            ])
        ]);
    }
}
