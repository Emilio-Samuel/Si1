update orders
	set netamount = prices.oprice
	from (select orders.orderid, sum( products.price*quantity ) as oprice from orderdetail,products,orders where products.prod_id=orderdetail.prod_id and orderdetail.orderid=orders.orderid group by orders.orderid) as prices
where prices.orderid=orders.orderid;



update orders
	set totalamount = prices.s1
	from (
select orderid, sum(s) as s1
from (select orderid, prod_id,sum(orderdetail.price) as s
	from orders natural join orderdetail natural join products
	where orders.orderid = orderdetail.orderid and products.prod_id = orderdetail.prod_id 
	group by orderid,prod_id
	order by orderid) as aux
group by orderid) as prices
where prices.orderid=orders.orderid



select orderid, sum(s) as s1
from (select orderid, prod_id,sum(products.price*orderdetail.quantity) as s
	from orders natural join orderdetail natural join products
	where orders.orderid = orderdetail.orderid and products.prod_id = orderdetail.prod_id 
	group by orderid,prod_id
	order by orderid) as aux
group by orderid
