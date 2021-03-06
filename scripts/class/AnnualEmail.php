<?php
include_once "Views.php";
class AnnualEmail extends Views
{
    public function emailViews()
    {
        //get the total page views from the db
        $this->selectViews->execute();
        $row = $this->selectViews->fetch();
        $totalViews = $row[1];
        $annualViews = $row[2];

        //construct the message to be emailed
        $message =
            "Over the past year there has been " .
            $annualViews .
            " page views on shanelucy.me and the total views for this website to date are " .
            $totalViews;
        //send the request to pepipost api
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.pepipost.com/v2/sendEmail",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"personalizations\":[{\"recipient\":\"myemail@address.com\"}],\"from\":{\"fromEmail\":\"info@mail.shanelucy.me\",\"fromName\":\"\"},\"subject\":\"Annual Page Views\",\"content\":\"'$message'\"}",
            CURLOPT_HTTPHEADER => [
                "api_key: Key",
                "content-type: application/json",
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
            //finally reset the annual views to 0
            $this->updateAnnualViews->execute([0, 1]);
        }
    }
}

$cron = new AnnualEmail();
$cron->dbConnection();
$cron->prepareStatements();
$cron->emailViews();
$cron->terminateConnections();
