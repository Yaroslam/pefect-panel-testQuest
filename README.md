**Задание 1**

SELECT users.id as id,
concat(users.first_name, users.last_name) as Name,
GROUP_CONCAT(distinct books.author) as author,
GROUP_CONCAT(books.name) as Books
FROM users
JOIN user_book ON users.id = user_book.user_id
JOIN books on books.id = user_book.book_id
WHERE (TIMESTAMPDIFF(YEAR, users.birthday, CURDATE()) BETWEEN 7 AND 17)
AND DATEDIFF(user_book.return_date, user_book.get_date) <= 14
GROUP BY users.id
HAVING count(distinct books.author) = 1 and count(distinct user_book.book_id) = 2;

**Задание 2**

Запуск

- docker-compose up -d
- На localhost:8000 откроется приложение

Тестирование
 - Получить токен /api/v1/token 
 - Запрос на несуществующий url -> ['status' => 'error', 'code' => 404, 'message' => 'Not found']
 - Запрос без токена или с неверным токеном -> ['status' => 'error', 'code' => 403, 'message' => 'Not Authenticated']
 - Запрос http://127.0.0.1:8000/api/v1?method=rates&currency=USD;UUU -> {
   "status": "error",
   "code": 400,
   "message": "currency UUU not found"
   }
 - Запрос http://127.0.0.1:8000/api/v1?method=rates&currency=USD -> {
   "status": "success",
   "code": 200,
   "data": {
   "USD": 42904.28999999999
   }
   }
 - Запрос http://127.0.0.1:8000/api/v1?method=convert с body {
   "currency_from": "AUD",
   "currency_to": "BTC",
   "value": 0.01
   } -> {
   "status": "success",
   "code": 200,
   "data": {
   "value": 0.01,
   "converted_value": 1.54e-7,
   "rate": 64930.54,
   "currency_from": "AUD",
   "currency_to": "BTC"
   }
   }, при value < 0.01 -> {
   "status": "error",
   "code": 400,
   "message": "minimum from currency value is 0.01"
   } c несуществующей валютой -> {
   "status": "error",
   "code": 400,
   "message": "currency UUU not found"
   }
