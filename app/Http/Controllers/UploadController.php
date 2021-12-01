<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BankTransaction;
use PhpParser\Node\Expr\Cast\Object_;

class UploadController extends Controller
{

    public function uploadCsv ( Request $request ) {

        if ( $request->hasFile('csvfile') ) {

            $file_name = $request->csvfile->getClientOriginalName();
            $mime_type = $request->csvfile->getClientMimeType();

            if ( $mime_type === 'text/csv' ){
                $request->csvfile->storeAs('banktxndata', $file_name );
            } else {
                return view('home', ['error_message' => 'Only CSV file can be imported']);
            }
        } else {
                return view('home', ['error_message' => 'Choose CSV file']);
        }

        $data = $this->getBankStatementfromCSV();

        $request->session()->put('txnData', $data );

       return redirect()->back();
    }

    private function sortTransaction( array $txnObject ) {
        usort($txnObject, function($a, $b) {
                if ( strtotime( $a->getTxnDate() ) < strtotime( $b->getTxnDate() ) ) {
                    return 1;
                }
                else if (strtotime( $a->getTxnDate() ) > strtotime( $b->getTxnDate() ) ) {
                    return -1;
                }
                else {
                    return 0;
                }
            }
        );

        return $txnObject;
    }

    private function getBankStatementfromCSV() : array {
        $fileName = storage_path('app/banktxndata/BankTransactions.csv');
        $fileHandler = fopen( $fileName, 'r');
        $line_of_text = [];

        while ( ! feof( $fileHandler ) ) {
            array_push( $line_of_text, fgetcsv( $fileHandler, 0, ',' ) );
        }

        fclose( $fileHandler );

        array_shift($line_of_text );

        $mappedData = [];

        foreach( $line_of_text as $data ) {
            if ( $data ) {
                $bank = new BankTransaction( $data[0], $data[1], $data[2], $data[3], $data[4] );
                $mappedData[] = $bank;
            }
        }

        return  $this->sortTransaction( $mappedData );
    }

}
