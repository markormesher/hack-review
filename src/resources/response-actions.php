<?php

class Responses
{
    public static function getById($id)
    {
        $result = mysql_query('SELECT * FROM `' . DB_PREFIX . 'response_values` WHERE `response_id` = \'' . $id . '\'');

        if (mysql_num_rows($result) == 0) {

            return array();
        } else {
            $output = array();
            while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
            {
                if ($row['is_text']) {
                    $result1 = mysql_query('SELECT * FROM `' . DB_PREFIX . 'response_text_values` WHERE `response_text_id` = \'' . $row['value'] . '\'');
                    echo mysql_error();
                  $row1=  mysql_fetch_array($result1, MYSQL_ASSOC);
                    $row['value'] = $row1['value'];
                }



                    $output[] = $row;

            }
            return $output;
        }

    }

}