<?php

namespace App\Models;

class BankTransaction {

    public string $txnDate = '';
    protected string $txnNumber;
    protected int $customerID;
    protected string $reference;
    protected int $amount = 0;

    const VALIDCHARS = array( '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C',
        'D', 'E', 'F', 'G', 'H' ,'J', 'K','L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T',
        'U', 'V', 'W', 'X', 'Y', 'Z');

    public function __construct( string $txnDate, string $txnNumber, int $customerID, string $reference, int $amount ) {
        $this->setTxnDate( $txnDate );
        $this->setTxnNumber( $txnNumber );
        $this->setCustomerID( $customerID );
        $this->setReference( $reference );
        $this->setAmount( $amount );
    }

    /**
     * @return string
     */
    public function getTxnDate(): string {
        $date = strtotime( $this->txnDate) ;
        return  date('d/m/Y h:i:s', $date);;
    }

    /**
     * @param string $txnDate
     */
    public function setTxnDate( string $txnDate ): void {
        $this->txnDate = $txnDate;
    }

    /**
     * @return string
     */
    public function getTxnNumber(): string {
        return $this->txnNumber;
    }

    /**
     * @param string $txnNumber
     */
    public function setTxnNumber( string $txnNumber ): void {
        $this->txnNumber = $txnNumber;
    }

    /**
     * @return int
     */
    public function getCustomerID(): int {
        return $this->customerID;
    }

    /**
     * @param int $customerID
     */
    public function setCustomerID( int $customerID ): void {
        $this->customerID = $customerID;
    }

    /**
     * @return string
     */
    public function getReference(): string {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference( string $reference ): void {
        $this->reference = $reference;
    }

    /**
     * @return int
     */
    public function getAmount(): int {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount( int $amount ): void {
        $this->amount = $amount;
    }

    public function getTransactionStatus(): string {

        $validTxn = 'No';

        if ( $this->VerifyKey( $this->txnNumber ) ){
            $validTxn = 'Yes';
        }

        return $validTxn;
    }

    private function VerifyKey( string $key ): bool {

        if ( strlen( $key ) != 10){
            return false;
        }

        $checkDigit = $this->GenerateCheckCharacter(strtoupper($key).substr(0,
                9));
        return $key[9] == $checkDigit;
    }

    // Implementation of algorithm for check digit.
    private function GenerateCheckCharacter( string $input ) : string {
        $factor = 2;
        $sum = 0;
        $n = count( self::VALIDCHARS);

        // Starting from the right and working leftwards is easier since
        // the initial "factor" will always be "2"
        for ( $i = strlen( $input ) - 1; $i >= 0; $i-- ) {

            $codePoint = array_search( $input[$i] , self::VALIDCHARS );
            $addend = $factor * $codePoint;

            // Alternate the "factor" that each "codePoint" is multiplied by
            $factor = ( $factor == 2 ) ? 1 : 2;
            // Sum the digits of the "addend" as expressed in base "n"
            $addend = floor ( ( $addend / $n ) ) + ( $addend % $n );

            $sum += $addend;
        }

        // Calculate the number that must be added to the "sum"
        // to make it divisible by "n"
        $remainder = $sum % $n;

        $checkCodePoint = ( $n - $remainder ) % $n;
        return self::VALIDCHARS[$checkCodePoint];
    }

}
