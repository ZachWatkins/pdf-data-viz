<?php
/**
 * Apply values from a JSON file to an existing PDF using common data formats.
 * @author Zachary K. Watkins <zwatkins.it@gmail.com>
 */
require __DIR__ . '/vendor/autoload.php';

/**
 * Output JSON file contents.
 */
$data = (array) json_decode(file_get_contents(__DIR__ . '/assets/stats.json'));

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
foreach ($data as $key => $value) {
    $value = is_array( $value ) ? implode( ', ', $value ) : $value;
    $pdf->Write( 8, $key . ': ' );
    $pdf->Write( 8, (string) $value );
    $pdf->Ln();
}
$pdf->Output('F', 'stats-json.pdf');

/**
 * Output CSV file contents.
 */
$stream = fopen(__DIR__ . '/assets/stats.csv', 'r');
$keys = fgetcsv($stream, 300);
$values = fgetcsv($stream, 300);
$data = array_combine($keys, $values);
fclose($stream);
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
foreach ($data as $key => $value) {
    $value = is_array( $value ) ? implode( ', ', $value ) : $value;
    $pdf->Write( 8, $key . ': ' );
    $pdf->Write( 8, (string) $value );
    $pdf->Ln();
}
$pdf->Output('F', 'stats-csv.pdf');
