
При решении задачи были описаны и использованы 4 сущности(таблицы):
1)Таблица Product 
2)Таблица clients
3)Таблица order
4)Таблица order_items
5)Таблица images

В базе данных images хранятся URL картинок. Картинки могут храниться на сервере, в облаке и т.д.
В базе order_items хранятся строки заказов. Каждая строка имеет id своего заказа.

1)Получить список товаров в группе: URL = myapp/Product/group - сервер вернет информацию в JSON формате"

"[
{"id":"2","name":"unagi","price":"14","group":"suchi","info":"some info",
"images":
[{"low_url":"images/suchi/id_1_low.jpg","hight_url":"images/suchi/id_1_hight.jpg"}]}

{"id":"3","name":"magi","price":"14","group":"suchi","info":"someinfo about this product",
"images":
[{"low_url":"images/suchi/id_1_low.jpg","hight_url":"images/suchi/id_1_hight.jpg"}]}]"

2)Получить информацию о товаре по id: URL = myapp/Products/get_by_id/id

[ "{"id":"1","name":"pizza","price":"100","group":"pizza_group","info":"some info",
"images":[{"low_url":"images/suchi/id_2_low.jpg","hight_url":"images/suchi/id_2_hight.jpg"},{"low_url":"images/suchi/id_3_low.jpg","hight_url":"images/suchi/id_3_hight.jpg"}]}"

3)Создать заказ. URL :  myapp/index.php/Order/create. Метод ожидает данные в JSON формате, возвращает :
[{"status":"status_ok"}] 	- Успешное создание заказа
{"status":"status_false"},  - Заказ не был создан,  сообщение об ошибке
{"Error_message": "Some error message"}

4)Получить заказ по id: URL = myapp/Order/get_by_id/id

 "[{"head":{"order_id":"1","date":"0000-00-00","status":"Выполняется","client_name":"Artem","comment":"somecomment"}},
 {"items":
 [{"item_id":"0","product_count":"5","price":"100"}]},
 {"status":"status_ok"}]"

5)Отменить заказ: URL = myapp/Order/cansel/id
[{"status":"status_ok"}] -Успешная отмена заказа


{"status":"status_false"}, - Неудачная отмена заказа, сообщение об ошибке
{"Error_message": "Some error message"}
]