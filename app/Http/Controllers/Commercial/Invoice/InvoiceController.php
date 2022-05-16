<?php

namespace App\Http\Controllers\Commercial\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Commercial\Invoice\DeleteArticleFormRequest;
use App\Http\Requests\Commercial\Invoice\InvoiceFormRequest;
use App\Http\Requests\Commercial\Invoice\InvoiceUpdateFormRequest;

use App\Http\Requests\Commercial\Invoice\SendEmailFormRequest;
use App\Mail\Commercial\Invoice\SendInvoiceMail;
use App\Models\Finance\Article;
use App\Models\Finance\Company;
use App\Models\Finance\Estimate;
use App\Models\Finance\Invoice;
use App\Models\Ticket;
use App\Repositories\Client\ClientInterface;
use App\Repositories\Company\CompanyInterface;
use App\Services\Commercial\Taxes\TVACalulator;
use App\Services\Mail\CheckConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class InvoiceController extends Controller
{

    use TVACalulator;

    public function indexFilter()
    {
        if (request()->has('appFilter') && request()->filled('appFilter')) {

            $invoices = QueryBuilder::for(Invoice::class)
                ->allowedFilters([
                    //'company_id'
                    //AllowedFilter::exact('etat')
                    AllowedFilter::scope('GetInvoiceDate', 'filters_date_invoice'),
                    AllowedFilter::scope('GetCompany', 'filters_companies'),
                    AllowedFilter::scope('GetStatus', 'filters_status'),
                    AllowedFilter::scope('GetClient', 'filters_clients'),

                ])
                ->with(['company', 'client'])
                ->withCount('avoir')
                ->paginate(100)
                ->appends(request()->query());
            //->get();
        } else {
            $invoices = Invoice::with(['company', 'client', 'bill'])->withCount('bill')
                ->withCount(['avoir'])
                //->with('avoir')
                ->get();
        }

        $clients = app(ClientInterface::class)->getClients(['id', 'uuid', 'entreprise', 'contact']);

        $companies = Company::select(['id', 'name', 'uuid'])->get();

        return view('theme.pages.Commercial.Invoice.index', compact('invoices', 'companies', 'clients'));
    }

    public function index()
    {
        $invoices = Invoice::with(['company', 'client'])->paginate(5);

        return view('theme.pages.Commercial.Invoice.index', compact('invoices'));
    }

    public function create()
    {
        $this->authorize('create', Invoice::class);
        if (request()->has('ticket')) {

            $ticket = Ticket::whereUuid(request()->ticket)->firstOrFail();
            $companies = app(CompanyInterface::class)->getCompanies(['id', 'name']);
            return view('theme.pages.Commercial.Invoice.__create.index', compact('ticket', 'companies'));
        }

        return view('theme.pages.Commercial.Invoice.__create.index');
    }

    public function single(Invoice $invoice)
    {
        $invoice->load('articles');
        return view('theme.pages.Commercial.Invoice.__detail.index', compact('invoice'));
    }


    public function store(InvoiceFormRequest $request)
    {
        //dd($request->all());
        $this->authorize('create', Invoice::class);

        $articles = $request->articles;

        $totalPrice = collect($articles)->map(function ($item) {
            return $item['prix_unitaire'] * $item['quantity'];
        })->sum();

        $invoicesArticles = collect($articles)->map(function ($item) {
            return collect($item)->merge(['montant_ht' => $item['prix_unitaire'] * $item['quantity']]);
        })->toArray();

        $invoice = new Invoice();

        $invoice->bl_code = $request->bl_code;
        $invoice->bc_code = $request->bc_code;

        $invoice->invoice_date = $request->date('invoice_date');
        $invoice->due_date = $request->date('due_date');

        $invoice->payment_mode = $request->payment_mode;

        $invoice->admin_notes = $request->admin_notes;
        $invoice->condition_general = $request->condition_general;

        $invoice->price_ht = $totalPrice;
        $invoice->price_total = $this->caluculateTva($totalPrice);
        $invoice->price_tva = $this->calculateOnlyTva($totalPrice);

        $invoice->client_id = $request->client;
        $invoice->ticket_id = $request->ticket;
        $invoice->company_id = $request->company;

        $invoice->status = 'non-paid';

        $invoice->save();

        if ($request->has('estimated') && $request->filled('estimated')) {
            //dd($request->estimated, "ouii");
            $estimate = Estimate::whereUuid($request->estimated)->firstOrFail();

            $estimate->invoice()->associate($invoice)->save();

            $estimate->update(['is_invoiced' => true]);
        }

        $invoice->articles()->createMany($invoicesArticles);

        if (isset($request->tickets) && is_array($request->tickets) && count($request->tickets)) {
            //dd($request->tickets);
            $invoice->tickets()->attach($request->tickets);
        }

        $invoice->histories()->create([
            'user_id' => auth()->id(),
            'user' => auth()->user()->full_name,
            'detail' => 'a crée la facture',
            'action' => 'add'
        ]);

        return redirect($invoice->edit_url)->with('success', "La Facture  a éte crée avec success");
    }

    public function edit(Invoice $invoice)
    {
        $this->authorize('update', $invoice);

        $invoice->load('articles', 'tickets:id,code,code_retour,uuid', 'histories')->loadCount('bill', 'tickets');

        return view('theme.pages.Commercial.Invoice.__edit.index', compact('invoice'));
    }

    public function update(InvoiceUpdateFormRequest $request, Invoice $invoice)
    {

        //dd("UuUu",$request->all());
        $this->authorize('update', $invoice);
        
        $newArticles = $request->getNewArticles()->map(function ($item) {
            return collect($item)
                ->merge(['montant_ht' => $item['prix_unitaire'] * $item['quantity']]);
        })->toArray();

        $totalArticlePrice = collect($newArticles)->map(function ($item) {
            return $item['prix_unitaire'] * $item['quantity'];
        })->sum();

        if ($totalArticlePrice !== $invoice->price_ht && $totalArticlePrice > 0) {
            // dd($totalArticlePrice,$invoice->price_ht);
            $totalPrice = $invoice->price_ht + $totalArticlePrice;
            $invoice->price_ht = $totalPrice;
            $invoice->price_total = $this->caluculateTva($totalPrice);
            $invoice->price_tva = $this->calculateOnlyTva($totalPrice);
        }

        $invoice->bl_code = $request->bl_code;
        $invoice->bc_code = $request->bc_code;

        $invoice->invoice_date = $request->date('invoice_date');
        $invoice->due_date = $request->date('due_date');
        
        $invoice->payment_mode = $request->payment_mode;

        $invoice->admin_notes = $request->admin_notes;
        //$invoice->client_notes = $request->client_notes;
        $invoice->condition_general = $request->condition_general;

        $invoice->save();
        $invoice->articles()->createMany($newArticles);

        if (isset($request->tickets) && is_array($request->tickets) && count($request->tickets)) {
            //dd($request->tickets);
            $invoice->tickets()->sync($request->tickets);
        }
        $invoice->histories()->create([
            'user_id' => auth()->id(),
            'user' => auth()->user()->full_name,
            'detail' => 'a modifier la facture',
            'action' => 'update'
        ]);

        return redirect($invoice->edit_url)->with('success', "Le Facture a été modifier avec success");
    }

    public function deleteInvoice(Request $request)
    {
        //dd($request->all());
        $request->validate(['invoiceId' => 'required|uuid']);

        $invoice = Invoice::whereUuid($request->invoiceId)->firstOrFail();

        $this->authorize('delete', $invoice);

        if ($invoice) {

            $invoice->articles()
                ->where('articleable_type', 'App\Models\Finance\Invoice')
                ->where('articleable_id', $invoice->id)
                ->delete();

            $invoice->tickets()->detach();

            $invoice->estimate()->update(['is_invoiced' => false]);

            $invoice->histories()->delete();

            $invoice->delete();

            return redirect(route('commercial:invoices.index'))->with('success', "La Facture  a éte supprimer avec success");
        }
        return redirect(route('commercial:invoices.index'))->with('success', "erreur . . . ");
    }

    public function deleteArticle(DeleteArticleFormRequest $request)
    {
        $invoice = Invoice::whereUuid($request->invoice)->firstOrFail();
        $article = Article::whereUuid($request->article)->firstOrFail();
        
        $this->authorize('delete', $invoice);

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
                'detail' => 'a supprimer un article depuis  la facture',
                'action' => 'delete'
            ]);

            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
        return response()->json([
            'error' => 'problem detected !'
        ]);
    }

    public function sendInvoice(SendEmailFormRequest $request)
    {
        $invoice = Invoice::whereUuid($request->invoice)->first();
        //dd($request->input('emails.*.*'),$request->collect('emails.*.*'));
        $emails = $request->input('emails.*.*');
        if (CheckConnection::isConnected()) {

            if (isset($emails) && is_array($emails) && count($emails)) {

                foreach ($emails as $email) {
                    Mail::to($email)->send(new SendInvoiceMail($invoice));
                }
            }

            Mail::to($invoice->client->email)->send(new SendInvoiceMail($invoice));

            if (empty(Mail::failures())) {

                $invoice->update(['is_send' => !$invoice->is_send]);

                //$estimate->tickets()->update(['status' => Status::EN_ATTENTE_DE_BON_DE_COMMAND]);

                $invoice->histories()->create([
                    'user_id' => auth()->id(),
                    'user' => auth()->user()->full_name,
                    'detail' => 'A envoyer la facture pa mail',
                    'action' => 'send'
                ]);

                return redirect()->back()->with('success', "l'email a été envoyé avec succès");
            }
        }
        return redirect()->back()->with('error', 'Email not send');
    }
}
