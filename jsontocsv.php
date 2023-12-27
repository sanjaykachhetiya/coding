<?php

$six_digit_random_number = mt_rand(100000, 999999);

//Find exact key value from array
function find_key_value($array, $key, $val)
{
    foreach ($array as $item)
    {
        if (is_array($item) && find_key_value($item, $key, $val)) return true;

        if (isset($item[$key]) && $item[$key] == $val) return true;
    }

    return false;
}

function jsonToCSV($jfilename, $cfilename)
{
    if (($json = file_get_contents($jfilename)) == false)
        die('Error reading json file...');
    $data = json_decode($json, true);
    $fp = fopen($cfilename, 'w');
    $dataCSV = [];

    // save the column headers
    fputcsv($fp, array('id', 'school_name'));
    $r=0;
    $dup_list = [];

    foreach ($data as $row)
    {
        //Will find key value and go to that array directly
        if(find_key_value($row, 'questionID', 'school_name')){
            $dup_array = [];
            foreach ($row as $key => $value )
            {
                if( !empty($value) && in_array("school_name", $value) ){

                    if (in_array("school_name", $dup_array)) {
                        $dup_list[] = array( $r => $value );
                    }else{
                        $dataCSV[] = array($value['id'],$value['response']);
                        $dup_array[] = "school_name";
                    }
                }
            }
        }else{
           $dataCSV[] = array('null','null');
        }
        $r++;
    }

    //echo '<pre> Duplicate records of school name '; print_r($dup_list); echo '</pre>';
    // output CSV data
    foreach ($dataCSV as $rowCSV)
    {
        fputcsv($fp, $rowCSV);
    }

    fclose($fp);

    return;
}

$json_filename = 'LPCQ.json';
$csv_filename = 'Result-'.date('d-m-Y').'-'.$six_digit_random_number.'.csv';

if (file_exists($json_filename)) {
    echo "The file $json_filename exists";

    jsonToCSV($json_filename, $csv_filename);

    echo 'Successfully converted json to csv file. <a href="' . $csv_filename . '" target="_blank">Click here to open it.</a>';
} else {
    echo "The file $json_filename does not exist. Check file path and file name!";
}
exit;
?>