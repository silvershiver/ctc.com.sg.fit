<?php
class All extends CI_Model {
    var $instanceapp = "fit";
    function _construct()
    {
        parent::_construct();
    }

    function base64_url_encode($input)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    function base64_url_decode($input)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    /*--XML PARSING FROM GTA--*/
    function insertNewBookingRequest($bName, $bRef, $bDepartDate, $bCheckoutDate, $paxID1, $paxName1, $paxID2, $paxName2, $price,
                                     $itemRef, $itemCityCode, $itemCode, $checkIn, $noofadult, $hotelRoomID)
    {
        $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
        $requestData .=     '<Source>';
        $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
        $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'" Currency="SGD">';
        $requestData .=             '<RequestMode>ASYNCHRONOUS</RequestMode>';
        $requestData .=             '<ResponseURL>/ProcessResponse/GetXML</ResponseURL>';
        $requestData .=         '</RequestorPreferences>';
        $requestData .=     '</Source>';
        $requestData .=     '<RequestDetails>';
        $requestData .=         '<AddBookingRequest Currency="SGD">';
        $requestData .=             '<BookingName>'.$bName.'</BookingName>';
        $requestData .=             '<BookingReference>'.$bRef.'</BookingReference>';
        $requestData .=             '<BookingDepartureDate>'.$bDepartDate.'</BookingDepartureDate>';
        $requestData .=             '<PaxNames>';
        $requestData .=             '   <PaxName PaxId="'.$paxID1.'"><![CDATA['.$paxName1.']]></PaxName>';
        $requestData .=             '   <PaxName PaxId="'.$paxID2.'"><![CDATA['.$paxName2.']]></PaxName>';
        $requestData .=             '</PaxNames>';
        $requestData .=             '<BookingItems>';
        $requestData .=             '   <BookingItem ItemType="hotel" ExpectedPrice ="'.$price.'">';
        $requestData .=             '       <ItemReference>'.$itemRef.'</ItemReference>';
        $requestData .=             '       <ItemCity Code="'.$itemCityCode.'" />';
        $requestData .=             '       <Item Code="'.$itemCode.'" />';
        $requestData .=             '       <HotelItem>';
        $requestData .=             '           <PeriodOfStay>';
        $requestData .=             '               <CheckInDate>'.$bDepartDate.'</CheckInDate>';
        $requestData .=             '               <CheckOutDate>'.$bCheckoutDate.'</CheckOutDate>';
        $requestData .=             '           </PeriodOfStay>';
        $requestData .=             '           <HotelPaxRoom Adults="'.$noofadult.'" Id="'.$hotelRoomID.'">';
        $requestData .=             '               <PaxIds>';
        $requestData .=             '                   <PaxId>'.$paxID1.'</PaxId>';
        $requestData .=             '                   <PaxId>'.$paxID2.'</PaxId>';
        $requestData .=             '               </PaxIds>';
        $requestData .=             '           </HotelPaxRoom>';
        $requestData .=             '       </HotelItem>';
        $requestData .=             '   </BookingItem>';
        $requestData .=             '</BookingItems>';
        $requestData .=         '</AddBookingRequest>';
        $requestData .=     '</RequestDetails>';
        $requestData .= '</Request>';
        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $array_output = $this->XMLtoArray($output);
        return $array_output;
    }

    function getSearchHotelPrice($destinationCode, $checkinDate, $duration, $roomCode, $numberOfRooms)
    {
        $requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
        $requestData .=     '<Source>';
        $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
        $requestData .=             '<RequestorPreferences Language="'.GTA_LANGUAGE.'" Currency="SGD" Country="SG">';
        $requestData .=                 '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
        $requestData .=             '</RequestorPreferences>';
        $requestData .=     '</Source>';
        $requestData .=     '<RequestDetails>';
        $requestData .=         '<SearchHotelPriceRequest>';
        $requestData .=             '<ItemDestination DestinationType="city" DestinationCode="'.$destinationCode.'"/>';
        $requestData .=             '<PeriodOfStay>';
        $requestData .=                 '<CheckInDate>'.$checkinDate.'</CheckInDate>';
        $requestData .=                 '<Duration>'.$duration.'</Duration>';
        $requestData .=             '</PeriodOfStay>';
        $requestData .=             '<Rooms>';
        $requestData .=                 '<Room Code="'.$roomCode.'" NumberOfRooms="'.$numberOfRooms.'"/>';
        $requestData .=             '</Rooms>';
        $requestData .=             '<OrderBy>pricelowtohigh</OrderBy>';
        $requestData .=         '</SearchHotelPriceRequest>';
        $requestData .=     '</RequestDetails>';
        $requestData .= '</Request>';
        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info   = curl_getinfo($ch);
        curl_close($ch);
        $array_output = $this->XMLtoArray($output);
        return $array_output;
    }

    function getSearchItemInformation($destinationCode, $itemCode)
    {
        $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
        $requestData .=     '<Source>';
        $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
        $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'">';
        $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
        $requestData .=         '</RequestorPreferences>';
        $requestData .=     '</Source>';
        $requestData .=     '<RequestDetails>';
        $requestData .=         '<SearchItemInformationRequest ItemType="hotel">';
        $requestData .=             '<ItemDestination DestinationType="city" DestinationCode="'.$destinationCode.'"/>';
        $requestData .=             '<ItemCode>'.$itemCode.'</ItemCode>';
        $requestData .=         '</SearchItemInformationRequest>';
        $requestData .=     '</RequestDetails>';
        $requestData .= '</Request>';
        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $array_output = $this->XMLtoArray($output);
        return $array_output;
    }

    function getSearchHotelRoomInformation($destinationCode, $itemCode, $availability_from, $availability_to, $days, $adult, $children)
    {
        $requestData = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
        $requestData .=     '<Source>';
        $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
        $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'" Currency="SGD" Country="SG">';
        $requestData .=             '<RequestMode>'.GTA_REQUEST_MODE.'</RequestMode>';
        $requestData .=         '</RequestorPreferences>';
        $requestData .= '   </Source>';
        $requestData .= '   <RequestDetails>';
        $requestData .= '       <SearchHotelPricePaxRequest>';
        $requestData .=             '<ItemDestination DestinationType="city" DestinationCode="'.$destinationCode.'"/>';
        $requestData .=             '<ItemCode>'.$itemCode.'</ItemCode>';
        $requestData .=             '<PeriodOfStay>';
        $requestData .=             '   <CheckInDate>'.$availability_from.'</CheckInDate>';
        $requestData .=             '   <Duration><![CDATA['.$days.']]></Duration>';
        $requestData .=             '</PeriodOfStay>';
        $requestData .=             '<IncludePriceBreakdown/>';
        $requestData .=             '<IncludeChargeConditions/>';
        $requestData .=             '<PaxRooms>';
        $requestData .=             '   <PaxRoom Adults="'.$adult.'" Cots="'.$children.'" RoomIndex="1" />';
        $requestData .=             '</PaxRooms>';
        $requestData .= '       </SearchHotelPricePaxRequest>';
        $requestData .= '   </RequestDetails>';
        $requestData .= '</Request>';
        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $array_output = $this->XMLtoArray($output);
        return $array_output;
    }
    /*--END OF XML PARSING FROM GTA--*/

    function frontend_login($email, $password)
    {
        $this->db->select('*');
        $this->db->from('user_access');
        $this->db->where('email_address', $email);
        $this->db->where('password', $password);
        $this->db->where('is_block', 0);
        $this->db->where('access_role', 'NORMAL');
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function backend_login($email, $password)
    {
        $this->db->select('*');
        $this->db->from('user_access');
        $this->db->where('email_address', $email);
        $this->db->where('password', $password);
        $this->db->where('is_block', 0);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function update_setting($name, $value)
    {
        $data = array(
            'value' => $value
        );
        $this->db->where('name', $name);
        $this->db->update('setting', $data);
    }

    function get_all_thumbnails($attachment_id, $product_id)
    {
        $query = $this->db->query(
        "
            SELECT * FROM attachment
            WHERE id != ".$attachment_id." AND foreign_id = ".$product_id." ORDER BY created DESC
        "
        );
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function get_related_products($sub_category_id, $product_id)
    {
        $query = $this->db->query(
        "
            SELECT * FROM product
            WHERE id != ".$product_id." AND sub_category_id = ".$sub_category_id." ORDER BY created DESC LIMIT 0,6
        "
        );
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function get_sum_amount_cart($customer_id)
    {
        $query = $this->db->query(
        "
            SELECT SUM(quantity*price_per_each) AS sum_cart FROM cart
            WHERE customer_id = ".$customer_id."
        "
        );
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function get_product_cart_filter_main($main_category_id)
    {
        $query = $this->db->query(
        "
            SELECT p.id AS product_id, p.name AS product_name, p.slug AS product_slug, p.code AS product_code,
            p.price AS product_price
            FROM product p, main_category mc, sub_category sc
            WHERE p.sub_category_id = sc.id AND sc.main_category_id = mc.id AND mc.id = ".$main_category_id."
        "
        );
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    /*--LIST FUNCTIONS--*/
    function select_template_orderby_limit($order_field, $order_value, $limit, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order_field, $order_value);
        $this->db->limit($limit);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_basic($table) {
        $this->db->select('*');
        $this->db->from($table);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template($field, $field_value, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field, $field_value);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_w_2_conditions($field1, $field_value1, $field2, $field_value2, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1, $field_value1);
        $this->db->where($field2, $field_value2);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_w_3_conditions($field1, $field_value1, $field2, $field_value2, $field3, $field_value3, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1, $field_value1);
        $this->db->where($field2, $field_value2);
        $this->db->where($field3, $field_value3);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_w_4_conditions($field1, $field_value1, $field2, $field_value2, $field3, $field_value3, $field4, $field_value4, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1, $field_value1);
        $this->db->where($field2, $field_value2);
        $this->db->where($field3, $field_value3);
        $this->db->where($field4, $field_value4);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_w_5_conditions($field1, $field_value1, $field2, $field_value2, $field3, $field_value3, $field4, $field_value4, $field5, $field_value5, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1, $field_value1);
        $this->db->where($field2, $field_value2);
        $this->db->where($field3, $field_value3);
        $this->db->where($field4, $field_value4);
        $this->db->where($field5, $field_value5);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_w_6_conditions($field1, $field_value1, $field2, $field_value2, $field3, $field_value3, $field4, $field_value4, $field5, $field_value5, $field6, $field_value6, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1, $field_value1);
        $this->db->where($field2, $field_value2);
        $this->db->where($field3, $field_value3);
        $this->db->where($field4, $field_value4);
        $this->db->where($field5, $field_value5);
        $this->db->where($field6, $field_value6);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_w_7_conditions($field1, $field_value1, $field2, $field_value2, $field3, $field_value3, $field4, $field_value4, $field5, $field_value5, $field6, $field_value6, $field7, $field_value7, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1, $field_value1);
        $this->db->where($field2, $field_value2);
        $this->db->where($field3, $field_value3);
        $this->db->where($field4, $field_value4);
        $this->db->where($field5, $field_value5);
        $this->db->where($field6, $field_value6);
        $this->db->where($field7, $field_value7);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_w_8_conditions($field1, $field_value1, $field2, $field_value2, $field3, $field_value3, $field4, $field_value4, $field5, $field_value5, $field6, $field_value6, $field7, $field_value7, $field8, $field_value8, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1, $field_value1);
        $this->db->where($field2, $field_value2);
        $this->db->where($field3, $field_value3);
        $this->db->where($field4, $field_value4);
        $this->db->where($field5, $field_value5);
        $this->db->where($field6, $field_value6);
        $this->db->where($field7, $field_value7);
        $this->db->where($field8, $field_value8);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_with_order($field, $field_value, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($field, $field_value);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_with_where_LIMIT($field, $field_value, $limit, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field, $field_value);
        $this->db->limit($limit);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_with_like_and_order($field, $field_value, $order, $order_value, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->like($field, $field_value);
        $this->db->order_by($order, $order_value);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_with_where_and_order($field, $field_value, $order, $order_value, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field, $field_value);
        $this->db->order_by($order, $order_value);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_with_where2_and_order($field, $field_value, $field1, $field_value1, $order, $order_value, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field, $field_value);
        $this->db->where($field1, $field_value1);
        $this->db->order_by($order, $order_value);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_with_where3_and_order($field, $field_value, $field1, $field_value1, $field2, $field_value2, $order, $order_value, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field, $field_value);
        $this->db->where($field1, $field_value1);
        $this->db->where($field2, $field_value2);
        $this->db->order_by($order, $order_value);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_with_where_limit_and_order($field, $field_value, $order, $order_value, $limit, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field, $field_value);
        $this->db->order_by($order, $order_value);
        $this->db->limit($limit);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_with_where_double_limit($field1, $field_value1, $field2, $field_value2, $limit, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1, $field_value1);
        $this->db->where($field2, $field_value2);
        $this->db->limit($limit);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_with_where_triple_limit($field1, $field_value1, $field2, $field_value2, $field3, $field_value3, $limit, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1, $field_value1);
        $this->db->where($field2, $field_value2);
        $this->db->where($field3, $field_value3);
        $this->db->limit($limit);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_with_where_quadruple_limit($field1, $field_value1, $field2, $field_value2, $field3, $field_value3, $field4, $field_value4, $limit, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1, $field_value1);
        $this->db->where($field2, $field_value2);
        $this->db->where($field3, $field_value3);
        $this->db->where($field4, $field_value4);
        $this->db->limit($limit);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    function select_template_with_where_limitoffset_and_order(
        $field, $field_value, $order, $order_value, $limit, $offset, $table) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field, $field_value);
        $this->db->order_by($order, $order_value);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }
    /*--END OF LIST FUNCTIONS--*/

    /*--INSERT FUNCTIONS--*/
    function insert_template($data_fields, $table)
    {
        $this->db->insert($table, $data_fields);
    }
    /*--END OF INSERT FUNCTIONS--*/

    /*--UPDATE FUNCTIONS--*/
    function update_template($data_fields, $field, $field_id, $table)
    {
        $this->db->where($field, $field_id);
        $this->db->update($table, $data_fields);
    }
    function update_template_two($data_fields, $field, $field_id, $field2, $field_id2, $table)
    {
        $this->db->where($field, $field_id);
        $this->db->where($field2, $field_id2);
        $this->db->update($table, $data_fields);
    }
    function update_template_three($data_fields, $field, $field_id, $field2, $field_id2, $field3, $field_id3, $table)
    {
        $this->db->where($field, $field_id);
        $this->db->where($field2, $field_id2);
        $this->db->where($field3, $field_id3);
        $this->db->update($table, $data_fields);
    }
    function update_template_four($data_fields, $field, $field_id, $field2, $field_id2, $field3, $field_id3, $field4, $field_id4, $table)
    {
        $this->db->where($field, $field_id);
        $this->db->where($field2, $field_id2);
        $this->db->where($field3, $field_id3);
        $this->db->where($field4, $field_id4);
        $this->db->update($table, $data_fields);
    }
    function update_template_five($data_fields, $field, $field_id, $field2, $field_id2, $field3, $field_id3, $field4, $field_id4, $field5, $field_id5, $table)
    {
        $this->db->where($field, $field_id);
        $this->db->where($field2, $field_id2);
        $this->db->where($field3, $field_id3);
        $this->db->where($field4, $field_id4);
        $this->db->where($field5, $field_id5);
        $this->db->update($table, $data_fields);
    }
    /*--END OF UPDATE FUNCTIONS*/

    /*--DELETE FUNCTIONS--*/
    function delete_template($field, $field_id, $table) {
        $this->db->where($field, $field_id);
        $this->db->delete($table);
    }

    function delete_template_w_2_conditions($field1, $field_id1, $field2, $field_id2, $table) {
        $this->db->where($field1, $field_id1);
        $this->db->where($field2, $field_id2);
        $this->db->delete($table);
    }

    function delete_template_w_3_conditions($field1, $field_id1, $field2, $field_id2, $field3, $field_id3, $table) {
        $this->db->where($field1, $field_id1);
        $this->db->where($field2, $field_id2);
        $this->db->where($field3, $field_id3);
        $this->db->delete($table);
    }

    function delete_empty_table($table) {
        $this->db->empty_table($table);
    }
    /*--END OF DELETE FUNCTIONS--*/

    function format_datetime_abacus($datetime)
    {
        $current_year = date("Y");
        $replace      = str_replace("T", " ", $datetime);
        $fullformat_date = $current_year.'-'.$replace;
        $real_format = date("H:i l, d F", strtotime($fullformat_date));
        return $real_format;
    }

    function format_datetime_return_abacus($datetime)
    {
        $replace         = str_replace("T", " ", $datetime);
        $fullformat_date = $replace;
        $real_format = date("H:i l, d F", strtotime($fullformat_date));
        return $real_format;
    }

    function get_airlines_details($code)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query($connection, "SELECT * FROM flight_airlines WHERE code = '".$code."'");
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["name"];
    }

    function list_city_country()
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $list_res = mysqli_query(
            $connection,
            "SELECT * FROM flight_airportV2"
        );
        if( mysqli_num_rows($list_res) > 0 ) {
            $array_value = array();
            while( $list_row = mysqli_fetch_array($list_res, MYSQL_ASSOC) ) {
                $array_value[] = "'".$list_row["name"].' ('.$list_row["code"].') - '.$list_row["city_name"].' - '.$list_row["country_name"].''."'";
            }
        }
        $implode_array = implode(",", $array_value);
        return $implode_array;
    }

    function list_typehea_hotel()
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $list_res = mysqli_query(
            $connection,
            "
                SELECT hlcity.city_name AS city_name, hlcg.country_name AS country_name, hlcity.city_code AS city_code
                FROM hotel_list_country_gta hlcg, hotel_list_city_gta hlcity
                WHERE hlcg.country_code = hlcity.country_code GROUP BY hlcity.city_code
            "
        );
        if( mysqli_num_rows($list_res) > 0 ) {
            $array_value = array();
            while( $list_row = mysqli_fetch_array($list_res, MYSQL_ASSOC) ) {
                $array_value[] = "'".$list_row["city_name"].' ('.$list_row["city_code"].') - '.$list_row["country_name"]."'";
            }
        }
        $implode_array = implode(",", $array_value);
        return $implode_array;

    }

    function XMLtoArray($XML)
    {
        $xml_parser = xml_parser_create();
        xml_parse_into_struct($xml_parser, $XML, $vals);
        xml_parser_free($xml_parser);
        $_tmp='';
        foreach ($vals as $xml_elem) {
            $x_tag=$xml_elem['tag'];
            $x_level=$xml_elem['level'];
            $x_type=$xml_elem['type'];
            if ($x_level!=1 && $x_type == 'close') {
                if (isset($multi_key[$x_tag][$x_level]))
                    $multi_key[$x_tag][$x_level]=1;
                else
                    $multi_key[$x_tag][$x_level]=0;
            }
            if ($x_level!=1 && $x_type == 'complete') {
                if ($_tmp==$x_tag)
                    $multi_key[$x_tag][$x_level]=1;
                $_tmp=$x_tag;
            }
        }
        // jedziemy po tablicy
        foreach ($vals as $xml_elem) {
            $x_tag=$xml_elem['tag'];
            $x_level=$xml_elem['level'];
            $x_type=$xml_elem['type'];
            if ($x_type == 'open')
                $level[$x_level] = $x_tag;
            $start_level = 1;
            $php_stmt = '$xml_array';
            if ($x_type=='close' && $x_level!=1)
                $multi_key[$x_tag][$x_level]++;
            while ($start_level < $x_level) {
                $php_stmt .= '[$level['.$start_level.']]';
                if (isset($multi_key[$level[$start_level]][$start_level]) && $multi_key[$level[$start_level]][$start_level])
                    $php_stmt .= '['.($multi_key[$level[$start_level]][$start_level]-1).']';
                $start_level++;
            }
            $add='';
            if (isset($multi_key[$x_tag][$x_level]) && $multi_key[$x_tag][$x_level] && ($x_type=='open' || $x_type=='complete')) {
                if (!isset($multi_key2[$x_tag][$x_level]))
                    $multi_key2[$x_tag][$x_level]=0;
                else
                    $multi_key2[$x_tag][$x_level]++;
                $add='['.$multi_key2[$x_tag][$x_level].']';
            }
            if (isset($xml_elem['value']) && trim($xml_elem['value'])!='' && !array_key_exists('attributes', $xml_elem)) {
                if ($x_type == 'open')
                    $php_stmt_main=$php_stmt.'[$x_type]'.$add.'[\'content\'] = $xml_elem[\'value\'];';
                else
                    $php_stmt_main=$php_stmt.'[$x_tag]'.$add.' = $xml_elem[\'value\'];';
                eval($php_stmt_main);
            }
            if (array_key_exists('attributes', $xml_elem)) {
                if (isset($xml_elem['value'])) {
                    $php_stmt_main=$php_stmt.'[$x_tag]'.$add.'[\'content\'] = $xml_elem[\'value\'];';
                    eval($php_stmt_main);
                }
                foreach ($xml_elem['attributes'] as $key=>$value) {
                    $php_stmt_att=$php_stmt.'[$x_tag]'.$add.'[$key] = $value;';
                    eval($php_stmt_att);
                }
            }
        }
        return $xml_array;
    }

    function convertToHoursMins($time, $format = '%02d:%02d')
    {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    function get_terminal_airport_no($airport_terminal)
    {
        if( $airport_terminal != "" || $airport_terminal != 0 ) {
            $terminal = "(Terminal ".$airport_terminal.")";
        }
        else {
            $terminal = "";
        }
        return $terminal;
    }

    function get_airport_name($code)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query($connection, "SELECT * FROM flight_airportV2 WHERE code = '".$code."'");
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["name"];
    }

    function get_airport_city_name($code)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query($connection, "SELECT * FROM flight_airportV2 WHERE code = '".$code."'");
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["city_name"];
    }

    function get_airport_country_name($code)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query($connection, "SELECT * FROM flight_airportV2 WHERE code = '".$code."'");
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["country_name"];
    }

    function get_country_hotel_bycitycode($city_code)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT hcountry.country_name AS country_name FROM hotel_list_city_gta hcity, hotel_list_country_gta hcountry
                WHERE hcity.country_code = hcountry.country_code AND hcity.city_code = '".$city_code."'
            "
        );
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["country_name"];
    }

