<?php

declare(strict_types=1);

namespace App\Http\Controllers\Commercial\BRouter;

use App\Http\Controllers\Controller;
use App\Models\Finance\BRouter;
use App\Repositories\Provider\ProviderInterface;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BRouterController extends Controller
{


    public function indexFilter()
    {
        if (request()->has('appFilter') && request()->filled('appFilter')) {

            $commandes = QueryBuilder::for(BCommand::class)
                ->allowedFilters([
                    AllowedFilter::scope('GetBRDate', 'filters_date_bc'),
                    AllowedFilter::scope('GetProvider', 'filters_providers'),

                ])
                ->with(['provider', 'provider.emails'])
                ->paginate(100)
                ->appends(request()->query());
            //->get();
        } else {
            $commandes = BRouter::with(['provider', 'provider.emails'])->get();
        }

        $providers = app(ProviderInterface::class)->Providers(['id', 'uuid', 'entreprise', 'contact']);

        return view('theme.pages.Commercial.BR.index', compact('commandes', 'providers'));
    }

    public function index()
    {

        $commandes = BRouter::with(['provider', 'provider.emails'])->get();

        return view('theme.pages.Commercial.BR.index', compact('commandes'));
    }

    public function create()
    {
        //$this->authorize('create', BCommand::class);

        return view('theme.pages.Commercial.BR.__create.index');
    }
}
