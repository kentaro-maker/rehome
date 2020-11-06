<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use setasign\Fpdi\TcpdfFpdi;
use Auth;

class PdfController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(int $id = null)
    {
      $pdf = new TcpdfFpdi();

      $pdf->setPageOrientation('L');
      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);

      $pdf->addPage();

      // テンプレートPDFの設定
      $template_path = resource_path('pdfs/sapporo.pdf');
      $pdf->setSourceFile($template_path);

      // テンプレートの適用
      $page = $pdf->importPage(1);
      $pdf->useTemplate($page,null,null,null,null,true);

      //$pdf->SetXY(44,199);
      $pdf->SetXY(44,20);
      $pdf->Write(0, "------".Auth::user()->name."--------" );

      $pdf->output('sample.pdf', 'I');

      return Redirect::back();
    }
}
