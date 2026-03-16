<?php

namespace App\Mail;

use App\Models\Factura;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudCreada extends Mailable
{
    use Queueable, SerializesModels;

    public $factura;

    public function __construct(Factura $factura)
    {
        $this->factura = $factura;
    }

    public function build()
    {
        // Generate the PDF from the Blade view
        $pdf = \PDF::loadView('pdf.planilla_solicitud', [
            'factura' => $this->factura
        ]);

        $pdfContent = $pdf->output();
        $filename = "solicitud_{$this->factura->id}.pdf";

        return $this->subject("SICMEC - Tu solicitud #{$this->factura->id} fue recibida")
            ->view('emails.solicitud_creada')
            ->with(['factura' => $this->factura])
            ->attachData($pdfContent, $filename, [
                'mime' => 'application/pdf',
            ]);
    }
}
