<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bank Transactions</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body>
    <div class="ui container">
        <h1> Bank Transaction from CSV </h1>
        @include('upload')

        @if ( ! empty ( $error_message ) )
        <div class="ui negative message" >
            <span> {{ $error_message }} </span>
        </div>
        @endif

        <div >
            @if ( session('txnData') )
                <table class="ui celled table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Transaction Number</th>
                        <th>Valid Transaction?</th>
                        <th>Customer Number</th>
                        <th>Reference</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                        @foreach ( session('txnData') as $record )

                        <tbody>
                            <tr>
                                <td data-label="Date">{{ $record->getTxnDate() }} </td>
                                <td data-label="Transaction Number">{{ $record->getTxnNumber() }} </td>
                                <td data-label="Valid Transaction?">{{ $record->getTransactionStatus() }} </td>
                                <td data-label="Customer Number">{{ $record->getCustomerID() }}</td>
                                <td data-label="Reference">{{ $record->getReference() }}</td>
                                <td data-label="Amount" style="color: {{ $record->isDebitedOrCredited() }}">{{ $record->getAmount() }}</td>
                            </tr>
                        </tbody>
                        @endforeach
                </table>
            @endif
        </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
    </body>
</html>
