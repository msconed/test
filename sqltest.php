

<?php


/*
---------------------------------------------------------------------------------------------------|
Удаляем лишние склады                                                                              |
DELETE FROM stocks WHERE NOT id IN (SELECT stock_id FROM availabilities);                          |
---------------------------------------------------------------------------------------------------|

---------------------------------------------------------------------------------------------------|
Удаляем лишние товары                                                                              |
DELETE FROM products WHERE NOT id IN (SELECT product_id FROM availabilities);                      |
---------------------------------------------------------------------------------------------------|

---------------------------------------------------------------------------------------------------|
Удаляем лишние категории                                                                           |
DELETE FROM categories WHERE NOT id IN (SELECT category_id FROM products);                         |
---------------------------------------------------------------------------------------------------|
*/

