CREATE VIEW `menu_items_view`
AS SELECT `item_id`, `item_name`, `item_description`, `item_image_name`, `category_no_of_size_variations`,  `item_category_code`, `category_display_name`, `item_subcategory_code`, `subcategory_display_name`
FROM `menu_items_table`,`menu_meta_category_table`, `menu_meta_rel_category-subcategory_table`
WHERE `menu_items_table`.`item_category_code` = `menu_meta_category_table`.`category_code`
AND `menu_items_table`.`item_subcategory_code` = `menu_meta_rel_category-subcategory_table`.`subcategory_code`


CREATE VIEW `menu_items_price_view`
AS SELECT `size_rel_id`, `item_id`, `size_sr_no`, `size_name`, `item_price`
FROM `menu_meta_rel_size-items_table`, `menu_meta_size_table`, `menu_items_table`
WHERE `menu_meta_rel_size-items_table`.`item_id` = `menu_items_table`.`item_id`
AND `menu_items_table`.`item_category_code` = `menu_meta_size_table`.`size_category_code`
AND `menu_meta_size_table`.`size_sr_no` = `menu_meta_rel_size-items_table`.`size_sr_no`