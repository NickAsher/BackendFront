DELIMITER $$
CREATE PROCEDURE `move_demo1_to_demo2`
  BEGIN


    INSERT INTO `demo2` SELECT * FROM `demo1` ;
    DELETE  FROM `demo1` ;
    ALTER TABLE `demo1` AUTO_INCREMENT = 1 ;



  END $$
DELIMITER ;

/* ************************************************************************************************ */
/*                                      PROCEDURE WITH TRANSACTION                                  */

DELIMITER $$
CREATE PROCEDURE `move_demo1_to_demo2`
  BEGIN


    INSERT INTO `demo2` SELECT * FROM `demo1` ;
    DELETE * FROM `demo1` ;
    ALTER TABLE `demo1` AUTO_INCREMENT = 1 ;



  END $$
DELIMITER ;




/* ************************************** */

DELIMITER $$

CREATE TRIGGER `autoinc_demo_sr_after_trigger` AFTER INSERT ON `demo`
FOR EACH ROW
  BEGIN
    DECLARE newSrNo INT default 0;
    SELECT Max(`item_sr_no`)+1 INTO newSrNo FROM demo WHERE `item_id` = new.`item_id`;
    UPDATE `demo` SET `item_sr_no` = newSrNo WHERE `item_id` = new.`item_id`;
  END$$

DELIMITER ;

/* ******************************************** */

INSERT INTO
  `demo`(  `item_sr_no`, `item_name`, `item_id`)
  SELECT MAX( `item_sr_no` ) + 1, 'yolo pizza', '' FROM `demo`;



UPDATE `menu_items_table` m INNER JOIN `menu_meta_rel_category-subcategory_table` s ON `m`.`item_subcategory_code` = `s`.`subcategory_code` SET `m`.`item_subcategory_code` = `s`.`rel_id`