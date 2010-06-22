<?php
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "http://stage-api.myspace.com/jdavid_net");

        $headers[] = "User-Agent: Fiddler";
        $headers[] = "Accept: application/xrds+xml";
        $headers[] = "Host: www.myspace.com";
        $headers[] = "Content-Type: application/x-www-form-urlencoded";

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        print $output;
?>