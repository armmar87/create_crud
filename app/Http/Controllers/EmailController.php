<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class EmailController extends Controller
{
    public function sendEmailAndGenaratePDF(Request $request)
    {
        $lang = Session::has('locale')?Session::get('locale'):app()->getLocale();
        if($request->has('id')) {
            $id = $request->id;
            $product = DB::table('products')
                ->leftjoin('products_t', 'products.id', '=', 'products_t.product_id')
                ->select('products.*', 'products_t.name as prod_name', 'products_t.description')
                ->where('products.id', $id)
                ->where('products_t.code', $lang)
                ->first();

            $options = [
                'isRemoteEnabled' => true,
                'dpi' => 96,
                'isHTML5ParserEnabled' => true,
            ];
            $pdf = PDF::loadView('pdf.pdf', compact('product'))->setOptions($options);
            $storePath = storage_path('/');
            if($pdf->save($storePath.'/'.$id.'.pdf')){
                Mail::send('email.email', compact('product'), function ($m) {
                    $m->from(env('MAIL_USERNAME'), 'Laravel crud');
                    $m->to(env('MAIL_TO'))->subject('crud');
                });
            }
           return redirect()->back()->with('success','mail successfully send');
        }

    }

    public function downloadPdfFile(Request $request)
    {
        if($request->has('p')) {
            $pdf_name = $request->p;
            $path = Storage::disk('pdf')->getDriver()->getAdapter()->applyPathPrefix($pdf_name.'.pdf');
            return response()->make(file_get_contents($path), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $pdf_name . '.pdf' . '"'
            ]);
        }
    }


}
