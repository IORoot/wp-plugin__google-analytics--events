<?php

class send_analytics {

    public $version = 1;

    public $urchin = 'UA-116670575-1';

    public $event = 'event';

    //  ┌─────────────────────────────────────────────────────────────────────────┐ 
    //  │                                                                         │░
    //  │                     Send event to Google Analytics                      │░
    //  │                                                                         │░
    //  └─────────────────────────────────────────────────────────────────────────┘░
    //   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
    /**
     * send_analytics_event
     *
     * Note: Make sure the 'value' is a round number. Google Analytics doesn't like decimal places.
     * 
     * @param mixed $category
     * @param mixed $action
     * @param mixed $label
     * @param mixed $value
     * @return void
     */
    public function send_analytics_event($category = "", $action = "", $label = "", $value = 1){

        $data = array(
            'v' => $this->version,      // VERSION
            'tid' => $this->urchin,     // URCHIN
            'cid' => $this->gen_uuid(), // RANDOM
            't' => $this->event         // EVENT
        );
    
        $data['ec'] = $category;
        $data['ea'] = $action;
        $data['el'] = $label;
        $data['ev'] = $value;
        $data['uip']= $_SERVER['REMOTE_ADDR'];
        $data['ua']=  $_SERVER['HTTP_USER_AGENT'];
    
        $url = 'https://www.google-analytics.com/collect';
        $content = http_build_query($data);
        $content = utf8_encode($content);
    
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-type: application/x-www-form-urlencoded'));
        curl_setopt($ch,CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
        curl_setopt($ch,CURLOPT_POST, TRUE);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    
        return;
    }


    //  ┌─────────────────────────────────────────────────────────────────────────┐ 
    //  │                                                                         │░
    //  │               Generate a random string for the client ID                │░
    //  │                                                                         │░
    //  └─────────────────────────────────────────────────────────────────────────┘░
    //   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░                                                                             
    function gen_uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

}
