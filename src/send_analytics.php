<?php


class send_analytics {

    //  ┌─────────────────────────────────────────────────────────────────────────┐ 
    //  │                                                                         │░
    //  │                     Send event to Google Analytics                      │░
    //  │                                                                         │░
    //  └─────────────────────────────────────────────────────────────────────────┘░
    //   ░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
    /**
     * send_analytics_event
     *
     * @param mixed $category
     * @param mixed $action
     * @param mixed $label
     * @param mixed $value
     * @return void
     */
    public function send_analytics_event($category = 'unassigned', $action = 'unassigned', $label = 'unassigned', $value = 1){

        $data = array(
            'v' => 1,                           // VERSION
            'tid' => 'UA-116670575-1',          // URCHIN
            'cid' => $this->gen_uuid(),         // RANDOM
            't' => 'event'                      // EVENT
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
