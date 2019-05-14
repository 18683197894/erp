<?php

namespace App\Http\Controllers\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    public function supplier_material_import(Request $request)
    {
    	dd($request->all());
    }
}
