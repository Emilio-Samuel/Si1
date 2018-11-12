create or replace function setOrderAmount() returns void as $$
	with prices as  (select orders.orderid, sum( orderdetail.price*quantity ) as oprice 
		from orderdetail,orders 
		where orderdetail.orderid=orders.orderid 
		group by orders.orderid)
	update orders
	set netamount = round(prices.oprice,2), totalamount = round(prices.oprice + prices.oprice * (tax/100),2)
	from prices
	where prices.orderid=orders.orderid; 
$$ language 'sql';

select setOrderAmount();
