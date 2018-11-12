update orderdetail
	set price = 
		ROUND(products.price/(1.02^((select cast(extract(year from current_date) as int ))-(select (cast(extract(year from orders.orderdate) as int)) from orders where orders.orderid=orderdetail.orderid))),2)
from products
where orderdetail.prod_id = products.prod_id;
