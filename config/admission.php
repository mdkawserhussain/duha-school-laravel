<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admission Grade Options
    |--------------------------------------------------------------------------
    |
    | Single source of truth for the grade options offered on the public
    | admission form. Values are stored verbatim in the
    | `admission_applications.applying_grade` column and matched by the
    | admin applications filter, so changing values here only affects new
    | submissions.
    |
    */

    'grades' => [
        // National curriculum track
        'Pre-Play',
        'Play',
        'Nursery',
        'KG',
        'Grade 1',
        'Grade 2',
        'Grade 3',
        'Grade 4',
        'Grade 5',
        'Grade 6',
        'Grade 7',
        'Grade 8',
        'Grade 9',
        'EYFS Day Care',

        // BC (British Curriculum) track — duplication of early years names
        // is intentional; the "BC " prefix keeps stored values unambiguous.
        'BC Pre-Play',
        'BC Play',
        'BC Nursery',
        'Reception',
        'Year 1',
        'Year 2',
        'Year 3',
        'Year 4',
        'Year 5',
        'Year 6',
    ],

];