    function list_of_airlines($flight_result_array)
    {
        $data_count = sizeof($flight_result_array);
        $array_airlines = array();
        for($x=0; $x<$data_count; $x++ ) {
            $array_airlines[] = $this->get_airlines_details($flight_result_array[$x]['FLIGHTSEGMENT'][$x]['MARKETINGAIRLINE']['CODE']);
        }
        return $array_airlines;
    }

    /*--CRUISES--*/
    function getCruiseShipName($shipID)
    {
        $shipNames = $this->select_template("ID", $shipID, "cruise_ships");
        foreach( $shipNames AS $shipName ) {
            $ship_name_print = $shipName->SHIP_NAME;
        }
        echo $ship_name_print;
    }

    function getCruiseBrandID($shipID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT cb.ID AS brand_id FROM cruise_ships cs, cruise_brand cb
                WHERE cs.PARENT_BRAND = cb.ID AND cs.ID = ".$shipID."
            "
        );
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["brand_id"];
    }

    function getCruiseBrandName($shipID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT cb.NAME AS brand_name FROM cruise_ships cs, cruise_brand cb
                WHERE cs.PARENT_BRAND = cb.ID AND cs.ID = ".$shipID."
            "
        );
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["brand_name"];
    }

    function getCruiseTitleName($cruiseTitleID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT * FROM cruise_title WHERE ID = ".$cruiseTitleID.""
        );
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["CRUISE_TITLE"];
    }

    function getCruiseTitleTourCode($cruiseTitleID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT * FROM cruise_title WHERE ID = ".$cruiseTitleID.""
        );
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["CRUISE_TOUR_CODE"];
    }

    function getShipIDByTitleID($cruiseTitleID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT * FROM cruise_title WHERE ID = ".$cruiseTitleID.""
        );
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["SHIP_ID"];
    }

    function getCruiseBrandNameByBrandID($brandID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if( $brandID == "ALL" ) {
            $brandName = "ALL";
        }
        else {
            $check_res  = mysqli_query(
                $connection, "SELECT * FROM cruise_brand WHERE ID = ".$brandID.""
            );
            $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
            $brandName = $check_row["NAME"];
        }
        return $brandName;
    }
    /*--END OF CRUISES--*/

    /*--START LOOPING MONTH AND YEAR--*/
    function get_months($startstring, $endstring)
    {
        $time1 = strtotime($startstring);
        $time2 = strtotime($endstring);
        $my1   = date('mY', $time1);
        $my2   = date('mY', $time2);
        $year1 = date('Y', $time1);
        $year2 = date('Y', $time2);
        $years = range($year1, $year2);
        foreach( $years as $year ) {
            $months[$year] = array();
            while( $time1 < $time2 ) {
                if( date('Y',$time1) == $year ) {
                    $months[$year][] = date('F', $time1);
                    $time1 = strtotime(date('Y-m-d', $time1).' +1 month');
                }
                else {
                    break;
                }
            }
            continue;
        }
        return $months;
    }
    /*--END OF START LOOPING MONTH AND YEAR--*/

    /*--Get landtour image--*/
    function getLandtourImage($landtourProductID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT * FROM landtour_image WHERE landtour_product_id = ".$landtourProductID." AND imgStatus = 'PRIMARY'
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
            $imageShow = base_url().'assets/landtour_img/'.$check_row["file_name"];
        }
        else {
            $imageShow = base_url().'assets/images/default.png';
        }
        return $imageShow;
    }
    /*--End of get landtour image--*/

    /*--Get cruise image--*/
    function getCruiseImage($cruiseTitleID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT * FROM cruise_image WHERE cruise_title_id = ".$cruiseTitleID." AND imgStatus = 'PRIMARY'"
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
            $imageShow = base_url().'assets/cruise_img/'.$check_row["file_name"];
            if( file_exists($imageShow) ) {
                $imagePrint = $imageShow;
            }
            else {
                $imagePrint = base_url().'assets/images/default.png';
            }
        }
        else {
            $imagePrint = base_url().'assets/images/default.png';
        }
        return $imagePrint;
    }
    /*--End of get cruise image--*/

    /*--Get cruise starting price (lowest)--*/
    function getStartingPrice($cruiseTitleID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query($connection, "SELECT * FROM cruise_title WHERE ID = ".$cruiseTitleID."");
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["STARTING_PRICE"];
    }
    /*--End of get cruise starting price (lowest)--*/

    /*--Get stateroom details by ID--*/
    function getStateroomDetails($stateroomID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT * FROM cruise_stateroom WHERE ID = ".$stateroomID.""
        );
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["STATEROOM_NAME"];
    }

    function getStateroomDetails2($stateroomID, $brandID, $shipID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT * FROM cruise_stateroom
                WHERE ID = ".$stateroomID." AND CRUISE_BRAND_ID = ".$brandID." AND CRUISE_SHIP_ID = ".$shipID."
            "
        );
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["STATEROOM_NAME"];
    }
    /*--End of get stateroom details by ID--*/

    /*--Get cruise price list--*/
    function checkDateRuleLow($shipID, $brandID, $noPax, $cruiseDate)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
        $connection,
            "
                SELECT * FROM cruise_prices_date_rule
                WHERE cruise_brand_id = ".$brandID." AND cruise_ship_id = ".$shipID." AND no_of_nights = ".$noPax."
                AND date_from <= '".$cruiseDate."' AND date_to >= '".$cruiseDate."' AND period_type = 'LOW'
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            $resultDateRuleLow = "YES";
        }
        else {
            $resultDateRuleLow = "NO";
        }
        return $resultDateRuleLow;
    }

    function checkDateRuleShoulder($shipID, $brandID, $noPax, $cruiseDate)
    {
        $connection  = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
        $connection,
            "
                SELECT * FROM cruise_prices_date_rule
                WHERE cruise_brand_id = ".$brandID." AND cruise_ship_id = ".$shipID." AND no_of_nights = ".$noPax."
                AND date_from <= '".$cruiseDate."' AND date_to >= '".$cruiseDate."' AND period_type = 'SHOULDER'
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            $resultDateRuleShoulder = "YES";
        }
        else {
            $resultDateRuleShoulder = "NO";
        }
        return $resultDateRuleShoulder;
    }

    function checkDateRulePeak($shipID, $brandID, $noPax, $cruiseDate)
    {
        $resultDateRulePeak = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
        $connection,
            "
                SELECT * FROM cruise_prices_date_rule
                WHERE cruise_brand_id = ".$brandID." AND cruise_ship_id = ".$shipID." AND no_of_nights = ".$noPax."
                AND date_from <= '".$cruiseDate."' AND date_to >= '".$cruiseDate."' AND period_type = 'PEAK'
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            $resultDateRulePeak = "YES";
        }
        else {
            $resultDateRulePeak = "NO";
        }
        return $resultDateRulePeak;
    }

    function getDiscountApplied($brandID, $shipID, $noofnight, $stateroomID)
    {
        $discountApplied = 0;
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $discount_res = mysqli_query(
            $connection,
            "
                SELECT * FROM cruise_discount
                WHERE cruise_brand_id = ".$brandID." AND cruise_ship_id = ".$shipID."
                AND no_of_nights = '".$noofnight."' AND stateroomID = ".$stateroomID."
            "
        );
        if( mysqli_num_rows($discount_res) > 0 ) {
            while( $discount_row = mysqli_fetch_array($discount_res, MYSQL_ASSOC) ) {
                $discountApplied += $discount_row["extra_price_value"];
            }
        }
        else {
            $discountApplied = 0;
        }
        return $discountApplied;
    }

    function getExtraCharge($brandID, $shipID, $noofnight, $cruiseDate, $stateroomID)
 	{
	 	$arrayData = array();
	 	$connection    = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	 	$peakCheck 	   = $this->checkDateRulePeak($shipID, $brandID, $noofnight, $cruiseDate);
		$shoulderCheck = $this->checkDateRuleShoulder($shipID, $brandID, $noofnight, $cruiseDate);
		$lowCheck 	   = $this->checkDateRuleLow($shipID, $brandID, $noofnight, $cruiseDate);
		$org 		 = "";
		$extraID 	 = "";
		$extraPeriod = "";
		if( $peakCheck == "YES" ) {
			$extra_res = mysqli_query(
			$connection,
				"
					SELECT * FROM cruise_extra_price
					WHERE cruise_brand_id = ".$brandID." AND cruise_ship_id = ".$shipID."
					AND period_type = 'PEAK' AND no_of_nights = '".$noofnight."' AND stateroomID = ".$stateroomID."
				"
			);
			if( mysqli_num_rows($extra_res) > 0 ) {
				while( $extra_row = mysqli_fetch_array($extra_res, MYSQL_ASSOC) ) {
					$org 	    += $extra_row["extra_price_value"];
					$extraID    .= $extra_row["id"].",";
					$extraPeriod = $extra_row["period_type"];
				}
			}
			else {
				$org = 0;
				$extraID 	 = "-";
				$extraPeriod = "-";
			}
		}
		else {
			if( $shoulderCheck == "YES" ) {
				$extra_res = mysqli_query(
				$connection,
					"
						SELECT * FROM cruise_extra_price
						WHERE cruise_brand_id = ".$brandID." AND cruise_ship_id = ".$shipID."
						AND period_type = 'SHOULDER' AND no_of_nights = '".$noofnight."' AND stateroomID = ".$stateroomID."
					"
				);
				if( mysqli_num_rows($extra_res) > 0 ) {
					while( $extra_row = mysqli_fetch_array($extra_res, MYSQL_ASSOC) ) {
						$org += $extra_row["extra_price_value"];
						$extraID    .= $extra_row["id"].",";
						$extraPeriod = $extra_row["period_type"];
					}
				}
				else {
					$org = 0;
					$extraID 	 = "-";
					$extraPeriod = "-";
				}
			}
			else {
				if( $lowCheck == "YES" ) {
					$extra_res = mysqli_query(
					$connection,
						"
							SELECT * FROM cruise_extra_price
							WHERE cruise_brand_id = ".$brandID." AND cruise_ship_id = ".$shipID."
							AND period_type = 'LOW' AND no_of_nights = '".$noofnight."' AND stateroomID = ".$stateroomID."
						"
					);
					if( mysqli_num_rows($extra_res) > 0 ) {
						while( $extra_row = mysqli_fetch_array($extra_res, MYSQL_ASSOC) ) {
							$org += $extra_row["extra_price_value"];
							$extraID    .= $extra_row["id"].",";
							$extraPeriod = $extra_row["period_type"];
						}
					}
					else {
						$org = 0;
						$extraID 	 = "-";
						$extraPeriod = "-";
					}
				}
			}
		}
		$arrayData["extraPrice"]  = $org;
		$arrayData["extraIDs"]    = trim($extraID, ",");
		$arrayData["extraPeriod"] = $extraPeriod;
		return $arrayData;
 	}

    function getCruisePriceListByOrderNumber($shipID, $brandID, $stateroomID, $numberGiven, $cruiseDate, $noCruise)
    {
        $connection    = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $peakCheck     = $this->checkDateRulePeak($shipID, $brandID, $noCruise, $cruiseDate);
        $shoulderCheck = $this->checkDateRuleShoulder($shipID, $brandID, $noCruise, $cruiseDate);
        $lowCheck      = $this->checkDateRuleLow($shipID, $brandID, $noCruise, $cruiseDate);
        if( $numberGiven == 1 ) {
            if( $peakCheck == "YES" ) {
                $check_res  = mysqli_query(
                $connection,
                    "
                        SELECT ATT_1 AS ATT_1 FROM cruise_prices
                        WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                        AND PERIOD_TYPE = 'PEAK' AND NIGHTS_NO = '".$noCruise."'
                    "
                );
                $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                $finalPrice = $check_row["ATT_1"];
            }
            else {
                if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                    $connection,
                        "
                            SELECT ATT_1 AS ATT_1 FROM cruise_prices
                            WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                            AND PERIOD_TYPE = 'SHOULDER' AND NIGHTS_NO = '".$noCruise."'
                        "
                    );
                    $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                    $finalPrice = $check_row["ATT_1"];
                }
                else {
                    if( $lowCheck == "YES" ) {
                        $check_res  = mysqli_query(
                        $connection,
                            "
                                SELECT ATT_1 AS ATT_1 FROM cruise_prices
                                WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                                AND PERIOD_TYPE = 'LOW' AND NIGHTS_NO = '".$noCruise."'
                            "
                        );
                        $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                        $finalPrice = $check_row["ATT_1"];
                    }
                    else {
                        $finalPrice = 0;
                    }
                }
            }
        }
        else if( $numberGiven == 2 ) {
            if( $peakCheck == "YES" ) {
                $check_res  = mysqli_query(
                $connection,
                    "
                        SELECT ATT_2 AS ATT_2 FROM cruise_prices
                        WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                        AND PERIOD_TYPE = 'PEAK' AND NIGHTS_NO = '".$noCruise."'
                    "
                );
                $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                $finalPrice = $check_row["ATT_2"];
            }
            else {
                if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                    $connection,
                        "
                            SELECT ATT_2 AS ATT_2 FROM cruise_prices
                            WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                            AND PERIOD_TYPE = 'SHOULDER' AND NIGHTS_NO = '".$noCruise."'
                        "
                    );
                    $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                    $finalPrice = $check_row["ATT_2"];
                }
                else {
                    if( $lowCheck == "YES" ) {
                        $check_res  = mysqli_query(
                        $connection,
                            "
                                SELECT ATT_2 AS ATT_2 FROM cruise_prices
                                WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                                AND PERIOD_TYPE = 'LOW' AND NIGHTS_NO = '".$noCruise."'
                            "
                        );
                        $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                        $finalPrice = $check_row["ATT_2"];
                    }
                    else {
                        $finalPrice = 0;
                    }
                }
            }
        }
        else if( $numberGiven == 3 ) {
            if( $peakCheck == "YES" ) {
                $check_res  = mysqli_query(
                $connection,
                    "
                        SELECT ATT_3 AS ATT_3 FROM cruise_prices
                        WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                        AND PERIOD_TYPE = 'PEAK' AND NIGHTS_NO = '".$noCruise."'
                    "
                );
                $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                $finalPrice = $check_row["ATT_3"];
            }
            else {
                if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                    $connection,
                        "
                            SELECT ATT_3 AS ATT_3 FROM cruise_prices
                            WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                            AND PERIOD_TYPE = 'SHOULDER' AND NIGHTS_NO = '".$noCruise."'
                        "
                    );
                    $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                    $finalPrice = $check_row["ATT_3"];
                }
                else {
                    if( $lowCheck == "YES" ) {
                        $check_res  = mysqli_query(
                        $connection,
                            "
                                SELECT ATT_3 AS ATT_3 FROM cruise_prices
                                WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                                AND PERIOD_TYPE = 'LOW' AND NIGHTS_NO = '".$noCruise."'
                            "
                        );
                        $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                        $finalPrice = $check_row["ATT_3"];
                    }
                    else {
                        $finalPrice = 0;
                    }
                }
            }
        }
        else if( $numberGiven >= 4 ) {
            if( $peakCheck == "YES" ) {
                $check_res  = mysqli_query(
                $connection,
                    "
                        SELECT ATT_4 AS ATT_4 FROM cruise_prices
                        WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                        AND PERIOD_TYPE = 'PEAK' AND NIGHTS_NO = '".$noCruise."'
                    "
                );
                $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                $finalPrice = $check_row["ATT_4"];
            }
            else {
                if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                    $connection,
                        "
                            SELECT ATT_4 AS ATT_4 FROM cruise_prices
                            WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                            AND PERIOD_TYPE = 'SHOULDER' AND NIGHTS_NO = '".$noCruise."'
                        "
                    );
                    $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                    $finalPrice = $check_row["ATT_4"];
                }
                else {
                    if( $lowCheck == "YES" ) {
                        $check_res  = mysqli_query(
                        $connection,
                            "
                                SELECT ATT_4 AS ATT_4 FROM cruise_prices
                                WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                                AND PERIOD_TYPE = 'LOW' AND NIGHTS_NO = '".$noCruise."'
                            "
                        );
                        $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                        $finalPrice = $check_row["ATT_4"];
                    }
                    else {
                        $finalPrice = 0;
                    }
                }
            }
        }
        return $finalPrice;
    }

    function getCruisePriceList($shipID, $brandID, $stateroomID, $noPax, $cruiseDate, $noCruise)
    {
        $connection    = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $peakCheck     = $this->checkDateRulePeak($shipID, $brandID, $noCruise, $cruiseDate);
        $shoulderCheck = $this->checkDateRuleShoulder($shipID, $brandID, $noCruise, $cruiseDate);
        $lowCheck      = $this->checkDateRuleLow($shipID, $brandID, $noCruise, $cruiseDate);
        if( $noPax == 1 ) {
            if( $peakCheck == "YES" ) {
                $check_res  = mysqli_query(
                $connection,
                    "
                        SELECT ATT_1 AS ATT_1 FROM cruise_prices
                        WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                        AND PERIOD_TYPE = 'PEAK' AND NIGHTS_NO = '".$noCruise."'
                    "
                );
                $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                $finalPrice = $check_row["ATT_1"];
            }
            else {
                if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                    $connection,
                        "
                            SELECT ATT_1 AS ATT_1 FROM cruise_prices
                            WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                            AND PERIOD_TYPE = 'SHOULDER' AND NIGHTS_NO = '".$noCruise."'
                        "
                    );
                    $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                    $finalPrice = $check_row["ATT_1"];
                }
                else {
                    if( $lowCheck == "YES" ) {
                        $check_res  = mysqli_query(
                        $connection,
                            "
                                SELECT ATT_1 AS ATT_1 FROM cruise_prices
                                WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                                AND PERIOD_TYPE = 'LOW' AND NIGHTS_NO = '".$noCruise."'
                            "
                        );
                        $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                        $finalPrice = $check_row["ATT_1"];
                    }
                    else {
                        $finalPrice = 0;
                    }
                }
            }
        }
        else if( $noPax == 2 ) {
            if( $peakCheck == "YES" ) {
                $check_res  = mysqli_query(
                $connection,
                    "
                        SELECT ATT_2 AS ATT_2 FROM cruise_prices
                        WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                        AND PERIOD_TYPE = 'PEAK' AND NIGHTS_NO = '".$noCruise."'
                    "
                );
                $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                $finalPrice = $check_row["ATT_2"];
            }
            else {
                if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                    $connection,
                        "
                            SELECT ATT_2 AS ATT_2 FROM cruise_prices
                            WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                            AND PERIOD_TYPE = 'SHOULDER' AND NIGHTS_NO = '".$noCruise."'
                        "
                    );
                    $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                    $finalPrice = $check_row["ATT_2"];
                }
                else {
                    if( $lowCheck == "YES" ) {
                        $check_res  = mysqli_query(
                        $connection,
                            "
                                SELECT ATT_2 AS ATT_2 FROM cruise_prices
                                WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                                AND PERIOD_TYPE = 'LOW' AND NIGHTS_NO = '".$noCruise."'
                            "
                        );
                        $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                        $finalPrice = $check_row["ATT_2"];
                    }
                    else {
                        $finalPrice = 0;
                    }
                }
            }
        }
        else if( $noPax == 3 ) {
            if( $peakCheck == "YES" ) {
                $check_res  = mysqli_query(
                $connection,
                    "
                        SELECT ATT_3 AS ATT_3 FROM cruise_prices
                        WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                        AND PERIOD_TYPE = 'PEAK' AND NIGHTS_NO = '".$noCruise."'
                    "
                );
                $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                $finalPrice = $check_row["ATT_3"];
            }
            else {
                if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                    $connection,
                        "
                            SELECT ATT_3 AS ATT_3 FROM cruise_prices
                            WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                            AND PERIOD_TYPE = 'SHOULDER' AND NIGHTS_NO = '".$noCruise."'
                        "
                    );
                    $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                    $finalPrice = $check_row["ATT_3"];
                }
                else {
                    if( $lowCheck == "YES" ) {
                        $check_res  = mysqli_query(
                        $connection,
                            "
                                SELECT ATT_3 AS ATT_3 FROM cruise_prices
                                WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                                AND PERIOD_TYPE = 'LOW' AND NIGHTS_NO = '".$noCruise."'
                            "
                        );
                        $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                        $finalPrice = $check_row["ATT_3"];
                    }
                    else {
                        $finalPrice = 0;
                    }
                }
            }
        }
        else if( $noPax >= 4 ) {
            if( $peakCheck == "YES" ) {
                $check_res  = mysqli_query(
                $connection,
                    "
                        SELECT ATT_4 AS ATT_4 FROM cruise_prices
                        WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                        AND PERIOD_TYPE = 'PEAK' AND NIGHTS_NO = '".$noCruise."'
                    "
                );
                $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                $finalPrice = $check_row["ATT_4"];
            }
            else {
                if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                    $connection,
                        "
                            SELECT ATT_4 AS ATT_4 FROM cruise_prices
                            WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                            AND PERIOD_TYPE = 'SHOULDER' AND NIGHTS_NO = '".$noCruise."'
                        "
                    );
                    $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                    $finalPrice = $check_row["ATT_4"];
                }
                else {
                    if( $lowCheck == "YES" ) {
                        $check_res  = mysqli_query(
                        $connection,
                            "
                                SELECT ATT_4 AS ATT_4 FROM cruise_prices
                                WHERE SHIP_ID = ".$shipID." AND BRAND_ID = ".$brandID." AND STATEROOM_ID = ".$stateroomID."
                                AND PERIOD_TYPE = 'LOW' AND NIGHTS_NO = '".$noCruise."'
                            "
                        );
                        $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
                        $finalPrice = $check_row["ATT_4"];
                    }
                    else {
                        $finalPrice = 0;
                    }
                }
            }
        }
        return $finalPrice;
    }
    /*--End of Get cruise price list--*/

    /*--Month format--*/
    function getMonthFormat($monthName)
    {
        if( $monthName == "January" || $monthName == "Jan" ) {
            $returnValue = "01";
        }
        else if( $monthName == "February" || $monthName == "Feb" ) {
            $returnValue = "02";
        }
        else if( $monthName == "March" || $monthName == "Mar" ) {
            $returnValue = "03";
        }
        else if( $monthName == "April" || $monthName == "Apr" ) {
            $returnValue = "04";
        }
        else if( $monthName == "May" || $monthName == "May" ) {
            $returnValue = "05";
        }
        else if( $monthName == "June" || $monthName == "Jun" ) {
            $returnValue = "06";
        }
        else if( $monthName == "July" || $monthName == "Jul" ) {
            $returnValue = "07";
        }
        else if( $monthName == "August" || $monthName == "August" ) {
            $returnValue = "08";
        }
        else if( $monthName == "September" || $monthName == "Sep" ) {
            $returnValue = "09";
        }
        else if( $monthName == "October" || $monthName == "Oct" ) {
            $returnValue = "10";
        }
        else if( $monthName == "November" || $monthName == "Nov" ) {
            $returnValue = "11";
        }
        else if( $monthName == "December" || $monthName == "Dec" ) {
            $returnValue = "12";
        }
        return $returnValue;
    }
    /*--End of month format*/

    function multipleBrandID($array_implode)
    {
        $brandString = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT * FROM cruise_ships WHERE PARENT_BRAND IN(".$array_implode.")"
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                $brandString .= $check_row["ID"].',';
            }
        }
        else {
            $brandString = "";
        }
        return $brandString;
    }

    function get_sumExtraCharge($cruiseBrandID, $cruiseShipID, $cruisenon)
    {
        $final_price = 0;
        $extras = $this->select_template_w_3_conditions(
            "cruise_brand_id", $cruiseBrandID, "cruise_ship_id", $cruiseShipID, "no_of_nights", $cruisenon, "cruise_extra_price"
        );
        if( $extras == TRUE ) {
            foreach( $extras AS $extra ) {
                $final_price += $extra->extra_price_value;
            }
        }
        else {
            $final_price = 0;
        }
        return $final_price;
    }

    function get_sumExtraChargeByID($array_implode_id)
    {
        if( $array_implode_id != "" && $array_implode_id != "-" ) {
            $final_price = 0;
            $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            $check_res  = mysqli_query(
                $connection,
                "SELECT * FROM cruise_extra_price WHERE id IN(".$array_implode_id.")"
            );
            if( mysqli_num_rows($check_res) > 0 ) {
                while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                    $final_price += $check_row["extra_price_value"];
                }
            }
            else {
                $final_price = 0;
            }
        }
        else {
            $final_price = 0;
        }
        return $final_price;
    }

    function getCountCart($user_access_id)
    {
        $countCart = 0;
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT COUNT(*) AS totalCart FROM cruise_cart WHERE user_access_id = ".$user_access_id.""
        );
        $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        $countCart = $check_row["totalCart"];
        return $countCart;
    }

    function getEmailUser($bookOrderID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT * FROM cruise_traverlerInfo WHERE bookOrderID = '".$bookOrderID."' AND contactPurchase = 1"
        );
        $check_row     = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        $email_address = $check_row["traveler_email"];
        return $email_address;
    }

    function getUserAccessID($emailAddress)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT * FROM user_access WHERE email_address = '".$emailAddress."'"
        );
        $check_row     = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        $userID = $check_row["id"];
        return $userID;
    }

    function query_price_syntax($noofnight, $shipID, $brandID, $periodType, $noofoccupant)
    {
        $query_syntax =
        "
            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
            cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
            cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
            FROM cruise_prices cp, cruise_stateroom cs
            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = '".$periodType."' AND (cp.ATT_SINGLE != '' OR cp.ATT_SINGLE != 0)
            AND cs.STATEROOM_OCCUPANT = ".$noofoccupant."
            GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
        ";
        return $query_syntax;
    }

    function query_cheapest_price_syntax($noofnight, $shipID, $brandID, $periodType)
    {
        $query_syntax =
        "
            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
            cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
            cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT, cs.STATEROOM_ROOM_QTY AS STATEROOM_ROOM_QTY
            FROM cruise_prices cp, cruise_stateroom cs
            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = '".$periodType."' AND (cp.ATT_SINGLE != '' OR cp.ATT_SINGLE != 0)
            GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC LIMIT 0,1
        ";
        return $query_syntax;
    }

    function getListStateroomPriceLatestCheapest($shipID, $brandID, $noofnight, $noAdult, $noChild, $cruiseTitleID)
    {
        $arrayData  = array();
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $availableDates = $this->All->select_template("ID", $cruiseTitleID, "cruise_title");
        foreach( $availableDates AS $availableDate ) {
            $cruiseDate = $availableDate->DEPARTURE_DATE;
        }
        $dateArray = explode(", ", $cruiseDate);
        for($a=0; $a<count($dateArray); $a++) {
            $peakCheck     = $this->checkDateRulePeak($shipID, $brandID, $noofnight, $dateArray[$a]);
            $shoulderCheck = $this->checkDateRuleShoulder($shipID, $brandID, $noofnight, $dateArray[$a]);
            $lowCheck      = $this->checkDateRuleLow($shipID, $brandID, $noofnight, $dateArray[$a]);
            if( $noAdult == 1 && $noChild == 0 ) {
                if( $peakCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
                            AND (cp.ATT_SINGLE != '' OR cp.ATT_SINGLE != 0)
                            AND cs.STATEROOM_OCCUPANT = 1
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_SINGLE+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att_single_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att_single_text."<br /> 0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "PEAK";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
                            AND (cp.ATT_SINGLE != '' OR cp.ATT_SINGLE != 0)
                            AND cs.STATEROOM_OCCUPANT = 1
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_SINGLE+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att_single_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att_single_text."<br /> 0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "SHOULDER";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $lowCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_SINGLE != '' OR cp.ATT_SINGLE != 0)
                            AND cs.STATEROOM_OCCUPANT = 1
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_SINGLE+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att_single_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att_single_text."<br /> 0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_SINGLE != '' OR cp.ATT_SINGLE != 0)
                            AND cs.STATEROOM_OCCUPANT = 1
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_SINGLE+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att_single_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att_single_text."<br /> 0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
            }
            else if( $noAdult == 2 && $noChild == 0 ) {
                if( $peakCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND cs.STATEROOM_OCCUPANT = 2
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br /> 0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "PEAK";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND cs.STATEROOM_OCCUPANT = 2
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br /> 0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "SHOULDER";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $lowCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND cs.STATEROOM_OCCUPANT = 2
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br /> 0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND cs.STATEROOM_OCCUPANT = 2
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br /> 0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
            }
            else if( $noAdult == 3 && $noChild == 0 ) {
                if( $peakCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0)
                            AND cs.STATEROOM_OCCUPANT = 3
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_ADULT+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_adult_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "PEAK";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0)
                            AND cs.STATEROOM_OCCUPANT = 3
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_ADULT+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_adult_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "SHOULDER";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $lowCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0)
                            AND cs.STATEROOM_OCCUPANT = 3
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_ADULT+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_adult_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0)
                            AND cs.STATEROOM_OCCUPANT = 3
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_ADULT+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_adult_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
            }
            else if( $noAdult == 4 && $noChild == 0 ) {
                if( $peakCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_ADULT != '' OR cp.ATT_4_ADULT != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_ADULT+cp.ATT_4_ADULT+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_adult_value+$att4_adult_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />4th Pax Adult: ".$att4_adult_text."<br />0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "PEAK";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_ADULT != '' OR cp.ATT_4_ADULT != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_ADULT+cp.ATT_4_ADULT+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_adult_value+$att4_adult_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />4th Pax Adult: ".$att4_adult_text."<br />0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "SHOULDER";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $lowCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_ADULT != '' OR cp.ATT_4_ADULT != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_ADULT+cp.ATT_4_ADULT+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_adult_value+$att4_adult_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />4th Pax Adult: ".$att4_adult_text."<br />0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_ADULT != '' OR cp.ATT_4_ADULT != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_ADULT+cp.ATT_4_ADULT+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_adult_value+$att4_adult_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />4th Pax Adult: ".$att4_adult_text."<br />0 Child: $0.00";
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
            }
            else if( $noAdult == 1 && $noChild == 1 ) {
                if( $peakCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 2
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br /> 1st Pax Child: ".$att2_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "PEAK";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 2
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br /> 1st Pax Child: ".$att2_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "SHOULDER";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $lowCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 2
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br /> 1st Pax Child: ".$att2_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 2
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br /> 1st Pax Child: ".$att2_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
            }
            else if( $noAdult == 2 && $noChild == 1 ) {
                if( $peakCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 3
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "PEAK";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 3
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "SHOULDER";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $lowCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 3
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 3
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
            }
            else if( $noAdult == 3 && $noChild == 1 ) {
                if( $peakCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_ADULT+cp.ATT_4_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_adult_value+$att4_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />1st Pax Child: ".$att4_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "PEAK";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_ADULT+cp.ATT_4_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_adult_value+$att4_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />1st Pax Child: ".$att4_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "SHOULDER";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $lowCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_ADULT+cp.ATT_4_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_adult_value+$att4_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />1st Pax Child: ".$att4_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_ADULT+cp.ATT_4_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_adult_value+$att4_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />1st Pax Child: ".$att4_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
            }
            else if( $noAdult == 1 && $noChild == 2 ) {
                if( $peakCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 3
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_CHILD+cp.ATT_3_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_child_value+$att3_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "PEAK";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 3
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_CHILD+cp.ATT_3_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_child_value+$att3_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "SHOULDER";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $lowCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 3
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_CHILD+cp.ATT_3_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_child_value+$att3_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 3
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_CHILD+cp.ATT_3_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_child_value+$att3_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
            }
            else if( $noAdult == 2 && $noChild == 2 ) {
                if( $peakCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_CHILD+cp.ATT_4_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_child_value+$att4_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text."<br />2nd Pax Child: ".$att4_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "PEAK";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_CHILD+cp.ATT_4_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_child_value+$att4_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text."<br />2nd Pax Child: ".$att4_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "SHOULDER";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $lowCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_CHILD+cp.ATT_4_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_child_value+$att4_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text."<br />2nd Pax Child: ".$att4_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_ADULT+cp.ATT_3_CHILD+cp.ATT_4_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_adult_value+$att3_child_value+$att4_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text."<br />2nd Pax Child: ".$att4_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
            }
            else if( $noAdult == 1 && $noChild == 3 ) {
                if( $peakCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_CHILD+cp.ATT_3_CHILD+cp.ATT_4_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_child_value+$att3_child_value+$att4_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text."<br />3rd Pax Child: ".$att4_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "PEAK";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $shoulderCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_CHILD+cp.ATT_3_CHILD+cp.ATT_4_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_child_value+$att3_child_value+$att4_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text."<br />3rd Pax Child: ".$att4_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "SHOULDER";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else if( $lowCheck == "YES" ) {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_CHILD+cp.ATT_3_CHILD+cp.ATT_4_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_child_value+$att3_child_value+$att4_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text."<br />3rd Pax Child: ".$att4_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
                else {
                    $check_res  = mysqli_query(
                        $connection,
                        "
                            SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                            cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD,
                            cp.ATT_3_ADULT AS ATT_3_ADULT, cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT,
                            cp.ATT_4_CHILD AS ATT_4_CHILD, cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                            FROM cruise_prices cp, cruise_stateroom cs
                            WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                            AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
                            AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
                            AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
                            AND cs.STATEROOM_OCCUPANT = 4
                            GROUP BY cs.STATEROOM_NAME ORDER BY cp.ATT_1+cp.ATT_2_CHILD+cp.ATT_3_CHILD+cp.ATT_4_CHILD+0 ASC LIMIT 0,1
                        "
                    );
                    if( mysqli_num_rows($check_res) > 0 ) {
                        $x = 0;
                        while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                            //text and value
                            $att_single_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_SINGLE"]);
                            $att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
                            $att1_text        = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_1"]);
                            $att1_value       = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
                            $att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_ADULT"]);
                            $att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
                            $att2_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_2_CHILD"]);
                            $att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
                            $att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_ADULT"]);
                            $att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
                            $att3_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_3_CHILD"]);
                            $att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
                            $att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_ADULT"]);
                            $att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
                            $att4_child_text  = $this->getValueAndTextFreeValidate("TEXT",  $check_row["ATT_4_CHILD"]);
                            $att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
                            //end of text and value
                            $arrayData[$x]["STATEROOM_ID"]       = $check_row["STATEROOM_ID"];
                            $arrayData[$x]["STATEROOM_NAME"]     = $check_row["STATEROOM_NAME"];
                            $arrayData[$x]["PRICE_STATED"]       = $att1_value+$att2_child_value+$att3_child_value+$att4_child_value;
                            $arrayData[$x]["PRICE_MENTIONED"]    = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text."<br />3rd Pax Child: ".$att4_child_text;
                            $arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
                            $arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
                            $arrayData[$x]["PERIOD_TYPE"]        = "LOW";
                            $arrayData[$x]["CRUIDE_DATE"]        = $dateArray[$a];
                            $x++;
                        }
                    }
                }
            }
        }
        return $arrayData;
    }

    function getListStateroomPriceLatest($shipID, $brandID, $cruiseDate, $noofnight, $noAdult, $noChild)
 	{
	 	$arrayData = array();
	 	$connection    = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	 	$peakCheck 	   = $this->checkDateRulePeak($shipID, $brandID, $noofnight, $cruiseDate);
		$shoulderCheck = $this->checkDateRuleShoulder($shipID, $brandID, $noofnight, $cruiseDate);
		$lowCheck 	   = $this->checkDateRuleLow($shipID, $brandID, $noofnight, $cruiseDate);
	 	if( $noAdult == 1 && $noChild == 0 ) {
		 	if( $peakCheck == "YES" ) {
			 	$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
						AND (cp.ATT_SINGLE != '' OR cp.ATT_SINGLE != 0)
						AND cs.STATEROOM_OCCUPANT = 1
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att_single_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: $".$att_single_text."<br /> 0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "PEAK";
						$x++;
					}
				}
			}
			else if( $shoulderCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
						AND (cp.ATT_SINGLE != '' OR cp.ATT_SINGLE != 0)
						AND cs.STATEROOM_OCCUPANT = 1
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att_single_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: $".$att_single_text."<br /> 0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] 		 = "SHOULDER";
						$x++;
					}
				}
			}
			else if( $lowCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_SINGLE != '' OR cp.ATT_SINGLE != 0)
						AND cs.STATEROOM_OCCUPANT = 1
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att_single_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: $".$att_single_text."<br /> 0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
			else {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_SINGLE != '' OR cp.ATT_SINGLE != 0)
						AND cs.STATEROOM_OCCUPANT = 1
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att_single_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: $".$att_single_text."<br /> 0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
	 	}
	 	else if( $noAdult == 2 && $noChild == 0 ) {
		 	if( $peakCheck == "YES" ) {
			 	$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND cs.STATEROOM_OCCUPANT = 2
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br /> 0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "PEAK";
						$x++;
					}
				}
			}
			else if( $shoulderCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND cs.STATEROOM_OCCUPANT = 2
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br /> 0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "SHOULDER";
						$x++;
					}
				}
			}
			else if( $lowCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND cs.STATEROOM_OCCUPANT = 2
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br /> 0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
			else {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND cs.STATEROOM_OCCUPANT = 2
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br /> 0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
	 	}
	 	else if( $noAdult == 3 && $noChild == 0 ) {
		 	if( $peakCheck == "YES" ) {
			 	$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0)
						AND cs.STATEROOM_OCCUPANT = 3
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_adult_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "PEAK";
						$x++;
					}
				}
			}
			else if( $shoulderCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0)
						AND cs.STATEROOM_OCCUPANT = 3
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_adult_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "SHOULDER";
						$x++;
					}
				}
			}
			else if( $lowCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0)
						AND cs.STATEROOM_OCCUPANT = 3
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_adult_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
			else {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0)
						AND cs.STATEROOM_OCCUPANT = 3
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_adult_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
	 	}
	 	else if( $noAdult == 4 && $noChild == 0 ) {
		 	if( $peakCheck == "YES" ) {
			 	$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_ADULT != '' OR cp.ATT_4_ADULT != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_adult_value+$att4_adult_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />4th Pax Adult: ".$att4_adult_text."<br />0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "PEAK";
						$x++;
					}
				}
			}
			else if( $shoulderCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_ADULT != '' OR cp.ATT_4_ADULT != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_adult_value+$att4_adult_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />4th Pax Adult: ".$att4_adult_text."<br />0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "SHOULDER";
						$x++;
					}
				}
			}
			else if( $lowCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_ADULT != '' OR cp.ATT_4_ADULT != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_adult_value+$att4_adult_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />4th Pax Adult: ".$att4_adult_text."<br />0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
			else {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_ADULT != '' OR cp.ATT_4_ADULT != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_adult_value+$att4_adult_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />4th Pax Adult: ".$att4_adult_text."<br />0 Child: $0.00";
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
	 	}
	 	else if( $noAdult == 1 && $noChild == 1 ) {
		 	if( $peakCheck == "YES" ) {
			 	$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 2
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br /> 1st Pax Child: ".$att2_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] 		 = "PEAK";
						$x++;
					}
				}
			}
			else if( $shoulderCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 2
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br /> 1st Pax Child: ".$att2_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] 		 = "SHOULDER";
						$x++;
					}
				}
			}
			else if( $lowCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 2
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br /> 1st Pax Child: ".$att2_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] 		 = "LOW";
						$x++;
					}
				}
			}
			else {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 2
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br /> 1st Pax Child: ".$att2_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] 		 = "LOW";
						$x++;
					}
				}
			}
	 	}
	 	else if( $noAdult == 2 && $noChild == 1 ) {
		 	if( $peakCheck == "YES" ) {
			 	$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 3
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "PEAK";
						$x++;
					}
				}
			}
			else if( $shoulderCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 3
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "SHOULDER";
						$x++;
					}
				}
			}
			else if( $lowCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 3
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
			else {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 3
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
	 	}
	 	else if( $noAdult == 3 && $noChild == 1 ) {
		 	if( $peakCheck == "YES" ) {
			 	$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_adult_value+$att4_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />1st Pax Child: ".$att4_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "PEAK";
						$x++;
					}
				}
			}
			else if( $shoulderCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_adult_value+$att4_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />1st Pax Child: ".$att4_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "SHOULDER";
						$x++;
					}
				}
			}
			else if( $lowCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_adult_value+$att4_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />1st Pax Child: ".$att4_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
			else {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_ADULT != '' OR cp.ATT_3_ADULT != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_adult_value+$att4_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />3rd Pax Adult: ".$att3_adult_text."<br />1st Pax Child: ".$att4_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
	 	}
	 	else if( $noAdult == 1 && $noChild == 2 ) {
		 	if( $peakCheck == "YES" ) {
			 	$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 3
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_child_value+$att3_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "PEAK";
						$x++;
					}
				}
			}
			else if( $shoulderCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 3
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_child_value+$att3_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "SHOULDER";
						$x++;
					}
				}
			}
			else if( $lowCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 3
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_child_value+$att3_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
			else {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 3
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_child_value+$att3_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
	 	}
	 	else if( $noAdult == 2 && $noChild == 2 ) {
		 	if( $peakCheck == "YES" ) {
			 	$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_child_value+$att4_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text."<br />2nd Pax Child: ".$att4_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "PEAK";
						$x++;
					}
				}
			}
			else if( $shoulderCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_child_value+$att4_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text."<br />2nd Pax Child: ".$att4_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "SHOULDER";
						$x++;
					}
				}
			}
			else if( $lowCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_child_value+$att4_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text."<br />2nd Pax Child: ".$att4_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
			else {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_ADULT != '' OR cp.ATT_2_ADULT != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_adult_value+$att3_child_value+$att4_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />2nd Pax Adult: ".$att2_adult_text."<br />1st Pax Child: ".$att3_child_text."<br />2nd Pax Child: ".$att4_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
	 	}
	 	else if( $noAdult == 1 && $noChild == 3 ) {
		 	if( $peakCheck == "YES" ) {
			 	$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'PEAK'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_child_value+$att3_child_value+$att4_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text."<br />3rd Pax Child: ".$att4_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "PEAK";
						$x++;
					}
				}
			}
			else if( $shoulderCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'SHOULDER'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_child_value+$att3_child_value+$att4_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text."<br />3rd Pax Child: ".$att4_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "SHOULDER";
						$x++;
					}
				}
			}
			else if( $lowCheck == "YES" ) {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_child_value+$att3_child_value+$att4_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text."<br />3rd Pax Child: ".$att4_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
			else {
				$check_res  = mysqli_query(
					$connection,
					"
						SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
						cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
						cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
						cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
						FROM cruise_prices cp, cruise_stateroom cs
						WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
						AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = 'LOW'
						AND (cp.ATT_1 != '' OR cp.ATT_1 != 0) AND (cp.ATT_2_CHILD != '' OR cp.ATT_2_CHILD != 0)
						AND (cp.ATT_3_CHILD != '' OR cp.ATT_3_CHILD != 0) AND (cp.ATT_4_CHILD != '' OR cp.ATT_4_CHILD != 0)
						AND cs.STATEROOM_OCCUPANT = 4
						GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
					"
				);
				if( mysqli_num_rows($check_res) > 0 ) {
					$x = 0;
					while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
						//text and value
						$att_single_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_SINGLE"]);
						$att_single_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_SINGLE"]);
						$att1_text  	  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_1"]);
						$att1_value 	  = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_1"]);
						$att2_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_ADULT"]);
						$att2_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_ADULT"]);
						$att2_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_2_CHILD"]);
						$att2_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_2_CHILD"]);
						$att3_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_ADULT"]);
						$att3_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_ADULT"]);
						$att3_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_3_CHILD"]);
						$att3_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_3_CHILD"]);
						$att4_adult_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_ADULT"]);
						$att4_adult_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_ADULT"]);
						$att4_child_text  = $this->getValueAndTextFreeValidate("TEXT", 	$check_row["ATT_4_CHILD"]);
						$att4_child_value = $this->getValueAndTextFreeValidate("VALUE", $check_row["ATT_4_CHILD"]);
						//end of text and value
						$arrayData[$x]["STATEROOM_ID"] 		 = $check_row["STATEROOM_ID"];
						$arrayData[$x]["STATEROOM_NAME"] 	 = $check_row["STATEROOM_NAME"];
						$arrayData[$x]["PRICE_STATED"] 		 = $att1_value+$att2_child_value+$att3_child_value+$att4_child_value;
						$arrayData[$x]["PRICE_MENTIONED"] 	 = "1st Pax Adult: ".$att1_text."<br />1st Pax Child: ".$att2_child_text."<br />2nd Pax Child: ".$att3_child_text."<br />3rd Pax Child: ".$att4_child_text;
						$arrayData[$x]["STATEROOM_OCCUPANT"] = $check_row["STATEROOM_OCCUPANT"];
						$arrayData[$x]["STATEROOM_ROOM_QTY"] = "";
						$arrayData[$x]["PERIOD_TYPE"] = "LOW";
						$x++;
					}
				}
			}
	 	}
	 	return $arrayData;
 	}

    function dynamicCheapestPrice($shipID, $brandID, $noofnight, $noofadult, $noofchild, $cruiseTitleID)
    {
        $arrayResult = array();
        $string      = "";
        $cruiseDate  = "";
        $totalAdultChild = $noofadult+$noofchild;
        $stateroom_lists = $this->getListStateroomPriceLatestCheapest(
            $shipID, $brandID, $noofnight, $noofadult, $noofchild, $cruiseTitleID
        );
        if( count($stateroom_lists) > 0 ) {
            foreach( $stateroom_lists AS $stateroom_list ) {
                //extra charge
                $extraChargeValues = $this->getExtraCharge(
                    $brandID, $shipID, $noofnight, $stateroom_list["CRUIDE_DATE"], $stateroom_list["STATEROOM_ID"]
                );
                $discount = $this->getDiscountApplied($brandID, $shipID, $noofnight, $stateroom_list["STATEROOM_ID"]);
                //end of extra charge
                $qts_res  = mysqli_query(
                    $connection,
                    "
                        SELECT * FROM cruise_title_stateroom_qty
                        WHERE stateroom_id = ".$stateroom_list["STATEROOM_ID"]." AND quantity > 0
                    "
                );
                if( mysqli_num_rows($qts_res) > 0 ) {
                    if( $discount != 0 ) {
                        $string .= '<tr id="available_price">';
                        $string .=      '<td style="background: #eff0f1;">&nbsp;</td>';
                        $string .=      '<td colspan="2" style="background: #eff0f1;">';
                        $string .=          '<div style="font-size:12px">'.$stateroom_list["STATEROOM_NAME"].'</div>';
                        $string .=          '<div style="font-size:10px"><i>* Discount: $'.number_format($discount, 2).'</i></div>';
                        $string .=      '</td>';
                        $string .=      '<td style="background: #eff0f1; text-align:center">';
                        $string .=          '<div style="font-size:12px; padding:10px; background-color:#F7941D;"><a style="color:white; padding:13px; font-size:18px; font-weight:bold; text-decoration:none" href="'.base_url().'cart/do_add_cartCruise/'.$brandID.'/'.$shipID.'/'.$cruiseTitleID.'/'.$noofnight.'/'.$stateroom_list["CRUIDE_DATE"].'/'.$stateroom_list["STATEROOM_ID"].'/'.$stateroom_list["PRICE_STATED"].'/'.$noofadult.'/'.$noofchild.'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraPrice"]))).'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraIDs"]))).'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraPeriod"]))).'" class="tip" data-tip="'.$stateroom_list["PRICE_MENTIONED"].'<br />Discount: $'.number_format($discount, 2).'<br />Total price: $'.number_format(($stateroom_list["PRICE_STATED"]+($extraChargeValues["extraPrice"]*$totalAdultChild))-$discount, 2).'<br />(Extra charge: $'.number_format($extraChargeValues["extraPrice"], 2).')">$'.number_format($stateroom_list["PRICE_STATED"]-$discount, 2).'</a></div>';
                        $string .=      '</td>';
                        $string .= '</tr>';
                    }
                    else {
                        $string .= '<tr id="available_price">';
                        $string .=      '<td style="background: #eff0f1;">&nbsp;</td>';
                        $string .=      '<td colspan="2" style="background: #eff0f1;">';
                        $string .=          '<div style="font-size:12px">'.$stateroom_list["STATEROOM_NAME"].'</div>';
                        $string .=      '</td>';
                        $string .=      '<td style="background: #eff0f1; text-align:center">';
                        $string .=          '<div style="font-size:12px; padding:10px; background-color:#F7941D;"><a style="color:white; padding:13px; font-size:18px; font-weight:bold; text-decoration:none" href="'.base_url().'cart/do_add_cartCruise/'.$brandID.'/'.$shipID.'/'.$cruiseTitleID.'/'.$noofnight.'/'.$cruiseDate.'/'.$stateroom_list["STATEROOM_ID"].'/'.$stateroom_list["PRICE_STATED"].'/'.$noofadult.'/'.$noofchild.'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraPrice"]))).'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraIDs"]))).'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraPeriod"]))).'" class="tip" data-tip="'.$stateroom_list["PRICE_MENTIONED"].'<br />Discount: $'.number_format($discount, 2).'<br />Total price: $'.number_format($stateroom_list["PRICE_STATED"]-$discount, 2).'<br />(Extra charge: $'.number_format($extraChargeValues["extraPrice"], 2).')">$'.number_format(($stateroom_list["PRICE_STATED"]+($extraChargeValues["extraPrice"]*$totalAdultChild))-$discount, 2).'</a></div>';
                        $string .=      '</td>';
                        $string .= '</tr>';
                    }
                    $cruiseDate = $stateroom_list["CRUIDE_DATE"];
                }
            }
        }
        else {
            $string = "";
        }
        $arrayResult["string"]     = $string;
        $arrayResult["cruiseDate"] = $cruiseDate;
        return $arrayResult;
    }

    function dynamicCheapestPriceMobile($shipID, $brandID, $noofnight, $noofadult, $noofchild, $cruiseTitleID)
    {
        $arrayResult = array();
        $string      = "";
        $cruiseDate  = "";
        $totalAdultChild = $noofadult+$noofchild;
        $stateroom_lists = $this->getListStateroomPriceLatestCheapest(
            $shipID, $brandID, $noofnight, $noofadult, $noofchild, $cruiseTitleID
        );
        if( count($stateroom_lists) > 0 ) {
            foreach( $stateroom_lists AS $stateroom_list ) {
                //extra charge
                $extraChargeValues = $this->getExtraCharge(
                    $brandID, $shipID, $noofnight, $stateroom_list["CRUIDE_DATE"], $stateroom_list["STATEROOM_ID"]
                );
                $discount = $this->getDiscountApplied($brandID, $shipID, $noofnight, $stateroom_list["STATEROOM_ID"]);
                //end of extra charge
                $qts_res  = mysqli_query(
                    $connection,
                    "
                        SELECT * FROM cruise_title_stateroom_qty
                        WHERE stateroom_id = ".$stateroom_list["STATEROOM_ID"]." AND quantity > 0
                    "
                );
                if( mysqli_num_rows($qts_res) > 0 ) {
                    if( $discount != 0 ) {
                        $string .= '<tr id="available_price">';
                        $string .=      '<td style="background: #eff0f1;">&nbsp;</td>';
                        $string .=      '<td colspan="2" style="background: #eff0f1;">';
                        $string .=          '<div style="font-size:12px">'.$stateroom_list["STATEROOM_NAME"].'</div>';
                        $string .=          '<div style="font-size:10px"><i>* Discount: $'.number_format($discount, 2).'</i></div>';
                        $string .=          '<br />';
                        $string .=          '<div style="font-size:12px; padding:10px; background-color:#F7941D;"><a style="color:white; padding:13px; font-size:18px; font-weight:bold; text-decoration:none" href="'.base_url().'cart/do_add_cartCruise/'.$brandID.'/'.$shipID.'/'.$cruiseTitleID.'/'.$noofnight.'/'.$stateroom_list["CRUIDE_DATE"].'/'.$stateroom_list["STATEROOM_ID"].'/'.$stateroom_list["PRICE_STATED"].'/'.$noofadult.'/'.$noofchild.'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraPrice"]))).'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraIDs"]))).'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraPeriod"]))).'" class="tip" data-tip="'.$stateroom_list["PRICE_MENTIONED"].'<br />Discount: $'.number_format($discount, 2).'<br />Total price: $'.number_format(($stateroom_list["PRICE_STATED"]+($extraChargeValues["extraPrice"]*$totalAdultChild))-$discount, 2).'<br />(Extra charge: $'.number_format($extraChargeValues["extraPrice"], 2).')">$'.number_format($stateroom_list["PRICE_STATED"]-$discount, 2).'</a></div>';
                        $string .=      '</td>';
                        $string .=      '<td style="background: #eff0f1; text-align:center">';
                        $string .=      '</td>';
                        $string .= '</tr>';
                    }
                    else {
                        $string .= '<tr id="available_price">';
                        $string .=      '<td style="background: #eff0f1;">&nbsp;</td>';
                        $string .=      '<td colspan="2" style="background: #eff0f1;">';
                        $string .=          '<div style="font-size:12px">'.$stateroom_list["STATEROOM_NAME"].'</div>';
                        $string .=          '<br />';
                        $string .=          '<div style="font-size:12px; padding:10px; background-color:#F7941D;"><a style="color:white; padding:13px; font-size:18px; font-weight:bold; text-decoration:none" href="'.base_url().'cart/do_add_cartCruise/'.$brandID.'/'.$shipID.'/'.$cruiseTitleID.'/'.$noofnight.'/'.$cruiseDate.'/'.$stateroom_list["STATEROOM_ID"].'/'.$stateroom_list["PRICE_STATED"].'/'.$noofadult.'/'.$noofchild.'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraPrice"]))).'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraIDs"]))).'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraPeriod"]))).'" class="tip" data-tip="'.$stateroom_list["PRICE_MENTIONED"].'<br />Discount: $'.number_format($discount, 2).'<br />Total price: $'.number_format($stateroom_list["PRICE_STATED"]-$discount, 2).'<br />(Extra charge: $'.number_format($extraChargeValues["extraPrice"], 2).')">$'.number_format(($stateroom_list["PRICE_STATED"]+($extraChargeValues["extraPrice"]*$totalAdultChild))-$discount, 2).'</a></div>';
                        $string .=      '</td>';
                        $string .=      '<td style="background: #eff0f1; text-align:center">';
                        $string .=      '</td>';
                        $string .= '</tr>';
                    }
                    $cruiseDate = $stateroom_list["CRUIDE_DATE"];
                }
            }
        }
        else {
            $string = "";
        }
        $arrayResult["string"]     = $string;
        $arrayResult["cruiseDate"] = $cruiseDate;
        return $arrayResult;
    }

    function dynamicContentPrice($shipID, $brandID, $cruiseDate, $noofnight, $adult, $child, $cruiseTitleID)
 	{
	 	$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	 	$string = "";
	 	$totalAdultChild = $adult+$child;
	 	$stateroom_lists = $this->getListStateroomPriceLatest($shipID, $brandID, $cruiseDate, $noofnight, $adult, $child);
	 	/*
	 	echo "<pre>";
	 	print_r($stateroom_lists);
	 	echo "</pre>";
	 	echo die("aaa");
	 	*/
	 	if( count($stateroom_lists) > 0 ) {
			foreach( $stateroom_lists AS $stateroom_list ) {
				//extra charge
				$extraChargeValues = $this->getExtraCharge($brandID, $shipID, $noofnight, $cruiseDate, $stateroom_list["STATEROOM_ID"]);
				$discount 		   = $this->getDiscountApplied($brandID, $shipID, $noofnight, $stateroom_list["STATEROOM_ID"]);
				//end of extra charge
				$qts_res  = mysqli_query(
					$connection,
					"
						SELECT * FROM cruise_title_stateroom_qty
						WHERE stateroom_id = ".$stateroom_list["STATEROOM_ID"]." AND quantity > 0
					"
				);
				if( mysqli_num_rows($qts_res) > 0 ) {
					if( $discount != 0 ) {
						if( $extraChargeValues["extraPrice"] == "" ) {
							$extraPrice = "-";
						}
						else {
							$extraPrice = base64_encode(base64_encode(base64_encode($extraChargeValues["extraPrice"])));
						}
						if( $extraChargeValues["extraIDs"] == "" ) {
							$extraIDs = "-";
						}
						else {
							$extraIDs = base64_encode(base64_encode(base64_encode($extraChargeValues["extraIDs"])));
						}
						if( $extraChargeValues["extraPeriod"] == "" ) {
							$extraPeriod = "-";
						}
						else {
							$extraPeriod = base64_encode(base64_encode(base64_encode($extraChargeValues["extraPeriod"])));
						}
						$string .= '<tr id="available_price">';
						$string .= 		'<td style="background: #eff0f1;">&nbsp;</td>';
						$string .=		'<td colspan="2" style="background: #eff0f1;">';
						$string .=			'<div style="font-size:12px">'.$stateroom_list["STATEROOM_NAME"].'</div>';
						$string .=			'<div style="font-size:12px"><i>* Discount: $'.number_format($discount, 2).'</i></div>';
						$string .=		'</td>';
						$string .=		'<td style="background: #eff0f1; text-align:center">';
						$string .=			'<div style="font-size:12px; padding:10px; background-color:#F7941D;"><a style="color:white; padding:13px; font-size:18px; font-weight:bold; text-decoration:none" href="'.base_url().'cart/do_add_cartCruise/'.$brandID.'/'.$shipID.'/'.$cruiseTitleID.'/'.$noofnight.'/'.$cruiseDate.'/'.$stateroom_list["STATEROOM_ID"].'/'.$stateroom_list["PRICE_STATED"].'/'.$adult.'/'.$child.'/'.$extraPrice.'/'.$extraIDs.'/'.$extraPeriod.'/'.base64_encode(base64_encode(base64_encode($stateroom_list["PERIOD_TYPE"]))).'" class="tip" data-tip="'.$stateroom_list["PRICE_MENTIONED"].'<br />Discount: $'.number_format($discount, 2).'<br />Total price: $'.number_format(($stateroom_list["PRICE_STATED"]+($extraChargeValues["extraPrice"]*$totalAdultChild))-$discount, 2).'<br />(Extra charge: $'.number_format($extraChargeValues["extraPrice"]*$totalAdultChild, 2).')">$'.number_format($stateroom_list["PRICE_STATED"]-$discount, 2).'</a></div>';
						$string .=		'</td>';
						$string .= '</tr>';
					}
					else {
						if( $extraChargeValues["extraPrice"] == "" ) {
							$extraPrice = "-";
						}
						else {
							$extraPrice = base64_encode(base64_encode(base64_encode($extraChargeValues["extraPrice"])));
						}
						if( $extraChargeValues["extraIDs"] == "" ) {
							$extraIDs = "-";
						}
						else {
							$extraIDs = base64_encode(base64_encode(base64_encode($extraChargeValues["extraIDs"])));
						}
						if( $extraChargeValues["extraPeriod"] == "" ) {
							$extraPeriod = "-";
						}
						else {
							$extraPeriod = base64_encode(base64_encode(base64_encode($extraChargeValues["extraPeriod"])));
						}
						$string .= '<tr id="available_price">';
						$string .= 		'<td style="background:#eff0f1;">&nbsp;</td>';
						$string .=		'<td colspan="2" style="background: #eff0f1;">';
						$string .=			'<div style="font-size:12px">'.$stateroom_list["STATEROOM_NAME"].'</div>';
						$string .=		'</td>';
						$string .=		'<td style="background: #eff0f1; text-align:center">';
						$string .=			'<div style="font-size:12px; padding:10px; background-color:#F7941D;"><a style="color:white; padding:13px; font-size:18px; font-weight:bold; text-decoration:none" href="'.base_url().'cart/do_add_cartCruise/'.$brandID.'/'.$shipID.'/'.$cruiseTitleID.'/'.$noofnight.'/'.$cruiseDate.'/'.$stateroom_list["STATEROOM_ID"].'/'.$stateroom_list["PRICE_STATED"].'/'.$adult.'/'.$child.'/'.$extraPrice.'/'.$extraIDs.'/'.$extraPeriod.'/'.base64_encode(base64_encode(base64_encode($stateroom_list["PERIOD_TYPE"]))).'" class="tip" data-tip="'.$stateroom_list["PRICE_MENTIONED"].'<br />Discount: $'.number_format($discount, 2).'<br />Total price: $'.number_format(($stateroom_list["PRICE_STATED"]+($extraChargeValues["extraPrice"]*$totalAdultChild))-$discount, 2).'<br />(Extra charge: $'.number_format($extraChargeValues["extraPrice"]*$totalAdultChild, 2).')">$'.number_format($stateroom_list["PRICE_STATED"]-$discount, 2).'</a></div>';
						$string .=		'</td>';
						$string .= '</tr>';
					}
				}
			}
		}
		else {
			$string = "";
		}
	 	return $string;
	}

    function dynamicContentPriceMobile($shipID, $brandID, $cruiseDate, $noofnight, $adult, $child, $cruiseTitleID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $string = "";
        $totalAdultChild = $adult+$child;
        $stateroom_lists = $this->getListStateroomPriceLatest($shipID, $brandID, $cruiseDate, $noofnight, $adult, $child);
        if( count($stateroom_lists) > 0 ) {
            foreach( $stateroom_lists AS $stateroom_list ) {
                //extra charge
                $extraChargeValues = $this->getExtraCharge($brandID, $shipID, $noofnight, $cruiseDate, $stateroom_list["STATEROOM_ID"]);
                $discount          = $this->getDiscountApplied($brandID, $shipID, $noofnight, $stateroom_list["STATEROOM_ID"]);
                //end of extra charge
                $qts_res  = mysqli_query(
                    $connection,
                    "
                        SELECT * FROM cruise_title_stateroom_qty
                        WHERE stateroom_id = ".$stateroom_list["STATEROOM_ID"]." AND quantity > 0
                    "
                );
                if( mysqli_num_rows($qts_res) > 0 ) {
                    if( $discount != 0 ) {
                        $string .= '<tr id="available_price">';
                        $string .=      '<td style="background: #eff0f1;">&nbsp;</td>';
                        $string .=      '<td colspan="2" style="background: #eff0f1;">';
                        $string .=          '<div style="font-size:12px">'.$stateroom_list["STATEROOM_NAME"].'</div>';
                        $string .=          '<div style="font-size:12px"><i>* Discount: $'.number_format($discount, 2).'</i></div>';
                        $string .=          '<br />';
                        $string .=          '<div style="font-size:12px; padding:10px; background-color:#F7941D;"><a style="color:white; padding:13px; font-size:18px; font-weight:bold; text-decoration:none" href="'.base_url().'cart/do_add_cartCruise/'.$brandID.'/'.$shipID.'/'.$cruiseTitleID.'/'.$noofnight.'/'.$cruiseDate.'/'.$stateroom_list["STATEROOM_ID"].'/'.$stateroom_list["PRICE_STATED"].'/'.$adult.'/'.$child.'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraPrice"]))).'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraIDs"]))).'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraPeriod"]))).'/'.base64_encode(base64_encode(base64_encode($stateroom_list["PERIOD_TYPE"]))).'" class="tip" data-tip="'.$stateroom_list["PRICE_MENTIONED"].'<br />Discount: $'.number_format($discount, 2).'<br />Total price: $'.number_format(($stateroom_list["PRICE_STATED"]+($extraChargeValues["extraPrice"]*$totalAdultChild))-$discount, 2).'<br />(Extra charge: $'.number_format($extraChargeValues["extraPrice"]*$totalAdultChild, 2).')">$'.number_format($stateroom_list["PRICE_STATED"]-$discount, 2).'</a></div>';
                        $string .=      '</td>';
                        $string .=      '<td style="background: #eff0f1; text-align:center">';
                        $string .=      '</td>';
                        $string .= '</tr>';
                    }
                    else {
                        $string .= '<tr id="available_price">';
                        $string .=      '<td style="background:#eff0f1;">&nbsp;</td>';
                        $string .=      '<td colspan="2" style="background: #eff0f1;">';
                        $string .=          '<div style="font-size:12px">'.$stateroom_list["STATEROOM_NAME"].'</div>';
                        $string .=          '<br />';
                        $string .=          '<div style="font-size:12px; padding:10px; background-color:#F7941D;"><a style="color:white; padding:13px; font-size:18px; font-weight:bold; text-decoration:none" href="'.base_url().'cart/do_add_cartCruise/'.$brandID.'/'.$shipID.'/'.$cruiseTitleID.'/'.$noofnight.'/'.$cruiseDate.'/'.$stateroom_list["STATEROOM_ID"].'/'.$stateroom_list["PRICE_STATED"].'/'.$adult.'/'.$child.'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraPrice"]))).'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraIDs"]))).'/'.base64_encode(base64_encode(base64_encode($extraChargeValues["extraPeriod"]))).'/'.base64_encode(base64_encode(base64_encode($stateroom_list["PERIOD_TYPE"]))).'" class="tip" data-tip="'.$stateroom_list["PRICE_MENTIONED"].'<br />Discount: $'.number_format($discount, 2).'<br />Total price: $'.number_format(($stateroom_list["PRICE_STATED"]+($extraChargeValues["extraPrice"]*$totalAdultChild))-$discount, 2).'<br />(Extra charge: $'.number_format($extraChargeValues["extraPrice"]*$totalAdultChild, 2).')">$'.number_format($stateroom_list["PRICE_STATED"]-$discount, 2).'</a></div>';
                        $string .=      '</td>';
                        $string .=      '<td style="background: #eff0f1; text-align:center">';
                        $string .=      '</td>';
                        $string .= '</tr>';
                    }
                }
            }
        }
        else {
            $string = "";
        }
        return $string;
    }

    function getItinerary($cruiseTitleID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection, "SELECT * FROM cruise_pdf WHERE cruise_title_id = ".$cruiseTitleID.""
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
            $pdfShow = base_url().'assets/cruise_pdf/'.$check_row["file_name"];
        }
        else {
            $pdfShow = "";
        }
        return $pdfShow;
    }

    /*--Get child age--*/
    function getChildAge($cruiseTitleID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT * FROM cruise_child_age WHERE cruise_title_id = ".$cruiseTitleID.""
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
            $printShow = "(".$check_row["child_age_value"]." years and above)";
        }
        else {
            $printShow = "";
        }
        return $printShow;
    }

    function getChildAgeValueOnly($cruiseTitleID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT * FROM cruise_child_age WHERE cruise_title_id = ".$cruiseTitleID.""
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
            $printShow = $check_row["child_age_value"];
        }
        else {
            $printShow = 0;
        }
        return $printShow;
    }
    /*--End of get child age--*/

    function getContactPurchasedBy($bookOrderID)
    {
        $checks = $this->All->select_template_w_2_conditions(
            "bookOrderID", $bookOrderID, "category", "main", "contact_person_information"
        );
        $print = "-";
        if ($checks == TRUE) {
            foreach( $checks AS $check ) {
                if( $check->cp_title == NULL ) {
                    $print = ucwords($check->cp_fullname);
                }
                else {
                    $print = $check->cp_title.". ".ucwords($check->cp_fullname);
                }
            }
        }
        return $print;
    }

    function getPurchasedBy($user_access_id)
    {
        $checks = $this->select_template("id", $user_access_id, "user_access");
        foreach( $checks AS $check ) {
            if( $check->title == NULL ) {
                $print = $check->first_name." ".$check->last_name;
            }
            else {
                $print = $check->title.". ".$check->first_name." ".$check->last_name;
            }
        }
        return $print;
    }

    function getStateroomQuantity($cruiseTitleID, $cruiseBrandID, $cruiseShipID, $stateroomID)
    {
        $returnPrint = "";
        $checks = $this->select_template_w_4_conditions(
            "cruise_title_id",  $cruiseTitleID,
            "cruise_ship_id",   $cruiseShipID,
            "cruise_brand_id",  $cruiseBrandID,
            "stateroom_id",     $stateroomID,
            "cruise_title_stateroom_qty"
        );
        if( $checks == TRUE ) {
            foreach( $checks AS $check ) {
                $returnPrint = $check->quantity;
            }
        }
        else {
            $returnPrint = "";
        }
        return $returnPrint;
    }

    function getIndividualPriceBasedAdult($stateroomID, $shipID, $brandID, $noofnight, $periodType, $noofadult, $noofchild)
    {
        $priceAdult = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
                cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
                cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                FROM cruise_prices cp, cruise_stateroom cs
                WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = '".$periodType."' AND  cs.ID = ".$stateroomID."
                GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
            "
        );
        $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        if( $noofadult == 1 && $noofchild == 0 ) {
            if( $check_row["ATT_SINGLE"] == 99999 ) {
                $priceAdult = 0;
            }
            else {
                $priceAdult = $check_row["ATT_SINGLE"];
            }
        }
        else if( $noofadult == 2 && $noofchild == 0 ) {
            if( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_2_ADULT"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_1"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] == 99999 ) {
                $priceAdult = 0;
            }
            else {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_2_ADULT"];
            }
        }
        else if( $noofadult == 3 && $noofchild == 0 ) {
            if( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] == 99999 ) {
                $priceAdult = 0;
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_2_ADULT"]+$check_row["ATT_3_ADULT"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_3_ADULT"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_2_ADULT"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_1"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_2_ADULT"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_3_ADULT"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_2_ADULT"]+$check_row["ATT_3_ADULT"];
            }
        }
        else if( $noofadult == 4 && $noofchild == 0 ) {
            if( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] == 99999 && $check_row["ATT_4_ADULT"] == 99999 ) {
                $priceAdult = 0;
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] != 99999 && $check_row["ATT_4_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_2_ADULT"]+$check_row["ATT_3_ADULT"]+$check_row["ATT_4_ADULT"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] == 99999 && $check_row["ATT_4_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_4_ADULT"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] != 99999 && $check_row["ATT_4_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_3_ADULT"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] == 99999 && $check_row["ATT_4_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_2_ADULT"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] == 99999 && $check_row["ATT_4_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_1"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] == 99999 && $check_row["ATT_4_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_2_ADULT"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] != 99999 && $check_row["ATT_4_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_2_ADULT"]+$check_row["ATT_3_ADULT"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] == 99999 && $check_row["ATT_4_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_2_ADULT"]+$check_row["ATT_4_ADULT"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] != 99999 && $check_row["ATT_4_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_3_ADULT"]+$check_row["ATT_4_ADULT"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] != 99999 && $check_row["ATT_4_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_2_ADULT"]+$check_row["ATT_3_ADULT"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] == 99999 && $check_row["ATT_4_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_2_ADULT"]+$check_row["ATT_4_ADULT"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] != 99999 && $check_row["ATT_4_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_3_ADULT"]+$check_row["ATT_4_ADULT"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] != 99999 && $check_row["ATT_4_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_2_ADULT"]+$check_row["ATT_3_ADULT"]+$check_row["ATT_4_ADULT"];
            }
        }
        else if( $noofadult == 1 && $noofchild == 1) {
            if( $check_row["ATT_1"] == 99999 ) {
                $priceAdult = 0;
            }
            else {
                $priceAdult = $check_row["ATT_1"];
            }
        }
        else if( $noofadult == 1 && $noofchild == 2) {
            if( $check_row["ATT_1"] == 99999 ) {
                $priceAdult = 0;
            }
            else {
                $priceAdult = $check_row["ATT_1"];
            }
        }
        else if( $noofadult == 1 && $noofchild == 3) {
            if( $check_row["ATT_1"] == 99999 ) {
                $priceAdult = 0;
            }
            else {
                $priceAdult = $check_row["ATT_1"];
            }
        }
        else if( $noofadult == 2 && $noofchild == 1) {
            if( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_2_ADULT"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_1"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] == 99999 ) {
                $priceAdult = 0;
            }
            else {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_2_ADULT"];
            }
        }
        else if( $noofadult == 2 && $noofchild == 2) {
            if( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_2_ADULT"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_1"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] == 99999 ) {
                $priceAdult = 0;
            }
            else {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_2_ADULT"];
            }
        }
        else if( $noofadult == 3 && $noofchild == 1) {
            if( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] == 99999 ) {
                $priceAdult = 0;
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_2_ADULT"]+$check_row["ATT_3_ADULT"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_3_ADULT"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_2_ADULT"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_1"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] == 99999 ) {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_2_ADULT"];
            }
            elseif( $check_row["ATT_1"] != 99999 && $check_row["ATT_2_ADULT"] == 99999 && $check_row["ATT_3_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_1"]+$check_row["ATT_3_ADULT"];
            }
            elseif( $check_row["ATT_1"] == 99999 && $check_row["ATT_2_ADULT"] != 99999 && $check_row["ATT_3_ADULT"] != 99999 ) {
                $priceAdult = $check_row["ATT_2_ADULT"]+$check_row["ATT_3_ADULT"];
            }
        }
        return $priceAdult;
    }

    function getIndividualPriceBasedChild($stateroomID, $shipID, $brandID, $noofnight, $periodType, $noofadult, $noofchild)
    {
        $priceChild = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT cp.STATEROOM_ID AS STATEROOM_ID, cs.STATEROOM_NAME AS STATEROOM_NAME, cp.ATT_SINGLE AS ATT_SINGLE,
                cp.ATT_1 AS ATT_1, cp.ATT_2_ADULT AS ATT_2_ADULT, cp.ATT_2_CHILD AS ATT_2_CHILD, cp.ATT_3_ADULT AS ATT_3_ADULT,
                cp.ATT_3_CHILD AS ATT_3_CHILD, cp.ATT_4_ADULT AS ATT_4_ADULT, cp.ATT_4_CHILD AS ATT_4_CHILD,
                cs.STATEROOM_OCCUPANT AS STATEROOM_OCCUPANT
                FROM cruise_prices cp, cruise_stateroom cs
                WHERE cp.STATEROOM_ID = cs.ID AND cp.NIGHTS_NO = ".$noofnight." AND cp.SHIP_ID = ".$shipID."
                AND cp.BRAND_ID = ".$brandID." AND cp.PERIOD_TYPE = '".$periodType."' AND  cs.ID = ".$stateroomID."
                GROUP BY cs.STATEROOM_NAME ORDER BY cs.orderNo ASC
            "
        );
        $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        if( $noofadult == 1 && $noofchild == 0 ) {
            $priceChild = 0;
        }
        else if( $noofadult == 2 && $noofchild == 0 ) {
            $priceChild = 0;
        }
        else if( $noofadult == 1 && $noofchild == 1 ) {
            if( $check_row["ATT_2_CHILD"] == 99999 ) {
                $priceChild = 0;
            }
            else {
                $priceChild = $check_row["ATT_2_CHILD"];
            }
        }
        else if( $noofadult == 1 && $noofchild == 2 ) {
            if( $check_row["ATT_2_CHILD"] == 99999 && $check_row["ATT_3_CHILD"] != 99999 ) {
                $priceChild = $check_row["ATT_3_CHILD"];
            }
            elseif( $check_row["ATT_2_CHILD"] != 99999 && $check_row["ATT_3_CHILD"] == 99999 ) {
                $priceChild = $check_row["ATT_2_CHILD"];
            }
            elseif( $check_row["ATT_2_CHILD"] == 99999 && $check_row["ATT_3_CHILD"] == 99999 ) {
                $priceChild = 0;
            }
            else {
                $priceChild = $check_row["ATT_2_CHILD"]+$check_row["ATT_3_CHILD"];
            }
        }
        else if( $noofadult == 1 && $noofchild == 3 ) {
            if( $check_row["ATT_2_CHILD"] == 99999 && $check_row["ATT_3_CHILD"] == 99999 && $check_row["ATT_4_CHILD"] == 99999 ) {
                $priceChild = 0;
            }
            elseif( $check_row["ATT_2_CHILD"] != 99999 && $check_row["ATT_3_CHILD"] != 99999 && $check_row["ATT_4_CHILD"] != 99999 ) {
                $priceChild = $check_row["ATT_2_CHILD"]+$check_row["ATT_3_CHILD"]+$check_row["ATT_4_CHILD"];
            }
            elseif( $check_row["ATT_2_CHILD"] == 99999 && $check_row["ATT_3_CHILD"] == 99999 && $check_row["ATT_4_CHILD"] != 99999 ) {
                $priceChild = $check_row["ATT_4_CHILD"];
            }
            elseif( $check_row["ATT_2_CHILD"] == 99999 && $check_row["ATT_3_CHILD"] != 99999 && $check_row["ATT_4_CHILD"] == 99999 ) {
                $priceChild = $check_row["ATT_3_CHILD"];
            }
            elseif( $check_row["ATT_2_CHILD"] != 99999 && $check_row["ATT_3_CHILD"] == 99999 && $check_row["ATT_4_CHILD"] == 99999 ) {
                $priceChild = $check_row["ATT_2_CHILD"];
            }
            elseif( $check_row["ATT_2_CHILD"] != 99999 && $check_row["ATT_3_CHILD"] != 99999 && $check_row["ATT_4_CHILD"] == 99999 ) {
                $priceChild = $check_row["ATT_2_CHILD"]+$check_row["ATT_3_CHILD"];
            }
            elseif( $check_row["ATT_2_CHILD"] != 99999 && $check_row["ATT_3_CHILD"] == 99999 && $check_row["ATT_4_CHILD"] != 99999 ) {
                $priceChild = $check_row["ATT_2_CHILD"]+$check_row["ATT_4_CHILD"];
            }
            elseif( $check_row["ATT_2_CHILD"] == 99999 && $check_row["ATT_3_CHILD"] != 99999 && $check_row["ATT_4_CHILD"] != 99999 ) {
                $priceChild = $check_row["ATT_3_CHILD"]+$check_row["ATT_4_CHILD"];
            }
        }
        else if( $noofadult == 3 && $noofchild == 1 ) {
            if( $check_row["ATT_4_CHILD"] == 99999 ) {
                $priceChild = 0;
            }
            else {
                $priceChild = $check_row["ATT_4_CHILD"];
            }
        }
        else if( $noofadult == 2 && $noofchild == 1 ) {
            if( $check_row["ATT_3_CHILD"] == 99999 ) {
                $priceChild = 0;
            }
            else {
                $priceChild = $check_row["ATT_3_CHILD"];
            }
        }
        else if( $noofadult == 2 && $noofchild == 2 ) {
            if( $check_row["ATT_3_CHILD"] == 99999 && $check_row["ATT_4_CHILD"] != 99999 ) {
                $priceChild = $check_row["ATT_4_CHILD"];
            }
            elseif( $check_row["ATT_3_CHILD"] != 99999 && $check_row["ATT_4_CHILD"] == 99999 ) {
                $priceChild = $check_row["ATT_3_CHILD"];
            }
            elseif( $check_row["ATT_3_CHILD"] == 99999 && $check_row["ATT_4_CHILD"] == 99999 ) {
                $priceChild = 0;
            }
            else {
                $priceChild = $check_row["ATT_3_CHILD"]+$check_row["ATT_4_CHILD"];
            }
        }
        return $priceChild;
    }

    function getSumExtraPrices($array_implode_extraIDs)
 	{
	 	$cruiseExtra = "";
	 	$connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	 	$check_res  = mysqli_query(
	 		$connection,
	 		"SELECT * FROM cruise_extra_price WHERE id IN(".$array_implode_extraIDs.")"
		);
		if( mysqli_num_rows($check_res) > 0 ) {
			while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
				$cruiseExtra += $check_row["extra_price_value"];
			}
		}
		else {
			$cruiseExtra = 0;
		}
		return $cruiseExtra;
 	}

    function calculateRoomQuantityAvailability($cruiseTitleID, $stateroomID)
    {
        $quantity = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT * FROM cruise_title_stateroom_qty
                WHERE cruise_title_id = ".$cruiseTitleID." AND stateroom_id = ".$stateroomID."
            "
        );
        $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["quantity"];
    }

    function getCruiseCartQty($cruiseTitleID, $stateroomID, $user_access_id)
    {
        $stateRoomQTY = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT ID, COUNT(*) AS countStateroom FROM cruise_cart
                WHERE cruiseTitleID = ".$cruiseTitleID." AND stateroomID = ".$stateroomID." AND user_access_id = ".$user_access_id."
                GROUP BY stateroomID
            "
        );
        $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        $stateRoomQTY = $check_row["countStateroom"];
        return $stateRoomQTY;
    }

    function calculateQtyAvaWithOutLogin($arraySessions)
    {
        $arrayContent = array();
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $a = 0;
        foreach( $arraySessions AS $key => $value ) {
            $explode = explode(":", $key);
            //available quantity
            $qtyRes = mysqli_query(
                $connection,
                "
                    SELECT * FROM cruise_title_stateroom_qty WHERE cruise_title_id = ".$explode[1]."
                    AND stateroom_id = ".$explode[0]."
                "
            );
            $qtyRow = mysqli_fetch_array($qtyRes, MYSQL_ASSOC);
            $stateRoomQTY = $qtyRow["quantity"];
            //end of available quantity
            //minus quantity
            $minus = $stateRoomQTY-$value;
            if( $minus >= 0 ) {
                $arrayContent[$a]["errorCode"] = 0;
                $arrayContent[$a]["message"]   = "No error";
            }
            else {
                $arrayContent[$a]["errorCode"]      = 1;
                $arrayContent[$a]["message"]        = "Error quantity";
                $arrayContent[$a]["stateroomID"]    = $explode[0];
                $arrayContent[$a]["cruiseTitleID"]  = $explode[1];
                $arrayContent[$a]["brandID"]        = $this->getCruiseBrandID($this->getShipIDByTitleID($explode[1]));
                $arrayContent[$a]["shipID"]         = $this->getShipIDByTitleID($explode[1]);
                $arrayContent[$a]["countStateroom"] = $value;
                $arrayContent[$a]["availableQty"]   = $stateRoomQTY;
                $arrayContent[$a]["minus"]          = $minus;
            }
            //end of minus quantity
            $a++;
        }
        return $arrayContent;
    }

    function calculateQtyAva($user_access_id)
    {
        $arrayContent = array();
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT stateroomID, cruiseTitleID, brandID, shipID, COUNT(*) AS countStateroom FROM cruise_cart
                WHERE user_access_id = ".$user_access_id." GROUP BY cruiseTitleID, stateroomID
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            $a = 0;
            while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                //available quantity
                $qtyRes = mysqli_query(
                    $connection,
                    "
                        SELECT * FROM cruise_title_stateroom_qty
                        WHERE cruise_title_id = ".$check_row["cruiseTitleID"]." AND stateroom_id = ".$check_row["stateroomID"]."
                    "
                );
                $qtyRow = mysqli_fetch_array($qtyRes, MYSQL_ASSOC);
                $stateRoomQTY = $qtyRow["quantity"];
                //end of available quantity
                //minus quantity
                $minus = $stateRoomQTY-$check_row["countStateroom"];
                if( $minus >= 0 ) {
                    $arrayContent[$a]["errorCode"] = 0;
                    $arrayContent[$a]["message"]   = "No error";
                }
                else {
                    $arrayContent[$a]["errorCode"]      = 1;
                    $arrayContent[$a]["message"]        = "Error quantity";
                    $arrayContent[$a]["stateroomID"]    = $check_row["stateroomID"];
                    $arrayContent[$a]["cruiseTitleID"]  = $check_row["cruiseTitleID"];
                    $arrayContent[$a]["brandID"]        = $check_row["brandID"];
                    $arrayContent[$a]["shipID"]         = $check_row["shipID"];
                    $arrayContent[$a]["countStateroom"] = $check_row["countStateroom"];
                    $arrayContent[$a]["availableQty"]   = $stateRoomQTY;
                    $arrayContent[$a]["minus"]          = $minus;
                }
                //end of minus quantity
                $a++;
            }
        }
        return $arrayContent;
    }

    function getValueAndTextFreeValidate($textOrValue, $priceValue)
    {
        $print = "";
        if( $priceValue == 99999 ) {
            if( $textOrValue == "TEXT" ) {
                $print = "FREE";
            }
            else if( $textOrValue == "VALUE" ) {
                $print = 0;
            }
        }
        else {
            if( $textOrValue == "TEXT" ) {
                $print = "$".number_format($priceValue, 2);
            }
            else if( $textOrValue == "VALUE" ) {
                $print = $priceValue;
            }
        }
        return $print;
    }

    function countryList()
    {
        $arrayCountryList = array();
        $finalOutput = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT DISTINCT(country_name) AS country_name FROM landtour_location ORDER BY country_name ASC"
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                $arrayCountryList[] = "'".$check_row["country_name"]."'";
            }
        }
        if( count($arrayCountryList) > 0 ) {
            $finalOutput = implode(", ", $arrayCountryList);
        }
        return $finalOutput;
    }

    function cityList()
    {
        $arrayCityList = array();
        $finalOutput = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT DISTINCT(city_name) AS city_name FROM landtour_location ORDER BY city_name ASC"
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                $arrayCityList[] = "'".$check_row["city_name"]."'";
            }
        }
        if( count($arrayCityList) > 0 ) {
            $finalOutput = implode(", ", $arrayCityList);
        }
        return $finalOutput;
    }

    function getLandtourCategoryName($categoryID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query($connection, "SELECT * FROM landtour_category WHERE id = '".$categoryID."'");
        $check_row  = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        return $check_row["category_name"];
    }

    function getPrice_basedonType($landtourID, $priceDate, $typeName)
    {
        $priceOutput = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT ".$typeName." FROM landtour_system_prices
                WHERE landtour_product_id = ".$landtourID." AND price_date = '".$priceDate."'
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            $check_row   = mysqli_fetch_array($check_res, MYSQL_ASSOC);
            $priceOutput = $check_row[$typeName];
        }
        else {
            $priceOutput = "";
        }
        return $priceOutput;
    }

    function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y' )
    {
        $dates   = array();
        $current = strtotime($first);
        $last    = strtotime($last);
        while( $current <= $last ) {
            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }
        return $dates;
    }

    function date_range_newFormatRoom($landtourID)
    {
        $dates = array();
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT * FROM landtour_priceDate
                WHERE landtour_product_id = ".$landtourID." AND selling_type = 'ROOM'
                AND DATE(priceDate) >= '".date("Y-m-d", strtotime("+7 days"))."'
                ORDER BY priceDate ASC
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                $dates[] = date("m/d/Y", strtotime($check_row["priceDate"]));
            }
        }
        return $dates;
    }

    function date_range_newFormatTicket($landtourID)
    {
        $dates = array();
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT * FROM landtour_priceDate
                WHERE landtour_product_id = ".$landtourID." AND selling_type = 'TICKET'
                AND DATE(priceDate) >= '".date("Y-m-d", strtotime("+7 days"))."'
                ORDER BY priceDate ASC
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                $dates[] = date("m/d/Y", strtotime($check_row["priceDate"]));
            }
        }
        return $dates;
    }

    function landtourShowPrice($landtourID, $selectDate, $selectAdult, $selectChild, $selectInfant, $checked)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $string = "";
        $contentToolTip = "";
        $prices = $this->select_template("landtour_product_id", $landtourID, "landtour_system_prices");
        foreach( $prices AS $price ) {
            $adultSingle_price     = $price->adultSingle_price;
            $adultTwin_price       = $price->adultTwin_price;
            $adultTriple_price     = $price->adultTriple_price;
            $child_w_bed_price     = $price->child_wb_price;
            $child_wo_bed_price    = $price->child_wob_price;
            $child_half_twin_price = $price->child_half_twin_price;
            $infant_price          = $price->infant_price;
        }
        if( $checked == "TRUE" ) {
            if( $selectAdult == 1 ) {
                $totalAdultPrice = $adultSingle_price;
            }
            else if( $selectAdult == 2 ) {
                $totalAdultPrice = $adultTwin_price;
            }
            else if( $selectAdult == 3 ) {
                $totalAdultPrice = $adultTriple_price;
            }
            $totalChildPrice  = $child_w_bed_price*$selectChild;
            $totalInfantPrice = $infant_price*$selectInfant;
            $totalGrandPrice  = $totalAdultPrice+$totalChildPrice+$totalInfantPrice;
        }
        else {
            if( $selectAdult == 1 ) {
                $totalAdultPrice = $adultSingle_price;
            }
            else if( $selectAdult == 2 ) {
                $totalAdultPrice = $adultTwin_price;
            }
            else if( $selectAdult == 3 ) {
                $totalAdultPrice = $adultTriple_price;
            }
            $totalChildPrice  = $child_wo_bed_price*$selectChild;
            $totalInfantPrice = $infant_price*$selectInfant;
            $totalGrandPrice  = $totalAdultPrice+$totalChildPrice+$totalInfantPrice;
        }
        $contentToolTip .= "Price breakdown for ".$selectAdult." adult(s) and ".$selectChild." child(s) and ".$selectInfant." infant(s)<hr />";
        if( $selectAdult > 0 ) {
            $contentToolTip .= "
                <div>
                    <div style='float:left; width:250px; text-align:left'>Adult Pax</div>
                    <div style='float:left; width:50px;  text-align:left'>
                        x ".$selectAdult."
                    </div>
                    <div style='float:left; width:100px; text-align:left'>
                        $".number_format($totalAdultPrice, 2)."
                    </div>
                    <div style='clear:both'></div>
                </div>
            ";
        }
        if( $selectChild > 0 ) {
            if( $checked == "TRUE" ) {
                $contentToolTip .= "
                    <div>
                        <div style='float:left; width:250px; text-align:left'>Child (With Bed) Pax</div>
                        <div style='float:left; width:50px;  text-align:left'>
                            x ".$selectChild."
                        </div>
                        <div style='float:left; width:100px; text-align:left'>
                            $".number_format($totalChildPrice, 2)."
                        </div>
                        <div style='clear:both'></div>
                    </div>
                ";
            }
            else {
                $contentToolTip .= "
                    <div>
                        <div style='float:left; width:250px; text-align:left'>Child (Without Bed) Pax</div>
                        <div style='float:left; width:50px;  text-align:left'>
                            x ".$selectChild."
                        </div>
                        <div style='float:left; width:100px; text-align:left'>
                            $".number_format($totalChildPrice, 2)."
                        </div>
                        <div style='clear:both'></div>
                    </div>
                ";
            }
        }
        if( $selectInfant > 0 ) {
            $contentToolTip .= "
                <div>
                    <div style='float:left; width:250px; text-align:left'>Infant Pax</div>
                    <div style='float:left; width:50px;  text-align:left'>
                        x ".$selectInfant."
                    </div>
                    <div style='float:left; width:100px; text-align:left'>
                        $".number_format($totalInfantPrice, 2)."
                    </div>
                    <div style='clear:both'></div>
                </div>
            ";
        }
        $contentToolTip .= "
            <hr />
            <div style='color:green; font-weight:bold'>
                <div style='float:left; width:250px; text-align:left'>TOTAL PRICE</div>
                <div style='float:left; width:50px;  text-align:left'>&nbsp;</div>
                <div style='float:left; width:100px; text-align:left'>
                    $".number_format($totalGrandPrice, 2)."
                </div>
                <div style='clear:both'></div>
            </div>
        ";
        $string .= '<tr id="available_price">';
        $string .=      '<td style="background:#eff0f1;">&nbsp;</td>';
        $string .=      '<td colspan="2" style="background: #eff0f1;">';
        $string .=          '<div style="font-size:16px">';
        $string .=              ''.$selectAdult.' Adult(s) & '.$selectChild.' Child(s) & '.$selectInfant.' Infant(s)';
        $string .=          '</div>';
        $string .=      '</td>';
        $string .=      '<td style="text-align:center; background: #eff0f1">';
        $string .=          '<div style="font-size:12px; padding:10px">';
        $string .=              '<a style="padding:13px; font-size:16px; font-weight:bold; text-decoration:none" href="#" class="tip" data-tip="'.$contentToolTip.'">$'.number_format($totalGrandPrice, 2).'</a>';
        $string .=          '</div>';
        $string .=      '</td>';
        $string .= '</tr>';
        $string .= '<tr id="available_price">';
        $string .=      '<td style="background:#eff0f1;">&nbsp;</td>';
        $string .=          '<td colspan="2" style="background: #eff0f1;">';
        $string .=              '<div style="font-size:12px">&nbsp;</div>';
        $string .=          '</td>';
        $string .=          '<td style="background: #eff0f1; text-align:center">';
        $string .=              '<div style="font-size:12px; padding:10px; background-color:#F7941D;">';
        $string .=                  '<a style="color:white; padding:13px; font-size:18px; font-weight:bold; text-decoration:none" href="'.base_url().'cart/do_add_cartLandtour/'.$landtourID.'/'.$selectDate.'/'.$selectAdult.'/'.$selectChild.'/'.$selectInfant.'/'.$checked.'">Book Now</a>';
        $string .=              '</div>';
        $string .=          '</td>';
        $string .=      '</td>';
        $string .= '</tr>';
        return $string;
    }

    function getPriceLantourSystem($landtourID, $typeLabel)
    {
        $priceOutput = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT ".$typeLabel." FROM landtour_system_prices WHERE landtour_product_id = ".$landtourID."
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            $check_row   = mysqli_fetch_array($check_res, MYSQL_ASSOC);
            $priceOutput = $check_row[$typeLabel];
        }
        else {
            $priceOutput = "";
        }
        return $priceOutput;
    }

    function checkAdultQty($landtourProductID)
    {
        $priceOutput = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT adult_qty FROM landtour_system_prices WHERE landtour_product_id = ".$landtourProductID.""
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            $check_row   = mysqli_fetch_array($check_res, MYSQL_ASSOC);
            $priceOutput = $check_row["adult_qty"];
        }
        else {
            $priceOutput = "";
        }
        return $priceOutput;
    }

    function checkChildQty($landtourProductID)
    {
        $priceOutput = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT ".$typeLabel." FROM landtour_system_prices WHERE landtour_product_id = ".$landtourProductID."
            "
        );
    }

    function checkInfantQty($landtourProductID)
    {
        $priceOutput = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT ".$typeLabel." FROM landtour_system_prices WHERE landtour_product_id = ".$landtourProductID."
            "
        );
    }

    function getLatestDayItinerary($landtourProductID)
    {
        $printOutput = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT itinerary_day_no FROM landtour_itinerary
                WHERE landtour_product_id = ".$landtourProductID." ORDER BY created DESC
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            $check_row   = mysqli_fetch_array($check_res, MYSQL_ASSOC);
            $printOutput = $check_row["itinerary_day_no"]+1;
        }
        else {
            $printOutput = 1;
        }
        return $printOutput;
    }

    function getSellingType_landtourID($landtourID)
    {
        $arrayContent = array();
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "
                SELECT DISTINCT(selling_type) AS selling_type FROM landtour_priceDate
                WHERE landtour_product_id = ".$landtourID."
            "
        );
        if( mysqli_num_rows($check_res) > 0 ) {
            while( $check_row = mysqli_fetch_array($check_res, MYSQL_ASSOC) ) {
                $arrayContent[] = $check_row["selling_type"];
            }
        }
        else {
            $arrayContent = array();
        }
        return $arrayContent;
    }

    function trueFalseShowRoomType($landtourID)
    {
        $result = "FALSE";
        $shows = $this->All->select_template_w_2_conditions(
            "landtour_product_id", $landtourID, "selling_type", "ROOM", "landtour_priceDate"
        );
        if( $shows == TRUE ) {
            $result = "TRUE";
        }
        else {
            $result = "FALSE";
        }
        return $result;
    }

    function trueFalseShowTicketType($landtourID)
    {
        $result = "FALSE";
        $shows = $this->All->select_template_w_2_conditions(
            "landtour_product_id", $landtourID, "selling_type", "TICKET", "landtour_priceDate"
        );
        if( $shows == TRUE ) {
            $result = "TRUE";
        }
        else {
            $result = "FALSE";
        }
        return $result;
    }

    function getEmailContactPurchaseInfo($bookOrderID)
    {
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $check_res  = mysqli_query(
            $connection,
            "SELECT * FROM contact_person_information WHERE category='main' AND bookOrderID = '".$bookOrderID."'"
        );
        $check_row     = mysqli_fetch_array($check_res, MYSQL_ASSOC);
        $email_address = $check_row["cp_email"];
        return $email_address;
    }

    function getHotelImagePicture($itemCode, $city_code="")
    {
        $print = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        //query mysql
        $queryRes = mysqli_query(
            $connection,
            "
                SELECT DISTINCT image FROM hotel_gta_item_information_image_link WHERE city_code='".$city_code."' AND item_code = '".$itemCode."'
                AND (text = 'Exterior' OR text='Guest Room' OR text = 'Suite') AND type='image' ORDER BY text LIMIT 0,1
            "
        );
        if( mysqli_num_rows($queryRes) > 0 ) {
            $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
            $print = $queryRow["image"];
        }
        else {
            $queryRes = mysqli_query(
            $connection,
                "
                    SELECT DISTINCT image FROM hotel_gta_item_information_image_link WHERE city_code='".$city_code."' AND item_code = '".$itemCode."' AND type='image' ORDER BY text LIMIT 0,1
                "
            );
            if( mysqli_num_rows($queryRes) > 0 ) {
                $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
                $print = $queryRow["image"];
            } else
             $print = "";
        }
        //end of query mysql
        return $print;
    }

    function getCountryCode($countryName)
    {
        $print = "";
        $connection = mysqli_connect(DB_LOCALHOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        //query mysql
        $queryRes = mysqli_query(
            $connection,
            "
                SELECT * FROM country WHERE LOWER(country_name) = '".strtolower($countryName)."' LIMIT 0,1
            "
        );

        if( mysqli_num_rows($queryRes) > 0 ) {
            $queryRow = mysqli_fetch_array($queryRes, MYSQL_ASSOC);
            $print = $queryRow["country_code"];
        }
        else {
            $print = "";
        }
        //end of query mysql
        return $print;
    }

    public function responseURL($responseGTA)
    {
        $array = array(
           'hotel_responseGTA' => $responseGTA
        );
        $data = $this->db->insert("hotel_gta_response_url", $array);

    }

    public function checkHotelAttributes($data_hotels, $hotel_facilities=null, $hotel_room_facilities=null)
    {
        $tbl_fac = 'hotel_gta_item_information_facility';
        $tbl_roomfac = 'hotel_gta_item_information_room_facility';
        $count_data_hotels = count($data_hotels);

        if($count_data_hotels) {
            $query_condition = $tbl_fac.".city_code = '".$data_hotels[0][0] ."' AND (";

            $query_condition2 = '(';
            for($n=0; $n<$count_data_hotels; $n++) {
                $query_condition .= "
                ".$tbl_fac.".item_code = '".$data_hotels[$n][1]."' OR";
                $query_condition2 .= " (".$tbl_roomfac.".city_code = '".$data_hotels[$n][0]."'
                AND ".$tbl_roomfac.".item_code = '".$data_hotels[$n][1]."') OR";
            }
            $query_condition = substr($query_condition, 0, -2);
            $query_condition2 = substr($query_condition2, 0, -2);

            $query_condition .= ")";
            $query_condition2 .= ")";
        }

        // // // ------------------------------------------------------------------------------------------


        $flag_hotel_facilities = FALSE; $flag_hotel_room_facilities = FALSE;
        $query_hotel_facilities = '';
        $query_hotel_room_facilities = '';

        // // // echo '<pre>';
        $count_facilities = count($hotel_facilities);
        // // // echo 'count_facilities = '.$count_facilities.'<br />';

        $query_hotel_facilities = '';
        if($count_facilities AND is_array($hotel_facilities)) {
            for($i=0; $i<$count_facilities; $i++) {
                $in_hotel_facilities = explode(",", $hotel_facilities[$i]);

                for ($j = 0; $j < count($in_hotel_facilities); $j++) {
                    $query_hotel_facilities .=  " ".$tbl_fac.".code='".$in_hotel_facilities[$j]."' OR";
                }
            }
            $query_hotel_facilities = substr($query_hotel_facilities, 0, -2);
            $flag_hotel_facilities = TRUE;

            $query_result_hotel_facilities = "SELECT city_code, item_code
            FROM ".$tbl_fac." WHERE $query_condition AND ($query_hotel_facilities) GROUP BY city_code, item_code";
            $result_hotel_facilities = $this->db->query($query_result_hotel_facilities);

            // // // echo 'query_result_hotel_facilities = '.$query_result_hotel_facilities.'<br />';
            if($result_hotel_facilities->num_rows() > 0)
            {
                // // // $result_hotel_facility =  $result_hotel_facilities->result();
                $x = 0;
                foreach ($result_hotel_facilities->result() as $row)
                {
                    $hotel_facility[$x][0] = $row->city_code;
                    $hotel_facility[$x][1] = $row->item_code;
                    $x++;
                }

            }
            else {
                $flag_hotel_facilities = FALSE;
            }
            // // // echo '<br />hotel_facility : <br />';
            // // // print_r($hotel_facility);

        }

        // // // // // // // // // // // ===========================================================================================

        //$count_room_facilities = count($hotel_room_facilities);
        // // // echo 'count_room_facilities = '.$count_room_facilities.'<br />';
        //if($count_room_facilities AND is_array($hotel_room_facilities)) {
        if($count_facilities AND is_array($hotel_facilities)) {
            for($j=0; $j<$count_facilities; $j++) {
                $in_hotel_facilities = explode(",", $hotel_facilities[$j]);

                for ($k = 0; $k < count($in_hotel_facilities); $k++) {
                    $query_hotel_room_facilities .= " ".$tbl_roomfac.".code='".$in_hotel_facilities[$k]."' OR";
                }

                //$query_hotel_room_facilities .= $tbl_roomfac.".code='".$hotel_room_facilities[$j]."' OR";
            }
            $query_hotel_room_facilities = substr($query_hotel_room_facilities, 0, -2);
            $flag_hotel_room_facilities = TRUE;
            $query_result_hotel_room_facilities = "SELECT city_code, item_code
            FROM ".$tbl_roomfac." WHERE $query_condition2 AND ($query_hotel_room_facilities) GROUP BY city_code, item_code";
            $result_hotel_room_facilities = $this->db->query($query_result_hotel_room_facilities);
            // // // echo 'query_result_hotel_room_facilities = '.$query_result_hotel_room_facilities.'<br />';
            if($result_hotel_room_facilities->num_rows() > 0)
            {
                // // echo '<br />OK2';
                // // // // // // // // // $result_hotel_room_facility =  $result_hotel_room_facilities->result();
                $x = 0;
                foreach ($result_hotel_room_facilities->result() as $row)
                {
                    $hotel_room_facility[$x][0] = $row->city_code;
                    $hotel_room_facility[$x][1] = $row->item_code;
                    $x++;
                }
            } else {
                $flag_hotel_room_facilities = FALSE;
            }
            // // // echo '<br />hotel_room_facility : <br />';
            // // // print_r($hotel_room_facility);
        }

        if((!$flag_hotel_facilities) AND (!$flag_hotel_room_facilities)) {
            $result = FALSE;
        }
        else if((!$flag_hotel_facilities) AND $flag_hotel_room_facilities) {
            $result = $hotel_room_facility;
        }
        else if(($flag_hotel_facilities) AND !($flag_hotel_room_facilities)) {
            $result = $hotel_facility;
        }
        else {
            $hotel_room_facility = false;
            $query_result_hotel_room_facilities = "
            SELECT t1.city_code, t1.item_code FROM (
                SELECT DISTINCT city_code, item_code
                FROM ".$tbl_roomfac." WHERE $query_condition2
                    AND ($query_hotel_room_facilities) GROUP BY city_code, item_code
                UNION ALL
                SELECT DISTINCT  city_code, item_code FROM ".$tbl_fac." WHERE $query_condition AND ($query_hotel_facilities) GROUP BY city_code, item_code
            ) AS t1 GROUP BY city_code, item_code  HAVING count(*) >= 2;
            ";
            $result_hotel_room_facilities = $this->db->query($query_result_hotel_room_facilities);

            if($result_hotel_room_facilities->num_rows() > 0)
            {
                // // echo '<br />OK2';
                // // // // // // // // // $result_hotel_room_facility =  $result_hotel_room_facilities->result();
                $x = 0;
                foreach ($result_hotel_room_facilities->result() as $row)
                {
                    $hotel_room_facility[$x][0] = $row->city_code;
                    $hotel_room_facility[$x][1] = $row->item_code;
                    $x++;
                }
            }
            $result = $hotel_room_facility;
            // // // echo '<pre>temp_result';
            // // // print_r($temp_result);
        }
        return $result;

    }

    public function checkHotelAttributes123($data_hotels, $hotel_facilities=null, $hotel_room_facilities=null)
    {
        $count_facilities = count($hotel_facilities);
        $flag_hotel_facilities = FALSE; $flag_hotel_room_facilities = FALSE;
        $query_hotel_facilities = '';
        $query_hotel_room_facilities = '';
        echo 'count_facilities = '.$count_facilities.'<br />';
        $query_hotel_facilities = '';
        if($count_facilities AND is_array($hotel_facilities)) {
            for($i=0; $i<$count_facilities; $i++) {
                $query_hotel_facilities .= " hotel_gta_item_information_facility.code='".$hotel_facilities[$i]."' OR";
            }
            $query_hotel_facilities = substr($query_hotel_facilities, 0, -2);
            $flag_hotel_facilities = TRUE;
        }
        $count_room_facilities = count($hotel_room_facilities);
        echo 'count_room_facilities = '.$count_room_facilities.'<br />';
        if($count_room_facilities AND is_array($hotel_room_facilities)) {

            for($j=0; $j<$count_room_facilities; $j++) {
                $query_hotel_room_facilities .= " hotel_gta_item_information_room_facility.code='".$hotel_room_facilities[$j]."' OR";
            }
            $query_hotel_room_facilities = substr($query_hotel_room_facilities, 0, -2);
            $flag_hotel_room_facilities = TRUE;
        }
        $count_data_hotels = count($data_hotels);
        if($count_data_hotels) {
            $query_condition = '';
            for($n=0; $n<$count_data_hotels; $n++) {
                $query_condition .= " (hotel_gta_item_information_facility.city_code = '".$data_hotels[$n][0]."'
                AND hotel_gta_item_information_facility.item_code = '".$data_hotels[$n][1]."') OR";
            }
            $query_condition = substr($query_condition, 0, -2);
        }
        $logic_sign = '';
        if($flag_hotel_facilities AND $flag_hotel_room_facilities) $logic_sign = 'OR';
        $all_query = " SELECT hotel_gta_item_information_facility.city_code, hotel_gta_item_information_facility.item_code, hotel_gta_item_information_room_facility.city_code,
                hotel_gta_item_information_room_facility.item_code FROM hotel_gta_item_information_facility, hotel_gta_item_information_room_facility
                WHERE $query_condition AND
                (hotel_gta_item_information_facility.city_code = hotel_gta_item_information_room_facility.city_code
                AND hotel_gta_item_information_facility.item_code = hotel_gta_item_information_room_facility.item_code)
                AND ($query_hotel_facilities $logic_sign $query_hotel_room_facilities)";
        echo 'all_query = '.$all_query;
    }

    public function getStatusBooking($bookOrderID)
    {
        $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
        $requestData .= '<Request>';
        $requestData .=     '<Source>';
        $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
        $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'" Currency="SGD" Country="SG">';
        $requestData .=             '<RequestMode>SYNCHRONOUS</RequestMode>';
        $requestData .=         '</RequestorPreferences>';
        $requestData .=     '</Source>';
        $requestData .=     '<RequestDetails>';
        $requestData .=     '<SearchBookingRequest>';
        $requestData .=     '<BookingReference ReferenceSource = "client">'.$bookOrderID.'</BookingReference>';
        $requestData .=     '<EchoSearchCriteria>true</EchoSearchCriteria>';
        $requestData .=     '<ShowPaymentStatus>false</ShowPaymentStatus>';
        $requestData .=     '</SearchBookingRequest>';
        $requestData .=     '</RequestDetails>';
        $requestData .= '</Request>';
        /*
        //log file
        $myfile = fopen("/var/www/html/ctctravel.org/fit-final-testing/assets/api-logs/logs_hotel.txt", "a") or die("Unable to open file!");
        // $txt  = "[".date("Y-m-d H:i:s")."] - ".$output;
        fwrite($myfile, "\n". $txt);
        fclose($myfile);*/

        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info   = curl_getinfo($ch);
        curl_close($ch);
        $array_output = $this->All->XMLtoArray($output);

        if(array_key_exists('RESPONSE', $array_output)) {
            if(array_key_exists('RESPONSEDETAILS', $array_output['RESPONSE'])) {
                if(isset($array_output['RESPONSE']['RESPONSEDETAILS']['SEARCHBOOKINGRESPONSE'])) {
                    $this->db->set('bookingorderid', $bookOrderID);
                    $this->db->set('bookingjsondata', json_encode($array_output['RESPONSE']['RESPONSEDETAILS']['SEARCHBOOKINGRESPONSE']));
                    $this->db->insert('hotel_booking_jsondata');
                }
            }
        }
    }
    public function insert_addNewBooking($bookOrderID)
    {
        //parameter preparation
        $travelerInfo = $this->All->select_template('bookOrderID', $bookOrderID, 'contact_person_information');
        if( $travelerInfo == TRUE ) {
            foreach( $travelerInfo AS $travelerData ) {
                $leadName = $travelerData->cp_title." ".$travelerData->cp_fullname;
            }
        }

        $bookingName = "CTC".$bookOrderID;
        $this->db->select_max('hotel_AdultQuantity');
        $this->db->where('bookingRefID', $bookOrderID);
        $queryAdult = $this->db->get('hotel_historyOder')->row();
        $maxAdult   = $queryAdult->hotel_AdultQuantity;

        $this->db->select_max('hotel_ChildQuantity');
        $this->db->where('bookingRefID', $bookOrderID);
        $queryChild = $this->db->get('hotel_historyOder')->row();
        $maxChild   = $queryChild->hotel_ChildQuantity;

        $totalPax   = $maxAdult+$maxChild;
        //end of parameter preparation

        //xml execution
        $this->db->distinct();
        $this->db->select('*');
        $this->db->from('hotel_historyOder');
        $this->db->where('bookingRefID', $bookOrderID);
        /*$this->db->group_by('hotel_ItemCode');
        $this->db->group_by('hotel_ItemCityCode');*/
        $qry_r = $this->db->get();

        $requests = $qry_r->result();

        if( $requests == TRUE ) {
            $txt = "";
            $itemRemarks = "";
            $paxNameData = "";

            $destinationCode = $requests[0]->hotel_ItemCityCode;

            $country_name = $this->get_country_hotel_bycitycode($destinationCode);
            $countryCode  = $this->getCountryCode($country_name);

            $requestData  = '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
            $requestData .= '<Request>';
            $requestData .=     '<Source>';
            $requestData .=         '<RequestorID Client="'.GTA_CLIENT_ID.'" EMailAddress="'.GTA_EMAIL.'" Password="'.GTA_PASSWORD.'"/>';
            $requestData .=         '<RequestorPreferences Language="'.GTA_LANGUAGE.'" Currency="SGD" Country="'.$countryCode.'">';
            $requestData .=             '<RequestMode>ASYNCHRONOUS</RequestMode>';
            $requestData .=             '<ResponseURL>'.base_url('example/gta/responseBooking').'</ResponseURL>';
            $requestData .=         '</RequestorPreferences>';
            $requestData .=     '</Source>';
            $requestData .=     '<RequestDetails>';

            $requestData .=         '<AddBookingRequest Currency="SGD">';
            $requestData .=             '<BookingName>'.$bookingName.'</BookingName>';
            $requestData .=             '<BookingReference>'.$bookOrderID.'</BookingReference>';

            $arrRoomTp = array();
            foreach( $requests AS $request ) {
                $this->db->select('*');
                $this->db->from('hotel_historyOder');
                $this->db->where('bookingRefID', $bookOrderID);
                $this->db->where('hotel_ItemCode', $request->hotel_ItemCode);
                $this->db->where('hotel_ItemCityCode', $request->hotel_ItemCityCode);
                $qry = $this->db->get();

                $res = false;
                if($qry->num_rows()) {
                    $res = $qry->result();
                    foreach($res as $dt) {
                        $arrRoomTp[] = $dt->hotel_RoomTypeID;
                    }
                }
            }

            $paxNameData .=             '<PaxNames>';
                        $arrayPax = array();
                        $this->db->select('*');
                        $this->db->from('hotel_paxName');
                        $this->db->where('bookingID', $bookOrderID);
                        $this->db->where_in('RoomTypeID', $arrRoomTp);
                        /*$this->db->where('flag_historyoder_id', $request->id);
                        $this->db->where('flag_room', $request->room_index);*/
                        $qrys = $this->db->get();
                        if($qrys->num_rows())
                           $paxNames = $qrys->result();
                        else $paxNames = false;

                        if( $paxNames == TRUE ) {
                            $a=1;
                            foreach( $paxNames AS $paxName ) {
                                $arrayPax["$paxName->RoomTypeID"][] = array('flag' => $paxName->flag_room, 'idx' => $a);
                                if(trim(strtolower($paxName->adult_or_child)) == 'child') {
                                $paxNameData .= '<PaxName PaxId="'.$a.'" PaxType="'.trim(strtolower($paxName->adult_or_child)).'" ChildAge="'.$paxName->age.'"><![CDATA['.$paxName->paxName.']]></PaxName>';
                                }
                                else {
                                $paxNameData .= '<PaxName PaxId="'.$a.'" PaxType="'.trim(strtolower($paxName->adult_or_child)).'"><![CDATA['.$paxName->paxName.']]></PaxName>';
                                }
                                $a++;
                            }
                        }
            $paxNameData .=             '</PaxNames>';
            $requestData .=  $paxNameData;
            $requestData .=             '<BookingItems>';

            $itemRef = 1;
            foreach( $requests AS $request ) {
/*

                $this->db->select('*');
                $this->db->from('hotel_historyOder');
                $this->db->where('bookingRefID', $bookOrderID);
                //$this->db->where('id', $request->id);
                $this->db->where('room_index', $request->room_index);
                $this->db->where_in('hotel_RoomTypeID', $arrRoomTp);
                $qrys = $this->db->get();
                if($qrys->num_rows())
                   $requestBookings = $qrys->result();
                else $requestBookings =false;

                if( $requestBookings == TRUE ) {
                    foreach( $requestBookings AS $requestBooking ) {*/
                $reqPaxTotal = $request->hotel_AdultQuantity+$request->hotel_ChildQuantity;

                if($request->hotelAPISpecialRequest != "") {
                    $itemRemarks = '<ItemRemarks>';
                    $arrsp = explode(",", $request->hotelAPISpecialRequest);
                    $itemRemarksd2 = "";
                    if (count($arrsp) > 0) {
                        foreach($arrsp as $datasp) {
                            /*$rem = $this->db->select('remarkContent')->from('hotel_specialRequest')->where('remarkCode', $datasp)->get();
                            if($rem) {
                                $itemRemarksd2 .= '<ItemRemark><![CDATA['.$rem->row()->remarkContent.']]></ItemRemark>';
                            }*/
                            $itemRemarksd2 .= '<ItemRemark Code="'.$datasp.'"/>';
                        }
                    }
                    $itemRemarks .= $itemRemarksd2;
                    $itemRemarks .= '</ItemRemarks>';
                }

                $requestData .=             '<BookingItem ItemType="hotel">';
                $requestData .=             '<ItemReference>'.$itemRef.'</ItemReference>';
                $requestData .=             '<ItemCity Code="'.$request->hotel_ItemCityCode.'" />';
                $requestData .=             '<Item Code="'.$request->hotel_ItemCode.'" />';
                $requestData .= $itemRemarks;
                $requestData .=             '<HotelItem>';
                $requestData .=             '<PeriodOfStay>';
                $requestData .=             '<CheckInDate>'.$request->check_in_date.'</CheckInDate>';
                $requestData .=             '<CheckOutDate>'.$request->check_out_date.'</CheckOutDate>';
                $requestData .=             '</PeriodOfStay>';
                $requestData .=             '<HotelPaxRoom Adults="'.$request->hotel_AdultQuantity.'" Children = "'.$request->hotel_ChildQuantity.'" Cots = "'.$request->hotel_InfantQuantity.'" Id="'.$request->hotel_RoomTypeID.'">';
                $requestData .=             '<PaxIds>';

                foreach($arrayPax["$request->hotel_RoomTypeID"] as $paxData) {
                    if($request->room_index == $paxData['flag'])
                        $requestData .=     '<PaxId>'.$paxData['idx'].'</PaxId>';
                }
                $requestData .=             '</PaxIds>';
                $requestData .=             '</HotelPaxRoom>';
                $requestData .=             '</HotelItem>';
                $requestData .=             '</BookingItem>';
                $itemRef++;

            }
            $requestData .=             '</BookingItems>';
            $requestData .=         '</AddBookingRequest>';
            $requestData .=     '</RequestDetails>';
            $requestData .= '</Request>';
        }
        /*echo '<xmp>'.$requestData.'</xmp>';
        die();*/
        //log file
        /*$myfile = fopen("/var/www/html/ctctravel.org/fit-final-testing/assets/api-logs/logs_hotel.txt", "a") or die("Unable to open file!");
         $txt  = "[".date("Y-m-d H:i:s")."] - ".$requestData;
        fwrite($myfile, "\n". $txt);
        fclose($myfile);*/
        $url = "https://rbs.gta-travel.com/rbsrsapi/RequestListenerServlet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        $output = curl_exec($ch);
        $info   = curl_getinfo($ch);
        curl_close($ch);
        $array_output = $this->All->XMLtoArray($output);

        //$this->All->getStatusBooking($bookOrderID);
        $homepage = file_get_contents(base_url().'example/gta/responseBooking');

        if(array_key_exists('RESPONSE', $array_output)) {
            if(array_key_exists('RESPONSEREFERENCE', $array_output['RESPONSE'])) {
                $dataUpd = array('CTC_REFERENCE_STRING' => $array_output['RESPONSE']['RESPONSEREFERENCE'], 'modified' => date("Y-m-d H:i:s"));
                $this->All->update_template($dataUpd, 'bookingRefID', $bookOrderID, 'hotel_historyOder');

                $this->All->getStatusBooking($bookOrderID);
            }

            if(isset($array_output['RESPONSE']['RESPONSEDETAILS']['BOOKINGRESPONSE']['ERRORS']['ERROR']))
            {
                $this->db->where('bookingorderid', $bookOrderID);
                    $this->db->set('bookingresponsejson', json_encode($array_output['RESPONSE']['RESPONSEDETAILS']['BOOKINGRESPONSE']['ERRORS']['ERROR']['ERRORID'] . ' '. $array_output['RESPONSE']['RESPONSEDETAILS']['BOOKINGRESPONSE']['ERRORS']['ERROR']['ERRORTEXT']));
                    $this->db->update('hotel_booking_jsondata');
            }
        }

        //end of xml execution
        /*--SAVE IT AS XML FORNAT--*/
        $xmlString = $output;
        $dom = new DOMDocument;
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xmlString);
        $dom->save($_SERVER['DOCUMENT_ROOT'].$this->instanceapp.'/assets/saveXML/'.$bookOrderID.'.xml');
        /*--END OF SAVE IT AS XML FORNAT--*/
    }

}
?>