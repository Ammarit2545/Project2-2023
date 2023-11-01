

<?php
                                                $total_part_price = 0;
                                                $sql_op = "SELECT 
                                                MAX(pu.pu_id) AS max_pu_id,
                                                MAX(gd.get_d_id) AS max_get_d_id,
                                                MAX(parts.p_id) AS pId,
                                                MAX(rs.rs_id) AS rsId,
                                                MAX(pud.pu_value) AS max_pu_value,
                                                MAX(repair_detail.p_id) AS r_brand,
                                                MAX(repair_detail.p_id) AS r_model,
                                                MAX(repair_detail.p_id) AS p_id,
                                                MAX(repair_detail.rd_value_parts) AS rd_value_parts,
                                                MAX(repair_detail.get_d_id) AS get_d_id,
                                                MAX(parts.p_brand) AS p_brand,
                                                MAX(parts.p_model) AS p_model,
                                                MAX(parts.p_price) AS p_price,
                                                MAX(parts_type.p_type_name) AS p_type_name,
                                                MAX(rs.rs_id) AS max_rs_id,
                                                MAX(parts.p_pic) AS p_pic,
                                                MAX(repair.r_brand) AS r_brand_repair,
                                                MAX(repair.r_model) AS r_model_repair
                                            FROM parts_use AS pu
                                            LEFT JOIN repair_status AS rs ON rs.rs_id = pu.rs_id
                                            LEFT JOIN get_repair AS gr ON rs.get_r_id = gr.get_r_id
                                            LEFT JOIN get_detail AS gd ON gd.get_r_id = gr.get_r_id
                                            LEFT JOIN repair ON gd.r_id = repair.r_id
                                            LEFT JOIN parts_use_detail AS pud ON pud.pu_id = pu.pu_id
                                            LEFT JOIN repair_detail ON repair_detail.rs_id = rs.rs_id
                                            LEFT JOIN parts ON pud.p_id = parts.p_id
                                            LEFT JOIN parts_type ON parts.p_type_id = parts_type.p_type_id
                                            WHERE rs.get_r_id = '$get_r_id' AND rs.del_flg = 0 AND pud.del_flg = 0
                                            GROUP BY pu.pu_id;
                                             ";
                                                // if ($status_id_last == 13) {
                                                //     $sqlCheckOffer = "SELECT * FROM repair_status WHERE get_r_id = '$get_r_id' AND status_id = 13 OR status_id = 17 AND del_flg = 0 ORDER BY rs_id DESC LIMIT 1 OFFSET 1";
                                                //     $resultOffer = mysqli_query($conn, $sqlCheckOffer);

                                                //     if (mysqli_num_rows($resultOffer)) {
                                                //         $rowOffer = mysqli_fetch_array($resultOffer);
                                                //         $Offer_rs =  $rowOffer['rs_id'];
                                                //         $sql_op .=   " AND repair_status.rs_id = '$Offer_rs' ";
                                                //     } else {
                                                //         $sql_op .=   " AND repair_status.status_id != 13 ";
                                                //     }
                                                // } elseif ($have_17 == 17) {
                                                //     $sqlCheckOffer = "SELECT *
                                                //             FROM repair_status
                                                //             LEFT JOIN repair_detail ON repair_detail.rs_id = repair_status.rs_id
                                                //             WHERE repair_status.get_r_id = '$get_r_id'
                                                //             AND (repair_status.status_id = 17 OR repair_status.status_id = 13)
                                                //             AND repair_status.del_flg = 0
                                                //             AND repair_detail.del_flg = 0
                                                //             ORDER BY repair_status.rs_id DESC
                                                //             LIMIT 1 OFFSET 1;
                                                //             ";
                                                //     $resultOffer = mysqli_query($conn, $sqlCheckOffer);

                                                //     if (mysqli_num_rows($resultOffer)) {
                                                //         $rowOffer = mysqli_fetch_array($resultOffer);
                                                //         $Offer_rs =  $rowOffer['rs_id'];
                                                //         $sql_op .=   " AND repair_status.rs_id = $Offer_rs ";
                                                //     } else {
                                                //         $sql_op .=   " AND repair_status.status_id != 13 ";
                                                //     }
                                                // }
                                                // $sql_op .= "GROUP BY repair_detail.rd_id;";