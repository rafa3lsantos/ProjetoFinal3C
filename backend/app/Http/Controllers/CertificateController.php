<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function store(Request $request)
    {
        $arrayRequest = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'file' => 'required|string',
            'candidate_id' => 'required|integer',
        ]);
    }
}
