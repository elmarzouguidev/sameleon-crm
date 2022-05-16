<?php

namespace App\Http\Controllers\Commercial\InvoiceAvoir;

use App\Http\Controllers\Controller;

use App\Http\Requests\Commercial\InvoiceAvoir\AvoirDeleteArticleFormRequest;
use App\Http\Requests\Commercial\InvoiceAvoir\AvoirFormRequest;
use App\Http\Requests\Commercial\InvoiceAvoir\AvoirUpdateFormRequest;
use App\Http\Requests\Commercial\InvoiceAvoir\SendEmailFormRequest;
use App\Mail\Commercial\InvoiceAvoir\SendInvoiceAvoirMail;
use App\Models\Finance\Article;
use App\Models\Finance\Company;
use App\Models\Finance\Invoice;
use App\Models\Finance\InvoiceAvoir;
use App\Services\Commercial\Taxes\TVACalulator;
use App\Services\Mail\CheckConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Repositories\Client\ClientInterface;
use App\Repositories\Company\CompanyInterface;

class InvoiceAvoirController extends Controller
{

    use TVACalulator;

    public function index()
    {

        if (request()->has('appFilter') && request()->filled('appFilter')) {

            $invoices = QueryBuilder::for(InvoiceAvoir::class)
                ->allowedFilters([
                    //'company_id'
                    //AllowedFilter::exact('etat')
                    AllowedFilter::scope('GetInvoiceAvoirDate', 'filters_date_invoice_avoir'),
                    AllowedFilter::scope('GetCompany', 'filters_companies'),
                    AllowedFilter::scope('GetClient', 'filters_clients'),

                ])
                ->with(['company', 'client'])
                ->get();
                //->appends(request()->query());
            //->get();
        } else {
            $invoices = InvoiceAvoir::with(['company:id,name,logo', 'client:id,entreprise,email','client.emails'])
                ->get();
        }
        $clients = app(ClientInterface::class)->getClients(['id', 'uuid', 'entreprise', 'contact']);

        $companies = Company::select(['id', 'name', 'uuid'])->get();

        return view('theme.pages.Commercial.InvoiceAvoir.__datatable.index', compact('invoices','clients','companies'));
    }

    public function create()
    {

        $clients = app(ClientInterface::class)->getClients(['id', 'entreprise', 'contact']);
        $companies = app(CompanyInterface::class)->getCompanies(['id', 'name']);
        $invoices = Invoice::select('id', 'code', 'full_number')
            ->doesntHave('avoir')
            ->get();

        return view('theme.pages.Commercial.InvoiceAvoir.__create_avoir.index', compact('clients', 'companies', 'invoices'));
    }

    public function store(AvoirFormRequest $request)
    {
        //dd($request->all(), "avoir");

        $articles = $request->articles;

        $totalPrice = collect($articles)->map(function ($item) {
            return $item['prix_unitaire'] * $item['quantity'];
        })->sum();

        $invoicesArticles = collect($articles)->map(function ($item) {
            return collect($item)->merge(['montant_ht' => $item['prix_unitaire'] * $item['quantity']]);
        })->toArray();

        $invoice = new InvoiceAvoir();
        $invoice->invoice_number = $request->invoice_number;

        $invoice->invoice_date = $request->date('invoice_date');
        // $invoice->due_date = $request->date('due_date');
        $invoice->payment_mode = $request->payment_mode;

        $invoice->admin_notes = $request->admin_notes;
        
        $invoice->condition_general = $request->condition_general;

        $invoice->price_ht = $totalPrice;
        $invoice->price_total = $this->caluculateTva($totalPrice);
        $invoice->price_tva = $this->calculateOnlyTva($totalPrice);

        $invoice->client_id = $request->client;
        $invoice->company_id = $request->company;
        $invoice->status = 'paid';

        $invoice->invoice()->associate($request->invoice_number);
        $invoice->invoice_number = $invoice->invoice->code;

        $invoice->save();

        $invoice->articles()->createMany($invoicesArticles);

        $invoice->histories()->create([
            'user_id' => auth()->id(),
            'user' => auth()->user()->full_name,
            'detail' => 'a crée la facture avoir',
            'action' => 'add'
        ]);
        return redirect($invoice->edit_url)->with('success', "La Facture Avoir a été crée avec success");
    }

    public function single(InvoiceAvoir $invoice)
    {
        $invoice->load('articles');

        return view('theme.pages.Commercial.InvoiceAvoir.__detail.index', compact('invoice'));
    }

    public function edit(InvoiceAvoir $invoice)
    {

        $invoice->load('articles','histories');

        return view('theme.pages.Commercial.InvoiceAvoir.__edit.index', compact('invoice'));
    }

