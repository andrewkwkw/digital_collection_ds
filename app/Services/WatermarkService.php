<?php

namespace App\Services;

use setasign\Fpdi\Fpdi;

class WatermarkService
{
    /**
     * Generate watermarked PDF from given file path.
     *
     * @param string $filePath Full physical path to the PDF file.
     * @param string $originalFilename Original filename for download attachment.
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function generate(string $filePath, string $originalFilename)
    {
        if (!file_exists($filePath)) {
            abort(404, 'File fisik tidak ditemukan.');
        }

        // --- Anonymous class FPDI untuk rotasi ---
        $pdf = new class extends Fpdi {
            public $angle = 0;

            function Rotate($angle, $x = -1, $y = -1)
            {
                if ($x == -1)
                    $x = $this->x;
                if ($y == -1)
                    $y = $this->y;
                if ($this->angle != 0)
                    $this->_out('Q');
                $this->angle = $angle;
                if ($angle != 0) {
                    $angle *= M_PI / 180;
                    $c = cos($angle);
                    $s = sin($angle);
                    $cx = $x * $this->k;
                    $cy = ($this->h - $y) * $this->k;
                    $this->_out(sprintf(
                        'q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',
                        $c,
                        $s,
                        -$s,
                        $c,
                        $cx,
                        $cy,
                        -$cx,
                        -$cy
                    ));
                }
            }

            function _endpage()
            {
                if ($this->angle != 0) {
                    $this->angle = 0;
                    $this->_out('Q');
                }
                parent::_endpage();
            }
        };
        // -------------------------------------

        try {
            $pageCount = $pdf->setSourceFile($filePath);
        } catch (\Exception $e) {
            return back()->with('error', 'File PDF corrupt atau terproteksi password.');
        }

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);

            $watermarkText = "DIGITAL COLLECTION ARCHIVE";
            $pdf->SetFont('Helvetica', 'B', 15); // font lebih kecil
            $pdf->SetTextColor(240, 240, 240);  // abu-abu terang

            $stepX = 100; // jarak horizontal antar teks
            $stepY = 60;  // jarak vertikal antar teks

            for ($x = 0; $x < $size['width']; $x += $stepX) {
                for ($y = 0; $y < $size['height']; $y += $stepY) {
                    $pdf->Rotate(45, $x, $y);
                    $pdf->Text($x, $y, $watermarkText);
                    $pdf->Rotate(0); // reset rotasi
                }
            }
        }

        return response($pdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="watermarked_' . basename($originalFilename) . '"',
        ]);
    }
}
