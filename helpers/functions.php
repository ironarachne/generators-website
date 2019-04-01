<?php

if ( !function_exists( 'distribute_array' ) ) {
    function distribute_array( $array1, $array2 )
    {
        $availableElements = $array2;

        $iterations[] = $availableElements;

        foreach ( $array1 as $element ) {
            $index = rnd( count( $availableElements ) - 1 );
            $myElement = $availableElements[ $index ];
            unset( $availableElements[ $index ] );
            $availableElements = array_values( $availableElements );

            $randomizedElements[ $element ] = $myElement;
        }

        return $randomizedElements;
    }
}

if ( !function_exists( 'rnd' ) ) {
    function rnd( $max )
    {
        srand();
        return mt_rand( 0, $max );
    }
}
