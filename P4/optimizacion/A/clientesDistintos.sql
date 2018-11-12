
drop index if exists orders_totalamount;
create index orders_totalamount on orders(totalamount);


--drop index if exists orders_orderdate;
--create index orders_orderdate on orders(orderdate);

--drop index if exists orders_customerid;
--create index orders_customerid on orders(customerid);


explain select count(distinct customerid)
from orders
where date_part('year', orderdate)::integer = 2014
    and date_part('month', orderdate)::integer = 5
    and totalamount > 100;