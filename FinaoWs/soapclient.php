<?php
$proxy = new SoapClient('http://finaonation.com/shop/api/v2_soap/?wsdl'); // TODO : change url
$sessionId = $proxy->login('apiintegrator', 'ap11ntegrator'); // TODO : change login and pwd if necessary

/*
$result = $proxy->customerCustomerCreate($sessionId, array('email' => 'customer-mail@example.org', 'firstname' => 'Dough', 'lastname' => 'Deeks', 'password' => 'password'));
print_r($result);
exit;
*/
$result = $proxy->customerCustomerList($sessionId);
$res=objectToArray($result);

$res=json_encode($res);
print_r($res);

function objectToArray( $object )
    {
        if( !is_object( $object ) && !is_array( $object ) )
        {
            return $object;
        }
        if( is_object( $object ) )
        {
            $object = get_object_vars( $object );
        }
        return array_map( 'objectToArray', $object );
    }
exit;

?>