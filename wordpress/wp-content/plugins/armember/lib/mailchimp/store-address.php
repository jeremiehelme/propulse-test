<?php /*   Part of the code from the book  Building Findable Websites: Web Standards, SEO, and Beyond  by Aarron Walter (aarron@buildingfindablewebsites.com)  http://buildingfindablewebsites.com  Distrbuted under Creative Commons license  http://creativecommons.org/licenses/by-sa/3.0/us/*/ function storeAddress(){    global $wpdb, $ARMember, $armemail, $armfname, $armlname, $form_id, $arm_social_feature, $arm_is_social_signup, $arm_mcapi_version;    $email_settings_unser = get_option('arm_email_settings');    $arm_optins_email_settings = maybe_unserialize($email_settings_unser);    $mailchimpOpt = (isset($arm_optins_email_settings['arm_email_tools']['mailchimp'])) ? $arm_optins_email_settings['arm_email_tools']['mailchimp'] : array();    $api_key = (isset($mailchimpOpt['api_key'])) ? $mailchimpOpt['api_key'] : '';    $list_id = (isset($mailchimpOpt['list_id'])) ? $mailchimpOpt['list_id'] : '';        $double_opt_in = (isset($mailchimpOpt['enable_double_opt_in'])) ? $mailchimpOpt['enable_double_opt_in'] : 0;        if($double_opt_in == 1)        {            $double_opt_in = true;        }        else {            $double_opt_in = false;        }        $responder_list_id = '';        if($arm_is_social_signup){            $social_settings = $arm_social_feature->arm_get_social_settings();            if(isset($social_settings['options']['optins_name']) && $social_settings['options']['optins_name'] == 'mailchimp') {                $etool_name = isset($social_settings['options']['optins_name']) ? $social_settings['options']['optins_name'] : '';                $status = 1;                $responder_list_id = isset($social_settings['options'][$etool_name]['list_id']) ? $social_settings['options'][$etool_name]['list_id'] : $list_id ;            }        }        else        {            $form_settings = $wpdb->get_var("SELECT `arm_form_settings` FROM `" . $ARMember->tbl_arm_forms . "` WHERE `arm_form_id`='" . $form_id . "'");            $form_settings = (!empty($form_settings)) ? maybe_unserialize($form_settings) : array();            $status = (isset($form_settings['email']['mailchimp']['status'])) ? $form_settings['email']['mailchimp']['status'] : 0;            $responder_list_id = (isset($form_settings['email']['mailchimp']['list_id'])) ? $form_settings['email']['mailchimp']['list_id'] : $list_id;        }            if (!empty($responder_list_id) && !empty($api_key)) {        if ($status == '1' && !empty($responder_list_id))        {            /*Validation*/            if (!$armemail) {                return "No email address provided";            }            if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $armemail)) {                return "Email address is invalid";            }            $merge_vars = array('FNAME' => $armfname, 'LNAME' => $armlname);            $arm_mailchimp_dc = substr($api_key,strpos($api_key,'-')+1);            $arm_subscribe_status = 'subscribed';            if( 1 == $double_opt_in)            {                $arm_subscribe_status = 'pending';            }            $arm_mailchimp_post_fields = array(                'email_address' => $armemail,                'status' => $arm_subscribe_status,                'merge_fields' => $merge_vars,            );            $arm_mailchimp_arguments = array(                'timeout' => '5000',                'headers' => array(                    'Content-Type' => 'application/json',                    'Authorization' => 'Basic ' . base64_encode( 'user:' . $api_key )                ),                'body' => json_encode($arm_mailchimp_post_fields),            );                        $arm_mailchimp_api_url = 'https://'.$arm_mailchimp_dc.'.api.mailchimp.com/'.$arm_mcapi_version.'/lists/'.$responder_list_id.'/members';            $arm_mailchimp_subscriber = wp_remote_post($arm_mailchimp_api_url,$arm_mailchimp_arguments);        }    }    return;} /* Call MailChimp API */ storeAddress();