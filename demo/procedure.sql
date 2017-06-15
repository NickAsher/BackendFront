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