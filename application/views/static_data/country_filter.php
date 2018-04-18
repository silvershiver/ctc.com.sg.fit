<html>
<head></head>
<body>
    <form method="post" action="<?php echo $actionurl;?>">
        <div>
            <label for="country_code">Select Country</label>
            <select name="country_code">
                <option value="-">All</option>
                <?php
                    $this->db->select('*');
                    if(isset($showOffCountry) && $showOffCountry) {
                        $this->db->where('done_proceed', 0);
                    }
                    if(isset($showOffCountry1) && $showOffCountry1) {
                        $this->db->where('done_proceed_item', 0);
                    }
                    $qry = $this->db->get("country");

                    if ($qry->num_rows()) {
                        foreach($qry->result() as $data) {
                            echo '<option value="'.$data->country_code.'">'.$data->country_name.'</option>';
                        }
                    }
                ?>
            </select>
        </div>
        <div>
            <input type="submit" value="Submit">
        </div>
    </form>
    <?php echo $this->session->flashdata('nodata');?>
</body>
</html>