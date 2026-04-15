<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\View\View;

class AuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $audits = Audit::with('user')
            ->latest('created_at')
            ->paginate(20);

        return view('audits.index', compact('audits'));
    }

    public function show(Audit $audit): View
    {
        $audit->load('user');
        return view('audits.show', compact('audit'));
    }
}