    public function update(AvoirUpdateFormRequest $request, InvoiceAvoir $invoice)
    {

        // dd('Ouiii',$request->all());

        $newArticles = $request->getArticles()->map(function ($item) {
            return collect($item)
                ->merge(['montant_ht' => $item['prix_unitaire'] * $item['quantity']]);
        })->toArray();

        $totalArticlePrice = collect($newArticles)->map(function ($item) {
            return $item['prix_unitaire'] * $item['quantity'];
        })->sum();

        if ($totalArticlePrice !== $invoice->price_ht && $totalArticlePrice > 0) {
            $totalPrice = $invoice->price_ht + $totalArticlePrice;
            $invoice->price_ht = $totalPrice;
            $invoice->price_total = $this->caluculateTva($totalPrice);
            $invoice->price_tva = $this->calculateOnlyTva($totalPrice);
        }

        $invoice->invoice_date = $request->date('invoice_date');
        //$invoice->due_date = $request->date('due_date');
        $invoice->payment_mode = $request->payment_mode;
        
        $invoice->admin_notes = $request->admin_notes;
        // $invoice->client_notes = $request->client_notes;
        $invoice->condition_general = $request->condition_general;

        $invoice->save();
        $invoice->articles()->createMany($newArticles);

        $invoice->histories()->create([
            'user_id' => auth()->id(),
            'user' => auth()->user()->full_name,
            'detail' => 'a modifier la facture avoir',
            'action' => 'update'
        ]);

        return redirect($invoice->edit_url)->with('success', "La Facture Avoir a été modifier avec success");
    }

    public function deleteInvoice(Request $request)
    {

        $request->validate(['invoiceId' => 'required|uuid']);

        $invoice = InvoiceAvoir::whereUuid($request->invoiceId)->firstOrFail();

        if ($invoice) {

            $invoice->articles()
                ->where('articleable_type', 'App\Models\Finance\InvoiceAvoir')
                ->where('articleable_id', $invoice->id)
                ->delete();

            $invoice->histories()->create([
                'user_id' => auth()->id(),
                'user' => auth()->user()->full_name,
                'detail' => 'a supprimer la facture avoir',
                'action' => 'delete'
            ]);

            $invoice->delete();

            return redirect(route('commercial:invoices.index.avoir'))->with('success', "La Facture  a éte supprimer avec success");
        }
        return redirect(route('commercial:invoices.index.avoir'))->with('success', "erreur . . . ");
    }

    public function deleteArticle(AvoirDeleteArticleFormRequest $request)
    {
        $invoice = InvoiceAvoir::whereUuid($request->invoice)->firstOrFail();
        $article = Article::whereUuid($request->article)->firstOrFail();

        if ($invoice && $article) {

            $totalPrice = $invoice->price_ht;

            $totalArticlePrice = $article->montant_ht;

            $finalPrice = $totalPrice - $totalArticlePrice;

            $article = $invoice->articles()
                ->whereUuid($request->article)
                ->whereId($article->id)
                ->whereArticleableId($invoice->id)
                ->forceDelete();

            if ($article) {
                $invoice->price_ht = $finalPrice;
                $invoice->price_total = $this->caluculateTva($finalPrice);
                $invoice->price_tva = $this->calculateOnlyTva($finalPrice);
                $invoice->save();
            }

            if ($invoice->articles()->count() <= 0) {
                $invoice->price_ht = 0;
                $invoice->price_total = 0;
                $invoice->price_tva = 0;
                $invoice->save();
            }

            $invoice->histories()->create([
                'user_id' => auth()->id(),
                'user' => auth()->user()->full_name,
                'detail' => 'a supprimer un article depuis  la facture avoir',
                'action' => 'delete-article'
            ]);

            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
        return response()->json([
            'error' => 'problem detected !'
        ]);
    }

    public function sendInvoiceAvoir(SendEmailFormRequest $request)
    {
        $invoice = InvoiceAvoir::whereUuid($request->invoice)->first();
        //dd($request->input('emails.*.*'),$request->collect('emails.*.*'));
        $emails = $request->input('emails.*.*');
        if (CheckConnection::isConnected()) {

            if (isset($emails) && is_array($emails) && count($emails)) {

                foreach ($emails as $email) {
                    Mail::to($email)->send(New SendInvoiceAvoirMail($invoice));
                }
            }

            Mail::to($invoice->client->email)->send(New SendInvoiceAvoirMail($invoice));

            if (empty(Mail::failures())) {

                $invoice->update(['is_send' => !$invoice->is_send]);

                //$estimate->tickets()->update(['status' => Status::EN_ATTENTE_DE_BON_DE_COMMAND]);

                $invoice->histories()->create([
                    'user_id' => auth()->id(),
                    'user' => auth()->user()->full_name,
                    'detail' => 'A envoyer la facture avoir pa mail',
                    'action' => 'send'
                ]);

                return redirect()->back()->with('success', "l'email a été envoyé avec succès");
            }
        }
        return redirect()->back()->with('error', 'Email not send');
    }

}
